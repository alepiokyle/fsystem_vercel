<x-auth-component>
    <div class="auth-form d-flex flex-column align-items-center justify-content-center min-vh-100"
         style="background: url('{{ asset('all/assets/images/school.png') }}') no-repeat center center;
                background-size: cover;
                font-family: 'Poppins', sans-serif;
                position: relative;">

        {{-- Review Card --}}
        <div class="card shadow-lg border-0" style="width: 100%; max-width: 600px; border-radius: 15px; z-index: 2; background-color: rgba(255,255,255,0.95);">
            <div class="card-body p-4">

                {{-- Logo & Heading --}}
                <div class="text-center mb-4">
                    <a href="#"><img src="{{ asset('all/assets/images/logo1.png') }}" alt="Logo" style="width: 60px;"></a>
                    <h3 class="mt-3 fw-bold">Registration Review</h3>
                    <small class="text-muted">Here are the auto-generated credentials for the student and parent accounts.</small>
                </div>

       {{-- Student Credentials --}}
<div class="d-flex justify-content-center mb-4">
    <div class="card shadow-sm" style="width: 80%; max-width: 450px;">
        <div class="card-body">
            <h5 class="fw-bold text-info mb-3 text-center">Student Credentials</h5>
            <div class="row mb-2">
                <div class="col-5 fw-bold">Username:</div>
                <div class="col-7">{{ session('student_username') }}</div>
            </div>
            <div class="row">
                <div class="col-5 fw-bold">Password:</div>
                <div class="col-7">{{ session('student_password') }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Parent Credentials --}}
<div class="d-flex justify-content-center mb-4">
    <div class="card shadow-sm" style="width: 80%; max-width: 450px;">
        <div class="card-body">
            <h5 class="fw-bold text-info mb-3 text-center">Parent Credentials</h5>
            <div class="row mb-2">
                <div class="col-5 fw-bold">Username:</div>
                <div class="col-7">{{ session('parent_username') }}</div>
            </div>
            <div class="row">
                <div class="col-5 fw-bold">Password:</div>
                <div class="col-7">{{ session('parent_password') }}</div>
            </div>
        </div>
    </div>
</div>


                {{-- Action Buttons --}}
                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2">
                        <i class="fas fa-sign-in-alt me-1"></i> Login Portal
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-success btn-lg me-2">
                        <i class="fas fa-user-plus me-1"></i> Register Another Student
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</x-auth-component>
