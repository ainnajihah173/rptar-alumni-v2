@extends('layouts.staff-base')

@section('content')
  <!-- Back Button -->
<div class="mb-3">
    <a href="{{ route('profile.index') }}" class="text-decoration-none text-dark">
        <i class="fas fa-arrow-left"></i> Kembali ke Profil Alumni
    </a>
</div>

<!-- Main Card -->
<div class="card border-0 shadow-lg rounded-3">
    <div class="card-body p-4">
        <div class="row">
            <!-- Profile Card (Left Side) -->
            <div class="col-lg-4 text-center">
                <div class="mb-4">
                    <!-- Profile Image -->
                    <img src="{{ $profile->profile_pic ? asset('storage/' . $profile->profile_pic) : asset('assets/images/default-avatar.png') }}"
                        class="rounded-circle img-thumbnail profile-image mb-3" alt="Profile Image"
                        style="width: 150px; height: 150px; object-fit: cover;">
                    <!-- Full Name -->
                    <h4 class="fw-bold mb-2">{{ $profile->full_name }}</h4>
                    <!-- Job Title -->
                    @if ($profile->job)
                        <p class="text-muted mb-4">{{ $profile->job }}</p>
                    @endif
                    <!-- Social Media Links -->
                    <div class="d-flex justify-content-center mt-3">
                        <a href="{{ $profile->linkedin ?? 'https://www.linkedin.com/' }}"
                            class="btn btn-info btn-circle mx-2" target="_blank">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="{{ $profile->facebook ?? 'https://www.facebook.com/' }}"
                            class="btn btn-primary btn-circle mx-2" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="{{ $profile->instagram ?? 'https://www.instagram.com/' }}"
                            class="btn btn-danger btn-circle mx-2" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                <!-- Quote -->
                @if ($profile->bio)
                    <div class="bg-light p-3 rounded-3">
                        <p class="mb-0 fst-italic text-muted">
                            <i class="fas fa-quote-left me-2"></i>
                            {{ $profile->bio }}
                        </p>
                    </div>
                @endif
            </div>

            <!-- Alumni Details (Right Side) -->
            <div class="col-lg-8">
                <h5 class="fw-bold mb-4 text-dark">
                    <i class="fas fa-user-circle me-2"></i> Butiran Profil Alumni
                </h5>
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        @if ($profile->full_name)
                            <div class="mb-3">
                                <p class="mb-1"><strong>Nama Penuh:</strong></p>
                                <p class="text-muted">{{ $profile->full_name ?? 'N/A' }}</p>
                            </div>
                        @endif
                        @if ($profile->user->email)
                            <div class="mb-3">
                                <p class="mb-1"><strong>Emel:</strong></p>
                                <p class="text-muted">{{ $profile->user->email ?? 'N/A' }}</p>
                            </div>
                        @endif
                        @if ($profile->contact_number)
                            <div class="mb-3">
                                <p class="mb-1"><strong>No. Telefon:</strong></p>
                                <p class="text-muted">{{ $profile->contact_number ?? 'N/A' }}</p>
                            </div>
                        @endif
                        @if ($profile->date_of_birth)
                            <div class="mb-3">
                                <p class="mb-1"><strong>Tarikh Lahir:</strong></p>
                                <p class="text-muted">{{ $profile->date_of_birth ? \Carbon\Carbon::parse($profile->date_of_birth)->format('d F Y') : 'N/A' }}</p>
                            </div>
                        @endif
                    </div>
                    <!-- Right Column -->
                    <div class="col-md-6">
                        @if ($profile->gender)
                            <div class="mb-3">
                                <p class="mb-1"><strong>Jantina:</strong></p>
                                <p class="text-muted">{{ ucfirst($profile->gender) ?? 'N/A' }}</p>
                            </div>
                        @endif
                        @if ($profile->address)
                            <div class="mb-3">
                                <p class="mb-1"><strong>Alamat:</strong></p>
                                <p class="text-muted">{{ $profile->address ?? 'N/A' }}</p>
                            </div>
                        @endif
                        @if ($profile->job)
                            <div class="mb-3">
                                <p class="mb-1"><strong>Jawatan:</strong></p>
                                <p class="text-muted">{{ $profile->job ?? 'N/A' }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <style>
        /* Profile Image */
        .profile-image {
            border: 4px solid #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Button Styling */
        .btn-circle {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        /* Hover effect for buttons */
        .btn-circle:hover {
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        /* Card Styling */
        .card {
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        /* Section Titles */
        h4.text-primary {
            font-size: 1.75rem;
            font-weight: 700;
        }

        /* Text Styling */
        .text-muted {
            color: #6c757d;
        }

        /* Quote Styling */
        .bg-light {
            background-color: #f8f9fa !important;
        }

        .fst-italic {
            font-style: italic;
        }
    </style>
@endpush
