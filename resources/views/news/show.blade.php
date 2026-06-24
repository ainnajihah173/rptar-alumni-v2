@extends('layouts.staff-base')

@section('content')
<style>
    .article-card {
        border-radius: 1.25rem;
        border: none;
        box-shadow: 0 2px 20px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    .article-card .card-body {
        padding: 2.5rem;
    }
    .back-link {
        color: #64748b;
        font-weight: 600;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
    }
    .back-link:hover {
        color: var(--accent-color);
        transform: translateX(-3px);
        text-decoration: none;
    }
    .meta-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        background: #f8fafc;
        padding: 0.375rem 0.875rem;
        border-radius: 2rem;
        font-size: 0.85rem;
        color: #64748b;
    }
    .article-content {
        font-size: 1rem;
        line-height: 1.8;
        color: #334155;
    }
    .sidebar-item {
        padding: 1rem 1.25rem;
        border-radius: 0.75rem;
        transition: all 0.2s;
        border-left: 3px solid transparent;
    }
    .sidebar-item:hover {
        background: #f8fafc;
        border-left-color: var(--accent-color);
    }
    .sidebar-item a {
        color: #1e293b;
        font-weight: 600;
        text-decoration: none;
    }
    .sidebar-item a:hover {
        color: var(--accent-color);
    }
</style>

<div class="container-fluid py-4">
    <a href="{{ route('news.index') }}" class="back-link mb-4">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>

    <div class="row g-4 mt-2">
        <div class="col-lg-8">
            <div class="card article-card">
                @if ($news->image)
                <div style="height: 380px; overflow: hidden;">
                    <img src="{{ asset('storage/' . $news->image) }}" class="w-100" style="height: 100%; object-fit: cover;" alt="">
                </div>
                @endif
                <div class="card-body">
                    <span class="badge px-3 py-2 mb-3 rounded-pill" style="background: linear-gradient(135deg, var(--accent-color), var(--accent-hover)); color: white; font-weight: 600;">
                        Berita
                    </span>
                    <h1 class="fw-800 mb-3" style="font-size: 1.75rem; color: var(--text-primary);">{{ $news->title }}</h1>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="meta-badge"><i class="fas fa-user"></i> {{ $news->users->profile->full_name ?? 'Admin' }}</span>
                        <span class="meta-badge"><i class="fas fa-calendar"></i> {{ $news->published_date ? date('d F Y', strtotime($news->published_date)) : 'Draf' }}</span>
                    </div>
                    <hr style="background: linear-gradient(90deg, var(--accent-color), transparent); height: 3px; border: none;">
                    <div class="article-content mt-4">
                        {!! nl2br(e($news->content)) !!}
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->role === 'user')
        <div class="col-lg-4">
            <div class="card article-card">
                <div class="card-header bg-white border-0 py-4">
                    <h6 class="fw-700 mb-0" style="color: var(--text-primary);">Berita Lain</h6>
                </div>
                <div class="card-body p-3">
                    @forelse ($otherNews as $other)
                    <div class="sidebar-item mb-2">
                        <a href="{{ route('news.show', $other->id) }}" class="d-block">{{ Str::limit($other->title, 60) }}</a>
                        <small class="text-muted">{{ $other->published_date ? date('d M Y', strtotime($other->published_date)) : 'Draf' }}</small>
                    </div>
                    @if (!$loop->last) <hr class="my-1" style="border-color: #f1f5f9;"> @endif
                    @empty
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-inbox fa-2x mb-2" style="opacity: 0.3;"></i>
                        <p class="mb-0">Tiada berita lain.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection