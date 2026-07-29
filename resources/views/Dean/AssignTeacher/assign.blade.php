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

        /* ====== Card Styles ====== */
        .card {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border: 1px solid #e6e6e6;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover { transform: translateY(-5px); box-shadow: 0 12px 24px rgba(0,0,0,0.12); }

        .card h2 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        /* ====== Form ====== */
        .form-group { margin-bottom: 15px; }
        label { font-weight: 500; color: #555; margin-bottom: 5px; display: block; }
        select {
            width: 100%;
            padding: 8px 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 0.95rem;
        }
        select:focus { outline: none; border-color: #0d6efd; box-shadow: 0 0 4px rgba(13,110,253,0.3); }

        .btn-assign {
            background-color: #0d6efd;
            color: #fff;
            padding: 10px 18px;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn-assign:hover { background-color: #0b5ed7; }

        /* ====== Table ====== */
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }
        thead { background-color: #f8f9fa; }
        th, td {
            padding: 12px 15px;
            text-align: left;
            font-size: 0.9rem;
            color: #333;
        }
        tbody tr { transition: background 0.2s; }
        tbody tr:hover { background-color: #f5f7fa; }
        .action-links a {
            margin: 0 5px;
            font-size: 0.85rem;
            text-decoration: none;
            font-weight: 500;
        }
        .action-links a.edit { color: #0d6efd; }
        .action-links a.remove { color: #dc3545; }
        .action-links a:hover { text-decoration: underline; }

        /* Mobile Responsiveness */
        @media (max-width: 767px) {
            x-dean-component {
                padding: 16px;
            }

            .page-header {
                margin-bottom: 20px;
            }

            .page-header-title h5 {
                font-size: 1.5rem;
            }

            .breadcrumb {
                font-size: 14px;
            }

            .card {
                padding: 16px;
                margin-bottom: 16px;
                border-radius: 8px;
            }

            .card h2 {
                font-size: 1.1rem;
                margin-bottom: 16px;
            }

            .row.mb-3 {
                margin-bottom: 16px !important;
            }

            .col-md-6 {
                margin-bottom: 16px;
            }

            .col-md-6:last-child {
                margin-bottom: 0;
            }

            label {
                font-size: 14px;
                margin-bottom: 8px;
            }

            select,
            p[style*="border"] {
                font-size: 16px; /* Prevent zoom on iOS */
                padding: 12px 10px;
            }

            .btn-assign {
                width: 100%;
                padding: 12px;
                font-size: 16px;
            }

            table {
                font-size: 14px;
            }

            th, td {
                padding: 8px 4px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            th:nth-child(4),
            td:nth-child(4) {
                width: 100px;
                min-width: 100px;
            }

            .action-links {
                display: flex;
                flex-direction: column;
                gap: 4px;
            }

            .action-links a {
                margin: 0;
                padding: 4px 8px;
                border-radius: 4px;
                background: #f8f9fa;
                display: block;
                text-align: center;
                font-size: 12px;
            }

            /* Stack table on very small screens */
            @media (max-width: 480px) {
                table {
                    display: block;
                    border: none;
                }

                thead {
                    display: none;
                }

                tbody,
                tr,
                td {
                    display: block;
                    width: 100%;
                }

                tr {
                    border: 1px solid #e9ecef;
                    border-radius: 8px;
                    margin-bottom: 12px;
                    padding: 12px;
                    background: #fff;
                }

                td {
                    border: none;
                    padding: 4px 0;
                    text-align: left;
                }

                td:before {
                    content: attr(data-label) ": ";
                    font-weight: bold;
                    display: inline-block;
                    min-width: 80px;
                    color: #666;
                }

                .action-links {
                    margin-top: 8px;
                    padding-top: 8px;
                    border-top: 1px solid #eee;
                }
            }
        }
    </style>

    <!-- ====== Page Header ====== -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title"><h5>Assign Teacher</h5></div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dean</a></li>
                        <li class="breadcrumb-item" aria-current="page">Assign Teacher</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- ====== Assign Teacher Form Card ====== -->
    <div class="card">
        <h2>New Assignment</h2>
        <form id="assignForm">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Department</label>
                    <p style="margin: 0; padding: 8px 10px; border: 1px solid #ccc; border-radius: 8px; background: #f8f9fa;">{{ $departmentName }}</p>
                </div>
                <div class="col-md-6">
                    <label for="year_level">Year Level</label>
                    <select id="year_level" name="year_level" class="form-control">
                        <option value="">-- Select Year Level --</option>
                        @foreach($yearLevels as $yl)
                            <option value="{{ $yl }}">{{ $yl }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="subject">Subject</label>
                    <select id="subject" name="subject_id" class="form-control">
                        <option value="">-- Select Subject --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" data-year="{{ $subject->year_level }}">{{ $subject->subject_code }} - {{ $subject->subject_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="teacher">Teacher</label>
                    <select id="teacher" name="teacher_id" class="form-control">
                        <option value="">-- Select Teacher --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                    <div id="teacherMessage" style="margin-top: 10px; font-weight: bold;"></div>
                    <div id="creatorMessage" style="margin-top: 5px; font-style: italic; color: #666;"></div>
                </div>
            </div>
        </form>
        <div style="margin-top:20px; text-align:right;">
            <button type="button" class="btn-assign" id="assignBtn">Assign Teacher</button>
        </div>
    </div>

    <!-- ====== Current Assignments Table Card ====== -->
    <div class="card">
        <h2>📑 Current Assignments</h2>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Department</th>
                        <th>Subject</th>
                        <th>Assign teacher</th>
                        <th style="text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjects as $subject)
                    <tr data-subject-id="{{ $subject->id }}">
                        <td data-label="Department">{{ $subject->department->name }}</td>
                        <td data-label="Subject">{{ $subject->subject_code }} - {{ $subject->subject_name }}</td>
                        <td data-label="Assign teacher">{{ $subject->teacher ? $subject->teacher->name : 'Not Assigned' }}</td>
                        <td data-label="Action" class="action-links" style="text-align:center;">
                            <a href="#" class="edit">✏ Reassign</a>
                            <a href="#" class="remove" data-id="{{ $subject->id }}">🗑 Remove</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Filter subjects based on year level
        function filterSubjects() {
            const selectedYL = document.getElementById('year_level').value;
            const subjectSelect = document.getElementById('subject');
            const options = subjectSelect.querySelectorAll('option');

            options.forEach(option => {
                if (option.value === '') return; // Skip the placeholder
                const year = option.getAttribute('data-year');
                if (selectedYL === '' || year === selectedYL) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            });

            // Reset subject selection if not matching
            const currentSubject = subjectSelect.value;
            if (currentSubject) {
                const currentOption = subjectSelect.querySelector(`option[value="${currentSubject}"]`);
                if (currentOption && currentOption.style.display === 'none') {
                    subjectSelect.value = '';
                }
            }
        }

        // Add event listeners for filtering
        document.getElementById('year_level').addEventListener('change', filterSubjects);

        // Handle teacher selection change
        document.getElementById('teacher').addEventListener('change', function() {
            const teacherId = this.value;
            const messageDiv = document.getElementById('teacherMessage');
            const creatorDiv = document.getElementById('creatorMessage');
            const btn = document.getElementById('assignBtn');

            if (!teacherId) {
                messageDiv.textContent = '';
                creatorDiv.textContent = '';
                btn.disabled = false;
                return;
            }

            // Fetch assignment count
            fetch(`{{ route('dean.AssignTeacher.check', ':teacherId') }}`.replace(':teacherId', teacherId))
                .then(response => response.json())
                .then(data => {
                    const count = data.count;
                    if (count === 0) {
                        messageDiv.innerHTML = '🟢 Available (0 subjects assigned)';
                        messageDiv.style.color = 'green';
                        btn.disabled = false;
                    } else if (count < 5) {
                        messageDiv.innerHTML = `⚠️ Already assigned to ${count} subjects`;
                        messageDiv.style.color = 'orange';
                        btn.disabled = false;
                    } else {
                        messageDiv.innerHTML = `🚫 Fully assigned (Limit reached, e.g., 5)`;
                        messageDiv.style.color = 'red';
                        btn.disabled = true;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    messageDiv.textContent = 'Error checking assignments.';
                    messageDiv.style.color = 'red';
                    btn.disabled = false;
                });

            // Fetch creator name
            fetch(`{{ route('dean.AssignTeacher.creator', ':teacherId') }}`.replace(':teacherId', teacherId))
                .then(response => response.json())
                .then(data => {
                    creatorDiv.textContent = 'Created by: ' + data.creator_name;
                })
                .catch(error => {
                    console.error('Error:', error);
                    creatorDiv.textContent = 'Error fetching creator.';
                });
        });

        // Handle assign button click
        document.querySelector('.btn-assign').addEventListener('click', function() {
            const form = document.getElementById('assignForm');
            const formData = new FormData(form);

            if (!formData.get('subject_id') || !formData.get('teacher_id')) {
                alert('Please select both subject and teacher.');
                return;
            }

            fetch('{{ route("dean.AssignTeacher.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    // Update the table dynamically
                    const subjectSelect = document.getElementById('subject');
                    const teacherSelect = document.getElementById('teacher');
                    const selectedSubjectText = subjectSelect.options[subjectSelect.selectedIndex].text;
                    const selectedTeacherText = teacherSelect.options[teacherSelect.selectedIndex].text;
                    // Find the row and update the teacher column
                    const rows = document.querySelectorAll('tbody tr');
                    for (let row of rows) {
                        if (row.cells[1].textContent === selectedSubjectText) {
                            row.cells[2].textContent = selectedTeacherText;
                            break;
                        }
                    }
                    // Clear the selects
                    document.getElementById('year_level').value = '';
                    subjectSelect.value = '';
                    teacherSelect.value = '';
                    document.getElementById('teacherMessage').textContent = '';
                    document.getElementById('assignBtn').disabled = false;
                    filterSubjects(); // Reset filter
                } else {
                    alert('Failed to assign teacher: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error assigning teacher.');
                console.error('Error:', error);
            });
        });

        // Handle remove button click
        document.querySelectorAll('.remove').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const subjectId = this.getAttribute('data-id');
                if (!subjectId) return;

                if (confirm('Are you sure you want to remove this assignment?')) {
                    fetch(`/dean/AssignTeacher/${subjectId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            // Remove the row from the table
                            const row = event.target.closest('tr');
                            if (row) row.remove();
                        } else {
                            alert('Failed to remove assignment: ' + data.message);
                        }
                    })
                    .catch(error => {
                        alert('Error removing assignment.');
                        console.error('Error:', error);
                    });
                }
            });
        });


    </script>
</x-dean-component>
