<x-student-components>
    <style>
        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }

            .table {
                font-size: 12px;
            }

            .table th, .table td {
                padding: 8px;
            }

            .btn {
                padding: 6px 12px;
                font-size: 12px;
            }

            .form-select {
                font-size: 14px;
            }

            .badge {
                font-size: 10px;
            }

            .alert {
                font-size: 14px;
            }
        }
    </style>

    <div class="container mt-4">
        <h3 class="page-header mb-4">📊 View Grades</h3>

        <!-- Filters -->
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">School Year</label>
                            <select id="schoolYearFilter" class="form-select">
                                <option value="">Select School Year</option>
                                @foreach($schoolYears as $year)
                                    <option value="{{ $year->schoolyear }}">{{ $year->schoolyear }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Enrolled Subject</label>
                            <select id="subjectFilter" class="form-select">
                                <option value="">Select Subject</option>
                                @foreach($enrolledSubjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->subject_name }} ({{ $subject->subject_code }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Semester</label>
                            <select id="semesterFilter" class="form-select">
                                <option value="">Select Semester</option>
                                <option value="1st Semester">1st Semester</option>
                                <option value="2nd Semester">2nd Semester</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Select Term</label>
                            <select id="termFilter" class="form-select">
                                <option value="">Select Term</option>
                                <option value="prelim">Prelim</option>
                                <option value="midterm">Midterm</option>
                                <option value="semi_final">Semi-Final</option>
                                <option value="final">Final</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary" onclick="loadGrades()">Filter Grades</button>
                    <button class="btn btn-secondary">Attendance record</button>
                </div>
            </div>
        </div>

        <!-- Grades Table -->
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Subject Code</th>
                                <th>Subject Name</th>
                                <th>Units</th>
                                <th>Teacher</th>
                                <th>Prelim</th>
                                <th>Midterm</th>
                                <th>Semi-Final</th>
                                <th>Final</th>
                                <th>Grade</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody id="gradesTableBody">
                            <!-- Grades will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- GPA / GWA Summary -->
        <div class="alert alert-info mt-3" id="gwaSummary" style="display: none;">
            <strong>General Weighted Average (GWA):</strong> <span id="gwaValue"></span>
        </div>
    </div>

    <script>
        function loadGrades() {
            const schoolYear = document.getElementById('schoolYearFilter').value;
            const semester = document.getElementById('semesterFilter').value;
            const subjectId = document.getElementById('subjectFilter').value;

            fetch(`/student/grades/fetch?school_year=${schoolYear}&semester=${semester}&subject_id=${subjectId}`)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('gradesTableBody');
                    tbody.innerHTML = '';

                    if (data.grades.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="10" class="text-center">No grades available</td></tr>';
                        document.getElementById('gwaSummary').style.display = 'none';
                        return;
                    }

                    data.grades.forEach(grade => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${grade.subject_code}</td>
                            <td>${grade.subject_name}</td>
                            <td>${grade.units}</td>
                            <td>${grade.teacher_name}</td>
                            <td>${grade.prelim}</td>
                            <td>${grade.midterm}</td>
                            <td>${grade.semi_final}</td>
                            <td>${grade.final}</td>
                            <td>${grade.term_grade}</td>
                            <td><span class="badge ${grade.remarks === 'Passed' ? 'bg-success' : 'bg-danger'}">${grade.remarks}</span></td>
                        `;
                        tbody.appendChild(row);
                    });

                    document.getElementById('gwaValue').textContent = data.gwa;
                    document.getElementById('gwaSummary').style.display = 'block';
                })
                .catch(error => {
                    console.error('Error loading grades:', error);
                    alert('Error loading grades');
                });
        }

        // Load grades on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadGrades();
        });
    </script>
</x-student-components>
