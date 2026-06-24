@extends('layouts.staff-base')
@section('content')
    <!-- Page Heading -->
    <div class="mb-3">
        <a href="{{ route('donations.index') }}" class="text-decoration-none text-dark">
            <i class="fas fa-arrow-left"></i> Kembali ke Senarai Derma
        </a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-dark">Paparan Derma</h6>
        </div>

        <div class="card-body">
            <!-- Campaign Preview Section -->
            <div class="campaign-preview p-4 border rounded bg-light">
                <h5 class="font-weight-bold text-dark mb-3">Pratonton Kempen</h5>
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ $campaigns->image_path ? asset('storage/' . $campaigns->image_path) : asset('assets/images/default-event.jpg') }}"
                            alt="Gambar Kempen" class="img-fluid rounded shadow-sm">
                    </div>
                    <div class="col-md-8">
                        <!-- Status Badge -->
                        @php
                            $status = $campaigns->status;
                            $formattedStatus = ucfirst($status); 
                            $badgeColor = match ($status) {
                                'pending' => 'badge-secondary',
                                'rejected' => 'badge-danger',
                                'closed' => 'badge-success',
                                'active' => 'badge-primary',
                                default => 'badge-warning', // Fallback for unknown statuses
                            };
                        @endphp
                        <div class="mb-3">
                            <span class="badge {{ $badgeColor }}">{{ $formattedStatus }}</span>
                        </div>
        
                        <!-- Campaign Title and Description -->
                        <h4 class="text-dark">{{ $campaigns->title }}</h4>
                        <p class="text-muted">{{ $campaigns->description }}</p>
        
                        <!-- Date Range -->
                        @php
                            $startDate = \Carbon\Carbon::parse($campaigns->start_date);
                            $endDate = \Carbon\Carbon::parse($campaigns->end_date);
                        @endphp
                        <p class="mb-2">
                            <strong>Tarikh:</strong> {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}
                        </p>
        
                        <!-- Progress Bar -->
                        <div class="progress mb-3" style="height: 20px;">
                            @php
                                $progress = ($campaigns->current_amount / $campaigns->target_amount) * 100;
                            @endphp
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%;"
                                aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                {{ number_format($progress, 0) }}%
                            </div>
                        </div>
        
                        <!-- Raised and Target Amount -->
                        <p class="mb-1">
                            <strong>Jumlah Dikumpul:</strong> RM {{ number_format($campaigns->current_amount, 2) }}
                        </p>
                        <p>
                            <strong>Jumlah Sasaran:</strong> RM {{ number_format($campaigns->target_amount, 2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Penderma</th>
                            <!--<th>Jumlah Derma</th>-->
                            <th>Tarikh Derma</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($donations as $donation)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $donation->users->profile->full_name }}</td>
                                <!--<td>RM {{ number_format($donation->amount, 2) }}</td>-->
                                <td>{{ $donation->created_at->format('d M Y') }}</td>
                                <td>
                                    @if ($donation->payment_status == 'successful')
                                        <span class="badge bg-success text-white">Berjaya</span>
                                    @elseif ($donation->payment_status == 'rejected')
                                        <span class="badge bg-danger text-white">Ditolak</span>
                                    @else
                                        <span class="badge bg-warning text-white">Menunggu</span>
                                    @endif
                                </td>
                                <td>
                                    <!-- View Campaign-->
                                    <a href="{{ route('donations.receipt', $donation->id)}}">
                                        <i class="fas fa-download text-dark mr-2"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .campaign-preview {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
        }

        .btn-primary {
            background-color: #dc3545;
            border-color: #dc3545;
            border-radius: 8px;
            padding: 10px 20px;
        }

        .btn-primary:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .btn-light {
            border-radius: 8px;
            padding: 10px 20px;
        }
    </style>
@endsection