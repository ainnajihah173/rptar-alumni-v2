@extends('layouts.staff-base')

@section('content')
    @php
        $roleColors = [
            'user' => 'linear-gradient(to right, #f53b57, #ff6f61)',
            'admin' => 'linear-gradient(to right, #117a8b, #23c6c8)',
            'staff' => 'linear-gradient(to right, #007bff, #6c757d)',
        ];
        $roleButtons = [
            'user' => 'btn-danger',
            'admin' => 'btn-info',
            'staff' => 'btn-primary',
        ];
    @endphp
    <style>
        /* Custom CSS for modern aesthetics */
        .form-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .form-header {
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .form-body {
            padding: 30px;
        }

        .upload-feedback {
            margin-top: 10px;
            font-size: 0.9em;
            color: #6c757d;
        }

        .rounded-img {
            border: 5px solid #f8f9fc;
        }

        .password-card {
            margin-top: 20px;
        }
    </style>

    <!-- Display general error messages -->
    @if (session('errors'))
        <div class="alert alert-danger">
            <ul>
                @foreach (session('errors')->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Edit Profile Card -->
    <div class="card form-card" style="max-width: 1100px; margin: auto;">
        <div class="form-header" style="background: {{ $roleColors[$user->role] }}">
            <h5 class="m-0">Kemaskini Profil {{ ucfirst($user->role) }}</h5>
        </div>

        <div class="card-body form-body">
            <p class="text-muted font-14 mb-4">Kemaskini maklumat profil {{ $user->role }} di bawah.</p>

            <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Profile Picture -->
                <div class="text-center mb-2">
                    <label for="profile_picture">
                        <img src="{{ $profile->profile_pic ? asset('storage/' . $profile->profile_pic) : asset('assets/images/default-avatar.png') }}"
                            id="profile-preview" alt="Profile Picture" class="img-fluid rounded-circle rounded-img"
                            style="width: 120px; height: 120px; object-fit: cover; cursor: pointer;">
                    </label>
                    <input type="file" id="profile_picture" class="d-none" name="profile_pic"
                        onchange="previewImage(event)">
                    <small class="upload-feedback" id="upload-feedback">Klik imej untuk muat naik gambar profil baru.</small>
                </div>

                <!-- Form Fields -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="username">Nama Pengguna<span class="text-danger">*</span></label>
                        <input type="text" id="username" class="form-control" name="name" value="{{ $user->name }}"
                            readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email">Alamat Emel<span class="text-danger">*</span></label>
                        <input type="email" id="email" class="form-control" name="email" value="{{ $user->email }}"
                            readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="full_name">Nama Penuh<span class="text-danger">*</span></label>
                        <input type="text" id="full_name" class="form-control" name="full_name"
                            value="{{ $profile->full_name ?? '' }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="gender">Jantina<span class="text-danger">*</span></label>
                        <select name="gender" id="gender" class="form-control" required>
                            <option selected disabled>Sila Pilih...</option>
                            <option value="male" {{ ($profile->gender ?? '') === 'male' ? 'selected' : '' }}>Lelaki</option>
                            <option value="female" {{ ($profile->gender ?? '') === 'female' ? 'selected' : '' }}>Perempuan
                            </option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="date_of_birth">Tarikh Lahir</label>
                        <input type="date" id="date_of_birth" class="form-control" name="date_of_birth"
                            value="{{ $profile->date_of_birth ?? '' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="contact_number">Nombor Telefon<span class="text-danger">*</span></label>
                        <input type="tel" id="contact_number" class="form-control" name="contact_number"
                            value="{{ $profile->contact_number ?? '' }}" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="address">Alamat</label>
                        <textarea id="address" class="form-control" name="address" rows="3">{{ $profile->address ?? '' }}</textarea>
                    </div>
                    @if ($user->role === 'user')
                        <div class="col-md-12 mb-3">
                            <label for="bio">Bio<span class="text-danger">*</span></label>
                            <textarea id="bio" class="form-control" name="bio" rows="4" required>{{ $profile->bio ?? '' }}</textarea>
                            <small class="text-muted">Tulis bio ringkas tentang alumni.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="job">Pekerjaan</label>
                            <input type="text" id="job" class="form-control" name="job"
                                value="{{ $profile->job ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="facebook">Facebook (Pilihan)</label>
                            <input type="text" id="facebook" class="form-control" name="facebook"
                                value="{{ $profile->facebook ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="instagram">Instagram (Pilihan)</label>
                            <input type="text" id="instagram" class="form-control" name="instagram"
                                value="{{ $profile->instagram ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="linkedin">LinkedIn (Pilihan)</label>
                            <input type="text" id="linkedin" class="form-control" name="linkedin"
                                value="{{ $profile->linkedin ?? '' }}">
                        </div>
                    @endif
                </div>

                <!-- Form Buttons -->
                <div class="text-center mt-4">
                    <button type="button" onclick="history.back()" class="btn btn-light mr-3">Batal</button>
                    <button type="submit" class="btn {{ $roleButtons[$user->role] }}">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Change Password Card -->
    <div class="card form-card password-card my-3" style="max-width: 1100px; margin:auto;">
        <div class="form-header" style="background: {{ $roleColors[$user->role] }}">
            <h5 class="m-0">Tukar Kata Laluan</h5>
        </div>

        <div class="card-body form-body">
            <p class="text-muted font-14 mb-4">Pastikan kata laluan baru anda kuat dan unik.</p>

            <form action="{{ route('profile.change-password', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
            
                <div class="row">
                    <!-- Current Password -->
                    <div class="col-md-6 mb-3">
                        <label for="current_password">Kata Laluan Semasa<span class="text-danger">*</span></label>
                        <input type="password" id="current_password" class="form-control" name="current_password" required>
                        @error('current_password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
            
                    <!-- New Password -->
                    <div class="col-md-6 mb-3">
                        <label for="new_password">Kata Laluan Baru<span class="text-danger">*</span></label>
                        <input type="password" id="new_password" class="form-control" name="new_password" required>
                        @error('new_password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
            
                    <!-- Confirm New Password -->
                    <div class="col-md-6 mb-3">
                        <label for="new_password_confirmation">Sahkan Kata Laluan Baru<span class="text-danger">*</span></label>
                        <input type="password" id="new_password_confirmation" class="form-control" name="new_password_confirmation" required>
                        @error('new_password_confirmation')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            
                <!-- Submit Button -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn {{ $roleButtons[$user->role] }}">Tukar Kata Laluan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Preview uploaded image with format validation
        function previewImage(event) {
            const file = event.target.files[0];
            const validImageTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif']; // Allowed formats
    
            if (!validImageTypes.includes(file.type)) {
                // Display error message if format is invalid
                document.getElementById('upload-feedback').innerText = "Gambar profil mesti dalam format imej yang sah (jpeg, png, jpg, gif).";
                document.getElementById('upload-feedback').style.color = "red"; // Make error message stand out
                document.getElementById('profile-preview').src = ""; // Clear previous preview
                return;
            }
    
            const reader = new FileReader();
            reader.onload = function () {
                // Display preview and feedback if valid
                document.getElementById('profile-preview').src = reader.result;
                document.getElementById('upload-feedback').innerText = "Imej berjaya dimuat naik.";
                document.getElementById('upload-feedback').style.color = "green"; // Success message in green
            };
            reader.readAsDataURL(file);
        }
    </script>
    
@endsection