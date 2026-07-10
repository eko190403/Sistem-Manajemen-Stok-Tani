<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Akun - Dashboard Stok & Blockchain</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #245bff, #0a1931);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.12);
            border-radius: 18px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
            animation: fadeIn 0.8s ease-out;
            width: 100%;
            max-width: 420px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .auth-title {
            font-size: 28px;
            font-weight: 600;
            color: #ffffff;
            text-align: center;
            margin-bottom: 25px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.25);
            border: none;
            border-radius: 12px;
            color: #ffffff;
            height: 48px;
            transition: 0.25s;
            padding: 10px 15px;
        }

        .form-control::placeholder {
            color: #e8e8e8;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.4);
            transform: scale(1.03);
            color: #000;
            box-shadow: none;
        }

        label {
            color: #eaeaea;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .btn-register {
            background: #4c6ef5;
            border-radius: 12px;
            border: none;
            height: 48px;
            font-size: 16px;
            transition: 0.25s;
            color: white;
            font-weight: 600;
        }

        .btn-register:hover {
            background: #3b5bdb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 110, 245, 0.4);
        }

        .form-footer {
            text-align: center;
            color: #dcdcdc;
            margin-top: 15px;
            font-size: 14px;
        }

        .form-footer a {
            color: #9bb8ff;
            text-decoration: none;
            font-weight: 600;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        .alert {
            background: rgba(255, 107, 107, 0.15);
            border: 1px solid rgba(255, 107, 107, 0.4);
            color: #ff9999;
            border-radius: 12px;
            padding: 12px;
            font-size: 14px;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .alert li {
            margin-bottom: 5px;
        }

        /* Fade Animation */
        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: translateY(20px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }

        /* Logo Section */
        .logo-section {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            text-decoration: none;
        }

        .logo-icon {
            font-size: 32px;
        }

        .logo-text {
            font-size: 16px;
            font-weight: 600;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .glass-card {
                padding: 30px 20px;
                max-width: 350px;
            }

            .auth-title {
                font-size: 24px;
                margin-bottom: 20px;
            }

            .form-control {
                height: 44px;
                font-size: 14px;
            }

            label {
                font-size: 13px;
            }

            .btn-register {
                height: 44px;
                font-size: 14px;
            }

            .form-footer {
                font-size: 13px;
            }

            .logo-text {
                display: none;
            }

            body {
                padding: 15px;
            }
        }

        @media (max-width: 480px) {
            .glass-card {
                padding: 25px 15px;
                max-width: 90%;
            }

            .auth-title {
                font-size: 20px;
                margin-bottom: 18px;
            }

            .mb-3 {
                margin-bottom: 12px !important;
            }

            .form-control {
                height: 42px;
                padding: 8px 12px;
                font-size: 13px;
            }

            label {
                font-size: 12px;
            }

            .btn-register {
                height: 42px;
                font-size: 13px;
            }

            .alert {
                padding: 10px;
                font-size: 12px;
            }

            body {
                padding: 10px;
            }
        }
    </style>
</head>

<body>

    <a href="{{ route('login') }}" class="logo-section text-decoration-none">
        <div class="logo-icon">🌾</div>
        <div class="logo-text">Kelompok Tani</div>
    </a>

    <div class="glass-card">

        <h2 class="auth-title">Daftar Akun</h2>

        @if ($errors->any())
            <div class="alert">
                <ul>
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
            </div>

            <button type="submit" class="btn-register w-100 mt-2">Daftar</button>
        </form>

        <div class="form-footer">
            Sudah punya akun?
            <a href="{{ route('login') }}">Login di sini</a>
        </div>

    </div>

</body>
</html>
    
