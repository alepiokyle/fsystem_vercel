<x-auth-component>
    <style>
        /* Fade + Slide animation */
        @keyframes fadeSlide {
            0% {
                opacity: 0;
                transform: translateY(-15px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Running gradient animation */
        @keyframes shine {
            0% {
                background-position: 0% 50%;
            }
            100% {
                background-position: 200% 50%;
            }
        }

        /* eGrade Connect title styling */
        .system-title {
            font-size: 20px;               /* Smaller but bold */
            font-weight: 800;
            margin-top: 8px;
            letter-spacing: 1px;

            /* Running sky-blue gradient */
            background: linear-gradient(
                90deg,
                #2c3e50,
                #4da9ff,
                #7bd3ff,
                #2c3e50
            );
            background-size: 200% auto;
            color: transparent;
            -webkit-background-clip: text;
            background-clip: text;

            animation: shine 3s linear infinite, fadeSlide 1.2s ease-out forwards;
        }
    </style>

    <div class="auth-form d-flex flex-column align-items-center justify-content-center min-vh-100"
         style="background: url('{{ asset('all/assets/images/school.png') }}') no-repeat center center;
                background-size: cover;
                font-family: 'Poppins', sans-serif;
                position: relative;">

        {{-- Login Card --}}
        <div class="card shadow-lg border-0"
             style="width: 100%; max-width: 400px; border-radius: 15px; z-index: 2; background-color: rgba(255,255,255,0.95); animation: fadeSlide 1.5s ease-out;">
            <div class="card-body p-4">

                {{-- Logo + System Title --}}
                <div class="text-center mb-3">
                    <a href="#">
                        <img src="{{ asset('all/assets/images/logo1.png') }}" alt="Logo"
                             class="d-block mx-auto" style="width: 60px;">
                    </a>

                    <h2 class="system-title">eGrade Connect</h2>

                    <small class="text-muted">Welcome back! Please login to your account.</small>
                </div>

                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="alert alert-danger py-2">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="alert alert-success py-2">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('signin') }}">
                    @csrf

                    {{-- Username --}}
                    <div class="form-group mb-3 position-relative">
                        <label class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fas fa-user text-muted"></i></span>
                            <input type="text" name="username"
                                   class="form-control @error('username') is-invalid @enderror"
                                   placeholder="Enter your username" value="{{ old('username') }}" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="form-group mb-3 position-relative">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fas fa-lock text-muted"></i></span>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Enter your password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Remember Me + Register Link --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Keep me signed in</label>
                        </div>
                        <a href="{{ route('register') }}" class="text-primary small">Don't have an account?</a>
                    </div>

                    {{-- Submit --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg" style="border-radius: 10px;">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</x-auth-component>
