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
            <h6 class="m-0 font-weight-bold text-dark">Buat Pertanyaan</h6>
        </div>

        <div class="card-body">
            <p class="text-muted font-14">
                Sila pastikan semua ruangan diisi.
            </p>
            <form action="{{ route('inquiries.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-center align-items-center g-2">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="example-readonly">Nama</label>
                            <input type="text" id="example-readonly" class="form-control" name="name" value="{{ $users->name }}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="example-readonly">Emel</label>
                            <input type="text" id="example-readonly" class="form-control" name="email" value="{{ $users->email }}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="status">Kategori<span class="text-danger">*</span></label>
                            <select name="category" id="status" class="form-control" required>
                                <option selected disabled>Sila Pilih...</option>
                                <option value="general">Pertanyaan Umum</option>
                                <option value="complaint">Aduan</option>
                                <option value="others">Lain-lain</option>
                            </select>
                        </div>
                    </div> 
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="title">Tajuk<span class="text-danger">*</span></label>
                            <input type="text" id="title" class="form-control" name="title" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="description">Keterangan<span class="text-danger">*</span></label>
                            <textarea id="description" class="form-control" name="description" required rows="5"></textarea>
                        </div>
                    </div>      
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="file">Muat Naik Fail (Pilihan)</label>
                            <input type="file" id="file" class="custom-file" name="image_path">
                        </div>
                    </div> 
                </div>

                <!-- end row-->
                <div class="text-center mt-2">
                    <button type="button" onclick="history.back()" class="btn btn-light mr-3">Batal</button>
                    <button type="submit" class="btn btn-danger">Simpan</button>
                </div>
            </form>
        </div>

    </div>
@endsection