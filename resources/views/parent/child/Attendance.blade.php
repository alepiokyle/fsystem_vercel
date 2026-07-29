<x-parent-component>
    <div class="container mt-4">

        <!-- Page Header -->
        <h3 class="page-header">📅 Child's Attendance</h3>
        <p class="text-muted">Track your child's daily and monthly attendance records.</p>

        <!-- Filters -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Linked Student</label>
                        <select class="form-select" id="studentSelect">
                            @if($students->isNotEmpty())
                                @foreach($students as $student)
                                    <option value="{{ $student->users_id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                                @endforeach
                            @else
                                <option disabled>No linked students found</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Month</label>
                        <select class="form-select" id="monthSelect">
                            <option value="2025-08">August 2025</option>
                            <option value="2025-09">September 2025</option>
                            <option value="2025-10">October 2025</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="button" class="btn btn-primary w-100" id="downloadBtn">
                            <i class="ti ti-download"></i> Download Report
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Attendance Summary -->
        <div class="row text-center mb-4" id="attendanceSummary">
            <div class="col-md-3">
                <div class="card shadow-sm p-3">
                    <h5 class="text-success">✅ Present</h5>
                    <p class="fs-4 fw-bold" id="presentCount">0</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm p-3">
                    <h5 class="text-danger">❌ Absent</h5>
                    <p class="fs-4 fw-bold" id="absentCount">0</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm p-3">
                    <h5 class="text-warning">🕒 Late</h5>
                    <p class="fs-4 fw-bold" id="lateCount">0</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm p-3">
                    <h5 class="text-primary">📊 Attendance Rate</h5>
                    <p class="fs-4 fw-bold" id="attendanceRate">0%</p>
                </div>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">📖 Detailed Attendance</h5>
                <table class="table table-bordered table-striped" id="attendanceTable">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody id="attendanceTableBody">
                        <!-- Data will be loaded via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Note Section -->
        <div class="alert alert-info mt-4">
            <i class="ti ti-info-circle"></i> Attendance records are updated daily by the teacher.
            Please contact the class adviser for clarifications.
        </div>

    </div>

    <script>
        $(document).ready(function() {
            loadAttendance();

            $('#studentSelect, #monthSelect').change(function() {
                loadAttendance();
            });

            function loadAttendance() {
                const studentId = $('#studentSelect').val();
                const month = $('#monthSelect').val();

                if (!studentId) return;

                $.ajax({
                    url: '/parent/attendance/fetch',
                    method: 'GET',
                    data: { student_id: studentId, month: month },
                    success: function(data) {
                        updateAttendanceSummary(data.summary);
                        updateAttendanceTable(data.attendances);
                    },
                    error: function() {
                        alert('Error loading attendance data.');
                    }
                });
            }

            function updateAttendanceSummary(summary) {
                $('#presentCount').text(summary.present);
                $('#absentCount').text(summary.absent);
                $('#lateCount').text(summary.late);
                $('#attendanceRate').text(summary.rate + '%');
            }

            function updateAttendanceTable(attendances) {
                const tbody = $('#attendanceTableBody');
                tbody.empty();
                if (attendances.length === 0) {
                    tbody.append('<tr><td colspan="3" class="text-center">No attendance records found for this month.</td></tr>');
                } else {
                    attendances.forEach(attendance => {
                        const row = `
                            <tr>
                                <td>${attendance.date}</td>
                                <td><span class="badge bg-${attendance.status_color}">${attendance.status}</span></td>
                                <td>${attendance.remarks}</td>
                            </tr>
                        `;
                        tbody.append(row);
                    });
                }
            }
        });
    </script>
</x-parent-component>
