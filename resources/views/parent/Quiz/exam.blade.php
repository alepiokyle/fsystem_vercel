<x-parent-component>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Submit Grades - Teacher Dashboard</title>
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
    .btn {
      padding: 8px 12px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
      margin-right: 6px;
    }
    .btn-submit {
      background: #007bff;
      color: white;
    }
    .btn-export {
      background: #6c757d;
      color: white;
    }
    .note {
      font-size: 13px;
      color: #b33;
      margin-top: 10px;
    }
    .page-header {
      color: #1e3a8a;
      font-weight: 600;
    }
  </style>
</head>
<body>

  <header>
    <h1>Submit Grades</h1>
  </header>

  <div class="content">
    <div class="container mt-4">
      <h3 class="page-header">📊 Quiz & Exam Results</h3>
    </div>

    <!-- Select Term -->
    <div class="card">
      <label for="term">Select Semester</label>
      <select id="term">
        <option value="">-- Choose Term --</option>
        <option value="prelim">Prelim</option>
        <option value="midterm">Midterm</option>
        <option value="semi_final">Semi-Final</option>
        <option value="final">Final</option>
      </select>
    </div>



    <div class="actions">
      <button class="btn btn-submit" id="submitGradesBtn" disabled onclick="submitGrades()">Submit Grades</button>
    </div>

    <p class="note">
      ⚠️ Once submitted, you can no longer edit these grades. Please double-check before submission.
    </p>
  </div>

  <script>
    // Example: Enable submit button when a term is selected
    document.getElementById('term').addEventListener('change', function() {
      const btn = document.getElementById('submitGradesBtn');
      btn.disabled = this.value === '';
    });

    // Placeholder submit action
    function submitGrades() {
      alert('Grades submitted successfully!');
    }
  </script>

</body>
</html>
</x-parent-component>
