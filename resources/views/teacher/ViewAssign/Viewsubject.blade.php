<x-teacher-component>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Teacher - Assigned Subjects</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
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

  <!-- Page Wrapper -->
  <div class="min-h-screen flex flex-col">

    <!-- Main Content -->
    <main class="flex-1 p-4 sm:p-8">
      <!-- Page Title -->
      <h2 class="text-xl sm:text-2xl font-bold mb-6 text-gray-800">
        📘 View Assigned Subjects
      </h2>

      <!-- Search / Filter Section -->
      <div class="mb-4 flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4">
        <input
          type="text"
          placeholder="Search by code, name, or section..."
          class="w-full sm:w-1/3 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200 text-base"
        />
        <button
          class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 text-base">
          Export to Excel
        </button>
      </div>

      <!-- Assigned Subjects Table -->
      <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full border border-gray-200">
          <!-- Table Head -->
          <thead class="bg-gray-100 text-gray-700">
            <tr>
              <th class="px-4 py-2 border">Subject Code</th>
              <th class="px-4 py-2 border">Subject Name</th>
              <th class="px-4 py-2 border">Students</th>
              <th class="px-4 py-2 border text-center">Actions</th>
            </tr>
          </thead>

          <!-- Table Body -->
          <tbody class="text-gray-800">
            @forelse($assignedSubjects as $subject)
            <tr class="hover:bg-gray-50">
              <td class="px-4 py-2 border" data-label="Subject Code">{{ $subject->subject_code }}</td>
              <td class="px-4 py-2 border" data-label="Subject Name">{{ $subject->subject_name }}</td>
              <td class="px-4 py-2 border text-center" data-label="Students">{{ $subject->students_count }}</td>
              <td class="px-4 py-2 border" data-label="Actions">
                <div class="flex flex-col sm:flex-row flex-wrap gap-2 justify-center">
                  <button class="view-students-btn px-3 py-1 bg-green-600 text-white text-sm rounded-lg shadow hover:bg-green-700 w-full sm:w-auto" data-subject-id="{{ $subject->id }}">
                    View Students
                  </button>
                  <a href="#" class="remove-btn px-3 py-1 bg-red-600 text-white text-sm rounded-lg shadow hover:bg-red-700 w-full sm:w-auto text-center" data-id="{{ $subject->id }}">
                    Remove
                  </a>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="text-center py-4 text-gray-500">
                No subjects assigned yet.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Mobile Card Layout for Small Screens -->
      <div class="block md:hidden mt-4">
        @forelse($assignedSubjects as $subject)
        <div class="bg-white shadow rounded-lg p-4 mb-4">
          <div class="mb-2">
            <strong>Subject Code:</strong> {{ $subject->subject_code }}
          </div>
          <div class="mb-2">
            <strong>Subject Name:</strong> {{ $subject->subject_name }}
          </div>
          <div class="mb-2">
            <strong>Students:</strong> {{ $subject->students_count }}
          </div>
          <div class="flex flex-col gap-2">
            <button class="view-students-btn px-3 py-2 bg-green-600 text-white text-sm rounded-lg shadow hover:bg-green-700" data-subject-id="{{ $subject->id }}">
              View Students
            </button>
            <a href="#" class="remove-btn px-3 py-2 bg-red-600 text-white text-sm rounded-lg shadow hover:bg-red-700 text-center" data-id="{{ $subject->id }}">
              Remove
            </a>
          </div>
        </div>
        @empty
        <div class="bg-white shadow rounded-lg p-4 text-center text-gray-500">
          No subjects assigned yet.
        </div>
        @endforelse
      </div>
    </main>
  </div>

  <!-- Students Modal -->
  <div id="studentsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden flex items-center justify-center transition-opacity duration-300">
    <div class="mx-auto p-4 sm:p-6 border border-gray-300 w-full max-w-4xl shadow-2xl rounded-xl bg-white transform transition-transform duration-300 scale-95 opacity-0" id="modalContent">
      <div class="mt-3">
        <div class="flex items-center mb-6">
          <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
            </svg>
          </div>
          <h3 class="ml-3 text-lg sm:text-xl font-semibold text-gray-900">Enrolled Students</h3>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-100 text-gray-700">
              <tr>
                <th class="px-4 py-2 border">Student ID</th>
                <th class="px-4 py-2 border">Full Name</th>
                <th class="px-4 py-2 border">Department</th>
                <th class="px-4 py-2 border">Year Level</th>
              </tr>
            </thead>
            <tbody id="studentsTableBody" class="text-gray-800">
              <!-- Students will be populated here -->
            </tbody>
          </table>
        </div>
        <div class="flex justify-end mt-4">
          <button id="closeModalBtn" class="px-4 py-2 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600 text-base">Close</button>
        </div>
      </div>
    </div>
  </div>

    <script>
        // Handle remove button click
        document.querySelectorAll('.remove-btn').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const subjectId = this.getAttribute('data-id');
                if (!subjectId) return;

                if (confirm('Are you sure you want to unassign this subject?')) {
                    fetch(`/teacher/ViewAssign/${subjectId}`, {
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
                            alert('Failed to unassign subject: ' + data.message);
                        }
                    })
                    .catch(error => {
                        alert('Error unassigning subject.');
                        console.error('Error:', error);
                    });
                }
            });
        });

        // Handle view students button click
        document.querySelectorAll('.view-students-btn').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const subjectId = this.getAttribute('data-subject-id');
                if (!subjectId) return;

                // Fetch students
                fetch(`/teacher/ViewAssign/${subjectId}/students`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const tbody = document.getElementById('studentsTableBody');
                        tbody.innerHTML = '';
                        if (data.students.length > 0) {
                            data.students.forEach(student => {
                                const row = document.createElement('tr');
                                row.className = 'hover:bg-gray-50';
                                row.innerHTML = `
                                    <td class="px-4 py-2 border">${student.student_id}</td>
                                    <td class="px-4 py-2 border">${student.full_name}</td>
                                    <td class="px-4 py-2 border">${student.department}</td>
                                    <td class="px-4 py-2 border">${student.year_level}</td>
                                `;
                                tbody.appendChild(row);
                            });
                        } else {
                            tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4 text-gray-500">No students enrolled.</td></tr>';
                        }
                        // Show modal with animation
                        const modal = document.getElementById('studentsModal');
                        const modalContent = document.getElementById('modalContent');
                        modal.classList.remove('hidden');
                        setTimeout(() => {
                            modalContent.classList.remove('scale-95', 'opacity-0');
                            modalContent.classList.add('scale-100', 'opacity-100');
                        }, 10);
                    } else {
                        alert('Failed to load students: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Error loading students.');
                    console.error('Error:', error);
                });
            });
        });

        // Handle close modal
        document.getElementById('closeModalBtn').addEventListener('click', function() {
            closeModal();
        });

        // Close modal when clicking outside
        document.getElementById('studentsModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeModal();
            }
        });

        function closeModal() {
            const modal = document.getElementById('studentsModal');
            const modalContent = document.getElementById('modalContent');
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
</body>
</html>
</x-teacher-component>
