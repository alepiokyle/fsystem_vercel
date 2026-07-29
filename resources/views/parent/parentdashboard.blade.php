<x-parent-component>
  <div class="page-header">
    <div class="page-block">
      <div class="row align-items-center">
        <div class="col-md-12 text-center">
          <div class="page-header-title">
            <h5 class="m-b-10">Parent Dashboard</h5>
          </div>
          <ul class="breadcrumb justify-content-center">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Overview</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- [ Main Content ] start -->
  <div class="d-flex justify-content-center align-items-center flex-wrap gap-4 my-5">
    <!-- Attendance -->
    <div class="card shadow-lg border-0 custom-card text-center">
      <div class="card-body">
        <h6 class="mb-2 text-muted">Child Attendance</h6>
        <h4 class="mb-3 fw-bold">95%
          <span class="badge bg-light-success border border-success">
            <i class="ti ti-check"></i>
          </span>
        </h4>
        <p class="mb-0 text-muted">Present <span class="text-success">19 days</span> / Absent <span class="text-danger">1 day</span></p>
      </div>
    </div>

    <!-- Quiz Results -->
    <div class="card shadow-lg border-0 custom-card text-center">
      <div class="card-body">
        <h6 class="mb-2 text-muted">Quiz Results</h6>
        <h4 class="mb-3 fw-bold">85%
          <span class="badge bg-light-primary border border-primary">
            <i class="ti ti-pencil"></i>
          </span>
        </h4>
        <p class="mb-0 text-muted">Latest quiz: <span class="text-primary">Passed</span></p>
      </div>
    </div>

    <!-- Exam Results -->
    <div class="card shadow-lg border-0 custom-card text-center">
      <div class="card-body">
        <h6 class="mb-2 text-muted">Exam Results</h6>
        <h4 class="mb-3 fw-bold">88%
          <span class="badge bg-light-warning border border-warning">
            <i class="ti ti-book"></i>
          </span>
        </h4>
        <p class="mb-0 text-muted">Latest exam: <span class="text-success">Good performance</span></p>
      </div>
    </div>
  </div>
  <!-- [ Main Content ] end -->

  <style>
    .custom-card {
      width: 280px;
      transition: all 0.3s ease-in-out;
      min-height: 180px;
      border-radius: 15px;
    }

    .custom-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .page-header-title h5 {
      font-weight: 700;
      color: #1e3a8a;
    }

    ul.breadcrumb {
      list-style: none;
      padding: 0;
      display: inline-flex;
      gap: 8px;
      margin-top: 10px;
    }

    ul.breadcrumb li {
      color: #6c757d;
    }

    ul.breadcrumb li.active {
      color: #000;
      font-weight: 600;
    }
  </style>
</x-parent-component>
