<?php

namespace App\Http\Controllers;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Inquiries;
use App\Models\Message;
use App\Models\User;
use App\Models\Events;
use App\Models\News;
use Illuminate\Support\Facades\Hash;
use App\Models\Profile;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{

  public function portal()
  {
    // Fetch data for each section
    $events = Events::where('is_active', true)->orderBy('start_date', 'asc')->take(3)->get();
    $news = News::orderBy('published_date', 'desc')->take(4)->get();
    $donations = Campaign::where('status', 'active') // ENUM value
      ->orderBy('start_date', 'desc')
      ->take(3)
      ->get();

    // Pass data to the view
    return view('welcome', compact('events', 'news', 'donations'));
  }

  public function dashboard()
  {
    // Get the authenticated user
    $user = auth()->user();

    if ($user->role === 'admin') {
      // Admin-specific logic (if needed)

      // Get the authenticated admin
      $admin = auth()->user();
      // Fetch total users
      $totalUsers = User::count();

      // Fetch total events
      $totalEvents = Events::count();

      // Fetch total donations
      $totalDonations = Donation::count();

      // Fetch total inquiries
      $totalInquiries = Inquiries::count();

      // Fetch donation history for the chart (last 6 months)
      $donationHistory = Campaign::select('title', 'current_amount')->where('status', 'active')->get();

      // Fetch total users by role
      $userCounts = User::selectRaw('role, COUNT(*) as total')
        ->groupBy('role')
        ->get()
        ->pluck('total', 'role');

      // Fetch inquiry status for the chart
      $inquiryStatus = Inquiries::selectRaw('status, COUNT(*) as total')
        ->groupBy('status')
        ->get();

      // Fetch recent users (e.g., last 5 users)
      $recentUsers = User::orderBy('created_at', 'desc')
        ->take(5)
        ->get();

      // Fetch upcoming events (e.g., next 5 events)
      $upcomingEvents = Events::where('start_date', '>=', Carbon::now())
        ->orderBy('start_date', 'asc')
        ->take(5)
        ->get();

      // Fetch recent donations (e.g., last 5 donations)
      $recentDonations = Donation::orderBy('created_at', 'desc')
        ->take(5)
        ->get();

      // Fetch recent inquiries (e.g., last 5 inquiries)
      $recentInquiries = Inquiries::orderBy('created_at', 'desc')
        ->take(5)
        ->get();

      // Pass data to the view
      return view('dashboard', compact(
        'admin',
        'totalUsers',
        'totalEvents',
        'totalDonations',
        'totalInquiries',
        'donationHistory',
        'userCounts',
        'inquiryStatus',
        'recentUsers',
        'upcomingEvents',
        'recentDonations',
        'recentInquiries'
      ));


    } elseif ($user->role === 'staff') {
      
      // Fetch latest news 
      $latestNews = News::orderBy('published_date', 'desc')->take(3)->get();

      // Fetch upcoming events 
      $upcomingEvents = Events::where('start_date', '>=', Carbon::now())
        ->where('is_active', 1) 
        ->orderBy('start_date', 'asc')
        ->take(4)
        ->get();

      // Fetch total donations
      $donationSummary = Campaign::where('status', 'active')->count();

      // Fetch recent inquiries
      $recentInquiries = Inquiries::orderBy('created_at', 'desc')
        ->take(3)
        ->get();

      // Fetch campaign current amount
      $donationHistory = Campaign::select('title', 'current_amount')->where('status', 'active')->get();

      // Fetch event participation for the chart (last 6 months)
      $eventParticipation = Events::select('name', 'registered_count')->where('is_active', true)
        ->get();

      // Pass data to the view
      return view('dashboard', compact(
        'user',
        'latestNews',
        'upcomingEvents',
        'donationSummary',
        'recentInquiries',
        'donationHistory',
        'eventParticipation',
      ));

    } else {
      // Fetch latest news 
      $latestNews = News::orderBy('published_date', 'desc')->take(3)->get();

      // Fetch upcoming events that the user has registered for
      $upcomingEvents = Events::where('start_date', '>=', Carbon::now())
        ->orderBy('start_date', 'asc')
        ->whereHas('participants', function ($query) use ($user) {
          $query->where('user_id', $user->id); // Filter events where the user is a participant
        })
        ->get(); 

      // Format events for FullCalendar
      $formattedEvents = $upcomingEvents->map(function ($event) {
        return [
          'title' => $event->name,
          'start' => $event->start_date, // Start date
          'end' => Carbon::parse($event->end_date)->addDay()->toDateString(), // Add 1 day for all-day events
          'allDay' => true, // Mark as an all-day event
          'url' => route('events.show', $event->id), // Link to event details
        ];
      });

      // Fetch user's donation summary
      $donationSummary = Donation::where('user_id', $user->id)->sum('amount');

      // Fetch user's recent inquiries 
      $recentInquiries = Inquiries::where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

      // Fetch donation history for the chart 
      $donationHistory = Donation::where('user_id', $user->id)
        ->selectRaw('SUM(amount) as total, MONTH(created_at) as month')
        ->where('created_at', '>=', Carbon::now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

      // Fetch event participation for the chart 
      $eventParticipation = Events::whereHas('participants', function ($query) use ($user) {
        $query->where('user_id', $user->id);
      })
        ->selectRaw('COUNT(*) as total, MONTH(start_date) as month')
        ->where('start_date', '>=', Carbon::now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

      // Pass data to the view
      return view('dashboard', compact(
        'user',
        'latestNews',
        'upcomingEvents',
        'donationSummary',
        'recentInquiries',
        'donationHistory',
        'eventParticipation',
        'formattedEvents'
      ));
    }
  }

  public function index()
  {
    $users = User::orderBy('role')->get();
    return view('user.index', compact('users'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255|unique:users,name',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:8',
    ], [
      'name.unique' => 'The name has already been taken.',
      'email.unique' => 'The email address has already been registered.',
    ]);

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'role' => $request->role,
    ]);

    Profile::create([
      'user_id' => $user->id,
    ]);

    // Return to user list with success message
    return redirect()->route('user.index')
      ->with('success', 'Pengguna berjaya disimpan')
      ->with('modal', '<strong>Email:</strong> ' . $user->email . '<br><br><strong>Password:</strong> ' . $request->password);
  }

  /**
   * Display the specified resource.
   */
  public function show($id)
  {

  }


  public function forgotPassword(Request $request)
  {
    // Validate the request
    $request->validate([
      'email' => 'required|email|exists:users,email',
      'password' => [
        'required',
        'confirmed',
        Password::min(8) // Minimum length of 8 characters
          ->letters() // Must contain at least one letter
          ->mixedCase() // Must contain both uppercase and lowercase letters
          ->numbers() // Must contain at least one number
          ->symbols() // Must contain at least one special character
      ]
    ]);

    // Find the user by email
    $user = User::where('email', $request->email)->first();

    if ($user) {
      // Update the user's password
      $user->password = Hash::make($request->password);
      $user->save();

      // Redirect with success message
      return redirect()->back()->with('success', 'Kata laluan berjaya dikemas kini.');
    }

    // If user not found, redirect with error message
    return redirect()->back()->with('error', 'Emel tidak dijumpai.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    User::destroy($id);
    return redirect()->route('user.index')
      ->with('success', "Pengguna berjaya dihapuskan!");

  }


}
