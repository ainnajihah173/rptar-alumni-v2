<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>RPTAR Alumni</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/cuba.png') }}">

    <!-- Custom fonts for this template-->
    <link href="{{ asset('../assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('../assets/css/sb-admin-2.css') }}" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css">
    <!-- Buttons CSS -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <!-- Blog Editor -->
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css" />

    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- jQuery and jQuery UI JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

    <style>
        .step-icon {
            font-size: 1.5rem;
        }

        .progress-bar {
            transition: width 0.4s;
        }
    </style>

</head>

<body id="page-top">


    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->

        @if (auth()->user()->role === 'admin')
            <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">
            @elseif(auth()->user()->role === 'staff')
                <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
                @else
                    <ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">
        @endif

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
            <div class="sidebar-brand-text mx-3">
                <img src="{{ asset('../assets/images/RP3.png') }}" alt="Logo" style="width: 110px; height: auto;">
            </div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        @if (auth()->user()->profile->full_name)
            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Halaman Utama</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Pilihan
            </div>

            @if (auth()->user()->role === 'staff' || auth()->user()->role === 'user')
                <!-- Nav Item - News -->
                <li class="nav-item {{ request()->routeIs('news.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('news.index') }}">
                        <i class="fas fa-fw fa-newspaper"></i>
                        <span>Berita</span></a>
                </li>
            @endif

            @if (auth()->user()->role === 'admin')
                <!-- Nav Item - News -->
                <li class="nav-item {{ request()->routeIs('user.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('user.index') }}">
                        <i class="fas fa-fw fa-user"></i>
                        <span>Pengguna</span></a>
                </li>
            @endif

            <li class="nav-item {{ request()->routeIs('events.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('events.index') }}">
                    <i class="fas fa-fw fa-calendar"></i>
                    <span>Acara</span></a>
            </li>

            {{-- <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
                aria-expanded="true" aria-controls="collapseThree">
                <i class="fas fa-fw fa-credit-card"></i>
                <span>Donations</span>
            </a>
            <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-gray-400 py-2 collapse-inner rounded">
                    <a class="collapse-item" href="">List of Donations</a>
                    <a class="collapse-item" href="cards.html">List of Donors</a>
                </div>
            </div>
        </li> --}}

            <!-- Nav Item - News -->
            <li class="nav-item {{ request()->routeIs('donations.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('donations.index') }}">
                    <i class="fas fa-fw fa-credit-card"></i>
                    <span>Derma</span></a>
            </li>

            @if (auth()->user()->role === 'user')
                <!-- Nav Item - News -->
                <li class="nav-item {{ request()->routeIs('message.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('message.index') }}">
                        <i class="fas fa-fw fa-comment"></i>
                        <span>Mesej</span></a>
                </li>
            @endif

            <!-- Nav Item - News -->
            <li class="nav-item {{ request()->routeIs('inquiries.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('inquiries.index') }}">
                    <i class="fas fa-fw fa-envelope"></i>
                    <span>Pertanyaan</span></a>
            </li>

            @if (auth()->user()->role === 'staff' || auth()->user()->role === 'user')
                <!-- Nav Item - News -->
                <li class="nav-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('profile.index') }}">
                        <i class="fas fa-fw fa-address-card"></i>
                        <span>Profil Alumni</span></a>
                </li>
            @endif
        @endif
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Alerts
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                 Counter - Alerts
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                             Dropdown - Alerts
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to
                                            download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All
                                    Alerts</a>
                            </div>
                        </li>-->

                        <!-- Nav Item - Messages -->
                        @if (auth()->user()->role === 'user')
                            <li class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown"
                                    role="button" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fas fa-comment fa-fw"></i>
                                    <!-- Counter - Messages -->
                                    <span class="badge badge-danger badge-counter">{{ $inboxCount }}</span>
                                </a>
                            </li>
                        @endif
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                                <img class="img-profile rounded-circle"
                                    src="{{ auth()->user()->profile && auth()->user()->profile->profile_pic ? asset('storage/' . auth()->user()->profile->profile_pic) : asset('assets/images/default-avatar.png') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('profile.edit', auth()->user()->id) }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Log Keluar
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @if (session()->has('success'))
                        <br>
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    @if (session()->has('warning'))
                        <br>
                        <div class="alert alert-warning">
                            {{ session()->get('warning') }}
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <br>
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    <!-- Page Content -->
                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; RPTAR Alumni
                            <script>
                                document.write(new Date().getFullYear())
                            </script>
                        </span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4" style="border-radius: 15px;">
                <!-- Icon -->
                <div class="mx-auto d-flex justify-content-center align-items-center mb-3"
                    style="width: 60px; height: 60px; background-color: #e0f4ff; border-radius: 50%;">
                    <i class="fas fa-sign-out-alt text-primary"></i>
                </div>
                <!-- Modal Header -->
                <h5 class="modal-title fw-bold mb-2" id="logoutModalLabel">Anda Pasti Untuk Log Keluar?</h5>
                <p class="text-muted mb-4">
                    Klik "Log Keluar" di bawah untuk keluar dengan selamat.
                </p>
                <!-- Buttons -->
                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-secondary px-4 mr-4" data-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" class="btn btn-danger px-4"
                        onclick="document.getElementById('logout-form').submit();">
                        Log Keluar
                    </button>
                </div>
            </div>
        </div>
    </div>



    <!-- Hidden Logout Form -->
    <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
        @csrf
    </form>
    <!-- Add the following JavaScript to auto-dismiss the alert after 3 seconds -->
    <script>
        setTimeout(function() {
            $('.alert').alert('close');
        }, 4000); // 5000 milliseconds = 4 seconds
    </script>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('../assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('../assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('../assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('../assets/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('../assets/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level plugins -->
    {{-- <script src="{{ asset('../assets/vendor/datatables/jquery.dataTables.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('../assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script> --}}

    <!-- DataTables and Buttons JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

    <!-- Text Editor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.umd.js"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                dom: 'Bfrtip', // Add buttons to the DOM
                buttons: [
                    'csv', 'excel', 'pdf' // Add the buttons you want
                ]
            });

            $('#data').DataTable({
                lengthChange: false, // Disable length change dropdown
            });
        });

        $(document).ready(function() {
            // Select All Checkbox
            $('#selectAll').on('click', function() {
                const isChecked = $(this).prop('checked');
                $('.select-checkbox').prop('checked', isChecked);
                toggleDeleteButton();
            });

            // Individual Checkbox Click
            $('#data tbody').on('click', '.select-checkbox', function() {
                if (!$(this).prop('checked')) {
                    $('#selectAll').prop('checked', false);
                }
                toggleDeleteButton();
            });

            // Toggle Delete Button State
            function toggleDeleteButton() {
                const anyChecked = $('.select-checkbox:checked').length > 0;
                $('#deleteSelected').prop('disabled', !anyChecked);
            }

            // Handle Delete Confirmation Modal
            $('#deleteSelected').on('click', function() {
                const selectedIds = $('.select-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                // Set the selected IDs in the hidden input field
                $('#selected_ids').val(selectedIds.join(','));
            });
        });

        // document.addEventListener('DOMContentLoaded', function() {
        // const userRole = "{{ auth()->user()->role }}"; // Get the user's role

        // // Only run this script for users
        // if (userRole === 'user') {
        //     const messageBadge = document.querySelector('#messagesDropdown .badge-counter');
        //     const inboxBadge = document.querySelector('.sidebar .badge-danger'); // Inbox badge in the sidebar
        //     let lastChecked = new Date().toISOString(); // Initialize with the current time

        //     // Function to fetch new message count
        //     function fetchNewMessageCount() {
        //         fetch(`/messages/new-count?last_checked=${lastChecked}`)
        //             .then(response => response.json())
        //             .then(data => {
        //                 if (data.count > 0) {
        //                     // Update the notification badge in staff-base
        //                     if (messageBadge) {
        //                         messageBadge.textContent = data.count; // Set the total count
        //                     }

        //                     // Update the inbox badge in the index page
        //                     if (inboxBadge) {
        //                         inboxBadge.textContent = data.count; // Set the total count
        //                     }

        //                     // Update the last checked time
        //                     lastChecked = new Date().toISOString();
        //                 }
        //             })
        //             .catch(error => console.error('Error fetching new message count:', error));
        //     }

        //     // Fetch the initial count when the page loads
        //     fetchNewMessageCount();

        //     // Poll the server every 10 seconds
        //     setInterval(fetchNewMessageCount, 2000); // Adjust the interval as needed
        // }
        // });

        // const {
        //     ClassicEditor,
        //     Essentials,
        //     Bold,
        //     Italic,
        //     Font,
        //     Paragraph
        // } = CKEDITOR;

        // ClassicEditor
        //     .create(document.querySelector('#editor'), {
        //         plugins: [Essentials, Bold, Italic, Font, Paragraph],
        //         toolbar: [
        //             'undo', 'redo', '|', 'bold', 'italic', '|',
        //             'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
        //         ]
        //     })
        //     .catch(error => {
        //         console.error('Error initializing CKEditor:', error);
        //     });
    </script>

    <!-- JavaScript for Multi-Step Form -->
    <script>
        const steps = document.querySelectorAll(".step-content");
        const progressBar = document.getElementById("progress-bar");
        const icons = document.querySelectorAll(".step-icon");
        let currentStep = 0;

        document.querySelectorAll(".next-btn").forEach(btn => {
            btn.addEventListener("click", () => {
                steps[currentStep].classList.add("d-none");
                icons[currentStep].classList.remove("text-primary");
                currentStep++;
                steps[currentStep].classList.remove("d-none");
                icons[currentStep].classList.add("text-primary");
                updateProgressBar();
            });
        });

        document.querySelectorAll(".prev-btn").forEach(btn => {
            btn.addEventListener("click", () => {
                steps[currentStep].classList.add("d-none");
                icons[currentStep].classList.remove("text-primary");
                currentStep--;
                steps[currentStep].classList.remove("d-none");
                icons[currentStep].classList.add("text-primary");
                updateProgressBar();
            });
        });

        function updateProgressBar() {
            const progressPercentage = ((currentStep + 1) / steps.length) * 100;
            progressBar.style.width = `${progressPercentage}%`;
        }
    </script>





</body>

</html>
