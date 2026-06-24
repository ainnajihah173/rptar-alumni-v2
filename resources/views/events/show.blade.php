@extends('layouts.staff-base')

@section('content')
    <div class="container my-4">
        <!-- Page Heading -->
        <div class="mb-3">
            <a href="{{ route('events.index') }}" class="text-decoration-none text-dark">
                <i class="fas fa-arrow-left"></i> Kembali ke Acara
            </a>
        </div>

        <!-- Event Header -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="row g-0">
                <div class="col-md-5">
                    <img src="{{ asset('storage/' . $events->image_path) }}" class="img-fluid rounded-start"
                        alt="{{ $events->name }}" style="object-fit: cover; height: 100%; max-height: 400px;">
                </div>
                <div class="col-md-7">
                    <div class="card-body">
                        <h3 class="card-title fw-bold text-dark">{{ $events->name }}</h3>
                        <div class="text-muted mb-3">
                            <p>
                                <i class="fas fa-calendar-alt me-2"></i>
                                @if ($events->start_date == $events->end_date)
                                    {{ \Carbon\Carbon::parse($events->start_date)->format('d M Y') }}
                                @else
                                    {{ \Carbon\Carbon::parse($events->start_date)->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($events->end_date)->format('d M Y') }}
                                @endif
                            </p>
                            <p>
                                <i class="fas fa-clock me-2"></i>
                                {{ date('h:i A', strtotime($events->start_time)) }} -
                                {{ $events->end_time ? date('h:i A', strtotime($events->end_time)) : 'TBD' }}
                            </p>
                        </div>
                        <p class="mb-3">
                            <strong>Penganjur:</strong> {{ $events->organizers->organizer_name ?? 'N/A' }}<br>
                            <strong>Hubungan:</strong> {{ $events->organizers->organizer_contact ?? 'N/A' }} |
                            {{ $events->organizers->organizer_email ?? 'N/A' }}
                        </p>
                        <p class="text-muted">{{ $events->description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Event Details Section -->
        <div class="row">
            <!-- Event Info -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Butiran Acara</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span><strong>Lokasi:</strong></span>
                                <span>{{ $events->location ?? 'TBD' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span><strong>Kapasiti:</strong></span>
                                <span>{{ $events->capacity }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span><strong>Slot Tersedia:</strong></span>
                                <span>{{ $events->capacity - $events->registered_count }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span><strong>Peserta Berdaftar:</strong></span>
                                <span>{{ $events->registered_count }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span><strong>Acara Aktif:</strong></span>
                                <span>
                                    {{ $events->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span><strong>Status Acara:</strong></span>
                                @if ($events->status === 'approved')
                                    <span class="badge rounded-pill text-white bg-success p-2">Diluluskan</span>
                                @elseif($events->status === 'rejected')
                                    <span class="badge rounded-pill text-white bg-danger p-2">Ditolak</span>
                                @else
                                    <span class="badge rounded-pill text-white bg-warning p-2">Dalam Proses</span>
                                @endif
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Registered Participants -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Peserta Berdaftar</h5>
                    </div>
                    <div class="card-body">
                        @if ($participants->isEmpty())
                            <p class="text-muted">Tiada peserta berdaftar lagi.</p>
                        @else
                            <table class="table table-striped table-responsive" id="dataTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Emel</th>
                                        <th>Hubungan</th>
                                        <th>Daftar Pada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($participants as $key => $participant)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $participant->users->profile->full_name }}</td>
                                            <td>{{ $participant->users->email }}</td>
                                            <td>{{ $participant->users->profile->contact_number }}</td>
                                            <td>{{ $participant->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection