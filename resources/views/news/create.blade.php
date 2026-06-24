@extends('layouts.staff-base')
@section('content')
    <!-- Page Heading -->
    <div class="mb-3">
        <a href="{{ route('news.index') }}" class="text-decoration-none text-dark">
            <i class="fas fa-arrow-left"></i> Kembali ke Berita
        </a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-dark">Cipta Berita</h6>
        </div>

        <div class="card-body">
            <p class="text-muted font-14">
                Sila isi borang di bawah.
            </p>
            <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-center align-items-center g-2">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="example-readonly">Tajuk Berita<span class="text-danger">*</span></label>
                            <input type="text" id="example-readonly" class="form-control" name="title" required
                                placeholder="Tajuk Berita">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="example-readonly">Slug Berita<span class="text-danger">*</span></label>
                            <input type="text" id="example-readonly" class="form-control" name="slug" required
                                placeholder="cth: tajuk-berita">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="example-readonly">Penulis Berita</label>
                            <input type="text" class="form-control" placeholder="{{ $users->name }}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="status">Status Berita<span class="text-danger">*</span></label>
                            <select name="is_active" id="status" class="form-control" required>
                                <option selected disabled>Sila Pilih...</option>
                                <option value="0">Draf</option>
                                <option value="1">Terbit</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="file">Muat Naik Fail<span class="text-danger">*</span></label>
                            <input type="file" name="image" id="image" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-6"></div>
                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <label for="example-readonly">Kandungan Berita<span class="text-danger">*</span></label>
                            <textarea class="form-control" id="editor" name="content" rows="6"></textarea>
                        </div>
                    </div>

                </div>
                <!-- end row-->
                <div class="text-center mt-2">
                    <button type="button" onclick="history.back()" class="btn btn-light mr-3">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>

    </div>


@endsection