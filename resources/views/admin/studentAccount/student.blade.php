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

/* Search + Filter */
.search-bar {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.search-bar input,
.search-bar select {
    flex: 1;
    padding: 8px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

.search-bar button {
    flex: 0.3;
    border-radius: 8px;
}

/* Table */
.glass-table {
    width: 100%;
    border-collapse: collapse;
    color: #333;
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.1);
}

.glass-table thead {
    background: rgba(0, 0, 0, 0.05);
    font-weight: bold;
    border-bottom: 2px solid rgba(0,0,0,0.15);
}

.glass-table tbody tr {
    background: rgba(255,255,255,0.6);
    transition: 0.2s;
    border-bottom: 1px solid rgba(0,0,0,0.08);
}

.glass-table tbody tr:nth-child(even) {
    background: rgba(245,245,245,0.6); /* alternate row */
}

.glass-table tbody tr:hover {
    background: rgba(255,255,255,0.95);
}

.glass-table th,
.glass-table td {
    padding: 14px;
    text-align: left;
    vertical-align: middle;
}

/* Status */
.status-active {
    color: #2ecc71;
    font-weight: bold;
    padding: 4px 8px;
    background: rgba(46, 204, 113, 0.1);
    border-radius: 6px;
}
.status-suspended {
    color: #e74c3c;
    font-weight: bold;
    padding: 4px 8px;
    background: rgba(231, 76, 60, 0.1);
    border-radius: 6px;
}

/* Action buttons */
.action-group {
    display: flex;
    gap: 6px;
    justify-content: center; /* center buttons */
}

.action-btn {
    flex: 1;
    padding: 6px 10px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    color: white;
    font-size: 0.8rem;
    transition: 0.2s;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.edit-btn { background: #3498db; }
.edit-btn:hover { background: #2980b9; }

.suspend-btn { background: #e67e22; }
.suspend-btn:hover { background: #ca6f1e; }

.delete-btn { background: #e74c3c; }
.delete-btn:hover { background: #c0392b; }

/* Mobile Responsiveness */
@media (max-width: 767px) {
    .glass-card {
        padding: 16px;
        margin-bottom: 16px;
        border-radius: 12px;
    }

    .search-bar {
        flex-direction: column;
        gap: 8px;
    }

    .search-bar input,
    .search-bar select,
    .search-bar button {
        width: 100%;
        padding: 12px;
        font-size: 16px; /* Prevent zoom on iOS */
    }

    .glass-table {
        font-size: 14px;
        border-radius: 8px;
    }

    .glass-table th,
    .glass-table td {
        padding: 8px 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .glass-table th:nth-child(4),
    .glass-table td:nth-child(4) {
        width: 120px;
        min-width: 120px;
    }

    .action-group {
        flex-direction: column;
        gap: 4px;
        align-items: stretch;
    }

    .action-btn {
        font-size: 12px;
        padding: 8px 6px;
        min-height: 32px;
    }

    /* Stack table on very small screens */
    @media (max-width: 480px) {
        .glass-table {
            display: block;
            border: none;
        }

        .glass-table thead {
            display: none;
        }

        .glass-table tbody,
        .glass-table tr,
        .glass-table td {
            display: block;
            width: 100%;
        }

        .glass-table tr {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 12px;
            padding: 12px;
            background: rgba(255,255,255,0.9);
        }

        .glass-table td {
            border: none;
            padding: 4px 0;
            text-align: left;
        }

        .glass-table td:before {
            content: attr(data-label) ": ";
            font-weight: bold;
            display: inline-block;
            min-width: 80px;
            color: #666;
        }

        .action-group {
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid #eee;
        }
    }
}
</style>

<div class="glass-card">
    <h3>Student List / Directory</h3>
    <a href="{{ route('admin.student.import.page') }}" class="action-btn edit-btn">Import Students from Excel/CSV</a>

    <!-- Search + Filter -->
    <form class="search-bar">
        <input type="text" placeholder="Search by name or ID...">
        <select>
            <option value="">All Courses</option>
            <option value="BSIT">BS Information Technology</option>
            <option value="BSED">BS Education</option>
            <option value="BSBA">BS Business Administration</option>
            <option value="BSN">BS Nursing</option>
            <option value="BSECE">BS Engineering</option>
        </select>
        <button type="button" class="action-btn edit-btn">Filter</button>
    </form>

    <!-- Student Table -->
    <div class="table-responsive">
        <table class="glass-table">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th style="width: 200px; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td data-label="Student ID">{{ $student->profile->student_id ?? 'N/A' }}</td>
                    <td data-label="Name">{{ $student->name }}</td>
                    <td data-label="Status">
                        <span class="{{ $student->is_active ? 'status-active' : 'status-suspended' }}">
                            {{ $student->is_active ? 'Active' : 'Suspended' }}
                        </span>
                    </td>
                    <td data-label="Action">
                        <div class="action-group">
                            <button class="action-btn edit-btn">Edit</button>
                            <button class="action-btn suspend-btn">{{ $student->is_active ? 'Suspend' : 'Activate' }}</button>
                            <form method="POST" action="{{ route('admin.student.destroy', $student->id) }}" onsubmit="return confirm('Are you sure you want to delete this student?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete-btn">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</x-admin-component>
