<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch the latest message for each conversation involving the logged-in user
        $messages = Message::where('receiver_id', auth()->user()->id)
            ->orWhere('sender_id', auth()->user()->id)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($message) {
                // Group messages by sender-receiver pair (sorted to avoid duplicates)
                return collect([$message->sender_id, $message->receiver_id])->sort()->implode('_');
            })
            ->map(function ($group) {
                // Return only the latest message for each pair
                return $group->first();
            });

            $count = Message::where('receiver_id', auth()->id())
                     ->where('is_read', 0) // Assuming 0 means unread
                    ->count();

        // Fetch all users with the role of 'user' and exclude the currently logged-in user
        $users = User::where('role', 'user') // Filter by role
            ->where('id', '!=', auth()->user()->id) // Exclude the logged-in user
            ->get();

        return view('message.index', compact('messages', 'users', 'count'));
    }

    public function getNewMessageCount(Request $request)
{
    // Fetch the count of new messages for the logged-in user since lastChecked
    $newMessageCount = Message::where('receiver_id', auth()->id())
        ->where('is_read', 0) // Assuming 0 means unread
        ->where('created_at', '>', $request->last_checked)
        ->count();

    return response()->json([
        'count' => $newMessageCount,
    ]);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => auth()->user()->id,
            'receiver_id' => $request->receiver_id,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return redirect()->route('message.index')->with('success', 'Mesej berjaya dihantar!');
    }

    /**
     * Update the specified resource in storage (for replying to a message).
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'message' => 'required|string',
        ]);

        // Find the original message
        $originalMessage = Message::findOrFail($id);

        // Check if a reply has already been sent
        if ($originalMessage->replies()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'A reply has already been sent for this message.',
            ], 400);
        }

        // Update the original message's is_read status to true
        $originalMessage->update([
            'is_read' => true, // Mark the original message as read
        ]);

        // Create the reply message
        $reply = Message::create([
            'sender_id' => auth()->id(), // The current user is the sender of the reply
            'receiver_id' => $originalMessage->sender_id, // The original sender is the receiver of the reply
            'parent_id' => $originalMessage->id, // Link the reply to the original message
            'subject' => $originalMessage->subject, // Use the same subject as the original message
            'message' => $request->message,
        ]);

        // Load the sender and receiver relationships for the reply
        $reply->load('sender.profile', 'receiver.profile');

        // Return a JSON response for AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Reply sent successfully!',
                'data' => [
                    'id' => $reply->id,
                    'sender_name' => $reply->sender->profile->full_name,
                    'receiver_name' => $reply->receiver->profile->full_name,
                    'message' => $reply->message,
                    'time' => $reply->created_at->format('h:i A'),
                ],
            ]);
        }

        // Redirect back to the conversation page for non-AJAX requests
        return redirect()->route('message.conversation', $originalMessage->id)->with('success', 'Reply berjaya dibalas!');
    }

    /**
     * Display the full conversation for a message.
     */
    public function conversation($id)
    {
        // Find the original message
        $originalMessage = Message::findOrFail($id);

        // Fetch the full conversation (including the original message and all replies)
        $conversation = Message::where(function ($query) use ($originalMessage) {
            // Fetch messages where the logged-in user is either the sender or receiver
            $query->where('sender_id', auth()->user()->id)
                ->orWhere('receiver_id', auth()->user()->id);
        })
            ->where(function ($query) use ($originalMessage) {
                // Fetch messages between the logged-in user and the other user
                $query->where(function ($q) use ($originalMessage) {
                    $q->where('sender_id', $originalMessage->sender_id)
                        ->where('receiver_id', $originalMessage->receiver_id);
                })
                    ->orWhere(function ($q) use ($originalMessage) {
                    $q->where('sender_id', $originalMessage->receiver_id)
                        ->where('receiver_id', $originalMessage->sender_id);
                });
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('message.conversation', compact('conversation'));
    }

    /**
     * Delete the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $request->validate([
            'selected_ids' => 'required|string', // Comma-separated IDs
        ]);

        // Convert the comma-separated string to an array
        $selectedIds = explode(',', $request->selected_ids);

        // Delete the selected messages
        Message::whereIn('id', $selectedIds)->delete();

        return redirect()->route('message.index')->with('success', 'Selected messages deleted successfully!');
    }

    /**
     * Remove a single message from storage.
     */
    public function destroy($id)
    {
        // Find the message to be deleted
        $message = Message::findOrFail($id);

        // Get the sender and receiver IDs from the message
        $senderId = $message->sender_id;
        $receiverId = $message->receiver_id;

        // Find all messages in the conversation (both sent and received)
        $conversationMessages = Message::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)
                ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)
                ->where('receiver_id', $senderId);
        })->get();

        // Delete all messages in the conversation
        foreach ($conversationMessages as $conversationMessage) {
            // Delete the attachment if it exists
            if ($conversationMessage->attachment) {
                Storage::delete('public/' . $conversationMessage->attachment);
            }
            // Delete the message
            $conversationMessage->delete();
        }

        return redirect()->route('message.index')
            ->with('success', 'Semua perbualan berjaya dihapuskan!');
    }
}