@extends('layouts.staff-base')
@section('content')
    <!-- Page Heading -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-left-info">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-gray-900 font-weight-bold">Jumlah Pertanyaan</h6>
                        <h2>{{ $counts['Total'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
        @if (auth()->user()->role !== 'staff')
            <!-- User Statistics Card -->
            <div class="col-md-3">
                <div class="card shadow-sm border-left-danger">
                    <div class="card-body">
                        <div class="text-center">
                            <h6 class="text-gray-900 font-weight-bold">Dalam Proses</h6>
                            <h2>{{ $counts['Pending'] }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- User Statistics Card -->
            <div class="col-md-3">
                <div class="card shadow-sm border-left-info">
                    <div class="card-body">
                        <div class="text-center">
                            <h6 class="text-gray-900 font-weight-bold">Jumlah Ditugaskan</h6>
                            <h2>{{ $counts['Assign'] }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-3">
            <div class="card shadow-sm border-left-warning">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-gray-900 font-weight-bold">Sedang Diproses</h6>
                        <h2>{{ $counts['In Progress'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-left-success">
                <div class="card-body">
                    <div class="text-center">
                        <h6 class="text-gray-900 font-weight-bold">Selesai</h6>
                        <h2>{{ $counts['Resolved'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-dark">Pertanyaan & Aduan</h6>
            @if (auth()->user()->role === 'user')
                <a href="{{ route('inquiries.create') }}" class="btn btn-sm btn-danger shadow-sm">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Buat Pertanyaan
                </a>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            @if (auth()->user()->role !== 'user')
                                <th>Nama</th>
                            @endif
                            <th>Tajuk</th>
                            <th>Keterangan</th>
                            <th>Kategori</th>
                            <th>Ditugaskan Kepada</th>
                            <th>Tarikh Dihantar</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inquiries as $inquiry)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                @if (auth()->user()->role !== 'user')
                                    <td>{{ $inquiry->user->profile->full_name }}</td>
                                @endif
                                <td>{{ $inquiry->title }}</td>
                                <td>{!! Str::limit($inquiry->description, 20) !!}</td>
                                <td>
                                    @if ($inquiry->category === 'general')
                                        Pertanyaan Umum
                                    @elseif ($inquiry->category === 'complaint')
                                        Aduan
                                    @else
                                        Lain-lain
                                    @endif
                                </td>
                                <td>{{ $inquiry->assignedTo->profile->full_name ?? 'Tiada' }}</td>

                                <td>{{ $inquiry->created_at->format('d F Y') }}</td>

                                <td>
                                    @if ($inquiry->status === 'Pending')
                                        <span class="badge bg-danger text-white">Dalam Proses</span>
                                    @elseif($inquiry->status === 'In Progress')
                                        <span class="badge bg-warning text-white">Sedang Diproses</span>
                                    @else
                                        <span class="badge bg-success text-white">Selesai</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('inquiries.show', $inquiry->id) }}">
                                        <i class="fas fa-eye text-dark mr-2"></i></a>
                                    @if (auth()->user()->role === 'user' && $inquiry->status === 'Pending')
                                        <a href="{{ route('inquiries.edit', $inquiry->id) }}">
                                            <i class="fas fa-edit mr-2"></i></a>
                                        <a href="#" class="action-icon-danger" data-toggle="modal"
                                            data-target="#deleteModal-{{ $inquiry->id }}">
                                            <i class="fas fa-trash text-danger"></i>
                                        </a>
                                    @endif
                                    @if (auth()->user()->role === 'admin' && $inquiry->status === 'Pending')
                                        <a href="{{ route('inquiries.edit', $inquiry->id) }}">
                                            <i class="fas fa-edit mr-2"></i></a>
                                    @endif
                                    @if (auth()->user()->role === 'staff' && $inquiry->status === 'In Progress')
                                        <a href="{{ route('inquiries.edit', $inquiry->id) }}">
                                            <i class="fas fa-edit mr-2"></i></a>
                                    @endif
                                </td>
                            </tr>
                            <div class="modal fade" id="deleteModal-{{ $inquiry->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content border-0 rounded-lg shadow">
                                        <button type="button" class="close position-absolute text-dark"
                                            data-dismiss="modal" aria-label="Close"
                                            style="top: 15px; right: 15px; font-size: 1.5rem;">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <div class="text-center pt-4">
                                            <div class="rounded-circle bg-danger d-inline-flex align-items-center justify-content-center"
                                                style="width: 60px; height: 60px;">
                                                <i class="fas fa-exclamation-triangle text-white"
                                                    style="font-size: 30px;"></i>
                                            </div>
                                        </div>
                                        <div class="modal-body text-center pt-3 pb-0">
                                            <h5 class="font-weight-bold mb-3">Padam Pertanyaan</h5>
                                            <p class="text-muted mb-3">Tindakan ini tidak boleh dibatalkan. Adakah anda pasti?</p>
                                        </div>
                                        <div class="modal-footer justify-content-center py-3 border-0">
                                            <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Tidak,
                                                Simpan</button>
                                            <form method="POST" action="{{ route('inquiries.destroy', $inquiry->id) }}"
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
@endsection