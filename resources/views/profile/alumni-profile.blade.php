@extends('layouts.staff-base')

@section('content')
    <!-- Page Heading -->
    <h3 class="text-center" style="color: #eb3a2a;">Profil Alumni</h3>
    <p class="text-center text-muted">Profil anda, kisah anda. Kongsi perjalanan anda bersama kami.</p>

    <!-- Alumni Cards Section -->
    <div class="row">
        @foreach ($alumni as $alumnus)
            <div class="col-lg-4 mb-4">
                <div class="card alumni-card border-0 shadow h-100 text-center">
                    <div class="card-body">
                        <!-- Profile Picture -->
                        <div class="profile-image-container" style="border: 2px solid #6c757d">
                            <!-- Standardized border color -->
                            <img src="{{ $alumnus->profile_pic ? asset('storage/' . $alumnus->profile_pic) : asset('assets/images/default-avatar.png') }}"
                                alt="Profile Image" class="rounded-circle img-thumbnail shadow-sm mb-3">
                        </div>
                        <!-- Name and Job Title -->
                        <h5 class="text-dark mt-2">{{ $alumnus->full_name }}</h5>
                        <p class="text-muted mb-1">{{ $alumnus->job }}</p>
                        <small class="d-block text-secondary">"{{ $alumnus->bio }}"</small>
                    </div>
                    <!-- Card Footer with Buttons -->
                    <div class="card-footer border-0 bg-light">
                        <a href="mailto:{{ $alumnus->user->email }}" class="btn btn-sm w-45 btn-secondary">
                            <!-- Standardized button color -->
                            <i class="fas fa-envelope"></i> Hantar Emel
                        </a>
                        <a href="{{ route('profile.show', $alumnus->id) }}" class="btn btn-outline-dark btn-sm w-45">
                            <i class="fas fa-user"></i> Lihat Profil
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination Section -->
    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item {{ $alumni->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $alumni->previousPageUrl() }}" tabindex="-1"
                    aria-disabled="true">Sebelumnya</a>
            </li>
            @for ($i = 1; $i <= $alumni->lastPage(); $i++)
                <li class="page-item {{ $alumni->currentPage() === $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ $alumni->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item {{ $alumni->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $alumni->nextPageUrl() }}">Seterusnya</a>
            </li>
        </ul>
    </nav>

    <style>
        /* Custom Alumni Card Styling */
        .alumni-card {
            background: linear-gradient(145deg, #ffffff, #f0f8ff);
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 350px;
            height: 350px;
            margin: 0 auto;
        }

        .alumni-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .profile-image-container {
            position: relative;
            width: 80px;
            height: 80px;
            margin: 0 auto;
            border-radius: 50%;
            overflow: hidden;
        }

        .profile-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .alumni-card .card-body {
            padding: 1.5rem;
        }

        .alumni-card h5 {
            font-size: 1.1rem;
            font-weight: bold;
            color: #343a40;
            margin-bottom: 0.5rem;
        }

        .alumni-card p {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .alumni-card small {
            font-size: 0.75rem;
            color: #6c757d;
            font-style: italic;
        }

        .alumni-card .card-footer {
            background: linear-gradient(145deg, #f0f8ff, #ffffff);
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            padding: 1rem;
        }

        .alumni-card .btn {
            font-size: 0.75rem;
            padding: 0.4rem 0.8rem;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .alumni-card .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .alumni-card .btn-secondary:hover {
            background-color: #5a6268;
        }

        .alumni-card .btn-outline-dark {
            border-color: #343a40;
            color: #343a40;
        }

        .alumni-card .btn-outline-dark:hover {
            background-color: #343a40;
            color: #fff;
        }

        /* Pagination Styling */
        .pagination .page-item .page-link {
            color: #6f6e6e;
            border: 1px solid #6f6e6e;
            margin: 0 5px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .pagination .page-item.active .page-link {
            background-color: #6f6e6e;
            color: #fff;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
        }

        .pagination .page-item .page-link:hover {
            background-color: #6f6e6e;
            color: #fff;
        }
    </style>
@endsection
