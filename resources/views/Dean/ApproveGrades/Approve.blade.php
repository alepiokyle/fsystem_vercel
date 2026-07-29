<x-dean-component>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Mobile responsiveness */
        @media (max-width: 768px) {
            x-dean-component {
                padding: 10px 15px;
            }

            .page-header-title h5 {
                font-size: 1.5rem;
            }

            .card {
                padding: 15px;
                margin-bottom: 20px;
            }

            .table {
                font-size: 12px;
            }

            .table th, .table td {
                padding: 8px;
            }

            .btn-action {
                padding: 4px 8px;
                font-size: 11px;
                margin: 0 2px;
            }

            .btn-filter {
                font-size: 12px;
            }

            .form-select {
                font-size: 14px;
            }

            .badge {
                font-size: 10px;
            }
        }

        /* ====== Background & Page ====== */
        x-dean-component {
            background: linear-gradient(to right, #f0f4f8, #ffffff);
            min-height: 100vh;
            padding: 20px 30px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: block;
        }

        /* ====== Page Header ====== */
        .page-header { margin-bottom: 30px; }
        .page-header-title h5 { font-weight: 700; font-size: 1.8rem; color: #222; }
        .breadcrumb { padding: 0; margin-top: 5px; background: transparent; }
        .breadcrumb-item a { text-decoration: none; color: #555; }
        .breadcrumb-item a:hover { text-decoration: underline; }

        /* ====== Cards ====== */
        .card {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 25px;
        }
        .card:hover { transform: translateY(-5px); box-shadow: 0 12px 24px rgba(0,0,0,0.12); }
        .card h4, .card h6 { font-weight: 600; margin-bottom: 15px; }

        /* Table */
        .table th {
            background: #f8f9fa;
        }

        /* Badge styles */
        .badge {
            font-size: 0.75em;
            padding: 0.35em 0.65em;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .py-4 {
            padding-top: 1.5rem !important;
            padding-bottom: 1.5rem !important;
        }

        /* Action buttons */
        .btn-action {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.375rem;
            margin: 0 0.125rem;
        }

        .btn-approve {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }

        .btn-approve:hover {
            background-color: #218838;
            border-color: #1e7e34;
            color: white;
        }

        .btn-reject {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        .btn-reject:hover {
            background-color: #c82333;
            border-color: #bd2130;
            color: white;
        }

        .btn-filter {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        .btn-filter:hover {
            background-color: #0056b3;
            border-color: #004085;
            color: white;
        }
    </style>

    <!-- ====== Page Header ====== -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title"><h5>Approve Submitted Grades</h5></div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Approve Grades</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

  <!-- ====== Filters ====== -->
<div class="card">
    <h4>🔍 Filter Grades</h4>
    <div class="row">
        <!-- Teacher -->
        <div class="col-md-4 mb-3">
            <label for="teacherFilter" class="form-label">Teacher Name</label>
            <select id="teacherFilter" class="form-select" onchange="loadSubjectsByTeacher(this.value)">
                <option value="">Select Teacher</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Subject -->
        <div class="col-md-4 mb-3">
            <label for="subjectFilter" class="form-label">Subject Code</label>
            <select id="subjectFilter" class="form-select">
                <option value="">Select Subject</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->subject_code }} - {{ $subject->subject_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Term -->
        <div class="col-md-4 mb-3">
            <label for="termFilter" class="form-label">Term</label>
            <select id="termFilter" class="form-select">
                <option value="">Select Term</option>
                <option value="prelim">Prelim</option>
                <option value="midterm">Midterm</option>
                <option value="semi_final">Semi-Final</option>
                <option value="final">Final</option>
            </select>
        </div>
    </div>

    <div class="row">
        <!-- School Year -->
        <div class="col-md-3 mb-3">
            <label for="schoolYearFilter" class="form-label">School Year</label>
            <select id="schoolYearFilter" class="form-select">
                <option value="">Select School Year</option>
                @foreach($schoolYears as $schoolYear)
                    <option value="{{ $schoolYear->schoolyear }}">{{ $schoolYear->schoolyear }}</option>
                @endforeach
            </select>
        </div>

        <!-- Semester -->
        <div class="col-md-3 mb-3">
            <label for="semesterFilter" class="form-label">Semester</label>
            <select id="semesterFilter" class="form-select">
                <option value="">Select Semester</option>
                <option value="1st Semester">1st Semester</option>
                <option value="2nd Semester">2nd Semester</option>
            </select>
        </div>

        <!-- Status -->
        <div class="col-md-3 mb-3">
            <label for="statusFilter" class="form-label">Status</label>
            <select id="statusFilter" class="form-select">
                <option value="">All</option>
                <option value="Pending">Pending</option>
                <option value="Approved">Approved</option>
                <option value="Rejected">Rejected</option>
            </select>
        </div>

        <!-- Filter Button -->
        <div class="col-md-3 mb-3 d-flex align-items-end">
            <button class="btn btn-filter w-100">Filter</button>
        </div>
    </div>
</div>

    <form>
        <button type="button" class="btn btn-primary" id="pendingBtn">Pending Grades</button>
        <button type="button" class="btn btn-danger" id="rejectedBtn">Rejected Grades</button>
        <button type="button" class="btn btn-success" id="approvedBtn">Approved Grades</button>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="gradesModal" tabindex="-1" aria-labelledby="gradesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gradesModalLabel">Grades</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped" id="gradesTable">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Prelim</th>
                                <th>Midterm</th>
                                <th>Semi-Final</th>
                                <th>Final</th>
                                <th>Term Grade</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="gradesTableBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentStatus = '';

        // Load subjects by teacher
        function loadSubjectsByTeacher(teacherId) {
            const subjectSelect = document.getElementById('subjectFilter');
            subjectSelect.innerHTML = '<option value="">Select Subject</option>';

            if (!teacherId) {
                return;
                return;
            }

            fetch(`/dean/ApproveGrades/subjects-by-teacher/${teacherId}`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(subject => {
                        subjectSelect.innerHTML += `<option value="${subject.id}">${subject.subject_code} - ${subject.subject_name}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error loading subjects:', error);
                });
        }

        // Event listeners for buttons
        document.getElementById('pendingBtn').addEventListener('click', function() {
            fetchGrades('Pending');
        });

        document.getElementById('rejectedBtn').addEventListener('click', function() {
            fetchGrades('Rejected');
        });

        document.getElementById('approvedBtn').addEventListener('click', function() {
            fetchGrades('Approved');
        });

        function fetchGrades(status) {
            currentStatus = status;
            const schoolYear = document.getElementById('schoolYearFilter').value;
            const semester = document.getElementById('semesterFilter').value;
            const subjectId = document.getElementById('subjectFilter').value;
            const teacherId = document.getElementById('teacherFilter').value;
            const term = document.getElementById('termFilter').value;

            fetch(`/dean/ApproveGrades/fetch-grades?school_year=${schoolYear}&semester=${semester}&subject_id=${subjectId}&teacher_id=${teacherId}&term=${term}&status=${status}`)
                .then(response => response.json())
                .then(data => {
                    displayGrades(data, status);
                    document.getElementById('gradesModalLabel').textContent = `${status} Grades`;
                    $('#gradesModal').modal('show');
                })
                .catch(error => {
                    console.error('Error fetching grades:', error);
                });
        }

        function displayGrades(data, status) {
            const tbody = document.getElementById('gradesTableBody');
            tbody.innerHTML = '';

            let grades = [];
            if (status === 'Pending') {
                grades = data.pending;
            } else if (status === 'Approved') {
                grades = data.approved;
            } else if (status === 'Rejected') {
                grades = data.rejected;
            }

            grades.forEach(grade => {
                let actionHtml = '';
                if (status === 'Pending') {
                    actionHtml = `
                        <button class="btn btn-approve btn-action" onclick="approveGrade(${grade.id})">Approve</button>
                        <button class="btn btn-reject btn-action" onclick="rejectGrade(${grade.id})">Reject</button>
                    `;
                } else {
                    actionHtml = grade.status;
                }

                const row = `
                    <tr>
                        <td>${grade.student_id}</td>
                        <td>${grade.student_name}</td>
                        <td>${grade.prelim}</td>
                        <td>${grade.midterm}</td>
                        <td>${grade.semi_final}</td>
                        <td>${grade.final}</td>
                        <td>${grade.term_grade}</td>
                        <td>${grade.remarks}</td>
                        <td>${actionHtml}</td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }

        function approveGrade(gradeId) {
            fetch('/dean/ApproveGrades/approve', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ grade_id: gradeId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Grade approved successfully');
                    fetchGrades(currentStatus); // Refresh the table
                } else {
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error approving grade:', error);
            });
        }

        function rejectGrade(gradeId) {
            fetch('/dean/ApproveGrades/reject', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ grade_id: gradeId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Grade rejected successfully');
                    fetchGrades(currentStatus); // Refresh the table
                } else {
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error rejecting grade:', error);
            });
        }
    </script>
</x-dean-component>
