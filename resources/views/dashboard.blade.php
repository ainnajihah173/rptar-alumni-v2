@extends('layouts.staff-base')
@section('content')
    @if (auth()->user()->role === 'user')
        <div class="container-fluid">
            <!-- Welcome Section -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <h3 class="text-gray-800">Selamat kembali, {{ $user->profile->full_name }}!</h3>
                                    <p class="text-gray-600 mb-0">Inilah yang berlaku dalam komuniti alumni anda.</p>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user fa-2x text-gray-300"></i> <!-- User Icon -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <!-- Total Donations Card -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card bg-primary text-white shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        Jumlah Derma Saya
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-white">
                                        RM {{ number_format($donationSummary, 2) }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-donate fa-2x text-white"></i> <!-- Donation Icon -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Events Card -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card bg-success text-white shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        Acara Akan Datang
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-white">
                                        {{ $upcomingEvents->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-alt fa-2x text-white"></i> <!-- Calendar Icon -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inquiries Events Card -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card bg-warning text-white shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        Pertanyaan Saya
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-white">
                                        {{ $recentInquiries->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-question-circle fa-2x text-white"></i> <!-- Inquiry Icon -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events Calendar Section -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Acara Akan Datang</h5>
                            <div id="calendar" class="calendar-container"></div> <!-- Calendar will be rendered here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Latest News Section -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Berita Terkini</h5>
                            @if ($latestNews->isEmpty())
                                <p>Tiada berita terkini.</p>
                            @else
                                <div class="list-group">
                                    @foreach ($latestNews as $news)
                                        <a href="{{ route('news.show', $news->id) }}"
                                            class="list-group-item list-group-item-action d-flex align-items-start">
                                            <!-- News Image -->
                                            @if ($news->image)
                                                <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}"
                                                    class="img-thumbnail me-3 mr-2"
                                                    style="width: 100px; height: 100px; object-fit: cover;">
                                            @else
                                                <!-- Placeholder image if no image is available -->
                                                <img src="https://via.placeholder.com/100" alt="Placeholder"
                                                    class="img-thumbnail me-3 mr-2"
                                                    style="width: 100px; height: 100px; object-fit: cover;">
                                            @endif

                                            <!-- News Content -->
                                            <div class="flex-grow-1">
                                                <h6>{{ $news->title }}</h6>
                                                <p class="mb-1">{{ Str::limit($news->content, 100) }}</p>
                                                <small>Diterbitkan pada
                                                    {{ \Carbon\Carbon::parse($news->published_date)->format('d F Y') }}</small>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FullCalendar Initialization -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const calendarEl = document.getElementById('calendar');
                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth', // Default view (month, week, day, etc.)
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    events: {!! json_encode($formattedEvents) !!}, // Events data from controller
                    eventClick: function(info) {
                        // Open event details page when an event is clicked
                        window.location.href = info.event.url;
                    },
                    contentHeight: 'auto', // Make the calendar height responsive
                    aspectRatio: 1.5, // Adjust the aspect ratio for better sizing
                });
                calendar.render();
            });
        </script>

        <!-- Custom CSS for Calendar -->
        <style>
            /* Make the calendar responsive */
            .calendar-container {
                overflow: hidden;
                position: relative;
            }

            .calendar-container .fc {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }

            /* Adjust calendar header and buttons */
            .fc-header-toolbar {
                padding: 10px;
                margin-bottom: 10px;
            }

            .fc-toolbar-title {
                font-size: 1.25rem;
                /* Adjust the title size */
            }

            .fc-button {
                font-size: 0.875rem;
                /* Adjust button size */
                padding: 0.25rem 0.5rem;
            }

            /* Adjust event font size */
            .fc-event-title {
                font-size: 0.875rem;
                /* Adjust event title size */
            }
        </style>
    @elseif(auth()->user()->role === 'admin')
        <!-- Admin-specific content can go here -->
        <div class="container-fluid">
            <!-- Welcome Section -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <h3 class="text-gray-800">Selamat kembali, {{ $admin->name }}!</h3>
                                    <p class="text-gray-600 mb-0">Inilah gambaran keseluruhan sistem anda.</p>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-shield fa-2x text-gray-300"></i> <!-- Admin Icon -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats Section -->
            <div class="row mb-4">
                <!-- Total Users Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Jumlah Pengguna
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $totalUsers }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i> <!-- Users Icon -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Events Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Jumlah Acara
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $totalEvents }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-alt fa-2x text-gray-300"></i> <!-- Events Icon -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Donations Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Jumlah Derma
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $totalDonations }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-donate fa-2x text-gray-300"></i> <!-- Donations Icon -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Inquiries Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Jumlah Pertanyaan
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $totalInquiries }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-question-circle fa-2x text-gray-300"></i> <!-- Inquiries Icon -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="row mb-4">
                <!-- Donation Trend Chart -->
                <div class="col-xl-6 col-md-12 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header bg-white">
                            <h6 class="m-0 font-weight-bold text-primary">Trend Derma</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="donationChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- User Role Distribution Chart -->
                <div class="col-xl-6 col-md-12 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header bg-white">
                            <h6 class="m-0 font-weight-bold text-success">Taburan Peranan Pengguna</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="userRoleChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Section -->
            <div class="row mb-4">
                <!-- Recent Users -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header bg-white">
                            <h6 class="m-0 font-weight-bold text-info">Pengguna Terkini</h6>
                        </div>
                        <div class="card-body">
                            @if ($recentUsers->isEmpty())
                                <p>Tiada pengguna terkini.</p>
                            @else
                                <div class="list-group">
                                    @foreach ($recentUsers as $user)
                                        <div class="list-group-item">
                                            <h6>{{ $user->name }}</h6>
                                            <small>Menyertai pada
                                                {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Upcoming Events -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header bg-white">
                            <h6 class="m-0 font-weight-bold text-success">Acara Akan Datang</h6>
                        </div>
                        <div class="card-body">
                            @if ($upcomingEvents->isEmpty())
                                <p>Tiada acara akan datang.</p>
                            @else
                                <div class="list-group">
                                    @foreach ($upcomingEvents as $event)
                                        <div class="list-group-item">
                                            <h6>{{ $event->name }}</h6>
                                            <small>Tarikh: @if ($event->start_date == $event->end_date)
                                                    {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                                                @else
                                                    {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }} -
                                                    {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}
                                                @endif
                                            </small>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Recent Donations -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header bg-white">
                            <h6 class="m-0 font-weight-bold text-warning">Derma Terkini</h6>
                        </div>
                        <div class="card-body">
                            @if ($recentDonations->isEmpty())
                                <p>Tiada derma terkini.</p>
                            @else
                                <div class="list-group">
                                    @foreach ($recentDonations as $donation)
                                        <div class="list-group-item">
                                            <h6>RM {{ number_format($donation->amount, 2) }}</h6>
                                            <small>Derma pada
                                                {{ \Carbon\Carbon::parse($donation->created_at)->format('d F Y') }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Recent Inquiries -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header bg-white">
                            <h6 class="m-0 font-weight-bold text-danger">Pertanyaan Terkini</h6>
                        </div>
                        <div class="card-body">
                            @if ($recentInquiries->isEmpty())
                                <p>Tiada pertanyaan terkini.</p>
                            @else
                                <div class="list-group">
                                    @foreach ($recentInquiries as $inquiry)
                                        <div class="list-group-item">
                                            <h6>{{ $inquiry->title }}</h6>
                                            <small>Dihantar pada
                                                {{ \Carbon\Carbon::parse($inquiry->created_at)->format('d M Y') }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Chart.js Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Donation Trend Chart
            const donationCtx = document.getElementById('donationChart').getContext('2d');
            const donationChart = new Chart(donationCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($donationHistory->pluck('title')) !!},
                    datasets: [{
                        label: 'Kutipan Derma (RM)',
                        data: {!! json_encode($donationHistory->pluck('current_amount')) !!},
                        borderColor: 'rgba(0, 123, 255, 1)',
                        backgroundColor: 'rgba(0, 123, 255, 0.1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // User Registration Chart
            document.addEventListener('DOMContentLoaded', function() {
                const userRoleCtx = document.getElementById('userRoleChart').getContext('2d');
                const userRoleChart = new Chart(userRoleCtx, {
                    type: 'bar', // You can also use 'pie' or 'doughnut' for a different style
                    data: {
                        labels: ['Admin', 'Staf', 'Pengguna'], // Labels for each category
                        datasets: [{
                            label: 'Jumlah Pengguna',
                            data: [
                                {{ $adminCount = $userCounts['admin'] ?? 0 }}, // Admin count
                                {{ $staffCount = $userCounts['staff'] ?? 0 }}, // Staff count
                                {{ $userCount = $userCounts['user'] ?? 0 }} // User count
                            ],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.8)', // Red for admin
                                'rgba(54, 162, 235, 0.8)', // Blue for staff
                                'rgba(75, 192, 192, 0.8)' // Green for user
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(75, 192, 192, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        </script>
    @else
        <div class="container-fluid">
            <!-- Welcome Section -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <h3 class="text-gray-800">Selamat kembali, {{ $user->profile->full_name }}!</h3>
                                    <p class="text-gray-600 mb-0">Inilah yang berlaku dalam komuniti alumni anda.</p>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user fa-2x text-gray-300"></i> <!-- User Icon -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats Section -->
            <div class="row mb-4">
                <!-- Total Donations Card -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card bg-primary text-white shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        Jumlah Kempen
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-white">
                                        {{ $donationSummary }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-white"></i> <!-- Donation Icon -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Events Card -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card bg-success text-white shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        Acara Akan Datang
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-white">
                                        {{ $upcomingEvents->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-alt fa-2x text-white"></i> <!-- Calendar Icon -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inquiries Card -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card bg-warning text-white shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        Jumlah Pertanyaan
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-white">
                                        {{ $recentInquiries->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-question-circle fa-2x text-white"></i> <!-- Inquiry Icon -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="row mb-4">
                <!-- Donation Trend Chart -->
                <div class="col-xl-6 col-md-12 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header bg-white">
                            <h6 class="m-0 font-weight-bold text-primary">Trend Derma</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="donationChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Event Participation Chart -->
                <div class="col-xl-6 col-md-12 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header bg-white">
                            <h6 class="m-0 font-weight-bold text-success">Penyertaan Acara</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="eventChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Section -->
            <div class="row mb-4">
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header bg-white">
                            <h6 class="m-0 font-weight-bold text-info">Berita Terkini</h6>
                        </div>
                        <div class="card-body">
                            @if ($latestNews->isEmpty())
                                <p>Tiada berita terkini.</p>
                            @else
                                <div class="list-group">
                                    @foreach ($latestNews as $news)
                                        <a href="{{ route('news.show', $news->id) }}"
                                            class="list-group-item list-group-item-action d-flex align-items-start">
                                            <!-- News Image -->
                                            @if ($news->image)
                                                <img src="{{ asset('storage/' . $news->image) }}"
                                                    alt="{{ $news->title }}" class="img-thumbnail me-3 mr-2"
                                                    style="width: 80px; height: 80px; object-fit: cover;">
                                            @else
                                                <!-- Placeholder image if no image is available -->
                                                <img src="https://via.placeholder.com/80" alt="Placeholder"
                                                    class="img-thumbnail me-3 mr-2"
                                                    style="width: 80px; height: 80px; object-fit: cover;">
                                            @endif

                                            <!-- News Content -->
                                            <div class="flex-grow-1">
                                                <h6>{{ $news->title }}</h6>
                                                <p class="mb-1">{{ Str::limit($news->content, 100) }}</p>
                                                <small>Diterbitkan pada
                                                    {{ \Carbon\Carbon::parse($news->published_date)->format('d F Y') }}</small>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header bg-white">
                            <h6 class="m-0 font-weight-bold text-success">Acara Akan Datang</h6>
                        </div>
                        <div class="card-body">
                            @if ($upcomingEvents->isEmpty())
                                <p>Tiada acara akan datang.</p>
                            @else
                                <div class="list-group">
                                    @foreach ($upcomingEvents as $event)
                                        <a href="{{ route('events.show', $event->id) }}"
                                            class="list-group-item list-group-item-action d-flex align-items-start">
                                            <!-- Event Image -->
                                            @if ($event->image_path)
                                                <img src="{{ asset('storage/' . $event->image_path) }}"
                                                    alt="{{ $event->name }}" class="img-thumbnail me-3 mr-2"
                                                    style="width: 80px; height: 80px; object-fit: cover;">
                                            @else
                                                <!-- Placeholder image if no image is available -->
                                                <img src="https://via.placeholder.com/80" alt="Placeholder"
                                                    class="img-thumbnail me-3 mr-2"
                                                    style="width: 80px; height: 80px; object-fit: cover;">
                                            @endif

                                            <!-- Event Content -->
                                            <div class="flex-grow-1">
                                                <h6>{{ $event->name }}</h6>
                                                <p class="mb-1">{{ $event->description }}</p>
                                                <small>Tarikh: @if ($event->start_date == $event->end_date)
                                                        {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                                                    @else
                                                        {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }} -
                                                        {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}
                                                    @endif
                                                </small>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Recent Inquiries -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header bg-white">
                            <h6 class="m-0 font-weight-bold text-warning">Pertanyaan Terkini</h6>
                        </div>
                        <div class="card-body">
                            @if ($recentInquiries->isEmpty())
                                <p>Tiada pertanyaan terkini.</p>
                            @else
                                <div class="list-group">
                                    @foreach ($recentInquiries as $inquiry)
                                        <div class="list-group-item">
                                            <h6>{{ $inquiry->title }}</h6>
                                            <p class="mb-1">{{ Str::limit($inquiry->message, 100) }}</p>
                                            <small>Dihantar pada {{ $inquiry->created_at }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart.js Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Donation Trend Chart
            const donationCtx = document.getElementById('donationChart').getContext('2d');
            const donationChart = new Chart(donationCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($donationHistory->pluck('title')) !!},
                    datasets: [{
                        label: 'Jumlah Derma Dikumpul (RM)',
                        data: {!! json_encode($donationHistory->pluck('current_amount')) !!},
                        borderColor: 'rgba(0, 123, 255, 1)',
                        backgroundColor: 'rgba(0, 123, 255, 0.1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Event Participation Chart
            const eventCtx = document.getElementById('eventChart').getContext('2d');
            const eventChart = new Chart(eventCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($eventParticipation->pluck('name')) !!},
                    datasets: [{
                        label: 'Acara Dihadiri',
                        data: {!! json_encode($eventParticipation->pluck('registered_count')) !!},
                        backgroundColor: 'rgba(40, 167, 69, 0.8)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    @endif
@endsection