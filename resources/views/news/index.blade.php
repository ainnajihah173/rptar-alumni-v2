@extends('layouts.staff-base')
@section('content')
<style>
    .hero-card {
        border-radius: 1.25rem;
        overflow: hidden;
        min-height: 400px;
        position: relative;
    }
    .hero-overlay {
        background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.2) 60%, transparent 100%);
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 2.5rem;
    }
    .hero-overlay h2,
    .hero-overlay p,
    .hero-overlay small {
        color: #fff !important;
    }
    .hero-overlay .text-white-50 {
        color: rgba(255,255,255,0.7) !important;
    }
    .news-grid-card {
        border-radius: 1rem;
        overflow: hidden;
        border: none;
        background: white;
        transition: all 0.3s ease;
        height: 100%;
    }
    .news-grid-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.08) !important;
    }
    .news-grid-card img {
        height: 200px;
        object-fit: cover;
        width: 100%;
    }
    .news-grid-card .card-body {
        padding: 1.5rem;
    }
    .stat-card {
        border-radius: 1rem;
        padding: 1.5rem;
        border: none;
    }
    .data-card {
        border-radius: 1.25rem;
        border: none;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .data-card .table {
        margin-bottom: 0;
    }
    .data-card .table th {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        padding: 1rem 1.25rem;
    }
    .data-card .table td {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .data-card .table tbody tr:last-child td {
        border-bottom: none;
    }
    .data-card .table tbody tr:hover {
        background: #f8fafc;
    }
    .act-btn {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        color: #64748b;
        transition: all 0.2s;
        background: #f1f5f9;
    }
    .act-btn:hover {
        background: #e2e8f0;
        color: #1e293b;
        text-decoration: none;
    }
    .act-btn.danger:hover {
        background: #fef2f2;
        color: #ef4444;
    }
    .badge-status {
        padding: 0.35rem 1rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 0.8rem;
    }
</style>

@if (auth()->user()->role === 'staff')
    <div class="container-fluid py-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-700 mb-1" style="color: var(--text-primary);">Pengurusan Berita</h4>
                <small class="text-muted">Urus dan pantau kandungan berita.</small>
            </div>
            <a href="{{ route('news.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i> Cipta Berita
            </a>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card stat-card shadow-sm text-white" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-3 mr-3" style="background: rgba(255,255,255,0.15);">
                            <i class="fas fa-newspaper fa-lg"></i>
                        </div>
                        <div>
                            <p class="mb-0 small opacity-75">Jumlah Berita</p>
                            <h3 class="fw-700 mb-0">{{ $totalNews }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card shadow-sm text-white" style="background: linear-gradient(135deg, #10b981, #059669);">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-3 mr-3" style="background: rgba(255,255,255,0.15);">
                            <i class="fas fa-check-circle fa-lg"></i>
                        </div>
                        <div>
                            <p class="mb-0 small opacity-75">Diterbitkan</p>
                            <h3 class="fw-700 mb-0">{{ $publishedNews }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card shadow-sm text-white" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-3 mr-3" style="background: rgba(255,255,255,0.15);">
                            <i class="fas fa-pen-alt fa-lg"></i>
                        </div>
                        <div>
                            <p class="mb-0 small opacity-75">Draf</p>
                            <h3 class="fw-700 mb-0">{{ $draftNews }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card data-card">
            <div class="card-header bg-white border-0 py-3 px-4">
                <h6 class="fw-700 mb-0" style="color: var(--text-primary);">Senarai Berita</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0" id="dataTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tajuk</th>
                                <th>Penulis</th>
                                <th>Tarikh</th>
                                <th>Status</th>
                                <th class="text-center">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($news as $item)
                            <tr>
                                <td class="fw-600">{{ $loop->iteration }}</td>
                                <td><span class="fw-600">{{ Str::limit($item->title, 40) }}</span></td>
                                <td>{{ $item->users->profile->full_name ?? '-' }}</td>
                                <td><small class="text-muted">{{ $item->published_date ? \Carbon\Carbon::parse($item->published_date)->format('d M Y') : '-' }}</small></td>
                                <td>
                                    @if ($item->is_active)
                                        <span class="badge bg-success text-white badge-status">Diterbitkan</span>
                                    @else
                                        <span class="badge bg-warning text-white badge-status">Draf</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('news.show', $item->id) }}" class="act-btn mr-1" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if (!$item->is_active)
                                        <a href="{{ route('news.edit', $item->id) }}" class="act-btn mr-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="act-btn danger" title="Padam" data-toggle="modal" data-target="#del{{ $item->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            <div class="modal fade" id="del{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow" style="border-radius: 1rem;">
                                        <div class="modal-body text-center p-5">
                                            <div class="rounded-circle bg-danger d-inline-flex align-items-center justify-content-center mb-4" style="width: 60px; height: 60px;">
                                                <i class="fas fa-exclamation-triangle text-white fa-lg"></i>
                                            </div>
                                            <h5 class="fw-700 mb-2">Padam Berita</h5>
                                            <p class="text-muted mb-4">Tindakan ini tidak boleh dibatalkan.</p>
                                            <div class="d-flex justify-content-center">
                                                <button class="btn btn-light px-4 mr-2" data-dismiss="modal">Batal</button>
                                                <form method="POST" action="{{ route('news.destroy', $item->id) }}">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-danger px-4">Padam</button>
                                                </form>
                                            </div>
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
    </div>

@else
    <div class="container-fluid py-4">
        @if ($news->first())
        <a href="{{ route('news.show', $news->first()->id) }}" class="text-decoration-none d-block mb-5">
            <div class="card hero-card border-0 shadow">
                <img src="{{ asset('storage/' . $news->first()->image) }}" class="card-img" style="height: 420px; object-fit: cover;" alt="">
                <div class="hero-overlay">
                    <span class="badge bg-danger mb-3 px-3 py-2 rounded-pill" style="font-weight: 600;">Berita Utama</span>
                    <h2 class="fw-700 mb-2" style="font-size: 1.75rem;">{{ $news->first()->title }}</h2>
                    <p class="mb-0" style="font-size: 0.95rem; opacity: 0.8;">
                        {{ $news->first()->users->profile->full_name ?? 'Admin' }} • 
                        {{ $news->first()->published_date ? \Carbon\Carbon::parse($news->first()->published_date)->format('d F Y') : '' }}
                    </p>
                </div>
            </div>
        </a>
        @endif

        @if ($news->count() > 1)
        <div class="d-flex align-items-center mb-4">
            <div class="rounded-circle p-2 mr-3" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                <i class="fas fa-clock text-white"></i>
            </div>
            <div>
                <h5 class="fw-700 mb-0" style="color: var(--text-primary);">Berita Terkini</h5>
                <small class="text-muted">Ikuti perkembangan terkini dari RPTAR</small>
            </div>
        </div>

        <div class="row g-4">
            @foreach ($news->slice(1) as $item)
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('news.show', $item->id) }}" class="text-decoration-none d-block h-100">
                    <div class="card news-grid-card shadow-sm">
                        <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="">
                        <div class="card-body d-flex flex-column">
                            <small class="text-muted mb-1">{{ \Carbon\Carbon::parse($item->published_date)->format('d M Y') }}</small>
                            <h6 class="fw-700 mb-2" style="color: var(--text-primary);">{{ $item->title }}</h6>
                            <p class="text-muted small mb-0 flex-grow-1">{!! Str::limit($item->content, 100) !!}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @endif
    </div>
@endif
@endsection