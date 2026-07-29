<div class="navbar-content">
  <ul class="pc-navbar">
    <!-- Dashboard -->
    <li class="pc-item">
      <a href="{{ route ('parent.parentdashboard')}}" class="pc-link">
        <span class="pc-micon"><i class="ti ti-home"></i></span>
        <span class="pc-mtext">Home</span>
      </a>
    </li>

    <!-- Child's Attendance -->
    <li class="pc-item">
      <a href="{{ route('parent.Attendance')}}" class="pc-link">
        <span class="pc-micon"><i class="ti ti-calendar"></i></span>
        <span class="pc-mtext">Child's Attendance</span>
      </a>
    </li>

    <!-- Behavior Notes -->
    <li class="pc-item">
      <a href="{{ route('parent.Notes')}}" class="pc-link">
        <span class="pc-micon"><i class="ti ti-message"></i></span>
        <span class="pc-mtext">Behavior Notes</span>
      </a>
    </li>

    <!-- Final Grades -->
    <li class="pc-item">
      <a href="{{ route('parent.Grades')}}" class="pc-link">
        <span class="pc-micon"><i class="ti ti-award"></i></span>
        <span class="pc-mtext">Final Grades</span>
      </a>
    </li>
  </ul>
</div>
