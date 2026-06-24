@extends('layouts.staff-base')
@section('content')
    <!-- Page Heading -->
    <div class="mb-3">
        <a href="{{ route('donations.index') }}" class="text-decoration-none text-dark">
            <i class="fas fa-arrow-left"></i> Kembali ke Senarai Derma
        </a>
    </div>

    @if (auth()->user()->role === 'user')
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-dark">Buat Derma</h6>
            </div>

            <div class="card-body">
                <!-- Campaign Preview Section -->
                <div class="campaign-preview mb-4 p-4 border rounded bg-light">
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
                                $formattedStatus = ucfirst($status); // Assuming 'status' is a field in your database
                                $badgeColor = match ($status) {
                                    'pending' => 'badge-secondary',
                                    'rejected' => 'badge-danger',
                                    'completed' => 'badge-success',
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

                <p class="text-muted font-14 mb-4">
                    Sila isi borang di bawah untuk membuat derma. Sokongan anda membuat perbezaan!
                </p>

                <!-- Donation Form -->
                <form action="{{ route('donations.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="campaign_id" value="{{ $campaigns->id }}">

                    <div class="row justify-content-center align-items-center g-2">
                        <!-- Donor's Name -->
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="full_name" class="form-label">Nama Penderma</label>
                                <input type="text" class="form-control" name="full_name" readonly
                                    value="{{ $users->profile->full_name }}">
                            </div>
                        </div>
                        <!-- Donor's Contact Number -->
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="contact_number" class="form-label">Nombor Telefon Penderma</label>
                                <input type="text" class="form-control" name="contact_number" readonly
                                    value="{{ $users->profile->contact_number }}">
                            </div>
                        </div>
                        <!-- Donor's Email -->
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Emel Penderma</label>
                                <input type="text" class="form-control" name="email" readonly
                                    value="{{ $users->email }}">
                            </div>
                        </div>
                        <!-- Donation Amount -->
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="amount" class="form-label">Jumlah Derma (RM)</label>
                                <input type="number" id="amount" class="form-control" name="amount" required
                                    placeholder="Masukkan jumlah" min="1">
                            </div>
                        </div>
                        <div class="col-lg-6"></div>
                    </div>

                    <!-- Form Actions -->
                    <div class="text-center mt-4">
                        <button type="button" onclick="history.back()" class="btn btn-light mr-3">Batal</button>
                        <button type="submit" class="btn btn-primary">Teruskan ke Pembayaran</button>
                    </div>
                </form>
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
    @else
        <!-- Page Heading -->
        <div class="mb-3">
            <a href="{{ route('donations.index') }}" class="text-decoration-none text-dark">
                <i class="fas fa-arrow-left"></i> Kembali ke Senarai Derma
            </a>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-dark">Kemaskini Derma</h6>
            </div>

            <div class="card-body">
                <p class="text-muted font-14">
                    Sila kemaskini borang di bawah.
                </p>
                <form action="{{ route('donations.update', $campaigns->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Spoof the PUT method -->
                    <div class="row justify-content-center align-items-center g-2">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="title">Tajuk Derma<span class="text-danger">*</span></label>
                                <input type="text" id="title" class="form-control" name="title" required
                                    value="{{ $campaigns->title }}" placeholder="Tajuk Derma">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="target_amount">Jumlah Sasaran<span class="text-danger">*</span></label>
                                <input type="number" id="target_amount" class="form-control" name="target_amount"
                                    required value="{{ $campaigns->target_amount }}" placeholder="0" min="1">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="start_date">Tarikh Mula<span class="text-danger">*</span></label>
                                <input type="date" id="start_date" class="form-control" name="start_date" required
                                    value="{{ $campaigns->start_date }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="end_date">Tarikh Tamat<span class="text-danger">*</span></label>
                                <input type="date" id="end_date" class="form-control" name="end_date" required
                                    value="{{ $campaigns->end_date }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="description">Penerangan<span class="text-danger">*</span></label>
                                <textarea class="form-control" name="description" required>{{ $campaigns->description }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="image">Muat Naik Fail</label>
                                <input type="file" name="image_path" id="image" class="custom-file">
                                @if ($campaigns->image_path)
                                    <div class="">
                                        <p>Gambar Semasa:<a href="{{ asset('storage/' . $campaigns->image_path) }}"
                                                target="_blank" class="text-decoration-none">
                                                Lihat Gambar
                                            </a></p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- end row-->
                    <div class="text-center mt-2">
                        <button type="button" onclick="history.back()" class="btn btn-light mr-3">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            Kemaskini
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection