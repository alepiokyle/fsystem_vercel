<div class="navbar-content">
    <ul class="pc-navbar">
        <li class="pc-item" data-tooltip="Admin Dashboard">
            <a href="{{ route('admin.dashboard') }}" class="pc-link">
                <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                <span class="pc-mtext">Admin Dashboard</span>
            </a>
        </li>

        <li class="pc-item" data-tooltip="Upload Subjects">
            <a href="{{ route('admin.upload-subject') }}" class="pc-link">
                <span class="pc-micon"><i class="ti ti-upload"></i></span>
                <span class="pc-mtext">Upload Subjects</span>
            </a>
        </li>

        <li class="pc-item" data-tooltip="View Student Grades">
            <a href="{{ route('admin.Grade') }}" class="pc-link">
                <span class="pc-micon"><i class="ti ti-user-check"></i></span>
                <span class="pc-mtext">View Student Grades</span>
            </a>
        </li>

        <li class="pc-item" data-tooltip="Student Account">
            <a href="{{ route('view.student') }}" class="pc-link">
                <span class="pc-micon"><i class="ti ti-users"></i></span>
                <span class="pc-mtext">Student Account</span>
            </a>
        </li>

        <li class="pc-item" data-tooltip="Parent Account">
            <a href="{{ route('view.parent') }}" class="pc-link">
                <span class="pc-micon"><i class="ti ti-home"></i></span>
                <span class="pc-mtext">Parent Account</span>
            </a>
        </li>

        <li class="pc-item" data-tooltip="Add Staff">
            <a href="{{ route('view.addstaff') }}" class="pc-link">
                <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
                <span class="pc-mtext">Add Staff</span>
            </a>
        </li>
    </ul>
</div>
