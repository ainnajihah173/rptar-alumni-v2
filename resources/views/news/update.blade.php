@extends('layouts.staff-base')
@section('content')
<style>
    .form-card {
        border-radius: 1.25rem;
        border: none;
        box-shadow: 0 2px 20px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    .form-card .card-body {
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
    .form-label {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }
    .form-control, .form-select {
        border-radius: 0.625rem;
        border: 1px solid #e2e8f0;
        padding: 0.7rem 1rem;
        font-size: 0.9rem;
        transition: all 0.2s;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    .form-control[readonly] {
        background: #f8fafc;
    }
    .current-img {
        border-radius: 0.5rem;
        border: 2px solid #e2e8f0;
    }
    .ck-editor__editable {
        min-height: 300px !important;
    }
</style>

<div class="container-fluid py-4">
    <a href="{{ route('news.index') }}" class="back-link mb-4">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card form-card">
                <div class="card-header bg-white border-0 py-4 px-4">
                    <h5 class="fw-700 mb-0" style="color: var(--text-primary);">Kemaskini Berita</h5>
                    <small class="text-muted">Sila kemaskini borang di bawah.</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Tajuk Berita <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="title" required value="{{ $news->title }}" placeholder="Masukkan tajuk berita">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Slug <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="slug" required value="{{ $news->slug }}" placeholder="cth: tajuk-berita">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Penulis</label>
                                <input type="text" class="form-control" value="{{ $news->users->name }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="is_active" class="form-control">
                                    <option value="0" {{ old('is_active', $news->is_active) == 0 ? 'selected' : '' }}>Draf</option>
                                    <option value="1" {{ old('is_active', $news->is_active) == 1 ? 'selected' : '' }}>Terbit</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Muatturun Gambar</label>
                                <input type="file" name="image" class="form-control">
                                @if ($news->image)
                                <div class="mt-3">
                                    <small class="text-muted d-block mb-2">Gambar Semasa:</small>
                                    <img src="{{ asset('storage/' . $news->image) }}" width="150" class="current-img shadow-sm">
                                </div>
                                @endif
                            </div>
                            <div class="col-12">
                                <label class="form-label">Kandungan Berita <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="editor" name="content" rows="8">{{ $news->content }}</textarea>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-5">
                            <button type="button" onclick="history.back()" class="btn btn-light px-5 mr-3">Batal</button>
                            <button type="submit" class="btn btn-primary px-5">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo'],
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                ]
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection