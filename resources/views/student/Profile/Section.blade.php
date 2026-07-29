<x-student-components>
    <style>
        x-student-component {
            background: linear-gradient(to right, #f0f4f8, #ffffff);
            min-height: 100vh;
            padding: 40px 60px;
            display: block;
            font-family: 'Poppins', sans-serif;
        }
        .page-header {
            font-weight: 700;
            color: #1e3a8a;
            border-bottom: 3px solid #2563eb;
            display: inline-block;
            padding-bottom: 8px;
        }
        .card {
            border: none;
            border-radius: 16px;
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        }
        .rounded-circle {
            border: 4px solid #2563eb;
            object-fit: cover;
        }
        .btn-outline-primary, .btn-success {
            border-radius: 30px;
            font-weight: 500;
            transition: 0.3s;
        }
        .btn-outline-primary:hover {
            background-color: #2563eb;
            color: white;
        }
        .btn-success:hover {
            background-color: #16a34a;
            color: white;
        }
        #saveProfileBtn {
            margin-top: 8px;
        }
    </style>

    <div class="container mt-4">
        <h3 class="page-header mb-4">🎓 Student Profile</h3>

        <div class="row g-4">
            <!-- Profile Summary -->
            <div class="col-md-4">
                <div class="card shadow-sm text-center p-3">
                    <div class="card-body">
                        <img id="studentImage"
                             src="{{ $profile->profile_picture ? asset('storage/profile_pictures/' . $profile->profile_picture) : asset('uploads/student_profiles/student.png') }}"
                             class="rounded-circle mb-3 shadow-sm"
                             width="130" height="130" alt="Student Avatar"
                             onerror="this.src='{{ asset('uploads/student_profiles/student.png') }}'">

                        <h5 class="card-title fw-bold text-primary">{{ $profile->name }}</h5>
                        <p class="text-muted mb-1">Student ID: {{ $profile->student_id }}</p>
                        <p class="text-muted mb-3">{{ $profile->course }} – {{ $profile->year_level }}</p>

                        <!-- Upload Form -->
                        <form id="profileForm" enctype="multipart/form-data" method="POST">
                            @csrf
                            <input type="file" id="uploadProfile" name="profile_picture" accept="image/*" style="display: none;">
                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="changeProfileBtn">
                                <i class="fas fa-camera me-1"></i> Change Profile Picture
                            </button>
                            <button type="button" class="btn btn-sm btn-success mt-2" id="saveProfileBtn" style="display: none;">
                                <i class="fas fa-save me-1"></i> Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Profile Details -->
            <div class="col-md-8">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-primary text-white">Personal Information</div>
                    <div class="card-body">
                        <p><strong>Full Name:</strong> {{ $profile->first_name }} {{ $profile->middle_name }} {{ $profile->last_name }} {{ $profile->suffix }}</p>
                        {{-- <p><strong>Email:</strong> {{ $profile->user->email }}</p> --}}
                        <p><strong>Student ID:</strong> {{ $profile->student_id }}</p>
                        <p><strong>Date of Birth:</strong> {{ $profile->date_of_birth ? \Carbon\Carbon::parse($profile->date_of_birth)->format('M d, Y') : 'N/A' }}</p>
                        <p><strong>Gender:</strong> {{ $profile->gender }}</p>
                        <p><strong>Course:</strong> {{ $profile->course }}</p>
                        <p><strong>Year Level:</strong> {{ $profile->year_level }}</p>
                        <p><strong>Department:</strong> {{ $profile->department->name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <script>
        const changeBtn = document.getElementById('changeProfileBtn');
        const saveBtn = document.getElementById('saveProfileBtn');
        const fileInput = document.getElementById('uploadProfile');
        const studentImage = document.getElementById('studentImage');

        changeBtn.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    studentImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
                saveBtn.style.display = 'inline-block';
            }
        });

        saveBtn.addEventListener('click', async () => {
            const formData = new FormData();
            formData.append('profile_picture', fileInput.files[0]);
            formData.append('_token', '{{ csrf_token() }}');

            try {
                const response = await fetch('{{ route('student.updateProfile') }}', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();
                if (result.success) {
                    studentImage.src = result.image_url;
                    // Update header profile images
                    document.querySelectorAll('.user-avtar').forEach(img => img.src = result.image_url);
                    alert(result.message);
                    saveBtn.style.display = 'none';
                } else {
                    alert('Upload failed. Please try again.');
                }
            } catch (error) {
                alert('Something went wrong. Try again.');
            }
        });


    </script>
</x-student-components>
