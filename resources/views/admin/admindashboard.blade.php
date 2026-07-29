<x-admin-component>
    <style>
        /* ====== Global Styles ====== */
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            color: #333;
            overflow-x: hidden;
            animation: fadeIn 1s ease-in;
        }

        /* ====== Animated Background ====== */
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
            color: #1e3a8a;
            font-weight: 700;
        }

        .breadcrumb {
            background: none;
            font-size: 0.9rem;
        }

        .breadcrumb a {
            color: #1976d2;
            text-decoration: none;
            transition: color 0.3s;
        }

        .breadcrumb a:hover {
            color: #0d47a1;
        }

        /* ====== Cards ====== */
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            text-align: center;
            animation: fadeIn 1s ease;
        }

        .glass-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
        }

        .card-icon {
            font-size: 2.5rem;
            margin-bottom: 12px;
        }

        .icon-students { color: #1976d2; }
        .icon-teachers { color: #388e3c; }
        .icon-subjects { color: #f57c00; }
        .icon-users { color: #0288d1; }

        h6 {
            font-weight: 600;
        }

        /* ====== Chart ====== */
        #activitiesChart {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            animation: fadeIn 1.2s ease;
        }

        /* ====== Responsive ====== */
        @media (max-width: 768px) {
            .glass-card {
                margin-bottom: 15px;
            }
        }
    </style>

    <x-slot:page_title>
        Admin Dashboard
    </x-slot>

    <!-- Header -->
    <div class="page-header mb-4">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12 text-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10"> Dashboard Overview </h5>
                    </div>
                    <ul class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards Row -->
    <div class="row g-4 mb-5 justify-content-center">
        <div class="col-md-6 col-xl-3">
            <div class="glass-card">
                <i class="fas fa-user-graduate card-icon icon-students"></i>
                <h6>Total Students</h6>
                <h4>{{ $totalStudents }}</h4>
                <p class="text-muted">Active students in the system</p>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="glass-card">
                <i class="fas fa-chalkboard-teacher card-icon icon-teachers"></i>
                <h6>Active Teachers</h6>
                <h4>{{ $activeTeachers }}</h4>
                <p class="text-muted">Logged in last 30 days</p>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="glass-card">
                <i class="fas fa-book card-icon icon-subjects"></i>
                <h6>Total Subjects</h6>
                <h4>{{ $totalSubjects }}</h4>
                <p class="text-muted">Subjects offered this semester</p>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="glass-card">
                <i class="fas fa-users card-icon icon-users"></i>
                <h6>System Users</h6>
                <h4>{{ $totalUsers }}</h4>
                <p class="text-muted">Total system users</p>
            </div>
        </div>
    </div>

    <canvas id="activitiesChart" height="100"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('activitiesChart').getContext('2d');
        const totalStudents = {{ $totalStudents }};
        const activeTeachers = {{ $activeTeachers }};
        const totalSubjects = {{ $totalSubjects }};
        const totalUsers = {{ $totalUsers }};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Students', 'Teachers', 'Subjects', 'Users'],
                datasets: [{
                    label: 'System Overview',
                    data: [totalStudents, activeTeachers, totalSubjects, totalUsers],
                    borderColor: '#4cafef',
                    backgroundColor: 'rgba(76, 175, 239, 0.15)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#4cafef',
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: '📊 Dashboard Data Overview',
                        font: { size: 16 }
                    }
                },
                scales: {
                    y: { beginAtZero: true },
                    x: { ticks: { color: '#333' } }
                }
            }
        });
    </script>
</x-admin-component>
