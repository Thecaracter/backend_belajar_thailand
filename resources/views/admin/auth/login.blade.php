<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #800020;
            --secondary-color: #5C0015;
            --accent-color: #B22222;
            --background-color: #FFF5F5;
            --text-color: #2D0000;
            --card-bg: #ffffff;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--background-color) 0%, #FFE4E4 100%);
            padding: 20px;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .card {
            border: none;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            max-width: 450px;
            width: 100%;
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            font-size: 28px;
            font-weight: 700;
            text-align: center;
            padding: 30px;
            border-radius: 24px 24px 0 0 !important;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        .card-body {
            padding: 40px;
            border-radius: 0 0 24px 24px;
        }

        .form-label {
            color: var(--text-color);
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 10px;
        }

        .form-control {
            padding: 14px 18px;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            transition: all 0.3s ease;
            font-size: 1rem;
            background-color: #f8fafc;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 4px rgba(128, 0, 32, 0.1);
            background-color: white;
        }

        .password-field {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            color: var(--text-color);
            opacity: 0.6;
            cursor: pointer;
            padding: 5px;
            transition: all 0.3s ease;
        }

        .password-toggle:hover {
            opacity: 1;
            color: var(--primary-color);
        }

        .btn-primary {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 14px 30px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            border-radius: 16px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(128, 0, 32, 0.2);
        }

        .form-check-input {
            width: 1.2em;
            height: 1.2em;
            border-radius: 6px;
            border: 2px solid #cbd5e1;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            color: var(--text-color);
            font-size: 0.95rem;
            padding-left: 6px;
        }

        .invalid-feedback {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 8px;
        }

        .input-group {
            margin-bottom: 24px;
        }

        ::placeholder {
            color: #94a3b8;
            opacity: 0.8;
        }

        /* Glassmorphism effect for form controls */
        .form-control, .btn {
            backdrop-filter: blur(4px);
        }

        /* Modern focus states */
        .form-control:focus, .btn:focus, .form-check-input:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .card {
                margin: 15px;
                width: 90%;
            }
            
            .card-header {
                font-size: 22px;
                padding: 20px;
            }

            .card-body {
                padding: 25px 20px;
            }

            .btn-primary {
                padding: 12px 20px;
                font-size: 1rem;
            }

            .form-label {
                font-size: 0.9rem;
            }

            .form-control {
                padding: 12px 15px;
                font-size: 0.95rem;
            }
        }

        @media (max-width: 480px) {
            .card {
                margin: 10px;
                width: 95%;
            }

            .card-header {
                font-size: 20px;
                padding: 15px;
            }

            .card-body {
                padding: 20px 15px;
            }

            .form-control {
                padding: 10px 12px;
            }

            .btn-primary {
                padding: 10px 15px;
                font-size: 0.95rem;
            }
        }

        /* Fix for very small screens */
        @media (max-height: 600px) {
            body {
                padding: 10px 0;
            }
            
            .container-fluid {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid d-flex align-items-center justify-content-center min-vh-100">
        <div class="row justify-content-center w-100">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="card">
                    <div class="card-header">
                        Admin Login
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.login') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="email" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <input 
                                        id="email" 
                                        type="email" 
                                        class="form-control @error('email') is-invalid @enderror" 
                                        name="email" 
                                        value="{{ old('email') }}" 
                                        required 
                                        autocomplete="email" 
                                        autofocus
                                        placeholder="Enter your email address"
                                    >
                                </div>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="password-field">
                                    <input 
                                        id="password" 
                                        type="password" 
                                        class="form-control @error('password') is-invalid @enderror" 
                                        name="password" 
                                        required 
                                        autocomplete="current-password"
                                        placeholder="Enter your password"
                                    >
                                    <button type="button" class="password-toggle" onclick="togglePassword()">
                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" 
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Sign In
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>