@extends('layouts.staff-base')

@section('content')
    <!-- Back Button -->
    <div class="mb-4 ml-3">
        <a href="{{ route('news.index') }}" class="text-decoration-none text-dark">
            <i class="fas fa-arrow-left"></i> Kembali ke Berita
        </a>
    </div>

    <!-- Main News Article Container -->
    <div class="row">
        <!-- News Article Section -->
        <div class="col-lg-8">
            <!-- Card for News -->
            <div class="card shadow-sm border-0 rounded">
                <div class="card-body">
                    <!-- News Title -->
                    <h1 class="card-title font-weight-bold text-dark mb-3">{{ $news->title }}</h1>

                    <!-- News Author and Date -->
                    <p class="text-muted mb-4">
                        Oleh <strong>{{ $news->users->profile->full_name }}</strong> |
                        <em>{{ $news->published_date ? date('d M Y', strtotime($news->published_date)) : 'Draf' }}</em>
                    </p>

                    <!-- News Image -->
                    <div class="news-image-container mb-4">
                        @if ($news->image)
                            <img src="{{ asset('storage/' . $news->image) }}" class="img-fluid rounded shadow-sm w-100"
                                alt="Gambar Berita" style="height: 400px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/1200x600" class="img-fluid rounded shadow-sm w-100"
                                alt="Tiada Gambar" style="height: 400px; object-fit: cover;">
                        @endif
                    </div>

                    <!-- News Content -->
                    <div class="news-content text-justify">
                        {!! nl2br(e($news->content)) !!}
                    </div>
                </div> <!-- End Card Body -->
            </div> <!-- End Card -->
        </div> <!-- End Column -->

        @if(auth()->user()->role === 'user')
        <!-- Other News Section -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded">
                <div class="card-body">
                    <h4 class="font-weight-bold text-dark mb-4">Berita Lain</h4>
                    <ul class="list-unstyled">
                        @foreach ($otherNews as $other)
                            <li class="mb-3">
                                <a href="{{ route('news.show', $other->id) }}" class="text-decoration-none text-dark">
                                    {{ Str::limit($other->title, 50) }}
                                </a>
                                <p class="text-muted small mb-0">
                                    {{ $other->published_date ? date('d M Y', strtotime($other->published_date)) : 'Draf' }}
                                </p>
                            </li>
                            @if (!$loop->last)
                                <hr class="my-2">
                            @endif
                        @endforeach
                    </ul>
                </div> <!-- End Card Body -->
            </div> <!-- End Card -->
        </div> <!-- End Column -->
    </div> <!-- End Row -->
    @endif
@endsection

<!-- Custom Styles -->
<style>
    .news-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 20px 0;
    }

    .news-content p {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #333;
    }

    .news-content h2,
    .news-content h3 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        font-weight: bold;
    }

    a.text-decoration-none.text-dark:hover {
        color: #979797 !important;
    }

    .list-unstyled li a {
        font-size: 1rem;
        font-weight: 500;
    }

    .list-unstyled li a:hover {
        text-decoration: underline;
    }
</style>