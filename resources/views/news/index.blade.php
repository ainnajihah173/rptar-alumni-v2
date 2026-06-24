@extends('layouts.staff-base')
@section('content')
    <!-- Page Heading -->
    @if (auth()->user()->role === 'staff')
        <div class="row mb-4">
            <!-- User Statistics Card -->
            <div class="col-md-4">
                <div class="card shadow-sm border-left-info">
                    <div class="card-body">
                        <div class="text-center">
                            <h6 class="text-gray-900 font-weight-bold">Jumlah Berita</h6>
                            <h2>{{ $totalNews }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-left-danger">
                    <div class="card-body">
                        <div class="text-center">
                            <h6 class="text-gray-900 font-weight-bold">Berita Diterbitkan</h6>
                            <h2>{{ $publishedNews }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-left-warning">
                    <div class="card-body">
                        <div class="text-center">
                            <h6 class="text-gray-900 font-weight-bold">Berita Draf</h6>
                            <h2>{{ $draftNews }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-dark">Kandungan Berita</h6>
                <div>
                    <a href="{{ route('news.create') }}" class="btn btn-sm btn-primary shadow-sm">
                        <i class="fas fa-plus fa-sm text-white-50"></i> Cipta Berita
                    </a>
                    {{-- <a href="{{ route('news.export') }}" class="btn btn-sm btn-success shadow-sm ml-2">
                        <i class="fas fa-file-excel fa-sm text-white-50"></i> Eksport ke Excel
                    </a> --}}
                </div>
            </div>
            <!-- Check if there is any news -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tajuk Berita</th>
                                <th>Kandungan Berita</th>
                                <th>Nama Penulis</th>
                                <th>Tarikh Diterbitkan</th>
                                <th>Status</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($news as $news)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{!! Str::limit($news->title, 20) !!}</td>
                                    <td>{!! Str::limit($news->content, 50) !!}</td>
                                    <td>{{ $news->users->profile->full_name }}</td>
                                    <td>{{ $news->published_date ? \Carbon\Carbon::parse($news->published_date)->format('d F Y') : 'N/A' }}
                                    </td>
                                    <td>
                                        @if ($news->is_active == 1)
                                            <span class="badge bg-success text-white">Diterbitkan</span>
                                        @else
                                            <span class="badge bg-warning text-white">Draf</span>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Show Page-->
                                        <a href="{{ route('news.show', $news->id) }}">
                                            <i class="fas fa-eye text-dark mr-2"></i></a>
                                        <!-- Edit Page-->
                                        @if ($news->is_active == 0)
                                            <a href="{{ route('news.edit', $news->id) }}">
                                                <i class="fas fa-edit mr-2"></i></a>

                                            <!-- Delete Page-->
                                            <a href="" class="action-icon-danger" data-toggle="modal"
                                                data-target="#bs-danger-modal-sm"> <i
                                                    class="fas fa-trash text-danger"></i></a>
                                        @endif
                                    </td>
                                </tr>

                                 <!-- Delete Modal -->
                                 <div class="modal fade" id="bs-danger-modal-sm" tabindex="-1"
                                    role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content border-0 rounded-lg shadow">
                                            <!-- Close Button -->
                                            <button type="button" class="close position-absolute text-dark"
                                                data-dismiss="modal" aria-label="Close"
                                                style="top: 15px; right: 15px; font-size: 1.5rem;">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <!-- Centered Warning Icon -->
                                            <div class="text-center pt-4">
                                                <div class="rounded-circle bg-danger d-inline-flex align-items-center justify-content-center"
                                                    style="width: 60px; height: 60px;">
                                                    <i class="fas fa-exclamation-triangle text-white"
                                                        style="font-size: 30px;"></i>
                                                </div>
                                            </div>
                                            <!-- Modal Body -->
                                            <div class="modal-body text-center pt-3 pb-0">
                                                <h5 class="font-weight-bold mb-3">Padam Berita</h5>
                                                <p class="text-muted mb-3">Tindakan ini tidak boleh dibatalkan. Adakah anda pasti?
                                                </p>
                                            </div>
                                            <!-- Modal Footer -->
                                            <div class="modal-footer justify-content-center py-3 border-0">
                                                <button type="button" class="btn btn-secondary px-4"
                                                    data-dismiss="modal">Tidak, Simpan</button>
                                                <form method="POST" action="{{ route('news.destroy', $news->id) }}"
                                                    class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger px-4">Ya,
                                                        Padam!</button>
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
        <div class="custom-container mx-4 px-5 py-3">

            <!-- Main Heading -->
            <div class="text-center mb-4">
                <h3 class="text-center" style="color: #eb3a2a;">Berita Terkini
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                </h3>
                <p class="text-muted">Kekal terkini dengan berita dan maklumat terkini.</p>
            </div>

            <!-- Featured News Section -->
            <div class="row mb-2">
                @if ($news->first())
                    <div class="col-md-8 mb-4 mb-md-0">
                        <div class="card border-0 overflow-hidden shadow-lg">
                            <img src="{{ asset('storage/' . $news->first()->image) }}" class="card-img-top"
                                alt="{{ $news->first()->title }}" style="height: 525px; object-fit: cover;">
                            <div class="card-img-overlay d-flex flex-column justify-content-end bg-dark-gradient p-4">
                                <h2 class="card-title fw-bold text-white mb-2">{{ $news->first()->title }}</h2>
                                <p class="text-white-50 small mb-1">Oleh {{ $news->first()->users->profile->full_name }} |
                                    {{ \Carbon\Carbon::parse($news->first()->published_date)->format('d F Y') }}</p>
                                <p class="card-text text-white-50">{!! Str::limit($news->first()->content, 150) !!}</p>
                                <a href="{{ route('news.show', $news->first()->id) }}"
                                    class="btn btn-danger btn-sm align-self-start">Baca
                                    Lagi...</a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Side News Section -->
                <div class="col-md-4">
                    @foreach ($news->slice(1, 2) as $item)
                        <div class="card mb-4 border-0 shadow-sm">
                            <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top"
                                alt="{{ $item->title }}" style="height: 80px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-2">{{ $item->title }}</h5>
                                <p class="text-muted small mb-1">Oleh {{ $item->users->profile->full_name }} |
                                    {{ $item->published_date ? \Carbon\Carbon::parse($item->published_date)->format('d F Y') : 'N/A' }}</p>
                                <p class="card-text text-muted small">{!! Str::limit($item->content, 80) !!}</p>
                                <a href="{{ route('news.show', $item->id) }}" class="btn btn-danger btn-sm">Baca
                                    Lagi...</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- News Section with Carousel -->
        <div class="custom-container mx-4 px-5 mt-3 py-2">
            <div class="text-center mb-4 mt-2">
                <h3 class="text-center" style="color: #eb3a2a;">Bahagian Berita</h3>
                <p class="text-muted">Baca berita dan kisah bersama kami.</p>
            </div>
            <div class="position-relative">
                <div id="newsCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($news->slice(3)->chunk(3) as $chunk)
                            <div class="carousel-item @if ($loop->first) active @endif">
                                <div class="row">
                                    @foreach ($chunk as $item)
                                        <div class="col-md-4 mb-4">
                                            <div class="card border-0 shadow-sm h-100">
                                                <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top"
                                                    alt="{{ $item->title }}" style="height: 200px; object-fit: cover;">
                                                <div class="card-body">
                                                    <h5 class="card-title fw-bold">{!! Str::limit($item->title, 30) !!}</h5>
                                                    <p class="text-muted small mb-1">Oleh
                                                        {{ $item->users->profile->full_name }} |
                                                        {{ $item->published_date ? \Carbon\Carbon::parse($item->published_date)->format('d F Y') : 'N/A' }}</p>
                                                    <p class="card-text text-muted">{!! Str::limit($item->content, 100) !!}</p>
                                                    <a href="{{ route('news.show', $item->id) }}"
                                                        class="btn btn-danger btn-sm">Baca Lagi...</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Updated Carousel Controls -->
                    <a class="carousel-control-prev" href="#newsCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Sebelumnya</span>
                    </a>
                    <a class="carousel-control-next" href="#newsCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Seterusnya</span>
                    </a>
                </div>
            </div>

            {{-- <!-- List of Links to Older News -->
            <div class="mt-5">
                <h3 class="fw-bold" style="color: #ff6f61;">Berita Arkib</h3>
                <ul class="list-unstyled">
                    @foreach ($news->where('created_at', '<', now()->subYear()) as $archivedNews)
                        <li>
                            <a href="{{ route('news.show', $archivedNews->slug) }}" class="text-primary">
                                {{ $archivedNews->title }} ({{ $archivedNews->created_at->format('Y') }})
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div> --}}
        </div>


        <style>
            .custom-container {
                width: auto;
                /* Adjusts width based on content */
                max-width: 100%;
                /* Ensures it doesn't exceed the viewport width */
            }

            .bg-dark-gradient {
                background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.8) 100%);
            }

            .shadow-lg {
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }

            .shadow-sm {
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            .card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            }

            .btn-light {
                background-color: #fff;
                border-color: #fff;
            }

            .btn-light:hover {
                background-color: #f8f9fa;
                border-color: #f8f9fa;
            }

            -primary {
                border-width: 2px;
            }

            /* Custom styles for carousel controls */
            .carousel-control-prev,
            .carousel-control-next {
                width: 40px;
                height: 40px;
                background-color: rgba(255, 111, 97, 0.8);
                /* Semi-transparent background */
                border-radius: 50%;
                top: 50%;
                transform: translateY(-50%);
                opacity: 0.8;
                transition: opacity 0.3s ease;
            }

            .carousel-control-prev {
                left: -35px;
                /* Adjust position to move it outside the carousel */
            }

            .carousel-control-next {
                right: -35px;
                /* Adjust position to move it outside the carousel */
            }

            .carousel-control-prev:hover,
            .carousel-control-next:hover {
                opacity: 1;
            }

            .carousel-control-prev-icon,
            .carousel-control-next-icon {
                background-size: 60%;
                width: 100%;
                height: 100%;
            }

            .carousel-control-prev-icon {
                background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E");
            }

            .carousel-control-next-icon {
                background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E");
            }
        </style>
    @endif
@endsection