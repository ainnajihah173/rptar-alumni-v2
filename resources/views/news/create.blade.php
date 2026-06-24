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
    .ai-btn {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        border-radius: 0.625rem;
        padding: 0.5rem 1.25rem;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .ai-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }
    .ai-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }
    .ai-btn .spinner {
        display: none;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255,255,255,0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.6s linear infinite;
    }
    .ai-btn.loading .spinner {
        display: inline-block;
    }
    .ai-btn.loading .btn-text {
        display: none;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
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
                    <h5 class="fw-700 mb-0" style="color: var(--text-primary);">Cipta Berita</h5>
                    <small class="text-muted">Sila isi borang di bawah untuk mencipta berita baru.</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Tajuk Berita <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="title" id="newsTitle" required placeholder="Masukkan tajuk berita">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Slug <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="slug" required placeholder="cth: tajuk-berita">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Penulis</label>
                                <input type="text" class="form-control" value="{{ $users->name }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="is_active" class="form-control" required>
                                    <option selected disabled>Sila Pilih...</option>
                                    <option value="0">Draf</option>
                                    <option value="1">Terbit</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Muatturun Gambar <span class="text-danger">*</span></label>
                                <input type="file" name="image" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <label class="form-label mb-0">Kandungan Berita <span class="text-danger">*</span></label>
                                    <button type="button" class="ai-btn" id="aiGenerateBtn">
                                        <span class="spinner"></span>
                                        <span class="btn-text"><i class="fas fa-magic mr-1"></i> Jana dengan AI</span>
                                    </button>
                                </div>
                                <textarea class="form-control" id="editor" name="content" rows="8" placeholder="Tulis kandungan berita di sini..."></textarea>
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
    let editorInstance;

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
        .then(editor => {
            editorInstance = editor;
        })
        .catch(error => {
            console.error(error);
        });

    // AI Generate Button
    document.getElementById('aiGenerateBtn').addEventListener('click', async function() {
        const title = document.getElementById('newsTitle').value.trim();
        if (!title) {
            alert('Sila masukkan tajuk berita terlebih dahulu.');
            return;
        }

        this.classList.add('loading');
        this.disabled = true;

        try {
            const response = await fetch('/api/generate-news', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                },
                body: JSON.stringify({ title: title })
            });

            const data = await response.json();
            
            if (data.content && editorInstance) {
                editorInstance.setData(data.content);
            } else if (data.content) {
                document.querySelector('#editor').value = data.content;
            }
        } catch (error) {
            // Fallback: Generate simple content based on title
            const fallbackContent = `
<h2>${title}</h2>

<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

<h3>Butiran Lanjut</h3>

<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>

<ul>
    <li>Point penting pertama mengenai program ini</li>
    <li>Point penting kedua yang perlu diketahui</li>
    <li>Point penting ketiga untuk makluman</li>
</ul>

<p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
`;
            if (editorInstance) {
                editorInstance.setData(fallbackContent);
            }
        } finally {
            this.classList.remove('loading');
            this.disabled = false;
        }
    });
</script>
@endsection