@extends('layouts.staff-base')
@section('content')
    <!-- Page Heading -->
    <div class="mb-3">
        <a href="{{ route('events.index') }}" class="text-decoration-none text-dark">
            <i class="fas fa-arrow-left"></i> Kembali ke Acara
        </a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-dark">Kemaskini Acara</h6>
        </div>

        <div class="card-body">
            <!-- Progress Bar -->
            <div class="progress mb-4">
                <div class="progress-bar" id="progress-bar" role="progressbar" style="width: 33%;" aria-valuenow="33"
                    aria-valuemin="0" aria-valuemax="100"></div>
            </div>

            <!-- Step Indicators -->
            <div class="row text-center mb-4">
                <div class="col step">
                    <i class="fas fa-calendar-alt step-icon" id="step-1-icon"></i>
                    <p>Butiran Acara</p>
                </div>
                <div class="col step">
                    <i class="fas fa-calendar-plus step-icon" id="step-2-icon"></i>
                    <p>Butiran Tambahan</p>
                </div>
                <div class="col step">
                    <i class="fas fa-user step-icon" id="step-3-icon"></i>
                    <p>Butiran Penganjur</p>
                </div>
            </div>

            <!-- Multi-Step Form -->
            <form id="multi-step-form" method="POST" enctype="multipart/form-data"
                action="{{ route('events.update', $events->id) }}">
                @method('PUT')
                @csrf
                <!-- Step 1 -->
                <div id="step-1" class="step-content">
                    <div class="row justify-content-center align-items-center g-2">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="example-readonly">Nama Acara<span class="text-danger">*</span></label>
                                <input type="text" id="example-readonly" class="form-control" name="name" required
                                    placeholder="Nama Acara" value="{{ $events->name }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="example-readonly">Acara Dicipta Oleh</label>
                                <input type="text" id="example-readonly" class="form-control" name="user_id" readonly
                                    placeholder="Nama Staf" value="{{ $events->users->name }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="example-readonly">Penerangan Acara<span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" name="description">{{ $events->description }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="example-readonly">Lokasi Acara<span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" name="location">{{ $events->location }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="start_date">Tarikh Mula Acara <span class="text-danger">*</span></label>
                                <input type="date" id="start_date" class="form-control" name="start_date" required
                                    value="{{ old('start_date', $events->start_date ? date('Y-m-d', strtotime($events->start_date)) : '') }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="end_date">Tarikh Tamat Acara</label>
                                <input type="date" id="end_date" class="form-control" name="end_date"
                                    value="{{ old('end_date', $events->end_date ? date('Y-m-d', strtotime($events->end_date)) : '') }}">
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-2">
                        <button type="button" class="btn btn-primary next-btn">Seterusnya</button>
                    </div>
                </div>

                <!-- Step 2: Additional Details -->
                <div id="step-2" class="step-content d-none">
                    <div class="row justify-content-center align-items-center g-2">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="start_time">Masa Mula Acara <span class="text-danger">*</span></label>
                                <input type="time" id="start_time" class="form-control" name="start_time" required
                                    value="{{ old('start_time', $events->start_time ? date('H:i', strtotime($events->start_time)) : '') }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="end_time">Masa Tamat Acara <span class="text-danger">*</span></label>
                                <input type="time" id="end_time" class="form-control" name="end_time"
                                    value="{{ old('end_time', $events->end_time ? date('H:i', strtotime($events->end_time)) : '') }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="example-readonly">Gambar Acara</label>
                                <input type="file" id="example-readonly" class="form-control" name="image_path">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="example-readonly">Kapasiti Acara<span class="text-danger">*</span></label>
                                <input type="number" id="example-readonly" class="form-control" name="capacity"
                                    required placeholder="0" value="{{ $events->capacity }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            @if ($events->image_path)
                                <!-- Check if there's an existing image -->
                                <div class="mt-2">
                                    <p>Gambar Semasa:</p>
                                    <img src="{{ asset('storage/' . $events->image_path) }}" alt="Gambar Acara"
                                        class="img-thumbnail" width="150">
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-6"></div>
                    </div>
                    <div class="text-center mt-2">
                        <button type="button" class="btn btn-secondary prev-btn mr-3">Kembali</button>
                        <button type="button" class="btn btn-primary next-btn">Seterusnya</button>
                    </div>
                </div>

                <!-- Step 3: Organizer Details -->
                <div id="step-3" class="step-content d-none">
                    <div class="row justify-content-center align-items-center g-2">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="organizer-select">Nama Penganjur<span class="text-danger">*</span></label>
                                <select id="organizer-select" name="organizer_id" class="form-control" required>
                                    <option value="" disabled selected>Pilih Penganjur</option>
                                    @foreach ($organizers as $organizer)
                                        <option value="{{ $organizer->id }}"
                                            data-contact="{{ $organizer->organizer_contact }}"
                                            data-email="{{ $organizer->organizer_email }}"
                                            {{ $events->organizer_id == $organizer->id ? 'selected' : '' }}>
                                            {{ $organizer->organizer_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="organizer-contact">Nombor Telefon<span class="text-danger">*</span></label>
                                <input type="text" id="organizer-contact" class="form-control"
                                    name="organizer_contact" required placeholder="Nombor Telefon" readonly
                                    value="{{ $events->organizers->organizer_contact }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="organizer-email">Emel<span class="text-danger">*</span></label>
                                <input type="email" id="organizer-email" class="form-control" name="organizer_email"
                                    required placeholder="Emel" readonly
                                    value="{{ $events->organizers->organizer_email }}">
                            </div>
                        </div>
                        <div class="col-lg-6"></div>
                    </div>
                    <div class="text-center mt-2">
                        <button type="button" class="btn btn-secondary prev-btn mr-3">Kembali</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for Organizer Dropdown -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const organizerSelect = document.getElementById('organizer-select');
            const organizerContact = document.getElementById('organizer-contact');
            const organizerEmail = document.getElementById('organizer-email');

            if (organizerSelect) {
                organizerSelect.addEventListener('change', function () {
                    const selectedOption = this.options[this.selectedIndex];
                    if (selectedOption.value) {
                        organizerContact.value = selectedOption.getAttribute('data-contact') || '';
                        organizerEmail.value = selectedOption.getAttribute('data-email') || '';
                    } else {
                        organizerContact.value = '';
                        organizerEmail.value = '';
                    }
                });
            }
        });
    </script>
@endsection