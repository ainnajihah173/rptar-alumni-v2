@extends('layouts.staff-base')
@section('content')
    <!-- Page Heading -->
    <div class="mb-3">
        <a href="{{ route('donations.index') }}" class="text-decoration-none text-dark">
            <i class="fas fa-arrow-left"></i> Kembali ke Senarai Derma
        </a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-dark">Cipta Derma</h6>
        </div>

        <div class="card-body">
            <p class="text-muted font-14">
                <!-- Please fill in the form. -->
                Sila isi borang berikut.
            </p>
            <form action="{{ route('donations.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-center align-items-center g-2">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="example-readonly">Tajuk Derma<span class="text-danger">*</span></label>
                            <input type="text" id="example-readonly" class="form-control" name="title" required
                                placeholder="Tajuk Derma">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="example-readonly">Jumlah Sasaran<span class="text-danger">*</span></label>
                            <input type="number" id="example-readonly" class="form-control" name="target_amount"
                                required placeholder="0" min="1">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="example-readonly">Tarikh Mula<span class="text-danger">*</span></label>
                            <input type="date" id="example-readonly" class="form-control" name="start_date" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="example-readonly">Tarikh Tamat<span class="text-danger">*</span></label>
                            <input type="date" id="example-readonly" class="form-control" name="end_date" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="example-readonly">Penerangan<span class="text-danger">*</span></label>
                            <textarea class="form-control" name="description" required></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="file">Muat Naik Fail<span class="text-danger">*</span></label>
                            <input type="file" name="image_path" id="image" class="custom-file" required>
                        </div>
                    </div>
                </div>
                <!-- end row-->
                <div class="text-center mt-2">
                    <button type="button" onclick="history.back()" class="btn btn-light mr-3">Batal</button>
                    <button type="submit" class="btn {{ Auth::user()->role === 'staff' ? 'btn-primary' : 'btn-info' }}">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection