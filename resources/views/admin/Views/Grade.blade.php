<x-admin-component>
<style>
    /* Custom styles for the Grade page */
    .glass-card {
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 20px;
        border: 1px solid rgba(255,255,255,0.3);
        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    }

    .glass-table {
        width: 100%;
        border-collapse: collapse;
        background: rgba(255,255,255,0.8);
        border-radius: 10px;
        overflow: hidden;
    }

    .glass-table thead {
        background: rgba(0,123,255,0.1);
    }

    .glass-table th, .glass-table td {
        padding: 12px;
        border-bottom: 1px solid rgba(0,0,0,0.1);
        text-align: left;
    }

    .glass-table tbody tr:hover {
        background: rgba(0,123,255,0.05);
    }

    .status-approved { color: #28a745; font-weight: bold; }
    .status-pending { color: #ffc107; font-weight: bold; }
</style>

<x-slot:page_title>
    Admin - View Grades
</x-slot>

<!-- Page Header -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">📖 Student Grades</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View Grades</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Content -->
<div class="row">
    <div class="col-md-12">
        <div class="glass-card">
            <h6>Approved Grades by Dean</h6>
            <p class="text-muted">Below are the student grades that have been approved.</p>

            <div class="table-responsive">
                <table class="glass-table">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Subject</th>
                            <th>Prelim</th>
                            <th>Midterm</th>
                            <th>Semi-Final</th>
                            <th>Final</th>
                            <th>Final Grade</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($grades as $grade)
                        <tr>
                            <td>{{ $grade->student->name }}</td>
                            <td>{{ $grade->subject->subject_name }}</td>
                            <td>{{ $grade->prelim }}</td>
                            <td>{{ $grade->midterm }}</td>
                            <td>{{ $grade->semi_final }}</td>
                            <td>{{ $grade->final }}</td>
                            <td><strong>{{ $grade->term_grade }}</strong></td>
                            <td><span class="status-approved">Approved</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No approved grades available yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</x-admin-component>
