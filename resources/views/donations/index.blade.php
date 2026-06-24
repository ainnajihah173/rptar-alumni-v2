@extends('layouts.staff-base')
@section('content')
    <!-- Page Heading -->
    @if (auth()->user()->role === 'staff' || auth()->user()->role === 'admin')
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-dark">Senarai Kempen</h6>
                @if (auth()->user()->role === 'staff')
                    <a href="{{ route('donations.create') }}" class="btn btn-sm btn-primary shadow-sm">
                        <i class="fas fa-plus fa-sm text-white-50"></i> Cipta Kempen
                    </a>
                @endif
            </div>
            <!-- Check if there are any campaigns -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tajuk Kempen</th>
                                <th>Jumlah Sasaran</th>
                                <th>Jumlah Semasa</th>
                                <th>Dicipta Oleh</th>
                                <th>Tarikh</th>
                                <th>Status</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($campaigns as $campaign)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{!! Str::limit($campaign->title, 20) !!}</td>
                                    <td>RM {{ number_format($campaign->target_amount, 2) }}</td>
                                    <td>RM {{ number_format($campaign->current_amount, 2) }}</td>
                                    <td>{{ $campaign->createdBy->profile->full_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($campaign->start_date)->format('d/m/Y') }} -
                                        {{ \Carbon\Carbon::parse($campaign->end_date)->format('d/m/Y') }}</td>
                                    <td>
                                        @if ($campaign->status == 'active')
                                            <span class="badge bg-primary text-white">Aktif</span>
                                        @elseif ($campaign->status == 'closed')
                                            <span class="badge bg-success text-white">Tutup</span>
                                        @elseif ($campaign->status == 'rejected')
                                            <span class="badge bg-danger text-white">Ditolak</span>
                                        @elseif($campaign->status == 'pending')
                                            <span class="badge bg-secondary text-white">Menunggu</span>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- View Campaign-->
                                        <a href="{{ route('donations.show', $campaign->id) }}">
                                            <i class="fas fa-eye text-dark mr-2"></i></a>
                                        <!-- Approve Reject -->
                                        @if (auth()->user()->role === 'admin' && $campaign->status === 'pending')
                                            <a href="#" class="action-icon-success" data-toggle="modal"
                                                data-target="#approveModal{{ $campaign->id }}">
                                                <i class="fas fa-check-circle text-success mr-2"></i>
                                            </a>
                                            <a href="#" class="action-icon-danger" data-toggle="modal"
                                                data-target="#rejectModal{{ $campaign->id }}">
                                                <i class="fas fa-times-circle text-danger mr-2"></i>
                                            </a>
                                        @endif
                                        <!-- Edit Campaign-->
                                        @if (auth()->user()->role === 'staff' &&
                                                in_array($campaign->status, ['pending', 'rejected']) &&
                                                $campaign->created_by === auth()->user()->id)
                                            <a href="{{ route('donations.edit', $campaign->id) }}">
                                                <i class="fas fa-edit mr-2"></i></a>

                                            <!-- Delete Campaign-->
                                            <a href="" class="action-icon-danger" data-toggle="modal"
                                                data-target="#delete-modal{{ $campaign->id }}">
                                                <i class="fas fa-trash text-danger"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                <!-- Delete Modal -->
                                <div class="modal fade" id="delete-modal{{ $campaign->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="deleteModalLabel"><i
                                                        class="fas fa-exclamation-triangle"></i> Padam Kempen</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <!-- Modal Body -->
                                            <div class="modal-body text-center">
                                                <p class="mb-0">Adakah anda pasti mahu memadam kempen ini?</p>
                                                <small class="text-muted">Tindakan ini tidak boleh dibatalkan.</small>
                                            </div>
                                            <!-- Modal Footer -->
                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    data-dismiss="modal">Batal</button>
                                                <form method="POST"
                                                    action="{{ route('donations.destroy', $campaign->id) }}"
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
                                <div class="modal fade" id="approveModal{{ $campaign->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="approveModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header bg-success text-white">
                                                <h5 class="modal-title" id="approveModalLabel">
                                                    <i class="fas fa-check-circle"></i> Luluskan Kempen
                                                </h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <!-- Modal Body -->
                                            <div class="modal-body text-center">
                                                <p class="mb-0">Adakah anda pasti mahu meluluskan kempen ini?</p>
                                                <small class="text-muted">Tindakan ini tidak boleh dibatalkan.</small>
                                            </div>
                                            <!-- Modal Footer -->
                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <form method="POST"
                                                    action="{{ route('donations.approve', $campaign->id) }}"
                                                    id="approveForm" class="d-inline-block">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success">Ya, Lulus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Reject Modal -->
                                <div class="modal fade" id="rejectModal{{ $campaign->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="rejectModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="rejectModalLabel">
                                                    <i class="fas fa-times-circle"></i> Tolak Kempen
                                                </h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <!-- Modal Body -->
                                            <div class="modal-body text-center">
                                                <p class="mb-0">Adakah anda pasti mahu menolak kempen ini?</p>
                                                <small class="text-muted">Tindakan ini tidak boleh dibatalkan.</small>
                                            </div>
                                            <!-- Modal Footer -->
                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <form method="POST"
                                                    action="{{ route('donations.reject', $campaign->id) }}"
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
    @else
        <div class="container-fluid">
            <h3 class="text-center" style="color: #eb3a2a;">Derma</h3>
            <p class="text-center text-muted">Setiap sumbangan bermakna. Derma hari ini.</p>

            <!-- Nav Tabs -->
            <ul class="nav nav-tabs mb-4" id="donationTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="donation-list-tab" data-bs-toggle="tab"
                        data-bs-target="#donation-list" type="button" role="tab" aria-controls="donation-list"
                        aria-selected="true">
                        Senarai Derma
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="user-donations-tab" data-bs-toggle="tab"
                        data-bs-target="#user-donations" type="button" role="tab" aria-controls="user-donations"
                        aria-selected="false">
                        Derma Saya
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="donationTabsContent">
                <!-- Donation List Tab -->
                <div class="tab-pane fade show active" id="donation-list" role="tabpanel"
                    aria-labelledby="donation-list-tab">
                    <div class="row gy-4">
                        @foreach ($activeCampaigns as $campaign)
                            <div class="col-md-6 col-lg-4">
                                <div class="card shadow-sm border-0 h-100">
                                    <img src="{{ $campaign->image_path ? asset('storage/' . $campaign->image_path) : asset('assets/images/default-event.jpg') }}"
                                        class="card-img-top" alt="{{ $campaign->title }}"
                                        style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title text-dark">{{ $campaign->title }}</h5>
                                        <p class="card-text text-muted">
                                            {{ Str::limit($campaign->description, 100, '...') }}
                                        </p>
                                        <!-- Date Range -->
                                        @php
                                            $startDate = \Carbon\Carbon::parse($campaign->start_date);
                                            $endDate = \Carbon\Carbon::parse($campaign->end_date);
                                        @endphp
                                        <p class="mb-2">
                                            <strong>Tarikh:</strong> {{ $startDate->format('d M Y') }} -
                                            {{ $endDate->format('d M Y') }}
                                        </p>
                                        <div class="progress mb-3" style="height: 20px;">
                                            @php
                                                $progress =
                                                    $campaign->target_amount > 0
                                                        ? ($campaign->current_amount / $campaign->target_amount) * 100
                                                        : 0;
                                            @endphp
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}"
                                                aria-valuemin="0" aria-valuemax="100">
                                                {{ number_format($progress, 0) }}%
                                            </div>
                                        </div>
                                        <p class="mb-1">
                                            <strong>Jumlah Dikumpul:</strong> RM {{ number_format($campaign->current_amount, 2) }}
                                        </p>
                                        <p>
                                            <strong>Jumlah Sasaran:</strong> RM
                                            {{ number_format($campaign->target_amount, 2) }}
                                        </p>
                                        <a href="{{ route('donations.edit', $campaign->id) }}"
                                            class="btn btn-danger btn-block w-100">
                                            Buat Derma
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Pagination Section -->
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <li class="page-item {{ $activeCampaigns->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $activeCampaigns->previousPageUrl() }}" tabindex="-1"
                                    aria-disabled="true">Sebelumnya</a>
                            </li>
                            @for ($i = 1; $i <= $activeCampaigns->lastPage(); $i++)
                                <li class="page-item {{ $activeCampaigns->currentPage() === $i ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $activeCampaigns->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ $activeCampaigns->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $activeCampaigns->nextPageUrl() }}">Seterusnya</a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- User Donations Tab -->
                <div class="tab-pane fade" id="user-donations" role="tabpanel" aria-labelledby="user-donations-tab">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-dark">Senarai Derma Saya</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Tajuk Kempen</th>
                                            <th>Jumlah</th>
                                            <th>Tarikh</th>
                                            <th>Status</th>
                                            <th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($userDonations as $donation)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $donation->campaign->title }}</td>
                                                <td>RM {{ number_format($donation->amount, 2) }}</td>
                                                <td>{{ $donation->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    @if ($donation->payment_status == 'successful')
                                                        <span class="badge bg-success text-white">Berjaya</span>
                                                    @else
                                                        <span class="badge bg-warning text-white">Menunggu</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <!-- View Campaign-->
                                                    <a href="{{ route('donations.receipt', $donation->id) }}">
                                                        <i class="fas fa-download text-dark mr-2"></i></a>
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

            .progress-bar {
                transition: width 0.5s ease-in-out;
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