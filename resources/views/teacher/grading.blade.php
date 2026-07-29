<x-teacher-component>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Student Grading - Teacher Dashboard</title>

  <style>
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

    select, input[type="number"] {
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

    .btn {
      display: inline-block;
      background: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      padding: 8px 16px;
      font-size: 14px;
      cursor: pointer;
      transition: 0.3s;
      margin: 2px;
    }

    .btn:hover {
      background: #0056b3;
    }

    .btn-success {
      background: #28a745;
    }

    .btn-success:hover {
      background: #218838;
    }

    .btn-warning {
      background: #ffc107;
      color: #212529;
    }

    .btn-warning:hover {
      background: #e0a800;
    }

    .grading-section {
      display: none;
    }

    .grading-section.show {
      display: block;
    }

    .component-inputs {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .component-inputs input {
      width: 80px;
      margin-bottom: 0;
    }

    .component-inputs .btn {
      padding: 6px 12px;
      font-size: 12px;
    }

    .final-grade {
      font-weight: bold;
      color: #28a745;
    }

    .status-done {
      background-color: #d4edda;
      color: #155724;
    }

    .status-incomplete {
      background-color: #fff3cd;
      color: #856404;
    }
  </style>
</head>

<body>
  <header>
    <h1>Student Grading</h1>
  </header>

  <div class="content">
    <div class="card">
      <label for="subject">Select Subject / Class</label>
      <select id="subject">
        <option value="">-- Choose Subject --</option>
        @foreach($assignedSubjects as $subject)
        <option value="{{ $subject->id }}">{{ $subject->subject_code }} - {{ $subject->subject_name }} ({{ $subject->section }})</option>
        @endforeach
      </select>

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

      <button class="btn" onclick="loadGradingData()">Load Students</button>
    </div>

    <div class="card grading-section" id="gradingSection">
      <h3>Student Grades</h3>
      <table id="gradingTable">
        <thead>
          <tr>
            <th>Student ID</th>
            <th>Student Name</th>
            <th>Department</th>
            <th>Year Level</th>
            <th>Quiz (10%)</th>
            <th>Assignment (10%)</th>
            <th>Attendance (10%)</th>
            <th>Exam (30%)</th>
            <th>Performance (40%)</th>
            <th>Final Grade</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Student rows will be populated here -->
        </tbody>
      </table>
    </div>
  </div>

  <script>
    let currentSubjectId = null;
    let studentsData = [];

    // Load saved subject on page load
    window.addEventListener('DOMContentLoaded', function() {
      const savedSubjectId = localStorage.getItem('gradingSubjectId');
      const savedTerm = localStorage.getItem('gradingTerm');
      const savedSemester = localStorage.getItem('gradingSemester');

      if (savedSubjectId) {
        document.getElementById('subject').value = savedSubjectId;
      }
      if (savedTerm) {
        document.getElementById('term').value = savedTerm;
      }
      if (savedSemester) {
        document.getElementById('semester').value = savedSemester;
      }

      if (savedSubjectId && savedTerm && savedSemester) {
        loadGradingData();
      }
    });

    function loadGradingData() {
      currentSubjectId = document.getElementById('subject').value;
      const term = document.getElementById('term').value;
      const semester = document.getElementById('semester').value;

      if (!currentSubjectId || !term || !semester) {
        alert('Please select subject, term, and semester.');
        return;
      }

      // Save selections to localStorage
      localStorage.setItem('gradingSubjectId', currentSubjectId);
      localStorage.setItem('gradingTerm', term);
      localStorage.setItem('gradingSemester', semester);

      const url = `/teacher/Manage/${currentSubjectId}/grading-students?term=${encodeURIComponent(term)}&semester=${encodeURIComponent(semester)}`;

      fetch(url, {
        method: 'GET',
        headers: {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
      })
        .then(response => {
          const contentType = response.headers.get('content-type');
          if (contentType && contentType.includes('application/json')) {
            return response.json();
          } else {
            throw new Error('Authentication error. Please log in as a teacher.');
          }
        })
        .then(data => {
          if (data.success) {
            studentsData = data.students;
            populateGradingTable(studentsData);
            document.getElementById('gradingSection').classList.add('show');
          } else {
            alert(data.message || 'Error loading students.');
          }
        })
        .catch(error => {
          console.error('Error loading students:', error);
          alert(error.message || 'Error loading students. Please check your authentication.');
        });
    }

    function populateGradingTable(students) {
      const tbody = document.querySelector('#gradingTable tbody');
      tbody.innerHTML = '';

      students.forEach(student => {
        const row = document.createElement('tr');

        // Calculate weighted scores
        const quizWeighted = student.quiz && student.total_quiz ? ((student.quiz / student.total_quiz) * 100 * 0.10).toFixed(2) : '-';
        const assignmentWeighted = student.assignment && student.total_assignment ? ((student.assignment / student.total_assignment) * 100 * 0.10).toFixed(2) : '-';
        const attendanceWeighted = student.attendance_score && student.total_attendance_score ? ((student.attendance_score / student.total_attendance_score) * 100 * 0.10).toFixed(2) : '-';
        const examWeighted = student.exam && student.total_exam ? ((student.exam / student.total_exam) * 100 * 0.30).toFixed(2) : '-';
        const performanceWeighted = student.performance && student.total_performance ? ((student.performance / student.total_performance) * 100 * 0.40).toFixed(2) : '-';

        const statusClass = student.is_done ? 'status-done' : 'status-incomplete';
        const statusText = student.is_done ? 'Done' : 'Incomplete';

        row.innerHTML = `
          <td>${student.student_id || 'N/A'}</td>
          <td>${student.name || 'N/A'}</td>
          <td>${student.department || 'N/A'}</td>
          <td>${student.year_level || 'N/A'}</td>
          <td>
            <div class="component-inputs">
              <input type="number" placeholder="Score" value="${student.quiz || ''}" data-student-id="${student.id}" data-component="quiz" />
              <span>/</span>
              <input type="number" placeholder="Total" value="${student.total_quiz || ''}" data-student-id="${student.id}" data-component="total_quiz" />
              <button class="btn btn-success" onclick="saveComponent('${student.id}', 'quiz')">Save</button>
            </div>
            <div>Weighted: ${quizWeighted}</div>
          </td>
          <td>
            <div class="component-inputs">
              <input type="number" placeholder="Score" value="${student.assignment || ''}" data-student-id="${student.id}" data-component="assignment" />
              <span>/</span>
              <input type="number" placeholder="Total" value="${student.total_assignment || ''}" data-student-id="${student.id}" data-component="total_assignment" />
              <button class="btn btn-success" onclick="saveComponent('${student.id}', 'assignment')">Save</button>
            </div>
            <div>Weighted: ${assignmentWeighted}</div>
          </td>
          <td>
            <div>Auto-calculated from attendance</div>
            <div>Score: ${student.attendance_score ? student.attendance_score.toFixed(2) : 'N/A'}</div>
            <div>Weighted: ${attendanceWeighted}</div>
          </td>
          <td>
            <div class="component-inputs">
              <input type="number" placeholder="Score" value="${student.exam || ''}" data-student-id="${student.id}" data-component="exam" />
              <span>/</span>
              <input type="number" placeholder="Total" value="${student.total_exam || ''}" data-student-id="${student.id}" data-component="total_exam" />
              <button class="btn btn-success" onclick="saveComponent('${student.id}', 'exam')">Save</button>
            </div>
            <div>Weighted: ${examWeighted}</div>
          </td>
          <td>
            <div class="component-inputs">
              <input type="number" placeholder="Score" value="${student.performance || ''}" data-student-id="${student.id}" data-component="performance" />
              <span>/</span>
              <input type="number" placeholder="Total" value="${student.total_performance || ''}" data-student-id="${student.id}" data-component="total_performance" />
              <button class="btn btn-success" onclick="saveComponent('${student.id}', 'performance')">Save</button>
            </div>
            <div>Weighted: ${performanceWeighted}</div>
          </td>
          <td class="final-grade">${student.final_grade ? parseFloat(student.final_grade).toFixed(2) : '-'}</td>
          <td class="${statusClass}">${statusText}</td>
          <td>
            ${!student.is_done ? `<button class="btn btn-warning" onclick="markAsDone('${student.id}')">Mark Done</button>` : ''}
            ${student.final_grade ? `<button class="btn" onclick="saveFinalGrade('${student.id}')">Save Final</button>` : ''}
          </td>
        `;
        tbody.appendChild(row);
      });
    }

    function saveComponent(studentId, component) {
      const term = document.getElementById('term').value;
      const semester = document.getElementById('semester').value;

      const scoreInput = document.querySelector(`input[data-student-id="${studentId}"][data-component="${component}"]`);
      const totalInput = document.querySelector(`input[data-student-id="${studentId}"][data-component="total_${component}"]`);

      const score = scoreInput ? scoreInput.value.trim() : null;
      const total = totalInput ? totalInput.value.trim() : null;

      if (!term || !semester) {
        alert('Please select both a term and a semester.');
        return;
      }

      const body = {
        subject_id: currentSubjectId,
        component: component,
        student_id: studentId,
        score: score || null,
        total: total || null,
        term: term,
        semester: semester
      };

      fetch('/teacher/Manage/save-grading-component', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(body)
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Score saved successfully!');
          // Reload the data to reflect changes
          loadGradingData();
        } else {
          alert(data.message || 'Error saving score.');
        }
      })
      .catch(() => alert('Error saving score.'));
    }

    function markAsDone(studentId) {
      const term = document.getElementById('term').value;
      const semester = document.getElementById('semester').value;

      if (!term || !semester) {
        alert('Please select both a term and a semester.');
        return;
      }

      fetch('/teacher/Manage/mark-as-done', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
          subject_id: currentSubjectId,
          student_id: studentId
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Student marked as done successfully!');
          // Reload the data to reflect changes
          loadGradingData();
        } else {
          alert(data.message || 'Error marking as done.');
        }
      })
      .catch(() => alert('Error marking as done.'));
    }

    function saveFinalGrade(studentId) {
      const term = document.getElementById('term').value;
      const semester = document.getElementById('semester').value;

      if (!term || !semester) {
        alert('Please select both a term and a semester.');
        return;
      }

      const student = studentsData.find(s => s.id == studentId);
      if (!student || student.final_grade === null) {
        alert('Final grade is not calculated yet.');
        return;
      }

      fetch('/teacher/Manage/save-final-grade', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
          subject_id: currentSubjectId,
          student_id: studentId,
          term: term,
          semester: semester,
          grade: student.final_grade
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Final grade saved successfully!');
          // Reload the data to reflect changes
          loadGradingData();
        } else {
          alert(data.message || 'Error saving final grade.');
        }
      })
      .catch(() => alert('Error saving final grade.'));
    }
  </script>
</body>
</html>
</x-teacher-component>
