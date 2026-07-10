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
            min-height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px 0;
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
            margin-top: 60px;
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
            transition: 0.25s;
        }

        .toggle-password:hover {
            color: #555;
        }

        /* Password Strength Indicator */
        .password-strength {
            height: 4px;
            background: #e0e0e0;
            border-radius: 2px;
            margin-top: 8px;
            overflow: hidden;
            display: none;
        }

        .password-strength.active {
            display: block;
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
            display: none;
        }

        .strength-text.active {
            display: block;
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
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
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
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
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
            width: 18px;
            height: 18px;
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
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
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
            }

            .main-container {
                padding: 10px;
                margin-top: 50px;
            }

            .toggle-password {
                margin-top: 20px;
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

            .toast {
                min-width: 280px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

<div class="logo-section">
    <div class="logo-icon">🌾</div>
    <div class="logo-text">Kelompok Tani</div>
</div>

<div id="btnReadme">Tentang Sistem</div>

<div id="toastContainer" class="toast-container"></div>

<div class="main-container">

    <!-- Login Flip -->
    <div class="login-col">
        <div class="flip-container">
            <div class="flip-card" id="flipCard">

                <!-- LOGIN -->
                <div class="flip-side flip-front {{ $errors->any() ? 'login-error' : '' }}">
                    <h3>Login</h3>

                    <form action="{{ route('login.post') }}" method="POST" class="login-form">
                        @csrf
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email"
                                   name="email"
                                   id="loginEmail"
                                   value="{{ old('email') }}"
                                   class="form-control @error('email') input-error @enderror"
                                   placeholder="Masukkan email"
                                   required>

                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <div class="password-wrapper">
                                <input type="password"
                                       name="password"
                                       id="loginPassword"
                                       class="form-control @error('password') input-error @enderror"
                                       placeholder="Masukkan password"
                                       required>
                                <i class="fas fa-eye-slash toggle-password" id="toggleLoginPassword"></i>
                            </div>

                            @error('password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                            <label class="form-check-label" for="rememberMe">
                                Ingat saya
                            </label>
                        </div>

                        <button type="submit" class="btn-auth w-100 mt-3">
                            <span class="btn-text">Login</span>
                        </button>

                        <div class="switch-link" id="toRegister" style="margin-top: 20px;">Belum punya akun? Daftar</div>
                    </form>
                </div>

                <!-- REGISTER -->
                <div class="flip-side flip-back">
                    <h3>Daftar Akun</h3>

                    <form action="{{ route('register.post') }}" method="POST" class="register-form">
                        @csrf
                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text" name="name" id="regName" class="form-control" placeholder="Masukkan nama lengkap" required>
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" id="regEmail" class="form-control" placeholder="Masukkan email" required>
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <div class="password-wrapper">
                                <input type="password" name="password" id="regPassword" class="form-control" placeholder="Masukkan password" required>
                                <i class="fas fa-eye-slash toggle-password" id="toggleRegPassword"></i>
                            </div>
                            <div class="password-strength" id="regPasswordStrength">
                                <div class="strength-bar" id="regStrengthBar"></div>
                            </div>
                            <div class="strength-text" id="regStrengthText"></div>
                        </div>

                        <div class="mb-3">
                            <label>Konfirmasi Password</label>
                            <div class="password-wrapper">
                                <input type="password" name="password_confirmation" id="regPasswordConfirm" class="form-control" placeholder="Ulangi password" required>
                                <i class="fas fa-eye-slash toggle-password" id="toggleRegPasswordConfirm"></i>
                            </div>
                        </div>

                        <button type="submit" class="btn-auth w-100 mt-3">
                            <span class="btn-text">Daftar</span>
                        </button>

                        <div class="switch-link" id="toLogin" style="margin-top: 20px;">Sudah punya akun? Login</div>
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
    // ===== FLIP CARD FUNCTIONALITY =====
    const flipCard = document.getElementById('flipCard');
    document.getElementById('toRegister').onclick = () => flipCard.classList.add('flip');
    document.getElementById('toLogin').onclick = () => flipCard.classList.remove('flip');

    // ===== TOGGLE README DAN GESER LOGIN =====
    const btnReadme = document.getElementById('btnReadme');
    const readmeCol = document.querySelector('.readme-col');
    const loginCol = document.querySelector('.login-col');

    let readmeOpen = false;
    btnReadme.onclick = () => {
        if(!readmeOpen){
            readmeCol.style.flex = '1 1 60%';
            loginCol.style.flex = '0 0 40%';
        } else {
            readmeCol.style.flex = '0';
            loginCol.style.flex = '0 0 400px';
        }
        readmeOpen = !readmeOpen;
    };

    // ===== SHOW/HIDE PASSWORD =====
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }

    document.getElementById('toggleLoginPassword').onclick = () => togglePassword('loginPassword', 'toggleLoginPassword');
    document.getElementById('toggleRegPassword').onclick = () => togglePassword('regPassword', 'toggleRegPassword');
    document.getElementById('toggleRegPasswordConfirm').onclick = () => togglePassword('regPasswordConfirm', 'toggleRegPasswordConfirm');

    // ===== PASSWORD STRENGTH INDICATOR =====
    function checkPasswordStrength(password) {
        let strength = 0;
        if (password.length >= 8) strength++;
        if (password.match(/[a-z]/)) strength++;
        if (password.match(/[A-Z]/)) strength++;
        if (password.match(/[0-9]/)) strength++;
        if (password.match(/[!@#$%^&*]/)) strength++;
        return strength;
    }

    const regPassword = document.getElementById('regPassword');
    const regStrengthBar = document.getElementById('regStrengthBar');
    const regStrengthText = document.getElementById('regStrengthText');
    const regPasswordStrength = document.getElementById('regPasswordStrength');

    regPassword.addEventListener('input', (e) => {
        const strength = checkPasswordStrength(e.target.value);
        
        if (e.target.value.length === 0) {
            regPasswordStrength.classList.remove('active');
            regStrengthText.classList.remove('active');
            return;
        }

        regPasswordStrength.classList.add('active');
        regStrengthText.classList.add('active');
        regStrengthBar.className = 'strength-bar';

        if (strength <= 1) {
            regStrengthBar.classList.add('weak');
            regStrengthText.textContent = '❌ Password lemah';
            regStrengthText.style.color = '#ff6b6b';
        } else if (strength <= 3) {
            regStrengthBar.classList.add('medium');
            regStrengthText.textContent = '⚠️ Password sedang';
            regStrengthText.style.color = '#ffc107';
        } else {
            regStrengthBar.classList.add('strong');
            regStrengthText.textContent = '✅ Password kuat';
            regStrengthText.style.color = '#28a745';
        }
    });

    // ===== FORM SUBMISSION WITH LOADING =====
    function setupFormLoading(formClass) {
        const form = document.querySelector(formClass);
        if (!form) return;

        form.addEventListener('submit', function(e) {
            const btn = this.querySelector('.btn-auth');
            const btnText = btn.querySelector('.btn-text');
            const originalText = btnText.textContent;
            
            btn.classList.add('loading');
            btn.disabled = true;
            
            // Spinner
            const spinner = document.createElement('span');
            spinner.className = 'spinner-border';
            spinner.setAttribute('role', 'status');
            spinner.setAttribute('aria-hidden', 'true');
            btn.insertBefore(spinner, btnText);
        });
    }

    setupFormLoading('.login-form');
    setupFormLoading('.register-form');

    // ===== TOAST NOTIFICATIONS =====
    function showToast(message, type = 'info', duration = 3000) {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.textContent = message;
        
        container.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease-out forwards';
            setTimeout(() => toast.remove(), 300);
        }, duration);
    }

    // Show session timeout warning (optional - requires backend session config)
    // Uncomment if you want session timeout after 15 minutes
    /*
    let sessionTimeout = 15 * 60 * 1000; // 15 minutes
    setTimeout(() => {
        showToast('⏰ Sesi Anda akan berakhir dalam 2 menit', 'error', 5000);
    }, sessionTimeout - 2 * 60 * 1000);
    */

    // Show success message if there's a referrer
    if (document.referrer.includes('login') && window.location.hash.includes('success')) {
        showToast('✅ Login berhasil! Selamat datang.', 'success');
    }

    // Add CSS for slideOut animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideOut {
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);

</script>

</body>
</html>
