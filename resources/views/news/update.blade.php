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
            <h6 class="m-0 font-weight-bold text-dark">Kemaskini Berita</h6>
        </div>

        <div class="card-body">
            <p class="text-muted font-14">
                Sila isi borang di bawah.
            </p>
            <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row justify-content-center align-items-center g-2">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="example-readonly">Tajuk Berita</label>
                            <input type="text" id="example-readonly" class="form-control" name="title" required
                                value="{{ $news->title }}" placeholder="Tajuk Berita">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="example-readonly">Slug</label>
                            <input type="text" id="example-readonly" class="form-control" name="slug" required
                                value="{{ $news->slug }}" placeholder="cth: tajuk-berita">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="example-readonly">Penulis</label>
                            <input type="text" class="form-control" value="{{ $news->users->name }}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="status">Status</label>
                            <select name="is_active" id="status" class="form-control">
                                <option selected disabled>Sila Pilih...</option>
                                <option value="0" {{ old('is_active', $news->is_active) == 0 ? 'selected' : '' }}>Draf
                                </option>
                                <option value="1" {{ old('is_active', $news->is_active) == 1 ? 'selected' : '' }}>
                                    Terbit</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="file">Muat Naik Fail</label>
                            <input type="file" name="image" id="image" class="form-control">
                            @if ($news->image)
                                <!-- Check if there's an existing image -->
                                <div class="mt-2">
                                    <p>Gambar Semasa:</p>
                                    <img src="{{ asset('storage/' . $news->image) }}" alt="Gambar Berita" class="img-thumbnail"
                                        width="150">
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6"></div>
                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <label for="example-readonly">Kandungan Berita</label>
                            <textarea class="form-control" id="editor" name="content" rows="6">{{ $news->content }}</textarea>
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