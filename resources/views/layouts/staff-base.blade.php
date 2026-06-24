<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>RPTAR Alumni | Dashboard</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/cuba.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <style>
        :root {
            --accent-color: {{ auth()->user()->role === 'admin' ? '#0ea5e9' : (auth()->user()->role === 'staff' ? '#6366f1' : '#f43f5e') }};
            --accent-hover: {{ auth()->user()->role === 'admin' ? '#0284c7' : (auth()->user()->role === 'staff' ? '#4f46e5' : '#e11d48') }};
        }
    </style>
</head>
<body>
    <div class="app-wrapper">
        <!-- Sidebar -->
        <aside class="app-sidebar" id="sidebar">
            <div class="sidebar-brand">
                <img src="{{ asset('assets/images/RP3.png') }}" alt="Logo">
            </div>
            <div class="sidebar-heading">Menu Utama</div>
            @if (auth()->user()->profile && auth()->user()->profile->full_name)
            <ul class="sidebar-nav">
                <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="sidebar-link"><i class="fas fa-th-large"></i> Dashboard</a>
                </li>
            </ul>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Pengurusan</div>
            <ul class="sidebar-nav">
                @if (in_array(auth()->user()->role, ['staff', 'user']))
                <li class="sidebar-item {{ request()->routeIs('news.index') ? 'active' : '' }}">
                    <a href="{{ route('news.index') }}" class="sidebar-link"><i class="fas fa-newspaper"></i> Berita & Info</a>
                </li>
                @endif
                @if (auth()->user()->role === 'admin')
                <li class="sidebar-item {{ request()->routeIs('user.index') ? 'active' : '' }}">
                    <a href="{{ route('user.index') }}" class="sidebar-link"><i class="fas fa-users"></i> Pengguna Sistem</a>
                </li>
                @endif
                <li class="sidebar-item {{ request()->routeIs('events.index') ? 'active' : '' }}">
                    <a href="{{ route('events.index') }}" class="sidebar-link"><i class="fas fa-calendar-alt"></i> Acara Alumni</a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('donations.index') ? 'active' : '' }}">
                    <a href="{{ route('donations.index') }}" class="sidebar-link"><i class="fas fa-heart"></i> Tabung Derma</a>
                </li>
                @if (auth()->user()->role === 'user')
                <li class="sidebar-item {{ request()->routeIs('message.index') ? 'active' : '' }}">
                    <a href="{{ route('message.index') }}" class="sidebar-link"><i class="fas fa-comment-alt"></i> Mesej Terus</a>
                </li>
                @endif
                <li class="sidebar-item {{ request()->routeIs('inquiries.index') ? 'active' : '' }}">
                    <a href="{{ route('inquiries.index') }}" class="sidebar-link"><i class="fas fa-question-circle"></i> Pertanyaan</a>
                </li>
                @if (in_array(auth()->user()->role, ['staff', 'user']))
                <li class="sidebar-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                    <a href="{{ route('profile.index') }}" class="sidebar-link"><i class="fas fa-id-card"></i> Profil Alumni</a>
                </li>
                @endif
            </ul>
            @endif
            <hr class="sidebar-divider">
            <button class="sidebar-toggle-btn" id="sidebarToggle"><i class="fas fa-bars"></i></button>
        </aside>

        <!-- Main Content -->
        <div class="app-main">
            <!-- Topbar -->
            <header class="app-topbar">
                <div class="topbar-left">
                    <button class="topbar-toggle" id="mobileToggle"><i class="fas fa-bars"></i></button>
                    <div class="topbar-greeting">
                        <h5>Selamat Datang, <span>{{ auth()->user()->name }}</span></h5>
                        <small>Pantau aktiviti terkini alumni RPTAR</small>
                    </div>
                </div>
                <div class="topbar-right">
                    @if (auth()->user()->role === 'user')
                    <a href="#" class="topbar-btn position-relative">
                        <i class="fas fa-envelope"></i>
                        <span class="badge-dot"></span>
                    </a>
                    @endif
                    <div class="topbar-divider"></div>
                    <div class="dropdown">
                        <div class="topbar-profile" data-toggle="dropdown">
                            <img src="{{ auth()->user()->profile && auth()->user()->profile->profile_pic ? asset('storage/' . auth()->user()->profile->profile_pic) : asset('assets/images/default-avatar.png') }}">
                            <span class="profile-name d-none d-lg-inline">{{ auth()->user()->name }}</span>
                        </div>
                        <div class="dropdown-menu">
                            <a href="{{ route('profile.edit', auth()->user()->id) }}" class="dropdown-item"><i class="fas fa-user"></i> Kemaskini Profil</a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item text-danger" data-toggle="modal" data-target="#logoutModal"><i class="fas fa-sign-out-alt"></i> Log Keluar</a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="page-content">
                @if (session()->has('success'))
                <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session()->get('success') }}</div>
                @endif
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="app-footer">
                <span>Copyright &copy; 2024 <strong>RPTAR Alumni</strong> Portal</span>
            </footer>
        </div>
    </div>

    <!-- Scroll to Top -->
    <a href="#" class="scroll-top" id="scrollTop"><i class="fas fa-angle-up"></i></a>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-5">
                <div class="mb-4">
                    <div class="rounded-circle bg-danger d-inline-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                        <i class="fas fa-sign-out-alt text-white fa-2x"></i>
                    </div>
                </div>
                <h5 class="fw-700 mb-2">Log Keluar?</h5>
                <p class="text-muted mb-4">Adakah anda pasti mahu menamatkan sesi ini?</p>
                <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-light px-4" data-dismiss="modal">Batal</button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-danger px-4">Ya, Log Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        $(document).ready(function() {
            // Auto-hide alerts
            setTimeout(function() { $('.alert').fadeOut('slow'); }, 5000);
            
            // DataTables
            $('.table').DataTable({
                language: { search: "_INPUT_", searchPlaceholder: "Cari...", lengthMenu: "Paparan _MENU_ setiap muka", zeroRecords: "Tiada rekod ditemui", info: "Menunjukkan _START_ hingga _END_ daripada _TOTAL_ rekod", infoEmpty: "Tiada rekod", infoFiltered: "(ditapis daripada _MAX_ jumlah rekod)" }
            });
            
            // Sidebar Toggle
            $('#sidebarToggle').click(function() { $('#sidebar').toggleClass('collapsed'); $('.app-main').toggleClass('expanded'); });
            $('#mobileToggle').click(function() { $('#sidebar').toggleClass('open'); });
            
            // Dropdown Toggle
            $('[data-toggle="dropdown"]').click(function(e) {
                e.stopPropagation();
                $(this).next('.dropdown-menu').toggleClass('show');
            });
            $(document).click(function() { $('.dropdown-menu').removeClass('show'); });
            
            // Modal
            $('[data-toggle="modal"]').click(function() {
                var target = $(this).data('target');
                $(target).addClass('show');
            });
            $('[data-dismiss="modal"]').click(function() {
                $(this).closest('.modal').removeClass('show');
            });
            $(document).keydown(function(e) { if (e.key === 'Escape') $('.modal').removeClass('show'); });
            
            // Scroll to Top
            $(window).scroll(function() {
                if ($(this).scrollTop() > 300) { $('#scrollTop').addClass('visible'); } 
                else { $('#scrollTop').removeClass('visible'); }
            });
            $('#scrollTop').click(function(e) { e.preventDefault(); $('html, body').animate({ scrollTop: 0 }, 300); });
        });
    </script>
</body>
</html>