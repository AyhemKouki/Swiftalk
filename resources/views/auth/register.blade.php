<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="icon" href="{{ asset('images/Web_Logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .social-login {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: transform 0.3s ease;
        }

        .social-btn:hover {
            transform: translateY(-3px);
        }

        .google {
            background-color: #db4437;
        }

        .facebook {
            background-color: #4267b2;
        }

        .apple {
            background-color: #000000;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #f6f7fb;
            color: #2b2d42;
            display: flex;
            min-height: 100vh;
            align-items: center;
        }

        .register-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .register-card:hover {
            transform: translateY(-5px);
        }

        .card-body {
            padding: 2.5rem;
        }

        .app-logo {
            height: 60px;
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease;
        }

        .app-logo:hover {
            transform: scale(1.05);
        }

        .form-control {
            height: 48px;
            border-radius: 12px;
            border: 1px solid #e0e0e0;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #4361ee;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        .btn-primary {
            background-color: #4361ee;
            border: none;
            border-radius: 12px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #3a56d4;
            transform: translateY(-2px);
        }

        .form-check-input:checked {
            background-color: #4361ee;
            border-color: #4361ee;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: #adb5bd;
        }

        .divider::before, .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #e0e0e0;
        }

        .divider::before {
            margin-right: 1rem;
        }

        .divider::after {
            margin-left: 1rem;
        }

        .input-group-text {
            background-color: transparent;
            border-right: none;
        }

        .input-with-icon {
            border-left: none;
        }

        .password-strength {
            height: 4px;
            background-color: #e9ecef;
            margin-top: 8px;
            border-radius: 2px;
            overflow: hidden;
        }

        .strength-meter {
            height: 100%;
            width: 0;
            transition: width 0.3s ease, background-color 0.3s ease;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }

        .footer-links a {
            color: var(--text-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #4361ee;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #adb5bd;
            z-index: 10;
        }

        .toggle-password:hover {
            color: #4361ee;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="register-card card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('images/Web_Logo.png') }}" alt="App Logo" class="app-logo">
                            </a>
                        </div>
                        <h2 class="h4">Create your account</h2>
                        <p class="text-muted">Join us to get started</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input id="name" type="text" class="form-control input-with-icon @error('name') is-invalid @enderror"
                                       name="name" value="{{ old('name') }}" placeholder="Enter your full name" required autofocus>
                            </div>
                            @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input id="email" type="email" class="form-control input-with-icon @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                            </div>
                            @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group position-relative">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input id="password" type="password" class="form-control input-with-icon @error('password') is-invalid @enderror"
                                       name="password" placeholder="Create a password" required>
                                <i class="fas fa-eye toggle-password" onclick="togglePassword('password')"></i>
                            </div>
                            <div class="password-strength">
                                <div class="strength-meter" id="password-strength-meter"></div>
                            </div>
                            @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <div class="input-group position-relative">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input id="password_confirmation" type="password" class="form-control input-with-icon"
                                       name="password_confirmation" placeholder="Confirm your password" required>
                                <i class="fas fa-eye toggle-password" onclick="togglePassword('password_confirmation')"></i>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                            Create Account <i class="fas fa-user-plus ms-2"></i>
                        </button>

                        <div class="divider">or sign up with</div>

                        <div class="social-login">
                            <a href="#" class="social-btn google"><i class="fab fa-google"></i></a>
                            <a href="#" class="social-btn facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-btn apple"><i class="fab fa-apple"></i></a>
                        </div>

                        <div class="text-center">
                            Already have an account? <a href="{{ route('login') }}" class="text-primary text-decoration-none">Sign in</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="footer-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Help Center</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
<script>
    // Toggle password visibility
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = field.nextElementSibling;

        if (field.type === "password") {
            field.type = "text";
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            field.type = "password";
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    // Password strength meter
    document.getElementById('password').addEventListener('input', function(e) {
        const password = e.target.value;
        const strengthMeter = document.getElementById('password-strength-meter');
        let strength = 0;

        // Check for length
        if (password.length > 7) strength += 1;

        // Check for uppercase letters
        if (password.match(/[A-Z]/)) strength += 1;

        // Check for numbers
        if (password.match(/[0-9]/)) strength += 1;

        // Check for special characters
        if (password.match(/[^A-Za-z0-9]/)) strength += 1;

        // Update the strength meter
        const width = strength * 25;
        let color = '#dc3545'; // red

        if (strength > 2) color = '#ffc107'; // yellow
        if (strength > 3) color = '#28a745'; // green

        strengthMeter.style.width = width + '%';
        strengthMeter.style.backgroundColor = color;
    });
</script>
</body>
</html>
