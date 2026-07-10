<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Transparansi Kelompok Tani - Login & Register dengan teknologi Blockchain">
    <meta name="keywords" content="Kelompok Tani, Blockchain, Stok, Keuangan, Transparansi">
    <meta name="theme-color" content="#5d8dff">
    <title>Login & Register - Sistem Kelompok Tani</title>

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect fill='%235d8dff' width='100' height='100'/><text x='50' y='50' font-size='60' fill='white' text-anchor='middle' dy='.3em'>🌾</text></svg>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #5d8dff, #1c2b52);
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
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
            z-index: 500;
        }

        .logo-icon {
            font-size: 32px;
        }

        .logo-text {
            font-size: 16px;
            font-weight: 600;
        }

        .main-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 30px;
            width: 100%;
            max-width: 1200px;
            transition: all 0.3s;
            padding: 20px;
        }

        .login-col {
            flex: 0 0 400px;
            transition: all 0.3s;
            min-width: 300px;
        }

        .readme-col {
            flex: 0;
            overflow: hidden;
            transition: flex 0.3s;
            color: #fff;
            max-height: 520px;
        }

        .flip-container {
            width: 100%;
            height: 520px;
            perspective: 1200px;
        }

        .flip-card {
            width: 100%;
            height: 100%;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 1s ease;
        }

        .flip-card.flip {
            transform: rotateY(180deg);
        }

        .flip-side {
            width: 100%;
            height: 100%;
            position: absolute;
            backface-visibility: hidden;
            background: rgba(255, 255, 255, 0.22);
            backdrop-filter: blur(16px);
            border-radius: 22px;
            padding: 40px;
            box-shadow: 0 8px 26px rgba(0,0,0,0.25);
            border: 1px solid rgba(255,255,255,0.3);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .flip-back {
            transform: rotateY(180deg);
        }

        h3 {
            text-align: center;
            color: #fff;
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 25px;
        }

        label {
            color: #f5f5f5;
            font-size: 14px;
        }

        .form-control {
            background: rgba(255,255,255,0.28);
            border: none;
            border-radius: 12px;
            height: 46px;
            color: white;
            transition: 0.25s;
            padding: 10px 15px;
        }

        .form-control::placeholder {
            color: #e8e8e8;
        }

        .form-control:focus {
            background: rgba(255,255,255,0.55);
            color: #000;
            transform: scale(1.03);
            box-shadow: none;
        }

        /* Password field wrapper */
        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #333;
            font-size: 18px;
            margin-top: 23px;
            z-index: 10;
        }

        /* Password Strength Indicator */
        .password-strength {
            height: 4px;
            background: #e0e0e0;
            border-radius: 2px;
            margin-top: 8px;
            overflow: hidden;
        }

        .strength-bar {
            height: 100%;
            width: 0;
            transition: width 0.3s;
            border-radius: 2px;
        }

        .strength-bar.weak {
            width: 33%;
            background: #ff6b6b;
        }

        .strength-bar.medium {
            width: 66%;
            background: #ffc107;
        }

        .strength-bar.strong {
            width: 100%;
            background: #28a745;
        }

        .strength-text {
            font-size: 12px;
            margin-top: 4px;
            color: #f5f5f5;
        }

        .btn-auth {
            background: #4c6ef5;
            border-radius: 12px;
            border: none;
            height: 48px;
            color: white;
            font-size: 16px;
            transition: 0.25s;
            position: relative;
            overflow: hidden;
        }

        .btn-auth:hover {
            background: #3b5bdb;
            transform: translateY(-3px);
            box-shadow: 0 4px 16px rgba(76,110,245,0.5);
        }

        /* Loading spinner */
        .btn-auth.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .spinner-border {
            width: 18px;
            height: 18px;
            margin-right: 8px;
        }

        .switch-link, #btnReadme {
            margin-top: auto;
            text-align: center;
            color: #d9e4ff;
            cursor: pointer;
            font-size: 14px;
        }

        .switch-link:hover, #btnReadme:hover {
            text-decoration: underline;
        }

        /* Checkbox styling */
        .form-check {
            margin-top: 15px;
        }

        .form-check-input {
            background-color: rgba(255,255,255,0.3);
            border: 1px solid rgba(255,255,255,0.5);
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #4c6ef5;
            border-color: #4c6ef5;
        }

        .form-check-label {
            color: #f5f5f5;
            cursor: pointer;
            font-size: 14px;
            margin-left: 5px;
        }

        /* ===== ERROR EFFECT ===== */
        @keyframes shake {
            0% { transform: translateX(0); }
            20% { transform: translateX(-6px); }
            40% { transform: translateX(6px); }
            60% { transform: translateX(-6px); }
            80% { transform: translateX(6px); }
            100% { transform: translateX(0); }
        }

        .login-error {
            animation: shake 0.4s;
        }

        .input-error {
            border: 2px solid #ff6b6b !important;
            background: rgba(255, 107, 107, 0.15) !important;
        }

        .error-message {
            font-size: 12px;
            color: #ff6b6b;
            margin-top: 6px;
        }

        /* Toast styling */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 2000;
        }

        .toast {
            background: rgba(0, 0, 0, 0.85);
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 10px;
            animation: slideIn 0.3s ease-out;
            min-width: 300px;
        }

        .toast.success {
            border-left: 4px solid #28a745;
        }

        .toast.error {
            border-left: 4px solid #ff6b6b;
        }

        .toast.info {
            border-left: 4px solid #4c6ef5;
        }

        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* README styling */
        .readme-content {
            background: rgba(255,255,255,0.22);
            backdrop-filter: blur(16px);
            border-radius: 22px;
            padding: 18px;
            max-height: 520px;
            overflow-y: auto;
            border: 1px solid rgba(255,255,255,0.3);
        }

        /* Top Right Button */
        #btnReadme {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: rgba(76, 110, 245, 0.9);
            border-radius: 25px;
            color: white;
            cursor: pointer;
            z-index: 1000;
            transition: 0.25s;
            border: none;
            font-size: 14px;
        }

        #btnReadme:hover {
            background: rgba(59, 91, 219, 1);
            transform: scale(1.05);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .main-container {
                flex-direction: column;
                gap: 20px;
            }

            .readme-col {
                flex: 1;
                max-height: 400px;
            }

            .flip-container {
                height: 450px;
            }
        }

        @media (max-width: 768px) {
            .logo-section {
                top: 10px;
                left: 10px;
            }

            .logo-text {
                display: none;
            }

            .login-col {
                flex: 0 0 100%;
                max-width: 350px;
            }

            .flip-container {
                height: 400px;
            }

            .flip-side {
                padding: 30px 20px;
            }

            h3 {
                font-size: 22px;
                margin-bottom: 20px;
            }

            .readme-col {
                display: none;
            }

            #btnReadme {
                top: 15px;
                right: 15px;
                padding: 8px 16px;
                font-size: 12px;
                z-index: 1001;
            }

            .main-container {
                padding: 10px;
            }

            /* Modal untuk mobile */
            .modal-readme {
                display: none;
                position: fixed;
                z-index: 2000;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.6);
                animation: fadeIn 0.3s;
            }

            .modal-readme.show {
                display: block;
            }

            .modal-readme-content {
                background: linear-gradient(135deg, #5d8dff, #1c2b52);
                position: relative;
                margin: auto;
                padding: 20px;
                max-height: 80vh;
                overflow-y: auto;
                border-radius: 12px;
                animation: slideUp 0.3s;
                margin-top: 10vh;
                margin-left: 10px;
                margin-right: 10px;
            }

            .modal-close-btn {
                position: absolute;
                right: 15px;
                top: 15px;
                font-size: 28px;
                font-weight: bold;
                color: white;
                cursor: pointer;
                background: none;
                border: none;
                padding: 0;
                width: 30px;
                height: 30px;
            }

            .modal-close-btn:hover {
                color: #ff6b6b;
            }

            .modal-readme-content h3 {
                color: white;
                text-align: center;
                margin-top: 0;
                padding-top: 10px;
            }

            @keyframes slideUp {
                from {
                    transform: translateY(50px);
                    opacity: 0;
                }
                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }

            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
        }

        @media (max-width: 480px) {
            .flip-side {
                padding: 25px 15px;
            }

            .mb-3 {
                margin-bottom: 15px !important;
            }

            h3 {
                font-size: 20px;
            }

            .btn-auth {
                height: 44px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>


<div class="logo-section">
 
    <div class="logo-text">Kelompok Tani</div>
</div>

<div id="btnReadme">Tentang Sistem</div>

<div id="toastContainer" class="toast-container"></div>


<!-- Modal README untuk mobile -->
<div id="modalReadme" class="modal-readme">
    <div class="modal-readme-content">
        <button class="modal-close-btn" onclick="closeModalReadme()">&times;</button>
        <div id="readmeModalBody"></div>
    </div>
</div>

<div class="main-container">

    <!-- Login Flip -->
    <div class="login-col">
        <div class="flip-container">
            <div class="flip-card" id="flipCard">

                <!-- LOGIN -->
                <div class="flip-side flip-front {{ $errors->any() ? 'login-error' : '' }}">
                    <h3>Login</h3>

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="form-control @error('email') input-error @enderror"
                                   placeholder="Masukkan email"
                                   required>

                            @error('email')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password"
                                   name="password"
                                   class="form-control @error('password') input-error @enderror"
                                   placeholder="Masukkan password"
                                   required>

                            @error('password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn-auth w-100">Login</button>

                        <div class="switch-link" id="toRegister">Belum punya akun? Daftar</div>

                    </form>
                </div>

                <!-- REGISTER -->
                <div class="flip-side flip-back">
                    <h3>Daftar Akun</h3>

                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" required>
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                        </div>

                        <div class="mb-3">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                        </div>

                        <button type="submit" class="btn-auth w-100 mt-2">Daftar</button>

                        <div class="switch-link" id="toLogin">Sudah punya akun? Login</div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- README -->
    <div class="readme-col">
        <div class="readme-content">
            @include('partials.tentang_partial')
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Flip login/register
    const flipCard = document.getElementById('flipCard');
    document.getElementById('toRegister').onclick = () => flipCard.classList.add('flip');
    document.getElementById('toLogin').onclick = () => flipCard.classList.remove('flip');

    // Toggle README dan geser login
    const btnReadme = document.getElementById('btnReadme');
    const readmeCol = document.querySelector('.readme-col');
    const loginCol = document.querySelector('.login-col');
    const modalReadme = document.getElementById('modalReadme');
    const isMobile = window.innerWidth <= 768;

    btnReadme.onclick = () => {
        if (isMobile) {
            // Tampilkan modal untuk mobile
            openModalReadme();
        } else {
            // Toggle readme untuk desktop
            if(!readmeOpen){
                readmeCol.style.flex = '1 1 60%';
                loginCol.style.flex = '0 0 40%';
            } else {
                readmeCol.style.flex = '0';
                loginCol.style.flex = '0 0 400px';
            }
            readmeOpen = !readmeOpen;
        }
    };

    let readmeOpen = false;

    function openModalReadme() {
        const modal = document.getElementById('modalReadme');
        const readmeContent = document.querySelector('.readme-content');
        
        if (readmeContent) {
            document.getElementById('readmeModalBody').innerHTML = readmeContent.innerHTML;
        }
        
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeModalReadme() {
        const modal = document.getElementById('modalReadme');
        modal.classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    // Tutup modal saat klik di luar content
    window.onclick = function(event) {
        const modal = document.getElementById('modalReadme');
        if (event.target === modal) {
            closeModalReadme();
        }
    }
</script>

</body>
</html>
