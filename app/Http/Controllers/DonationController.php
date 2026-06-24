<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Campaign;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // For Staff/Admin
        if (auth()->user()->role === 'staff' || auth()->user()->role === 'admin') {
            // Fetch all campaigns sorted by start_date and status
            $campaigns = Campaign::orderByRaw("FIELD(status, 'pending', 'rejected', 'active', 'closed')")->orderBy('end_date', 'desc')->paginate(20);

            // Automatically set campaigns to 'closed' if end_date has passed or target_amount is reached
            foreach ($campaigns as $campaign) {
                if ($campaign->end_date && Carbon::now()->gt($campaign->end_date) || $campaign->current_amount >= $campaign->target_amount) {
                    $campaign->status = 'closed';
                    $campaign->save();
                }
            }

            return view('donations.index', compact('campaigns'));
        }
        // For Users
        elseif (auth()->user()->role === 'user') {
            // First Tab: Active campaigns where current_amount < target_amount
            $activeCampaigns = Campaign::where('status', 'active')
                ->whereColumn('current_amount', '<', 'target_amount')
                ->paginate(6);

            // Second Tab: User's donations
            $userDonations = Donation::where('user_id', auth()->id())
                ->with('campaign')
                ->paginate(30);

            return view('donations.index', [
                'activeCampaigns' => $activeCampaigns,
                'userDonations' => $userDonations,
            ]);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('donations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'user') {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'target_amount' => 'required|numeric|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Handle profile picture upload
            $imagePath = null; // Default if no image is uploaded
            if ($request->hasFile('image_path')) {
                $image = $request->file('image_path');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('donation_images', $imageName, 'public'); // Stored in 'storage/app/public/donation_images'
            }

            // Create the campaign
            Campaign::create([
                'created_by' => auth()->user()->id,
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'target_amount' => $request->input('target_amount'),
                'start_date' => $request->input('start_date') ?? null,
                'end_date' => $request->input('end_date') ?? null,
                'image_path' => $imagePath,
            ]);

            return redirect()->route('donations.index')->with('success', 'Kempen berjaya disimpan!');
        } else {
            $campaign = Campaign::findOrFail($request->input('campaign_id'));

            Donation::create([
                'campaign_id' => $request->input('campaign_id'),
                'user_id' => auth()->user()->id, // Get the authenticated user's ID
                'amount' => $request->input('amount'),
                'payment_status' => 'successful', // Set payment status to 'approved'
            ]);

            // Update the campaign's current_amount
            $campaign->current_amount += $request->input('amount');
            $campaign->save();

            return redirect()->route('donations.index')->with('success', 'Kami telah menerima sumbangan anda, terima kasih!');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Fetch the campaign by ID
        $campaigns = Campaign::findOrFail($id);

        // Fetch all donations for the campaign
        $donations = Donation::where('campaign_id', $id)->get();
        return view('donations.show', compact('campaigns', 'donations'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (auth()->user()->role === 'user') {
            $campaigns = Campaign::find($id);
            $users = User::find(auth()->user()->id);
            return view('donations.update', compact('campaigns', 'users'));
        } else {
            $campaigns = Campaign::find($id);
            return view('donations.update', compact('campaigns'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        // Find the campaign by ID
        $campaign = Campaign::findOrFail($id);

        // Update the campaign data
        $campaign->title = $request->input('title');
        $campaign->target_amount = $request->input('target_amount');
        $campaign->start_date = $request->input('start_date');
        $campaign->end_date = $request->input('end_date');
        $campaign->description = $request->input('description');
        $campaign->status = 'pending';

        // Handle file upload if a new image is provided
        if ($request->hasFile('image_path')) {
            // Delete the old image if it exists
            if ($campaign->image_path && Storage::exists('public/' . $campaign->image_path)) {
                Storage::delete('public/' . $campaign->image_path);
            }

            // Store the new image
            $imagePath = $request->file('image_path')->store('donations', 'public'); // Save in storage/app/public/campaigns
            $campaign->image_path = $imagePath; // Update the image path in the database
        }

        // Save the updated campaign
        $campaign->save();

        // Redirect with a success message
        return redirect()->route('donations.index')->with('success', 'Kempen berjaya dikemaskini!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the campaign by ID
        $campaign = Campaign::findOrFail($id);

        // Delete the image from storage if it exists
        if ($campaign->image_path && Storage::exists('public/' . $campaign->image_path)) {
            Storage::delete('public/' . $campaign->image_path);
        }

        // Delete the campaign record from the database
        $campaign->delete();

        // Redirect with a success message
        return redirect()->route('donations.index')->with('success', 'Kempen berjaya dihapuskan!');
    }

    public function approve($id)
    {
        $campaign = Campaign::find($id);
        $campaign->update(['status' => 'active']);
        return redirect()->route('donations.index')->with('success', 'Kempen telah diterima!');
    }

    public function reject($id)
    {
        $campaign = Campaign::find($id);
        $campaign->update(['status' => 'rejected']);
        return redirect()->route('donations.index')->with('success', 'Kempen telah ditolak!');
    }

    public function generateReceipt($id)
    {
        // Fetch the donation by ID
        $donation = Donation::with('campaign')->findOrFail($id);

        // Generate the PDF
        $pdf = Pdf::loadView('donations.receipt', compact('donation'));

        // Download the PDF
        return $pdf->download('receipt-' . $donation->id . '.pdf');
    }
}
