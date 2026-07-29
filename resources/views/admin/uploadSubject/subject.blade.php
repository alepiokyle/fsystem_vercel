<x-admin-component>
<style>
body {
    background: linear-gradient(135deg, #e6e9ec 0%, #f4f6f7 100%);
    font-family: Arial, sans-serif;
    min-height: 100vh;
    color: #333;
}

.background-overlay, .school-background {
    position: fixed;
    top: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
}

.background-overlay {
    left: 0;
    background: linear-gradient(135deg, rgba(230,233,236,0.95), rgba(244,246,247,0.95));
}

.school-background {
    right: 0;
    width: 45%;
    background: linear-gradient(135deg, rgba(200,210,215,0.15), rgba(240,245,248,0.15));
    opacity: 0.4;
    mask-image: linear-gradient(to left, rgba(0,0,0,0.8), rgba(0,0,0,0));
    -webkit-mask-image: linear-gradient(to left, rgba(0,0,0,0.8), rgba(0,0,0,0));
}

@media (max-width: 768px) {
    .school-background { width: 100%; opacity: 0.2; }
}

.glass-card {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(15px);
    border-radius: 20px;
    padding: 25px;
    color: #333;
    border: 1px solid rgba(255,255,255,0.4);
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

label {
    font-weight: 600;
    margin-bottom: 6px;
    display: block;
    font-size: 14px;
    color: #333;
}

.form-control,
.form-select,
textarea {
    width: 100%;
    height: 46px;
    padding: 10px 12px;
    font-size: 14px;
    background: rgba(255,255,255,0.8);
    border: 1px solid rgba(200,200,200,0.4);
    border-radius: 8px;
    box-sizing: border-box;
    transition: all 0.2s ease;
    color: #333;
}

textarea.form-control { min-height: 80px; resize: vertical; }

.form-control::placeholder,
textarea::placeholder { color: rgba(80,80,80,0.6); font-style: italic; }

.form-control:focus,
.form-select:focus {
    background: rgba(255,255,255,0.95);
    border-color: rgba(0,123,255,0.6);
    box-shadow: 0 0 6px rgba(0,123,255,0.3);
    outline: none;
}

.row.mb-3 { gap: 15px 0; }

.btn-primary {
    background: rgba(0,123,255,0.8);
    border: none;
    color: white;
    padding: 10px 18px;
    border-radius: 8px;
    font-size: 14px;
}

.btn-primary:hover { background: rgba(0,123,255,1); }

.btn-secondary {
    background: rgba(108,117,125,0.8);
    border: none;
    color: white;
    padding: 10px 18px;
    border-radius: 8px;
    font-size: 14px;
    text-decoration: none;
}

.btn-secondary:hover { background: rgba(108,117,125,1); }

.glass-table {
    width: 100%;
    border-collapse: collapse;
    color: #333;
    margin-top: 20px;
}

.glass-table thead {
    background: rgba(255,255,255,0.6);
}

.glass-table tbody tr {
    background: rgba(255,255,255,0.45);
}

.glass-table th,
.glass-table td {
    padding: 12px;
    text-align: left;
}

.status-approved { color: #2ecc71; font-weight: bold; }
.status-pending { color: #e67e22; font-weight: bold; }

@media (max-width: 768px) {
    .form-control, .form-select { height: 42px; font-size: 13px; }
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 8px;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

.d-flex {
    display: flex;
}

.gap-2 {
    gap: 0.5rem;
}

.table-responsive {
    overflow-x: auto;
}

/* Toast Notification Styles - Positioned at top of form */
.toast-container {
    position: relative;
    margin-bottom: 20px;
    z-index: 1000;
}

.toast {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(0, 123, 255, 0.3);
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 10px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    transform: translateY(-10px);
    opacity: 0;
    transition: all 0.3s ease;
    min-width: 300px;
    max-width: 500px;
    position: relative;
    overflow: hidden;
}

.toast.show {
    transform: translateY(0);
    opacity: 1;
}

.toast.success {
    border-left: 4px solid #2ecc71;
    background: linear-gradient(135deg, rgba(46, 204, 113, 0.1), rgba(255, 255, 255, 0.95));
}

.toast.error {
    border-left: 4px solid #e74c3c;
    background: linear-gradient(135deg, rgba(231, 76, 60, 0.1), rgba(255, 255, 255, 0.95));
}

.toast-content {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1;
}

.toast-icon {
    font-size: 18px;
    flex-shrink: 0;
}

.toast-message {
    font-size: 14px;
    font-weight: 500;
    color: #333;
    line-height: 1.4;
}

.toast-close {
    background: none;
    border: none;
    font-size: 20px;
    color: #999;
    cursor: pointer;
    padding: 0;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.toast-close:hover {
    background: rgba(0, 0, 0, 0.1);
    color: #666;
}

.toast-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    background: rgba(0, 123, 255, 0.3);
    border-radius: 0 0 12px 12px;
    animation: toastProgress 5s linear forwards;
}

.toast.success .toast-progress {
    background: rgba(46, 204, 113, 0.6);
}

.toast.error .toast-progress {
    background: rgba(231, 76, 60, 0.6);
}

@keyframes toastProgress {
    from {
        width: 100%;
    }
    to {
        width: 0%;
    }
}

@media (max-width: 768px) {
    .toast {
        min-width: auto;
        max-width: 100%;
        margin: 0 10px 10px 10px;
    }

    .toast-message {
        font-size: 13px;
    }
}
</style>

<div class="background-overlay"></div>
<div class="school-background"></div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Toast Container - Positioned at top of form -->
<div class="toast-container" id="toastContainer"></div>

<div class="glass-card">
    <h2>📚 Upload New Subject</h2>
    <p class="text-muted mb-4">Add a new subject to the system that will be available for student enrollment and teacher assignment.</p>

    <form id="uploadSubjectForm" action="{{ route('admin.upload-subject.store') }}" method="POST">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="subject_code">Subject Code</label>
                <input type="text" id="subject_code" name="subject_code" class="form-control"
                       placeholder="e.g., IT101, MATH101" required maxlength="10">
            </div>
            <div class="col-md-6">
                <label for="subject_name">Subject Name</label>
                <input type="text" id="subject_name" name="subject_name" class="form-control"
                       placeholder="e.g., Introduction to Programming" required maxlength="255">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="department">Program</label>
                <select id="department" name="department" class="form-control" required>
                    <option value="">-- Select Program--</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="year_level">Year Level</label>
                <select id="year_level" name="year_level" class="form-select">
                    <option value="">-- Select Year Level --</option>
                    <option value="1st Year">1st Year</option>
                    <option value="2nd Year">2nd Year</option>
                    <option value="3rd Year">3rd Year</option>
                    <option value="4th Year">4th Year</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="semester">Semester</label>
                <select id="semester" name="semester" class="form-select" required>
                    <option value="">-- Select Semester --</option>
                    <option value="1st Semester">1st Semester</option>
                    <option value="2nd Semester">2nd Semester</option>
                    <option value="Summer">Summer</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="school_year">School Year</label>
                <select id="school_year" name="school_year" class="form-select" required>
                    <option value="">-- Select School Year --</option>
                    <option value="2024-2025">2024–2025</option>
                    <option value="2025-2026">2025–2026</option>
                    <option value="2026-2027">2026–2027</option>
                    <option value="2027-2028">2027–2028</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="units">Units</label>
                <input type="number" id="units" name="units" class="form-control" placeholder="Enter units" required min="1">
            </div>
        </div>

        <div class="mb-3">
            <label for="description">Description (Optional)</label>
            <textarea id="description" name="description" class="form-control"
                      placeholder="Brief description of the subject content and objectives..."></textarea>
        </div>

        <div class="mb-4">
            <label for="status">Status</label>
            <select id="status" name="status" class="form-select" required>
                <option value="">-- Select Status --</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
                <option value="Pending">Pending Approval</option>
            </select>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary" id="submitBtn">
                <span class="btn-text">📤 Upload Subject</span>
                <span class="loading-spinner" style="display: none;">⟳</span>
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">← Back to Dashboard</a>
        </div>
    </form>
</div>

<!-- Recent Subjects Table -->
<div class="glass-card">
    <h3>📋 Recently Uploaded Subjects <button id="toggleSubjects" class="btn btn-link p-0 ms-2" style="font-size: 18px; color: #333;">▼</button></h3>
    <div class="table-responsive">
        <table class="glass-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Subject Name</th>
                    <th>Program</th>
                    <th>Units</th>
                    <th>Semester</th>
                    <th>Year Level</th>
                    <th>Year</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody id="subjectsTableBody">
                @forelse($subjects as $subject)
                <tr>
                    <td>{{ $subject->subject_code }}</td>
                    <td>{{ $subject->subject_name }}</td>
                    <td>{{ $subject->department->name }}</td>
                    <td>{{ $subject->units }}</td>
                    <td>{{ $subject->semester }}</td>
                    <td>{{ $subject->year_level }}</td>
                    <td>{{ $subject->school_year }}</td>
                    <td>
                        <span class="status-{{ strtolower($subject->status) }}">
                            {{ $subject->status }}
                        </span>
                    </td>
                    <td>{{ $subject->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-3">
                        No subjects uploaded yet. Use the form above to add subjects.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('uploadSubjectForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.querySelector('.btn-text');
    const loadingSpinner = document.querySelector('.loading-spinner');

    // Toast notification functions
    function showToast(message, type = 'success', duration = 5000) {
        const toastContainer = document.getElementById('toastContainer');

        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <span class="toast-icon">${getToastIcon(type)}</span>
                <span class="toast-message">${message}</span>
            </div>
            <button class="toast-close" onclick="closeToast(this)">×</button>
            <div class="toast-progress"></div>
        `;

        toastContainer.appendChild(toast);

        // Show toast immediately
        setTimeout(() => {
            toast.classList.add('show');
        }, 10);

        // Auto remove after duration
        setTimeout(() => {
            removeToast(toast);
        }, duration);
    }

    function getToastIcon(type) {
        switch(type) {
            case 'success': return '✅';
            case 'error': return '❌';
            case 'warning': return '⚠️';
            default: return 'ℹ️';
        }
    }

    function closeToast(button) {
        const toast = button.closest('.toast');
        removeToast(toast);
    }

    function removeToast(toast) {
        toast.classList.remove('show');
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }

    // Function to refresh subjects table
    function refreshSubjectsTable() {
        fetch('{{ route("admin.upload-subject") }}', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            }
        })
        .then(response => response.text())
        .then(html => {
            // Parse the HTML and extract the table body
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTableBody = doc.getElementById('subjectsTableBody');

            if (newTableBody) {
                document.getElementById('subjectsTableBody').innerHTML = newTableBody.innerHTML;
                // Preserve hidden state
                if (isTableHidden) {
                    document.getElementById('subjectsTableBody').style.display = 'none';
                }
            }
        })
        .catch(error => {
            console.error('Error refreshing table:', error);
        });
    }

    // Toggle subjects table visibility
    const toggleBtn = document.getElementById('toggleSubjects');
    const tableBody = document.getElementById('subjectsTableBody');
    let isTableHidden = localStorage.getItem('subjectsTableHidden') === 'true';

    // Set initial state based on localStorage
    if (isTableHidden) {
        tableBody.style.display = 'none';
        toggleBtn.textContent = '▲';
    } else {
        tableBody.style.display = '';
        toggleBtn.textContent = '▼';
    }

    toggleBtn.addEventListener('click', function() {
        isTableHidden = !isTableHidden;
        localStorage.setItem('subjectsTableHidden', isTableHidden);
        if (isTableHidden) {
            tableBody.style.display = 'none';
            toggleBtn.textContent = '▲';
        } else {
            tableBody.style.display = '';
            toggleBtn.textContent = '▼';
        }
    });

    // Form submission handler
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Show loading state
        submitBtn.disabled = true;
        btnText.style.display = 'none';
        loadingSpinner.style.display = 'inline-block';

        const formData = new FormData(form);

        // Get CSRF token from the form
        const csrfToken = document.querySelector('input[name="_token"]').value;

        // Send AJAX request
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            // Check if response is JSON
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                return response.json();
            } else {
                throw new Error('Server returned non-JSON response');
            }
        })
        .then(data => {
            // Reset loading state
            submitBtn.disabled = false;
            btnText.style.display = 'inline';
            loadingSpinner.style.display = 'none';

            if (data.success) {
                // Show success toast
                showToast(data.message || 'Subject uploaded successfully!', 'success');

                // Reset form
                form.reset();

                // Refresh the subjects table instead of reloading the page
                refreshSubjectsTable();

                // Optional: Refresh the subjects table or redirect
                // setTimeout(() => {
                //     location.reload(); // Refresh page to show updated data
                // }, 2000);
            } else if (data.errors) {
                // Handle validation errors
                let errorMessages = [];
                for (let field in data.errors) {
                    errorMessages = errorMessages.concat(data.errors[field]);
                }
                showToast(errorMessages.join('<br>'), 'error');
            } else {
                // Show error toast
                showToast(data.message || 'An error occurred while uploading the subject.', 'error');
            }
        })
        .catch(error => {
            // Reset loading state
            submitBtn.disabled = false;
            btnText.style.display = 'inline';
            loadingSpinner.style.display = 'none';

            console.error('Error:', error);
            showToast('Network error occurred. Please try again.', 'error');
        });
    });
});
</script>
</x-admin-component>
