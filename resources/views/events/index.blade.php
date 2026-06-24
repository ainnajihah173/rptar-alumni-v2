@extends('layouts.staff-base')
@section('content')
    <!-- Page Heading -->
    @if (auth()->user()->role === 'staff' || auth()->user()->role === 'admin')
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-dark">Kandungan Acara</h6>
                @if (auth()->user()->role === 'staff')
                    <div class="d-flex">
                        <a href="{{ route('events.create') }}" class="btn btn-sm btn-primary shadow-sm me-2 mr-3">
                            <i class="fas fa-plus fa-sm text-white-50"></i> Cipta Acara
                        </a>
                        <a href="#" class="btn btn-sm btn-info shadow-sm" data-toggle="modal"
                            data-target="#addOrganizerModal">
                            <i class="fas fa-plus fa-sm text-dark-50"></i> Tambah Penganjur
                        </a>
                    </div>
                @endif
            </div>
            <!-- Check if there is any news -->

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Acara</th>
                                <th>Penerangan Acara</th>
                                <th>Butiran Acara</th> <!-- Tarikh, Masa, Lokasi --->
                                @if (auth()->user()->role === 'admin')
                                    <th>Butiran Penganjur</th>
                                @endif
                                <th>Aktif Acara</th>
                                <th>Status</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $events)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{!! Str::limit($events->name, 15) !!}</td>
                                    <td>{!! Str::limit($events->description, 30) !!}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <!-- Date Range -->
                                            <div class="mb-2">
                                                <span class="text-muted">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    @if ($events->start_date == $events->end_date)
                                                        {{ \Carbon\Carbon::parse($events->start_date)->format('d M Y') }}
                                                    @else
                                                        {{ \Carbon\Carbon::parse($events->start_date)->format('d M Y') }} -
                                                        {{ \Carbon\Carbon::parse($events->end_date)->format('d M Y') }}
                                                    @endif
                                                </span>
                                            </div>
                                            <!-- Time Range -->
                                            <div class="mb-2">
                                                <span class="text-muted">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ date('h:i A', strtotime($events->start_time)) }} -
                                                    {{ $events->end_time ? date('h:i A', strtotime($events->end_time)) : 'TBD' }}
                                                </span>
                                            </div>

                                            <!-- Location -->
                                            <div>
                                                <span class="text-muted">
                                                    <i class="fas fa-map-marker-alt me-1"></i>
                                                    {{ $events->location }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    @if (auth()->user()->role === 'admin')
                                        <td>
                                            Dianjurkan Oleh : {{ $events->organizers->organizer_name }}<br>
                                            Emel : {{ $events->organizers->organizer_email }}
                                        </td>
                                    @endif
                                    <td>{{ $events->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
                                    <td>
                                        @if ($events->status === 'pending')
                                            <span class="badge bg-warning text-white">Dalam Proses</span>
                                        @elseif($events->status === 'approved')
                                            <span class="badge bg-success text-white">Diluluskan</span>
                                        @else
                                            <span class="badge bg-danger text-white">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Approve Reject -->
                                        @if (auth()->user()->role === 'admin' && $events->status === 'pending')
                                            <a href="#" class="action-icon-success" data-toggle="modal"
                                                data-target="#approveModal{{ $events->id }}">
                                                <i class="fas fa-check-circle text-success mr-2"></i>
                                            </a>
                                            <a href="#" class="action-icon-danger" data-toggle="modal"
                                                data-target="#rejectModal{{ $events->id }}">
                                                <i class="fas fa-times-circle text-danger mr-2"></i>
                                            </a>
                                        @endif
                                        <!-- Show Page-->
                                        <a href="{{ route('events.show', $events->id) }}">
                                            <i class="fas fa-eye text-dark mr-2"></i></a>
                                        <!-- Edit Page-->
                                        @if (auth()->user()->role === 'staff' && in_array($events->status, ['pending', 'rejected']) && $events->created_by === auth()->user()->id)
                                            <a href="{{ route('events.edit', $events->id) }}">
                                                <i class="fas fa-edit mr-2"></i></a>

                                            <!-- Delete Page -->
                                            <a href="#" class="action-icon-danger" data-toggle="modal"
                                                data-target="#delete-modal{{ $events->id }}">
                                                <i class="fas fa-trash text-danger"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <!-- Delete Modal -->
                                <div class="modal fade" id="delete-modal{{ $events->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="deleteModalLabel"><i
                                                        class="fas fa-exclamation-triangle"></i> Padam Acara</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <!-- Modal Body -->
                                            <div class="modal-body text-center">
                                                <p class="mb-0">Adakah anda pasti mahu memadam acara ini?</p>
                                                <small class="text-muted">Tindakan ini tidak boleh dibatalkan.</small>
                                            </div>
                                            <!-- Modal Footer -->
                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    data-dismiss="modal">Batal</button>
                                                <form method="POST" action="{{ route('events.destroy', $events->id) }}"
                                                    class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Ya,
                                                        Padam</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Approve Modal -->
                                <div class="modal fade" id="approveModal{{ $events->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="approveModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header bg-success text-white">
                                                <h5 class="modal-title" id="approveModalLabel">
                                                    <i class="fas fa-check-circle"></i> Luluskan Acara
                                                </h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <!-- Modal Body -->
                                            <div class="modal-body text-center">
                                                <p class="mb-0">Adakah anda pasti mahu meluluskan acara ini?</p>
                                                <small class="text-muted">Tindakan ini tidak boleh dibatalkan.</small>
                                            </div>
                                            <!-- Modal Footer -->
                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <form method="POST" action="{{ route('events.approve', $events->id) }}"
                                                    id="approveForm" class="d-inline-block">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success">Ya, Luluskan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Reject Modal -->
                                <div class="modal fade" id="rejectModal{{ $events->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="rejectModalLabel">
                                                    <i class="fas fa-times-circle"></i> Tolak Acara
                                                </h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <!-- Modal Body -->
                                            <div class="modal-body text-center">
                                                <p class="mb-0">Adakah anda pasti mahu menolak acara ini?</p>
                                                <small class="text-muted">Tindakan ini tidak boleh dibatalkan.</small>
                                            </div>
                                            <!-- Modal Footer -->
                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <form method="POST" action="{{ route('events.reject', $events->id) }}"
                                                    id="rejectForm" class="d-inline-block">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-danger">Ya, Tolak</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Organizer Modal -->
        <div class="modal fade" id="addOrganizerModal" tabindex="-1" role="dialog"
            aria-labelledby="addOrganizerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="addOrganizerModalLabel">
                            <i class="fas fa-plus"></i> Tambah Penganjur
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form action="{{ route('events.addOrganizer') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="organizer_name">Nama Penganjur<span class="text-danger">*</span></label>
                                <input type="text" id="organizer_name" name="organizer_name" class="form-control"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="organizer_contact">Nombor Telefon<span class="text-danger">*</span></label>
                                <input type="text" id="organizer_contact" name="organizer_contact"
                                    class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="organizer_email">Emel<span class="text-danger">*</span></label>
                                <input type="email" id="organizer_email" name="organizer_email" class="form-control"
                                    required>
                            </div>
                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container-fluid">
            <h3 class="text-center" style="color: #eb3a2a;">Acara</h3>
            <p class="text-center text-muted">Sertai acara kami dan kekal berhubung.</p>

            <!-- Nav Tabs -->
            <ul class="nav nav-tabs mb-4" id="eventTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="event-list-tab" data-bs-toggle="tab"
                        data-bs-target="#event-list" type="button" role="tab" aria-controls="event-list"
                        aria-selected="true">
                        Senarai Acara
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="user-events-tab" data-bs-toggle="tab" data-bs-target="#user-events"
                        type="button" role="tab" aria-controls="user-events" aria-selected="false">
                        Acara Saya
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="eventTabsContent">
                <!-- Event List Tab -->
                <div class="tab-pane fade show active" id="event-list" role="tabpanel" aria-labelledby="event-list-tab">
                    <div class="row gy-4">
                        @foreach ($events as $event)
                            @if ($event->is_active && \Carbon\Carbon::now()->lte($event->end_date) && $event->registered_count < $event->capacity)
                                <div class="col-md-6 col-lg-4 mt-3">
                                    <div class="card shadow-sm border-0 h-100">
                                        <img src="{{ $event->image_path ? asset('storage/' . $event->image_path) : asset('assets/images/default-event.jpg') }}"
                                            class="card-img-top" alt="{{ $event->name }}"
                                            style="height: 200px; object-fit: cover;">
                                        <div class="card-body">
                                            <h5 class="card-title text-danger">{{ $event->name }}</h5>
                                            <p class="card-text text-muted">
                                                {{ Str::limit($event->description, 100, '...') }}
                                            </p>
                                            <p class="mb-1">
                                                <i class="fas fa-calendar"></i>
                                                @if ($event->start_date == $event->end_date)
                                                    {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                                                @else
                                                    {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }} -
                                                    {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}
                                                @endif
                                            </p>
                                            <p class="mb-1">
                                                <i class="fas fa-clock"></i>
                                                {{ date('h:i A', strtotime($event->start_time)) }} -
                                                {{ $event->end_time ? date('h:i A', strtotime($event->end_time)) : 'TBD' }}
                                            </p>
                                            <p class="mb-3">
                                                <i class="fas fa-map-marker-alt"></i> {{ $event->location }}
                                            </p>
                                            <p class="mb-3">
                                                <strong>Slot Tersedia:</strong>
                                                {{ $event->capacity - $event->registered_count }}
                                            </p>
                                            @if ($event->participants->contains('user_id', auth()->id()))
                                                <a class="btn btn-secondary btn-block w-100 mt-2" disabled>
                                                    Sudah Daftar
                                                </a>
                                            @else
                                                <a href="" class="btn btn-danger btn-block w-100 mt-2"
                                                    data-toggle="modal" data-target="#eventModal{{ $event->id }}">
                                                    Daftar Sekarang
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="eventModal{{ $event->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="eventModalLabel{{ $event->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title font-weight-bold"
                                                    id="eventModalLabel{{ $event->id }}">
                                                    {{ $event->name }}</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <!-- Modal Body -->
                                            <div class="modal-body">
                                                <div class="row">
                                                    <!-- Event Image -->
                                                    <div class="col-md-5">
                                                        <img src="{{ $event->image_path ? asset('storage/' . $event->image_path) : asset('assets/images/default-event.jpg') }}"
                                                            alt="Gambar Acara" class="img-fluid rounded-lg shadow-sm mb-3">
                                                    </div>

                                                    <!-- Event Details -->
                                                    <div class="col-md-7">
                                                        <div class="event-details">
                                                            <p class="mb-3">
                                                                <strong>Penganjur:</strong>
                                                                <span
                                                                    class="text-muted">{{ $event->organizers->organizer_name }}</span>
                                                            </p>
                                                            <p class="mb-3">
                                                                <strong>Hubungan:</strong>
                                                                <span
                                                                    class="text-muted">{{ $event->organizers->organizer_contact }}</span>
                                                            </p>
                                                            <p class="mb-3">
                                                                <strong>Emel:</strong>
                                                                <span
                                                                    class="text-muted">{{ $event->organizers->organizer_email }}</span>
                                                            </p>
                                                            <p class="mb-3">
                                                                <strong>Tarikh:</strong>
                                                                <span class="text-muted">
                                                                    @if ($event->start_date == $event->end_date)
                                                                        {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                                                                    @else
                                                                        {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                                                                        -
                                                                        {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}
                                                                    @endif
                                                                </span>
                                                            </p>
                                                            <p class="mb-3">
                                                                <strong>Masa:</strong>
                                                                <span class="text-muted">
                                                                    {{ date('h:i A', strtotime($event->start_time)) }} -
                                                                    {{ $event->end_time ? date('h:i A', strtotime($event->end_time)) : 'TBD' }}
                                                                </span>
                                                            </p>
                                                            <p class="mb-3">
                                                                <strong>Lokasi:</strong>
                                                                <span class="text-muted">{{ $event->location }}</span>
                                                            </p>
                                                            <p class="mb-3">
                                                                <strong>Penerangan:</strong>
                                                                <span class="text-muted">{{ $event->description }}</span>
                                                            </p>
                                                            <p class="mb-3">
                                                                <strong>Kapasiti:</strong>
                                                                <span class="text-muted">{{ $event->capacity }}</span>
                                                            </p>
                                                            <p class="mb-3">
                                                                <strong>Slot Tersedia:</strong>
                                                                <span
                                                                    class="text-muted">{{ $event->capacity - $event->registered_count }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Footer -->
                                            <div class="modal-footer d-flex justify-content-between">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-dismiss="modal">Tutup</button>
                                                <form action="{{ route('events.register', $event->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-lg">
                                                        <i class="fas fa-check-circle"></i> Sahkan Pendaftaran
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Pagination Section -->
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <li class="page-item {{ $events->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $events->previousPageUrl() }}" tabindex="-1"
                                    aria-disabled="true">Sebelumnya</a>
                            </li>
                            @for ($i = 1; $i <= $events->lastPage(); $i++)
                                <li class="page-item {{ $events->currentPage() === $i ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $events->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ $events->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $events->nextPageUrl() }}">Seterusnya</a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- User Events Tab -->
                <div class="tab-pane fade" id="user-events" role="tabpanel" aria-labelledby="user-events-tab">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-dark">Senarai Acara Saya</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Tajuk Acara</th>
                                            <th>Tarikh</th>
                                            <th>Lokasi</th>
                                            <th>Status</th>
                                            <th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($registeredEvents as $userEvent)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $userEvent->name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($userEvent->start_date)->format('F d, Y') }}
                                                </td>
                                                <td>{{ $userEvent->location }}</td>
                                                <td>
                                                    @if ($userEvent->is_active)
                                                        <span class="badge bg-success text-white">Aktif</span>
                                                    @else
                                                        <span class="badge bg-warning text-white">Tidak Aktif</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <!-- Show Page-->
                                                    <a href="{{ route('events.show', $userEvent->id) }}">
                                                        <i class="fas fa-eye text-dark mr-2"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .card {
                transition: transform 0.2s, box-shadow 0.2s;
            }

            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }

            .nav-tabs .nav-link {
                font-weight: 500;
                color: #6c757d;
                border: none;
            }


            .pagination .page-item.active .page-link {
                background-color: #dc3545;
                border-color: #dc3545;
                color: white;
            }

            /*Modal*/
            /* Custom Modal Styling */
            .modal-content {
                border: none;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            }

            .modal-header {
                border-top-left-radius: 10px;
                border-top-right-radius: 10px;
                padding: 1rem;
            }

            .modal-title {
                font-size: 20px;
                font-weight: 600;
            }

            .modal-body {
                padding: 1rem;
            }

            .modal-footer {
                border-bottom-left-radius: 10px;
                border-bottom-right-radius: 10px;
                padding: 1rem;
                border-top: 1px solid #e9ecef;
            }

            .event-details p {
                margin-bottom: 1rem;
                font-size: 1rem;
                line-height: 1.6;
            }

            .event-details strong {
                color: #333;
                font-weight: 600;
            }

            .event-details .text-muted {
                color: #6c757d;
            }

            .btn-danger {
                background-color: #dc3545;
                border: none;
                padding: 0.5rem;
                font-size: 1rem;
                font-weight: 600;
                transition: background-color 0.3s ease;
            }

            .btn-danger:hover {
                background-color: #c82333;
            }

            .btn-outline-secondary {
                border: 1px solid #6c757d;
                color: #6c757d;
                transition: all 0.3s ease;
            }

            .btn-outline-secondary:hover {
                background-color: #6c757d;
                color: #fff;
            }

            .img-fluid.rounded-lg {
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .nav-tabs .nav-link {
                font-weight: 500;
                color: #6c757d;
                border: none;
            }

            .nav-tabs .nav-link.active {
                color: #dc3545;
                border-bottom: 2px solid #dc3545;
            }
        </style>

        <!-- Bootstrap 5 JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @endif
@endsection