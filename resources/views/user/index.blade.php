@extends('layouts.staff-base')

@section('content')
    <div class="container-fluid">
        @php
            $roles = [
                'Jumlah Pengguna' => $users->count(),
                'Admin' => $users->where('role', 'admin')->count(),
                'Staff' => $users->where('role', 'staff')->count(),
                'Pengguna' => $users->where('role', 'user')->count(),
            ];
            $colors = ['primary', 'success', 'info', 'secondary'];
        @endphp
        <!-- Summary Section -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-left-primary">
                    <div class="card-body">
                        <div class="text-center">
                            <h6 class="text-gray-900 font-weight-bold">Jumlah Pengguna</h6>
                            <h2>{{ $users->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-left-success">
                    <div class="card-body">
                        <div class="text-center">
                            <h6 class="text-gray-900 font-weight-bold">Admin</h6>
                            <h2>{{ $users->where('role', 'admin')->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-left-info">
                    <div class="card-body">
                        <div class="text-center">
                            <h6 class="text-gray-900 font-weight-bold">Staff</h6>
                            <h2>{{ $users->where('role', 'staff')->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-left-danger">
                    <div class="card-body">
                        <div class="text-center">
                            <h6 class="text-gray-900 font-weight-bold">Pengguna</h6>
                            <h2>{{ $users->where('role', 'user')->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="successModalLabel">
                            <i class="fas fa-check-circle"></i> Akaun Berjaya Dicipta
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <p class="text-muted mt-2">Sila ambil perhatian bahawa kata laluan ini hanya boleh dilihat sekali
                            sahaja. Anda boleh menukarnya selepas log masuk.</p>
                        <hr>
                        <p>{!! session('modal') !!}</p>
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-outline-success" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-dark">Urus Pengguna</h6>
                <a href="" class="btn btn-sm btn-info shadow-sm" data-toggle="modal" data-target="#create-modal">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Cipta Pengguna
                </a>
            </div>
            <!-- Check if there is any news -->

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Pengguna</th>
                                <th>Emel</th>
                                <th>Peranan</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $users)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $users->name }}</td>
                                    <td>{{ $users->email }}</td>
                                    <td><span
                                            class="badge badge-{{ $users->role == 'admin' ? 'success' : ($users->role == 'staff' ? 'info' : 'secondary') }}">
                                            {{ ucfirst($users->role) }}
                                        </span></td>
                                    <td>
                                        <!-- Show Page-->
                                        @if ($users->role === 'user')
                                            <a href="#" data-toggle="modal"
                                                data-target="#view-modal{{ $users->id }}">
                                                <i class="fas fa-eye text-dark mr-2 fa-sm"></i>
                                            </a>
                                        @endif
                                        <!-- Edit Page-->
                                        @if ($users->role === 'staff' || $users->role === 'admin')
                                            <a href="" data-toggle="modal"
                                                data-target="#edit-modal{{ $users->id }}">
                                                <i class="fas fa-edit mr-2 fa-sm"></i></a>
                                        @endif
                                        <!-- Delete Page -->
                                        <a href="#" class="action-icon-danger" data-toggle="modal"
                                            data-target="#delete-modal{{ $users->id }}">
                                            <i class="fas fa-trash text-danger fa-sm"></i>
                                        </a>
                                    </td>
                                </tr>

                                <!-- View Modal -->
                                <div class="modal fade" id="view-modal{{ $users->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="viewUserModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg rounded-lg">
                                            <!-- Close Button -->
                                            <button type="button" class="close position-absolute" data-dismiss="modal"
                                                aria-label="Close" style="top: 15px; right: 20px; font-size: 1.5rem;">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <!-- Modal Header -->
                                            <div
                                                class="modal-header border-0 text-center pt-4 d-flex flex-column align-items-center">
                                                <h4 class="modal-title font-weight-bold" id="viewUserModalLabel">Maklumat
                                                    Pengguna</h4>
                                            </div>
                                            <!-- Modal Body -->
                                            <div class="modal-body px-5 py-2">
                                                <div class="form-row">
                                                    <!-- User Name -->
                                                    <div class="form-group col-md-12">
                                                        <label for="viewUserName" class="font-weight-bold">Nama</label>
                                                        <input type="text" id="viewUserName" class="form-control"
                                                            value="{{ $users->name }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <!-- Role -->
                                                    <div class="form-group col-md-12">
                                                        <label for="viewUserRole" class="font-weight-bold">Nama Penuh</label>
                                                        <input type="text" id="viewUserRole" class="form-control"
                                                            value="{{ ucfirst($users->profile->full_name) ?? 'N/A' }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <!-- Email -->
                                                    <div class="form-group col-md-12">
                                                        <label for="viewUserEmail" class="font-weight-bold">Emel</label>
                                                        <input type="email" id="viewUserEmail" class="form-control"
                                                            value="{{ $users->email }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <!-- Gender -->
                                                    <div class="form-group col-md-12">
                                                        <label for="viewUserGender" class="font-weight-bold">Jantina</label>
                                                        <input type="text" id="viewUserGender" class="form-control"
                                                            value="{{ $users->profile->gender == 'male' ? 'Lelaki' : 'Perempuan' }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <!-- Gender -->
                                                    <div class="form-group col-md-12">
                                                        <label for="viewUserGender" class="font-weight-bold">Nombor Telefon</label>
                                                        <input type="text" id="viewUserGender" class="form-control"
                                                            value="{{ $users->profile->contact_number ?? 'N/A' }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <!-- Role -->
                                                    <div class="form-group col-md-12">
                                                        <label for="viewUserRole" class="font-weight-bold">Peranan</label>
                                                        <input type="text" id="viewUserRole" class="form-control"
                                                            value="{{ ucfirst($users->role) }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Footer -->
                                            <div class="modal-footer border-0 d-flex justify-content-center py-3">
                                                <button type="button" class="btn btn-secondary px-4"
                                                    data-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Create User Modal -->
                                <div class="modal fade" id="create-modal" tabindex="-1" role="dialog"
                                    aria-labelledby="createUserModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg rounded-lg">
                                            <!-- Close Button -->
                                            <button type="button" class="close position-absolute" data-dismiss="modal"
                                                aria-label="Close" style="top: 15px; right: 20px; font-size: 1.5rem;">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <!-- Modal Header -->
                                            <div
                                                class="modal-header border-0 text-center pt-4 d-flex flex-column align-items-center">
                                                <h4 class="modal-title font-weight-bold" id="createUserModalLabel">Cipta
                                                    Pengguna Baharu</h4>
                                            </div>
                                            <!-- Modal Body -->
                                            <form method="POST" action="{{ route('user.store') }}">
                                                @csrf
                                                <div class="modal-body px-5 py-2">
                                                    <div class="form-row">
                                                        <!-- User Name -->
                                                        <div class="form-group col-md-12">
                                                            <label for="userName" class="font-weight-bold">Nama
                                                                Pengguna<span class="text-danger">*</span></label>
                                                            <input type="text" id="userName" class="form-control"
                                                                name="name" placeholder="username" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <!-- Email -->
                                                        <div class="form-group col-md-12">
                                                            <label for="userEmail" class="font-weight-bold">Emel<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="email" id="userEmail" class="form-control"
                                                                name="email" placeholder="example@gmail.com" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <!-- Role -->
                                                        <div class="form-group col-md-12">
                                                            <label for="userRole" class="font-weight-bold">Peranan<span
                                                                    class="text-danger">*</span></label>
                                                            <select name="role" id="userRole" class="form-control"
                                                                required>
                                                                <option selected disabled>Sila Pilih...</option>
                                                                <option value="admin">Admin</option>
                                                                <option value="staff">Staff</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <!-- Password -->
                                                        <div class="form-group col-md-12">
                                                            <label for="userPassword" class="font-weight-bold">Kata
                                                                Laluan<span class="text-danger">*</span></label>
                                                            <input type="password" id="userPassword" class="form-control"
                                                                name="password" placeholder="Masukkan Kata Laluan"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal Footer -->
                                                <div class="modal-footer border-0 d-flex justify-content-center py-3">
                                                    <button type="button" class="btn btn-secondary px-4 mr-4"
                                                        data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-info px-4">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="edit-modal{{ $users->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg rounded-lg">
                                            <!-- Close Button -->
                                            <button type="button" class="close position-absolute" data-dismiss="modal"
                                                aria-label="Close" style="top: 15px; right: 20px; font-size: 1.5rem;">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <!-- Modal Header -->
                                            <div
                                                class="modal-header border-0 text-center pt-4 d-flex flex-column align-items-center">
                                                <h4 class="modal-title font-weight-bold" id="createUserModalLabel">
                                                    Kemaskini
                                                    Pengguna</h4>
                                            </div>
                                            <!-- Modal Body -->
                                            <form method="POST" action="{{ route('user.update', $users->id) }}">
                                                @csrf
                                                <div class="modal-body px-5 py-2">
                                                    <div class="form-row">
                                                        <!-- User Name -->
                                                        <div class="form-group col-md-12">
                                                            <label for="userName" class="font-weight-bold">Nama</label>
                                                            <input type="text" id="userName" class="form-control"
                                                                name="name" placeholder="John Smith" required
                                                                value="{{ $users->name }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <!-- Email -->
                                                        <div class="form-group col-md-12">
                                                            <label for="userEmail" class="font-weight-bold">Emel</label>
                                                            <input type="email" id="userEmail" class="form-control"
                                                                name="email" placeholder="example@gmail.com" required
                                                                value="{{ $users->email }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <!-- Role -->
                                                        <div class="form-group col-md-12">
                                                            <label for="userRole" class="font-weight-bold">Peranan</label>
                                                            <select name="role" id="userRole" class="form-control"
                                                                required>
                                                                <option disabled>Sila Pilih...</option>
                                                                <option value="admin"
                                                                    {{ $users->role == 'admin' ? 'selected' : '' }}>Admin
                                                                </option>
                                                                <option value="staff"
                                                                    {{ $users->role == 'staff' ? 'selected' : '' }}>Staff
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- Modal Footer -->
                                                <div class="modal-footer border-0 d-flex justify-content-center py-3">
                                                    <button type="button" class="btn btn-secondary px-4 mr-4"
                                                        data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-info px-4">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="delete-modal{{ $users->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content border-0 rounded-lg shadow">
                                            <!-- Close Button -->
                                            <button type="button" class="close position-absolute text-dark"
                                                data-dismiss="modal" aria-label="Close"
                                                style="top: 15px; right: 15px; font-size: 1.5rem;">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <!-- Centered Warning Icon -->
                                            <div class="text-center pt-4">
                                                <div class="rounded-circle bg-danger d-inline-flex align-items-center justify-content-center"
                                                    style="width: 60px; height: 60px;">
                                                    <i class="fas fa-exclamation-triangle text-white"
                                                        style="font-size: 30px;"></i>
                                                </div>
                                            </div>
                                            <!-- Modal Body -->
                                            <div class="modal-body text-center pt-3 pb-0">
                                                <h5 class="font-weight-bold mb-3">Padam Pengguna</h5>
                                                <p class="text-muted mb-3">Tindakan ini tidak boleh dibatalkan. Adakah anda
                                                    pasti?
                                                </p>
                                            </div>
                                            <!-- Modal Footer -->
                                            <div class="modal-footer justify-content-center py-3 border-0">
                                                <button type="button" class="btn btn-secondary px-4"
                                                    data-dismiss="modal">Tidak, Simpan</button>
                                                <form method="POST" action="{{ route('user.destroy', $users->id) }}"
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
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('modal'))
                // Show the modal
                $('#successModal').modal('show');
            @endif
        });
    </script>
@endsection
