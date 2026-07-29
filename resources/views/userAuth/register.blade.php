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

        /* Animated title styling */
        .system-title {
            font-size: 24px;
            font-weight: 800;
            margin-top: 10px;
            letter-spacing: 1px;

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

        {{-- Registration Card --}}
        <div class="card shadow-lg border-0"
             style="width: 100%; max-width: 600px; border-radius: 15px;
                    z-index: 2; background-color: rgba(255,255,255,0.95);
                    animation: fadeSlide 1.5s ease-out;">
            <div class="card-body p-4">

                {{-- Logo + Animated Title --}}
                <div class="text-center mb-4">
                    <a href="#">
                        <img src="{{ asset('all/assets/images/logo1.png') }}"
                             alt="Logo" style="width: 60px; margin: 0 auto;">
                    </a>

                    <h2 class="system-title">Student & Parent Registration</h2>

                    <small class="text-muted">
                        Fill out the form to register a new student and parent account.
                    </small>
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

                <form action="{{ route('register.store') }}" method="POST">
                    @csrf

                    {{-- Student Information --}}
                    <h5 class="fw-bold text-info mb-3">Student Information</h5>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Student ID</label>
                            <input type="text" name="student_id" class="form-control"
                                   value="{{ old('student_id') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control"
                                   value="{{ old('date_of_birth') }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control"
                                   value="{{ old('first_name') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Middle Name</label>
                            <input type="text" name="middle_name" class="form-control"
                                   value="{{ old('middle_name') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control"
                                   value="{{ old('last_name') }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Suffix</label>
                            <input type="text" name="suffix" class="form-control"
                                   value="{{ old('suffix') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-control" required>
                                <option value="">Select Gender</option>
                                <option value="Male" {{ old('gender')=='Male'?'selected':'' }}>Male</option>
                                <option value="Female" {{ old('gender')=='Female'?'selected':'' }}>Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Course</label>
                            <input type="text" name="course" class="form-control"
                                   value="{{ old('course') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Year Level</label>
                            <input type="text" name="year_level" class="form-control"
                                   value="{{ old('year_level') }}">
                        </div>
                    </div>

                    <hr>

                    {{-- Parent / Guardian Information --}}
                    <h5 class="fw-bold text-info mb-3">Parent / Guardian Information</h5>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">First Name</label>
                            <input type="text" name="parent_first_name" class="form-control"
                                   value="{{ old('parent_first_name') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Middle Name</label>
                            <input type="text" name="parent_middle_name" class="form-control"
                                   value="{{ old('parent_middle_name') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="parent_last_name" class="form-control"
                                   value="{{ old('parent_last_name') }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="parent_gender" class="form-control">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ old('parent_gender')=='Male'?'selected':'' }}>Male</option>
                                <option value="Female" {{ old('parent_gender')=='Female'?'selected':'' }}>Female</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Relationship</label>
                            <input type="text" name="relationship" class="form-control"
                                   value="{{ old('relationship') }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="parent_contact" class="form-control"
                                   value="{{ old('parent_contact') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="2" required>{{ old('address') }}</textarea>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success btn-lg me-2">
                            <i class="fas fa-user-plus me-1"></i> Register
                        </button>

                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2">
                            <i class="fas fa-sign-in-alt me-1"></i> Login Portal
                        </a>

                        <a href="{{ route('review') }}" class="btn btn-info btn-lg text-white">
                            <i class="fas fa-eye me-1"></i> Review Registration
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- Font Awesome --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</x-auth-component>
