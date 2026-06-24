@extends('layouts.staff-base')

@section('content')
<!-- Welcome Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card welcome-card animate-fade-in-up" style="background: linear-gradient(135deg, {{ auth()->user()->role === 'admin' ? '#0ea5e9' : (auth()->user()->role === 'staff' ? '#6366f1' : '#f43f5e') }} 0%, {{ auth()->user()->role === 'admin' ? '#0284c7' : (auth()->user()->role === 'staff' ? '#4f46e5' : '#e11d48') }} 100%); box-shadow: 0 20px 60px rgba(99,102,241,0.25);">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div class="text-white" style="z-index: 1;">
                    <h2 class="fw-800 mb-2" style="font-size: 1.75rem;">
                        Selamat Kembali, {{ auth()->user()->role === 'admin' ? $admin->name : (auth()->user()->profile->full_name ?? auth()->user()->name) }}!
                    </h2>
                    <p class="mb-0 opacity-75" style="font-size: 1.05rem;">
                        {{ auth()->user()->role === 'admin' ? '📊 Sistem sedang berjalan dengan lancar hari ini.' : '🎯 Berikut adalah ringkasan aktiviti alumni anda.' }}
                    </p>
                </div>
                <div class="d-none d-md-block" style="z-index: 1;">
                    <div class="welcome-icon">
                        <i class="fas {{ auth()->user()->role === 'admin' ? 'fa-user-shield' : 'fa-user-graduate' }} fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    @if (auth()->user()->role === 'admin')
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card animate-fade-in-up delay-1" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 10px 30px rgba(102,126,234,0.3);">
            <div class="d-flex align-items-center">
                <div class="stat-icon mr-3"><i class="fas fa-users"></i></div>
                <div>
                    <p class="stat-label">Jumlah Pengguna</p>
                    <h3 class="stat-value">{{ $totalUsers }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card animate-fade-in-up delay-2" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); box-shadow: 0 10px 30px rgba(240,147,251,0.3);">
            <div class="d-flex align-items-center">
                <div class="stat-icon mr-3"><i class="fas fa-calendar-check"></i></div>
                <div>
                    <p class="stat-label">Acara Aktif</p>
                    <h3 class="stat-value">{{ $totalEvents }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card animate-fade-in-up delay-3" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); box-shadow: 0 10px 30px rgba(79,172,254,0.3);">
            <div class="d-flex align-items-center">
                <div class="stat-icon mr-3"><i class="fas fa-hand-holding-usd"></i></div>
                <div>
                    <p class="stat-label">Kutipan Derma</p>
                    <h3 class="stat-value">RM {{ number_format($totalDonations) }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card animate-fade-in-up delay-4" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); box-shadow: 0 10px 30px rgba(250,112,154,0.3);">
            <div class="d-flex align-items-center">
                <div class="stat-icon mr-3"><i class="fas fa-inbox"></i></div>
                <div>
                    <p class="stat-label">Pertanyaan Baru</p>
                    <h3 class="stat-value">{{ $totalInquiries }}</h3>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card animate-fade-in-up delay-1" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 10px 30px rgba(102,126,234,0.3);">
            <div class="d-flex align-items-center">
                <div class="stat-icon mr-3"><i class="fas fa-donate"></i></div>
                <div>
                    <p class="stat-label">Jumlah Sumbangan</p>
                    <h3 class="stat-value">RM {{ number_format($donationSummary, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card animate-fade-in-up delay-2" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); box-shadow: 0 10px 30px rgba(240,147,251,0.3);">
            <div class="d-flex align-items-center">
                <div class="stat-icon mr-3"><i class="fas fa-calendar-alt"></i></div>
                <div>
                    <p class="stat-label">Acara Dihadiri</p>
                    <h3 class="stat-value">{{ $upcomingEvents->count() }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card animate-fade-in-up delay-3" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); box-shadow: 0 10px 30px rgba(79,172,254,0.3);">
            <div class="d-flex align-items-center">
                <div class="stat-icon mr-3"><i class="fas fa-comment-dots"></i></div>
                <div>
                    <p class="stat-label">Mesej/Pertanyaan</p>
                    <h3 class="stat-value">{{ $recentInquiries->count() }}</h3>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Main Content -->
<div class="row g-4">
    <!-- Left: Charts / Calendar -->
    <div class="col-lg-8">
        <!-- Donation Chart -->
        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex align-items-center">
                <div class="rounded-circle p-2 mr-3" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <i class="fas fa-chart-line text-white"></i>
                </div>
                <div>
                    <h6 class="fw-700 mb-0">Trend Derma Terkini</h6>
                    <small class="text-muted">Prestasi derma dalam tempoh terkini</small>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-area" style="height: 280px;"><canvas id="donationChart"></canvas></div>
            </div>
        </div>

        @if(auth()->user()->role === 'admin')
        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center">
                <div class="rounded-circle p-2 mr-3" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                    <i class="fas fa-users text-white"></i>
                </div>
                <div>
                    <h6 class="fw-700 mb-0">Taburan Peranan Pengguna</h6>
                    <small class="text-muted">Statistik peranan pengguna dalam sistem</small>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-pie" style="height: 280px;"><canvas id="userRoleChart"></canvas></div>
            </div>
        </div>
        @else
        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center">
                <div class="rounded-circle p-2 mr-3" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                    <i class="fas fa-calendar-alt text-white"></i>
                </div>
                <div>
                    <h6 class="fw-700 mb-0">{{ auth()->user()->role === 'staff' ? 'Takwim Acara Alumni' : 'Takwim Acara Saya' }}</h6>
                    <small class="text-muted">Jadual acara yang akan datang</small>
                </div>
            </div>
            <div class="card-body">
                <div id="calendar" style="min-height: 400px;"></div>
            </div>
        </div>
        @endif
    </div>

    <!-- Right: News & Activity -->
    <div class="col-lg-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle p-2 mr-3" style="background: linear-gradient(135deg, #fa709a, #fee140);">
                        <i class="fas fa-newspaper text-white"></i>
                    </div>
                    <h6 class="fw-700 mb-0">Berita Terkini</h6>
                </div>
                <a href="{{ route('news.index') }}" class="small fw-600" style="color: var(--accent-color);">Semua →</a>
            </div>
            <div class="p-0">
                @forelse ($latestNews as $news)
                <a href="{{ route('news.show', $news->id) }}" class="sidebar-news-item d-block border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="rounded mr-3 flex-shrink-0" style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center;">
                            @if($news->image)
                            <img src="{{ asset('storage/' . $news->image) }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 0.5rem;">
                            @else
                            <i class="fas fa-image text-white"></i>
                            @endif
                        </div>
                        <div class="overflow-hidden">
                            <h6 class="mb-0 text-truncate fw-600" style="font-size: 0.9rem;">{{ $news->title }}</h6>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($news->published_date)->format('d M Y') }}</small>
                        </div>
                    </div>
                </a>
                @empty
                <div class="p-4 text-center text-muted">Tiada berita terkini.</div>
                @endforelse
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center">
                <div class="rounded-circle p-2 mr-3" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                    <i class="fas fa-bell text-white"></i>
                </div>
                <h6 class="fw-700 mb-0">Aktiviti Terkini</h6>
            </div>
            <div class="card-body">
                @foreach ($recentInquiries->take(3) as $inquiry)
                <div class="d-flex mb-3 align-items-start pb-3 border-bottom">
                    <div class="rounded p-2 mr-3" style="background: #fff5f5;">
                        <i class="fas fa-question-circle text-danger"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-600" style="font-size: 0.9rem; color: var(--text-primary);">{{ $inquiry->title }}</h6>
                        <p class="mb-0 text-muted small">{{ Str::limit($inquiry->message ?? '', 50) }}</p>
                    </div>
                </div>
                @endforeach
                <a href="{{ route('inquiries.index') }}" class="btn btn-light btn-sm btn-block mt-2">Buka Semua Pertanyaan</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    new Chart(document.getElementById('donationChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: {!! json_encode($donationHistory->pluck('title')) !!},
            datasets: [{
                label: 'Jumlah Derma (RM)',
                data: {!! json_encode($donationHistory->pluck('current_amount')) !!},
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78,115,223,0.05)',
                fill: true, tension: 0.4, pointRadius: 4, borderWidth: 3
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false } },
                y: { grid: { borderDash: [5,5] }, ticks: { callback: v => 'RM ' + v } }
            }
        }
    });

    @if(auth()->user()->role === 'admin')
    new Chart(document.getElementById('userRoleChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Admin', 'Staff', 'Alumni'],
            datasets: [{
                data: [{{ $userCounts['admin'] ?? 0 }}, {{ $userCounts['staff'] ?? 0 }}, {{ $userCounts['user'] ?? 0 }}],
                backgroundColor: ['#36b9cc', '#4e73df', '#a12c2f'],
                hoverOffset: 10, borderWidth: 0
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } } },
            cutout: '75%'
        }
    });
    @endif

    @if(in_array(auth()->user()->role, ['user', 'staff']))
    const calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: { left: 'prev,next', center: 'title', right: 'today' },
            events: {!! json_encode($formattedEvents) !!},
            eventClick: info => window.location.href = info.event.url,
            height: 450, displayEventTime: false, eventDisplay: 'block'
        }).render();
    }
    @endif
});
</script>
@endsection