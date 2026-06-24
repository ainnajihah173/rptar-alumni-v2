<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>RPTAR Alumni | Daftar Akaun</title>
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
            padding: 1rem 0;
        }
        .register-card {
            border: none;
            border-radius: 1.25rem;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            overflow: hidden;
            background-color: #fff;
        }
        .left-image-container {
            background-color: #f8f9fc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem;
        }
        .left-image-container img {
            max-width: 100%;
            height: auto;
            object-fit: contain;
        }
        .form-control-modern {
            height: calc(1.5em + 1.1rem + 2px);
            padding: 0.6rem 1.1rem;
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
        .btn-google-modern {
            background-color: #ffffff;
            color: #444;
            border: 1px solid #dadce0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
        }
        .btn-google-modern:hover {
            background-color: #f8f9fa;
            border-color: #d2d2d2;
            color: #222;
            text-decoration: none;
        }
        .google-icon {
            width: 20px;
            height: 20px;
        }
        .logo-main {
            max-width: 160px;
            margin-bottom: 1rem;
        }
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.25rem 0;
            color: #858796;
            font-size: 0.8rem;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e3e6f0;
        }
        .divider:not(:empty)::before { margin-right: .75em; }
        .divider:not(:empty)::after { margin-left: .75em; }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12">
                <div class="card register-card">
                    <div class="card-body p-0">
                        <div class="row no-gutters">
                            <!-- Kiri: Gambar Illustration -->
                            <div class="col-lg-5 d-none d-lg-flex left-image-container">
                                <img src="assets/images/login3.png" alt="Register Illustration">
                            </div>
                            
                            <!-- Kanan: Form -->
                            <div class="col-lg-7">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="assets/images/RP.png" class="logo-main" alt="Logo">
                                        <h1 class="h4 text-gray-900 font-weight-bold mb-1">Daftar Sekarang</h1>
                                        <p class="text-muted mb-4">Lengkapkan maklumat di bawah</p>
                                    </div>

                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-modern @error('name') is-invalid @enderror" 
                                                placeholder="Nama Pengguna" name="name" value="{{ old('name') }}" required>
                                            @error('name')
                                                <span class="invalid-feedback ml-2" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-modern @error('email') is-invalid @enderror" 
                                                placeholder="Alamat Emel" name="email" value="{{ old('email') }}" required>
                                            @error('email')
                                                <span class="invalid-feedback ml-2" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="password" class="form-control form-control-modern @error('password') is-invalid @enderror" 
                                                    placeholder="Kata Laluan" name="password" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="password" class="form-control form-control-modern" 
                                                    placeholder="Sahkan Kata Laluan" name="password_confirmation" required>
                                            </div>
                                        </div>

                                        <div class="form-group mb-4">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="terms" required>
                                                <label class="custom-control-label text-muted" for="terms">
                                                    Saya bersetuju dengan <a href="#" style="color: #a12c2f; font-weight: 600;">Terma & Syarat</a>
                                                </label>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-danger btn-modern btn-block shadow-sm" style="background-color: #a12c2f;">
                                            Daftar Akaun
                                        </button>

                                        <div class="divider">Atau daftar melalui</div>

                                        <a href="{{ url('auth/google') }}" class="btn btn-modern btn-google-modern shadow-sm">
                                            <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" class="google-icon" alt="Google">
                                            <span>Sertai dengan Google</span>
                                        </a>
                                    </form>
                                    
                                    <div class="text-center mt-4">
                                        <p class="small mb-0 text-muted">Sudah ada akaun? 
                                            <a class="font-weight-bold" href="{{ route('login') }}" style="color: #a12c2f;">Log Masuk</a>
                                        </p>
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