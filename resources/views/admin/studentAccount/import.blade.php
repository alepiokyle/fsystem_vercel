<x-admin-component>

<style>
body {
    font-family: Arial, sans-serif;
    color: #333;
}

/* Card design */
.glass-card {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(15px);
    border-radius: 20px;
    padding: 25px;
    border: 1px solid rgba(255,255,255,0.4);
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    margin-bottom: 30px;
    transition: 0.3s ease-in-out;
}

.glass-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.15);
}

/* Form */
.import-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.import-form input[type="file"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
}

.import-form button {
    padding: 10px;
    background: #3498db;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.2s;
}

.import-form button:hover {
    background: #2980b9;
}

/* Sample */
.sample-info {
    background: rgba(255,255,255,0.8);
    padding: 15px;
    border-radius: 10px;
    border: 1px solid rgba(0,0,0,0.1);
}

.sample-info h4 {
    margin-top: 0;
}

.sample-info ul {
    margin: 0;
    padding-left: 20px;
}
</style>

<div class="glass-card">
    <h3>Import Students from Excel or CSV</h3>

    @if(session('success'))
        <div style="color: green; margin-bottom: 15px;">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div style="color: red; margin-bottom: 15px;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.student.import') }}" method="POST" enctype="multipart/form-data" class="import-form">
        @csrf
        <label for="file">Select Excel or CSV File:</label>
        <input type="file" name="file" id="file" accept=".xlsx,.xls,.csv" required>

        <button type="submit">Import Students</button>
    </form>

    <div class="sample-info">
        <h4>File Format Requirements:</h4>
        <p><strong>IMPORTANT:</strong> The import automatically detects column headers. Include headers in the first row for best results, or download the sample file as a template.</p>
        <p><strong>Required columns (case-insensitive headers):</strong></p>
        <ul>
            <li><strong>Student ID</strong> or <strong>Student_ID</strong> (required, unique)</li>
        </ul>
        <p><strong>Download the sample file and copy your data into it to ensure correct import:</strong></p>
        <p><a href="{{ route('admin.student.download.sample') }}" download style="background: #27ae60; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; display: inline-block;">📥 Download Sample Excel File</a></p>
        <p><em>The import will skip rows with empty required fields and show errors for invalid data.</em></p>
        <p><strong>Note:</strong> If you encounter issues with Excel files, try converting to CSV format.</p>
    </div>
</div>

</x-admin-component>
