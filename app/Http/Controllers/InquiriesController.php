<?php

namespace App\Http\Controllers;

use App\Models\Inquiries;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InquiriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $inquiries = collect(); // Initialize an empty collection

        if ($user->role === 'user') {
            // Get inquiries specific to the logged-in user
            $inquiries = Inquiries::where('user_id', $user->id)
                ->orderByRaw("FIELD(status, 'Pending', 'In Progress', 'Resolved')")
                ->paginate(20);

            $counts = [
                'Total' => $inquiries->total(),
                'Pending' => $inquiries->where('status', 'Pending')->count(),
                'In Progress' => $inquiries->where('status', 'In Progress')->count(),
                'Resolved' => $inquiries->where('status', 'Resolved')->count(),
            ];
        } elseif ($user->role === 'staff') {
            // Get inquiries assigned to the staff member
            $inquiries = Inquiries::where('assign_id', $user->id)
                ->orderByRaw("FIELD(status, 'Pending', 'In Progress', 'Resolved')")
                ->paginate(20);

            $counts = [
                'Total' => Inquiries::count(),
                'Assign' => $inquiries->total(), // Total inquiries assigned to the staff
                'In Progress' => Inquiries::where('assign_id', $user->id)->where('status', 'In Progress')->count(),
                'Resolved' => Inquiries::where('assign_id', $user->id)->where('status', 'Resolved')->count(),
            ];

        } elseif ($user->role === 'admin') {
            // Get all inquiries for admin
            $inquiries = Inquiries::orderByRaw("FIELD(status, 'Pending', 'In Progress', 'Resolved')")
                ->paginate(20);

            $counts = [
                'Total' => $inquiries->total(),
                'Pending' => Inquiries::where('status', 'Pending')->count(),
                'In Progress' => Inquiries::where('status', 'In Progress')->count(),
                'Resolved' => Inquiries::where('status', 'Resolved')->count(),
            ];
        }

        return view('inquiries.index', compact('inquiries', 'counts'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('id', auth()->user()->id)->first();
        return view('inquiries.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'category' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Handle file upload if applicable
        $imagePath = null; // Default if no image is uploaded
        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('inquiries_images', $imageName, 'public'); // Stored in 'storage/app/public/news_images'
        }

        // Create new inquiry
        $inquiry = new Inquiries();
        $inquiry->user_id = auth()->user()->id;
        $inquiry->category = $request->category;
        $inquiry->title = $request->title;
        $inquiry->description = $request->description;
        $inquiry->image_path = $imagePath;


        // Save to the database
        $inquiry->save();

        // Redirect with success message
        return redirect()->route('inquiries.index')->with('success', 'Pertanyaan berjaya disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $inquiries = Inquiries::find($id);
        return view('inquiries.show', compact('inquiries'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $inquiries = Inquiries::find($id);
        $staff = User::where('role', 'staff')->get();
        return view('inquiries.update', compact('inquiries', 'staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $inquiry = Inquiries::findOrFail($id);

        if (auth()->user()->role === 'user') {
            $request->validate([
                'category' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'image_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            ]);

            // Update inquiry fields
            $inquiry->category = $request->category;
            $inquiry->title = $request->title;
            $inquiry->description = $request->description;

            // Handle file upload if a new file is provided
            if ($request->hasFile('image_path')) {
                // Delete the old file if exists
                if ($inquiry->image_path) {
                    Storage::delete('public/' . $inquiry->image_path);
                }
                // Store the new file
                $image = $request->file('image_path');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('inquiries_images', $imageName, 'public');

                $inquiry->image = $imagePath; // Update the image path
            }
        } elseif (auth()->user()->role === 'admin') {
            $inquiry->assign_id = $request->assign_id;
            $inquiry->status = 'In Progress';
        } else {
            $inquiry->resolved_date = $request->resolved_date;
            $inquiry->solution = $request->solution;
            $inquiry->status = 'Resolved';
        }

        $inquiry->save();

        return redirect()->route('inquiries.index')->with('success', 'Pertanyaan berjaya dikemaskini!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $inquiry = Inquiries::findOrFail($id);
        if ($inquiry->image_path) {
            Storage::delete('public/' . $inquiry->image_path);
        }
        Inquiries::destroy($id);
        return redirect()->route('inquiries.index')
            ->with('success', "Pertanyaan berjaya dihapuskan!");
    }
}
