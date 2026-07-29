<x-student-components>
  <!-- Page Header -->
  <div class="page-header mb-4">
    <div class="page-block">
      <div class="row align-items-center">
        <div class="col-md-12">
          <div class="page-header-title">
            <h5 class="m-b-10 fw-bold text-primary">Student Dashboard</h5>
          </div>
          <ul class="breadcrumb">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active" aria-current="page">Overview</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- [ Main Content ] start -->
  <div class="row g-4">

    <!-- Enrolled Subjects -->
    <div class="col-md-6 col-xl-3 d-flex">
      <div class="card shadow-sm border-0 rounded-3 hover-card flex-fill">
        <div class="card-body text-center">
          <h6 class="mb-2 text-muted">Enrolled Subjects</h6>
          <h4 class="mb-3 fw-bold">
            6 
            <span class="badge bg-light-primary border border-primary ms-2">
              <i class="ti ti-book"></i>
            </span>
          </h4>
          <p class="mb-0 text-muted small">Your current subjects this semester</p>
        </div>
      </div>
    </div>

    <!-- Grades -->
    <div class="col-md-6 col-xl-3 d-flex">
      <div class="card shadow-sm border-0 rounded-3 hover-card flex-fill">
        <div class="card-body text-center">
          <h6 class="mb-2 text-muted">Grades</h6>
          <h4 class="mb-3 fw-bold">
            Available 
            <span class="badge bg-light-success border border-success ms-2">
              <i class="ti ti-award"></i>
            </span>
          </h4>
          <p class="mb-0 text-muted small">View your prelim, midterm, and finals</p>
        </div>
      </div>
    </div>

    <!-- Notifications -->
    <div class="col-md-6 col-xl-3 d-flex">
      <div class="card shadow-sm border-0 rounded-3 hover-card flex-fill">
        <div class="card-body text-center">
          <h6 class="mb-2 text-muted">Notifications</h6>
          <h4 class="mb-3 fw-bold">
            3 
            <span class="badge bg-light-warning border border-warning ms-2">
              <i class="ti ti-bell"></i>
            </span>
          </h4>
          <p class="mb-0 text-muted small">Latest updates from your teachers</p>
        </div>
      </div>
    </div>


  </div>

  <!-- Extra CSS for hover effect -->
  <style>
    .hover-card {
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 6px 16px rgba(0,0,0,0.15);
    }
  </style>
</x-student-components>
