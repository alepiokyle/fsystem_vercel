<x-dean-component>
    <style>
        /* ====== Background & Page ====== */
        x-dean-component {
            background: linear-gradient(to right, #f0f4f8, #ffffff);
            min-height: 100vh;
            padding: 20px 30px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* ====== Page Header ====== */
        .page-header { margin-bottom: 30px; }
        .page-header-title h5 { font-weight: 700; font-size: 1.8rem; color: #222; }
        .breadcrumb { padding: 0; margin-top: 5px; background: transparent; }
        .breadcrumb-item a { text-decoration: none; color: #555; }
        .breadcrumb-item a:hover { text-decoration: underline; }

        /* ====== Dashboard Cards ====== */
        .row { display: flex; flex-wrap: wrap; gap: 20px; }
        .col-md-6.col-xl-3 { display: flex; flex: 1; }
        .card {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            width: 100%;
        }
        .card:hover { transform: translateY(-5px); box-shadow: 0 12px 24px rgba(0,0,0,0.12); }
        .card h6 { font-weight: 600; color: #555; margin-bottom: 10px; }
        .card h4 { font-weight: 700; color: #333; display: flex; align-items: center; justify-content: space-between; }
        .badge { font-size: 0.8rem; padding: 0.35em 0.6em; border-radius: 6px; display: flex; align-items: center; }

        /* Badge Colors */
        .bg-light-primary { background-color: #e1f0ff; color: #0d6efd; border-color: #0d6efd; }
        .bg-light-success { background-color: #e6f4ea; color: #198754; border-color: #198754; }
        .bg-light-warning { background-color: #fff4e5; color: #fd7e14; border-color: #fd7e14; }

        /* Card description - smaller text */
        .card p {
            color: #777;
            font-size: 0.75rem; /* smaller text */
            margin-top: 8px;
        }

        /* Responsive tweaks */
        @media (max-width: 768px) { .col-md-6.col-xl-3 { flex: 0 0 100%; } }
    </style>

    <!-- ====== Page Header ====== -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title"><h5>Dean Dashboard</h5></div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Dean</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- ====== Main Content: Cards ====== -->
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <h6>Subjects Uploaded by Admin</h6>
                <h4>{{ $totalSubjects }} <span class="badge bg-light-primary"><i class="ti ti-trending-up" style="margin-right:4px;"></i>5%</span></h4>
                <p>Subjects uploaded in your department</p>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <h6>Teachers Assigned</h6>
                <h4>{{ $teachersAssigned }} <span class="badge bg-light-success"><i class="ti ti-trending-up" style="margin-right:4px;"></i>10%</span></h4>
                <p>Current assignments in your department</p>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <h6>Pending Grade Approvals</h6>
                <h4>15 <span class="badge bg-light-warning"><i class="ti ti-trending-down" style="margin-right:4px;"></i>20%</span></h4>
                <p>Grades waiting for your approval</p>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <h6>Grades Posted</h6>
                <h4>30 <span class="badge bg-light-success"><i class="ti ti-trending-up" style="margin-right:4px;"></i>40%</span></h4>
                <p>Grades already posted to Students & Parents</p>
            </div>
        </div>
    </div>
</x-dean-component>
