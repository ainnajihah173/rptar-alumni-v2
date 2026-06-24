@extends('layouts.staff-base')

@section('content')
    <!-- Page Heading -->
    <div class="mb-3">
        <a href="{{ route('inquiries.index') }}" class="text-decoration-none text-dark">
            <i class="fas fa-arrow-left"></i> Kembali ke Pertanyaan
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-dark">Lihat Pertanyaan</h6>
        </div>

        <div class="card-body">

            <div class="row justify-content-center align-items-center g-2">
                <!-- Name Field -->
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="name">Nama</label>
                        <input type="text" id="name" class="form-control" name="name"
                            value="{{ $inquiries->user->name }}" readonly>
                    </div>
                </div>

                <!-- Email Field -->
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="email">Emel</label>
                        <input type="text" id="email" class="form-control" name="email"
                            value="{{ $inquiries->user->email }}" readonly>
                    </div>
                </div>

                <!-- Contact Number Field -->
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="email">Nombor Telefon</label>
                        <input type="text" id="email" class="form-control" name="email"
                            value="{{ $inquiries->user->profile->contact_number }}" readonly>
                    </div>
                </div>

                <!-- Category Field -->
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="name">Kategori</label>
                        @php
                            $displayCategory = 'Tidak Diketahui';
                            if ($inquiries->category === 'general') {
                                $displayCategory = 'Pertanyaan Umum';
                            } elseif ($inquiries->category === 'complaint') {
                                $displayCategory = 'Aduan';
                            } elseif ($inquiries->category === 'others') {
                                $displayCategory = 'Lain-lain';
                            }
                        @endphp
                        <input type="text" id="name" class="form-control" name="category"
                            value="{{ $displayCategory }}" readonly>
                    </div>
                </div>

                <!-- Issued Date Field -->
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="title">Tarikh Dihantar</label>
                        <input type="text" id="title" class="form-control"
                            value="{{ $inquiries->created_at->format('d F Y') }}" readonly>
                    </div>
                </div>

                <!-- Title Field -->
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="title">Tajuk</label>
                        <input type="text" id="title" class="form-control" value="{{ $inquiries->title }}" readonly>
                    </div>
                </div>

                <!-- Assign To Field -->
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="title">Ditugaskan Kepada</label>
                        <input type="text" id="title" class="form-control"
                            value="{{ $inquiries->assignedTo->profile->full_name ?? 'Tiada' }}" readonly>
                    </div>
                </div>

                <!-- Inquiry Status Field -->
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="title">Status Pertanyaan</label>
                        <input type="text" id="title" class="form-control" value="{{ $inquiries->status }}" readonly>
                    </div>
                </div>

                <!-- Resolved Date Field -->
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="title">Tarikh Selesai</label>
                        <input type="text" id="title" class="form-control"
                            value="{{ $inquiries->resolved_date ? \Carbon\Carbon::parse($inquiries->resolved_date)->format('d F Y') : 'Tiada' }}"
                            readonly>
                    </div>
                </div>

                <!-- File Upload Field -->
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="file">Gambar</label>
                        @if ($inquiries->image_path)
                            <div class="mt-2">
                                <p><a href="{{ Storage::url($inquiries->image_path) }}" target="_blank"
                                        class="text-primary">Lihat Fail Semasa</a></p>
                            </div>
                        @else
                            <p>Tiada Gambar Disediakan</p>
                        @endif
                    </div>
                </div>

                <!-- Description Field -->
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="description">Keterangan</label>
                        <textarea id="description" class="form-control" name="description" readonly rows="5">{{ $inquiries->description }}</textarea>
                    </div>
                </div>

                <!-- Solution Field -->
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="description">Penyelesaian</label>
                        <textarea id="description" class="form-control" name="description" readonly rows="5">{{ $inquiries->solution ?? 'Tiada Penyelesaian' }}</textarea>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection