<x-teacher-component>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Manage Assessments - Teacher Dashboard</title>


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

    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f8f9fa;
      margin: 0;
      padding: 0;
    }

    header {
      background: #ffffff;
      padding: 15px 20px;
      border-bottom: 1px solid #ddd;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    header h1 {
      margin: 0;
      font-size: 22px;
      color: #333;
    }

    .content {
      padding: 20px;
    }

    .card {
      background: #fff;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
      margin-bottom: 20px;
    }

    label {
      font-weight: 500;
      display: block;
      margin-bottom: 6px;
      color: #444;
    }

    select {
      width: 100%;
      padding: 8px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 14px;
      margin-bottom: 10px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      font-size: 14px;
    }

    th, td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: center;
    }

    th {
      background: #f1f3f5;
      font-weight: 600;
    }

    input.grade-input {
      width: 70px;
      padding: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
      text-align: center;
      font-size: 13px;
    }

    .btn {
      padding: 8px 12px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
      margin-right: 6px;
    }

    .btn-save { background: #4CAF50; color: white; }
    .btn-edit { background: #f39c12; color: white; }
    .btn-submit { background: #007bff; color: white; }
    .btn-export { background: #6c757d; color: white; }
    .btn-compute { background: #1e3a8a; color: #fff; }

    .note {
      font-size: 13px;
      color: #333;
      margin-top: 10px;
    }

    .actions { margin-top: 10px; }

    /* ===== Modal Styles ===== */
    .modal {
      display: none;
      position: fixed;
      z-index: 10;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.4);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background-color: #fff;
      margin: 8% auto;
      padding: 20px;
      border-radius: 10px;
      width: 400px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.3);
      position: relative;
      animation: pop 0.3s ease;
    }

    @keyframes pop {
      from { transform: scale(0.9); opacity: 0; }
      to { transform: scale(1); opacity: 1; }
    }

    .close {
      color: #aaa;
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 22px;
      cursor: pointer;
    }

    .close:hover { color: #000; }

    .modal-content input {
      width: 100%;
      padding: 8px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .modal-content button {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 6px;
      background: #2f3e46;
      color: #fff;
      font-size: 14px;
      cursor: pointer;
    }

    .modal-content button:hover { background: #1f2b32; }

    #computeResult {
      background: #f1f5ff;
      padding: 10px;
      border-radius: 8px;
      text-align: center;
      margin-top: 15px;
      font-weight: 600;
    }

    /* ===== Landscape Modal ===== */
    .modal-content.landscape {
      width: 450px;
      margin-top: 4%;
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      align-items: flex-start;
      gap: 15px;
    }

    .modal-content.landscape .left,
    .modal-content.landscape .right {
      width: 47%;
    }

    .modal-content.landscape .right {
      background: #f8f9ff;
      padding: 12px;
      border-radius: 8px;
      min-height: 250px;
    }
    /* ===== Table Responsiveness ===== */
.table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch; /* smooth scroll for mobile */
}

.table-responsive table {
    width: 100%;
    border-collapse: collapse;
    min-width: 600px; /* adjust as needed */
}

.table-responsive th,
.table-responsive td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: center;
    white-space: nowrap; /* prevents columns from squishing */
}

.table-responsive th {
    background: #f1f3f5;
    font-weight: 600;
}

/* Optional: improve mobile readability */
@media (max-width: 768px) {
    .table-responsive th,
    .table-responsive td {
        font-size: 13px;
        padding: 8px;
    }
}

  </style>
</head>

<body>
  <header>
    <h1>Manage Assessments</h1>
  </header>

  <div class="content">
    <div class="card">
      <label for="subject">Select Subject</label>
      <select id="subject">
        <option value="">-- Choose Subject --</option>
        @foreach($subjects as $subject)
          <option value="{{ $subject->id }}">{{ $subject->subject_name }} ({{ $subject->subject_code }})</option>
        @endforeach
      </select>
    </div>

    <div class="card">
      <label for="term">Select Term</label>
      <select id="term">
        <option value="">-- Select Term --</option>
        <option value="prelim">Prelim</option>
        <option value="midterm">Midterm</option>
        <option value="semi">Semi</option>
        <option value="finals">Finals</option>
      </select>

      <label for="semester">Select Semester</label>
      <select id="semester">
        <option value="">-- Select Semester --</option>
        <option value="first">First Semester</option>
        <option value="second">Second Semester</option>
      </select>
    </div>

 <div class="card">
  <h3 style="margin-bottom: 10px;">Student Grades</h3>
  <div class="table-responsive">
    <table>
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
        </tr>
      </thead>
     <tbody id="studentsTableBody">
      <!-- Students will be populated dynamically via JavaScript -->
     </tbody>

  </div>
</div>


    <div class="actions">
      <button class="btn btn-submit" id="submitBtn" onclick="showSubmitModal()">Submit to Dean</button>
    </div>

    <p class="note">
      ⚠️ Once submitted, you can no longer edit the grades. Dean will review and approve/post.
    </p>
  </div>

  <!-- ===== Edit Modal ===== -->
  <div id="editModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <h3>Edit Grades</h3>
      <form id="editForm">
        <input type="hidden" id="editStudentId">
        <label>Prelim:</label>
        <input type="number" id="editPrelim" min="0" max="100">
        <label>Midterm:</label>
        <input type="number" id="editMidterm" min="0" max="100">
        <label>Semi-Final:</label>
        <input type="number" id="editSemiFinal" min="0" max="100">
        <label>Final:</label>
        <input type="number" id="editFinal" min="0" max="100">
        <button type="submit">Update Grades</button>
      </form>
    </div>
  </div>

  <!-- ===== Submit Confirmation Modal ===== -->
  <div id="submitModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeSubmitModal()">&times;</span>
      <h3>Confirm Submission</h3>
      <p>Are you sure you want to submit the grades to the Dean? Once submitted, you cannot edit them anymore.</p>
      <button class="btn btn-submit" onclick="confirmSubmit()">Yes, Submit</button>
      <button class="btn btn-export" onclick="closeSubmitModal()">Cancel</button>
    </div>
  </div>



  <script>


    // ===== Load Students =====
    document.getElementById('subject').addEventListener('change', loadStudents);
    document.getElementById('term').addEventListener('change', loadStudents);
    document.getElementById('semester').addEventListener('change', loadStudents);

    function loadStudents() {
      const subjectId = document.getElementById('subject').value;
      const term = document.getElementById('term').value;
      const semester = document.getElementById('semester').value;
      const tbody = document.getElementById('studentsTableBody');
      tbody.innerHTML = '';
      if (!subjectId) return;

      let url = `/teacher/Manages/${subjectId}/students`;
      const params = new URLSearchParams();
      if (term) params.append('term', term);
      if (semester) params.append('semester', semester);
      if (params.toString()) url += '?' + params.toString();

      fetch(url)
        .then(response => response.json())
        .then(data => {
          data.forEach(student => {
            const row = document.createElement('tr');
            const isEditable = student.status === 'draft' || student.status === 'saved';
           row.innerHTML = `
  <td>${student.id}</td>
  <td>${student.name || 'N/A'}</td>
  <td>${student.prelim ?? '—'}</td>
  <td>${student.midterm ?? '—'}</td>
  <td>${student.semi_final ?? '—'}</td>
  <td>${student.final ?? '—'}</td>
          <td>${student.term_grade ?? '—'}</td>
  <td>${student.remarks ?? '—'}</td>
`;

            tbody.appendChild(row);
          });
        })
        .catch(() => alert('Error loading students.'));
    }

    // ===== Save Grades =====
    function saveStudentGrades(studentId) {
      const subjectId = document.getElementById('subject').value;
      const inputs = document.querySelectorAll(`.grade-input[data-student-id="${studentId}"]`);
      const grades = {};
      inputs.forEach(input => grades[input.dataset.field] = input.value || 0);

      fetch(`/teacher/Manages/${subjectId}/save-grades`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ grades: { [studentId]: grades } })
      })
      .then(res => res.json())
      .then(data => alert(data.success ? 'Grades saved successfully!' : (data.error || 'Error saving grades.')))
      .catch(() => alert('Error saving grades.'));
    }

    // ===== Edit Modal =====
    function openEditModal(studentId) {
      const modal = document.getElementById('editModal');
      document.getElementById('editStudentId').value = studentId;
      document.getElementById('editPrelim').value = document.querySelector(`.grade-input[data-student-id="${studentId}"][data-field="prelim"]`).value;
      document.getElementById('editMidterm').value = document.querySelector(`.grade-input[data-student-id="${studentId}"][data-field="midterm"]`).value;
      document.getElementById('editSemiFinal').value = document.querySelector(`.grade-input[data-student-id="${studentId}"][data-field="semi_final"]`).value;
      document.getElementById('editFinal').value = document.querySelector(`.grade-input[data-student-id="${studentId}"][data-field="final"]`).value;
      modal.style.display = 'flex';
    }

    function closeModal() { document.getElementById('editModal').style.display = 'none'; }

    document.getElementById('editForm').addEventListener('submit', e => {
      e.preventDefault();
      const id = document.getElementById('editStudentId').value;
      ['prelim', 'midterm', 'semi_final', 'final'].forEach(field => {
        const modalVal = document.getElementById('edit' + field.charAt(0).toUpperCase() + field.slice(1));
        const tableVal = document.querySelector(`.grade-input[data-student-id="${id}"][data-field="${field}"]`);
        if (modalVal && tableVal) tableVal.value = modalVal.value;
      });
      alert('Grade update submitted!');
      closeModal();
    });

    // ===== Submit to Dean =====
    function showSubmitModal() { document.getElementById('submitModal').style.display = 'flex'; }
    function closeSubmitModal() { document.getElementById('submitModal').style.display = 'none'; }
    function confirmSubmit() { closeSubmitModal(); submitToDean(); }

    function submitToDean() {
      const subjectId = document.getElementById('subject').value;
      fetch(`/teacher/Manages/${subjectId}/submit-grades`, {
        method: 'POST',
        headers: { 
          'Content-Type': 'application/json', 
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
        }
      })
      .then(res => res.json())
      .then(data => {
        alert(data.success ? data.message : data.error);
        document.getElementById('subject').dispatchEvent(new Event('change'));
      });
    }


  

  </script>
</body>
</html>
</x-teacher-component>
