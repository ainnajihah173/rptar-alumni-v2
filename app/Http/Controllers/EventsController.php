<?php

namespace App\Http\Controllers;

use App\Models\EventParticipant;
use App\Models\Events;
use App\Models\EventOrganizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EventsController extends Controller
{

    public function index()
    {
        // Get the current date and time
        $now = Carbon::now();

        // Find events that have passed their end date and are still active
        $inactiveEvents = Events::where('end_date', '<', $now)
            ->where('is_active', true)
            ->get();

        // Update the status of these events to inactive
        foreach ($inactiveEvents as $event) {
            $event->update(['is_active' => false]);
        }

        // Fetch events based on the user's role
        $user = auth()->user();

        if ($user->role === 'user') {
            // Section 1: All active, not full, and future events
            $events = Events::where('is_active', true)
                ->where('end_date', '>=', $now) // Ensure the event hasn't ended
                ->whereRaw('capacity > registered_count') // Ensure the event is not full
                ->paginate(6); // 6 events per page

            // Section 2: Events that the user has registered for
            $registeredEvents = Events::whereHas('participants', function ($query) use ($user) {
                $query->where('user_id', $user->id); // Filter events where the user is a participant
            })
                ->paginate(30); // 6 events per page

            return view('events.index', compact('events', 'registeredEvents'));
        } else {
            // For admins/staff: Show all events
            $events = Events::orderByRaw("FIELD(status, 'pending', 'rejected', 'approved')")
                ->orderBy('start_date', 'desc') // Sorts by latest date first
                ->paginate(20);
            return view('events.index', compact('events'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch all organizers from the organizer table
        $organizers = EventOrganizer::all();
        // Pass the organizers to the view
        return view('events.create', compact('organizers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date|after:today',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            // 'organizer_name' => 'required|string|max:255',
            // 'organizer_contact' => 'required|string|max:20',
            // 'organizer_email' => 'required|email|max:255',
            'image_path' => 'nullable|image|max:2048',
        ]);

        $imagePath = null; // Default if no image is uploaded
        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('event_images', $imageName, 'public'); // Stored in 'storage/app/public/event_images'
        }

        // Fetch the organizer details
        $organizer = EventOrganizer::find($request->organizer_id);

        Events::create([
            'organizer_id' => $organizer->id,
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'image_path' => $imagePath,
            'created_by' => auth()->user()->id,
            'status' => 'pending',
            'is_active' => false,
            'registered_count' => 0,
        ]);

        return redirect()->route('events.index')->with('success', 'Acara berjaya disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $events = Events::find($id);
        $participants = EventParticipant::where('event_id', $id)->get();
        return view('events.show', compact('events', 'participants'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $events = Events::find($id);
        $organizers = EventOrganizer::all();
        return view('events.update', compact('events', 'organizers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date|after:today',
            'end_date' => 'nullable|date|after_or_equal:start_date', // Validate end_date if provided
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'image_path' => 'nullable|image|max:2048',
            'organizer_id' => 'required|exists:event_organizers,id', // Validate organizer_id
        ]);

        // Find the event by ID
        $event = Events::findOrFail($id);

        // Handle image upload if provided
        if ($request->hasFile('image_path')) {
            // Delete the old image if it exists
            if ($event->image_path) {
                Storage::disk('public')->delete($event->image_path);
            }

            // Store the new image
            $image = $request->file('image_path');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('event_images', $imageName, 'public');
            $event->image_path = $imagePath; // Update the event image path
        }

        // Update event details
        $event->update([
            'organizer_id' => $request->organizer_id, // Use organizer_id from the request
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date, // Update end_date if provided
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'status' => 'Pending', // Keep the existing status
            'is_active' => $request->has('is_active') ? (bool) $request->is_active : $event->is_active,
        ]);

        // Optionally, update the organizer details if needed
        if ($request->has('organizer_contact') || $request->has('organizer_email')) {
            $organizer = EventOrganizer::findOrFail($request->organizer_id);
            $organizer->update([
                'organizer_contact' => $request->organizer_contact,
                'organizer_email' => $request->organizer_email,
            ]);
        }

        return redirect()->route('events.index')->with('success', 'Acara berjaya dikemaskini!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the event by its ID
        $event = Events::find($id);

        // Check if the event exists
        if (!$event) {
            return redirect()->route('events.index')->with('error', "Event not found.");
        }

        // Delete the image from storage
        if ($event->image_path && Storage::exists('public/' . $event->image_path)) {
            Storage::delete('public/' . $event->image_path);
        }

        // // Delete associated EventOrganizer if it exists
        // if ($event->organizers) {
        //     $event->organizers->delete();
        // }

        // Delete the event
        $event->delete();

        // Redirect with success message
        return redirect()->route('events.index')->with('success', "Acara berjaya dihapuskan!");
    }

    public function approve($id)
    {
        $events = Events::find($id);
        $events->update(['status' => 'approved', 'is_active' => true]);
        return redirect()->route('events.index')->with('success', 'Acara telah diterima!');
    }

    public function reject($id)
    {
        $events = Events::find($id);
        $events->update(['status' => 'rejected']);
        return redirect()->route('events.index')->with('success', 'Acara telah ditolak!');
    }

    public function register(Request $request, $id)
    {
        $event = Events::findOrFail($id);

        // Check if the user is already registered for the event
        if ($event->participants->contains('user_id', auth()->id())) {
            return redirect()->back()->with('error', 'Anda sudah mendaftar acara ini!');
        }

        if ($event->registered_count >= $event->capacity) {
            return redirect()->back()->with('error', 'Acara ini sudah penuh');
        }

        EventParticipant::create([
            'event_id' => $event->id,
            'user_id' => auth()->id(),
            'registration_date' => now(),
            'status' => 'Registered',
        ]);

        $event->increment('registered_count');

        return redirect()->back()->with('success', 'Anda telah berjaya mendaftar acara ini!');
    }

    public function addOrganizer(Request $request)
    {

        $organizer = EventOrganizer::create([
            'organizer_name' => $request->organizer_name,
            'organizer_contact' => $request->organizer_contact,
            'organizer_email' => $request->organizer_email,
        ]);

        // Associate the organizer with the event
        $organizer->save();

        // Redirect back with a success message
        return redirect()->route('events.index')->with('success', 'Penganjur berjaya disimpan');
    }



}
