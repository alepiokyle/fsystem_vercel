<div class="navbar-content">
  <ul class="pc-navbar">
    <!-- Dashboard -->
    <li class="pc-item">
      <a href="{{ route ('student.studentdashboard')}}" class="pc-link">
        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
        <span class="pc-mtext">Student Dashboard</span>
      </a>
    </li>

    <!-- Subjects -->
  <li class="pc-item">
  <a href="{{ route('student.Subject')}}" class="pc-link">
    <span class="pc-micon"><i class="ti ti-notebook"></i></span>
    <span class="pc-mtext">Enrolled Subjects</span>
  </a>
</li>


    <!-- Grades -->
    <li class="pc-item">
      <a href="{{ route('student.grades')}}" class="pc-link">
        <span class="pc-micon"><i class="ti ti-clipboard-list"></i></span>
        <span class="pc-mtext">View Grades</span>
      </a>
    </li>

    <!-- Notifications -->
    <li class="pc-item">
      <a href="{{ route('student.Notif')}}" class="pc-link">
        <span class="pc-micon"><i class="ti ti-bell"></i></span>
        <span class="pc-mtext">Notifications</span>
      </a>
    </li>

    <!-- Section -->
    <li class="pc-item">
      <a href="{{ route('student.Section')}}" class="pc-link">
        <span class="pc-micon"><i class="ti ti-users"></i></span>
        <span class="pc-mtext">Profile Section</span>
      </a>
    </li>
  </ul>
</div>
