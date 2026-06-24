<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>RPTAR Alumni | Lupa Kata Laluan</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/cuba.png')}}">
    
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="assets/css/sb-admin-2.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #a12c2f 0%, #6e1d1f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .modern-card {
            border: none;
            border-radius: 1.25rem;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            overflow: hidden;
            background-color: #fff;
        }
        .left-visual {
            background-color: #f8f9fc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
        }
        .left-visual img {
            max-width: 100%;
            height: auto;
            object-fit: contain;
        }
        .form-control-modern {
            height: calc(1.5em + 1.25rem + 2px);
            padding: 0.75rem 1.25rem;
            font-size: 0.9rem;
            border-radius: 0.75rem;
            border: 1px solid #d1d3e2;
        }
        .form-control-modern:focus {
            border-color: #a12c2f;
            box-shadow: 0 0 0 0.2rem rgba(161, 44, 47, 0.1);
        }
        .btn-modern {
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 0.75rem;
            border: none;
            transition: all 0.2s ease;
        }
        .logo-header {
            max-width: 180px;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card modern-card">
                    <div class="card-body p-0">
                        <div class="row no-gutters">
                            <!-- Kiri: Gambar Center -->
                            <div class="col-lg-6 d-none d-lg-flex left-visual">
                                <img src="assets/images/login.png" alt="Forgot Password Illustration">
                            </div>
                            
                            <!-- Kanan: Form -->
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="assets/images/RP.png" class="logo-header" alt="Logo">
                                        <h1 class="h4 text-gray-900 font-weight-bold mb-2">Lupa Kata Laluan?</h1>
                                        <p class="text-muted mb-4 small">Jangan risau, masukkan emel anda untuk menetapkan semula kata laluan.</p>
                                    </div>

                                    @if (session('success'))
                                        <div class="alert alert-success small shadow-sm border-0" style="border-radius: 10px;">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('forgot-password') }}">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-modern @error('email') is-invalid @enderror" 
                                                placeholder="Alamat Emel" name="email" value="{{ old('email') }}" required>
                                            @error('email')
                                                <span class="invalid-feedback ml-2" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-modern @error('password') is-invalid @enderror" 
                                                placeholder="Kata Laluan Baru" name="password" required>
                                            @error('password')
                                                <span class="invalid-feedback ml-2" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-4">
                                            <input type="password" class="form-control form-control-modern" 
                                                placeholder="Sahkan Kata Laluan Baru" name="password_confirmation" required>
                                        </div>

                                        <button type="submit" class="btn btn-danger btn-modern btn-block shadow-sm" style="background-color: #a12c2f;">
                                            Tetapkan Semula Kata Laluan
                                        </button>
                                    </form>
                                    
                                    <hr class="my-4">
                                    <div class="text-center">
                                        <a class="small font-weight-bold" href="{{ route('login') }}" style="color: #a12c2f;">Kembali ke Log Masuk</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small text-muted" href="{{ route('register') }}">Daftar Akaun Baru!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>