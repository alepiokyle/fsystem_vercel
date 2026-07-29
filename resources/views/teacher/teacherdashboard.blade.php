<x-teacher-component>
    <style>
        /* ====== Global Page Reset ====== */
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            color: #333;
            overflow-x: hidden;
            animation: fadeIn 1s ease-in;
        }

        /* ====== Animated Background (SAME AS ADMIN) ====== */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(-45deg, #f3f7fd, #e3f2fd, #fce4ec, #f1f8e9);
            background-size: 400% 400%;
            z-index: -1;
            animation: gradientBG 10s ease infinite;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ====== Page Header ====== */
        .page-header-title h5 {
            font-weight: 700;
            font-size: 1.8rem;
            color: #1e3a8a;
        }

        .breadcrumb {
            padding: 0;
            margin-top: 5px;
            background: transparent;
            font-size: 0.9rem;
        }

        .breadcrumb-item a {
            text-decoration: none;
            color: #1976d2;
        }

        .breadcrumb-item a:hover {
            text-decoration: underline;
            color: #0d47a1;
        }

        /* ====== Cards ====== */
        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .col-md-6.col-xl-3 {
            display: flex;
            flex: 1;
        }

        .card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 20px;
            width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            animation: fadeIn 1s ease;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
        }

        .card h6 {
            font-weight: 600;
            color: #555;
            margin-bottom: 10px;
        }

        .card h4 {
            font-weight: 700;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .badge {
            font-size: 0.8rem;
            padding: 0.35em 0.6em;
            border-radius: 6px;
            display: flex;
            align-items: center;
        }

        /* Badge Colors */
        .bg-light-primary { background-color: #e1f0ff; color: #0d6efd; }
        .bg-light-success { background-color: #e6f4ea; color: #198754; }
        .bg-light-warning { background-color: #fff4e5; color: #fd7e14; }

        .card p {
            color: #777;
            font-size: 0.75rem;
            margin-top: 8px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .col-md-6.col-xl-3 {
                flex: 0 0 100%;
            }
        }
    </style>


    <!-- ====== Page Header ====== -->
    <div class="page-header">
        <div class="page-header-title"><h5>Teacher Dashboard</h5></div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item" aria-current="page">Dashboard</li>
        </ul>
    </div>

    <!-- ====== Overview Cards ====== -->
    <div class="row">
        <div class="card">
            <h6>Subjects Assigned</h6>
            <h4>{{ $subjectsCount }} <span class="badge bg-light-primary">📚</span></h4>
            <p>Total subjects assigned this semester</p>
        </div>
        <div class="card">
            <h6>Students</h6>
            <h4>{{ $studentsCount }} <span class="badge bg-light-success">👨‍🎓</span></h4>
            <p>Total students under your subjects</p>
        </div>
        <div class="card">
            <h6>Pending Attendance</h6>
            <h4>5 <span class="badge bg-light-warning">⏰</span></h4>
            <p>Classes/sessions where attendance hasn't been taken</p>
        </div>
        <div class="card">
            <h6>Pending Assessments</h6>
            <h4>8 <span class="badge bg-light-danger">📝</span></h4>
            <p>Quizzes or exams that haven’t been graded yet</p>
        </div>
    </div>

   

   
</x-teacher-component>
