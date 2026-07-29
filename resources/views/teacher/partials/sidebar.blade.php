<div class="navbar-content">
      <ul class="pc-navbar">
        <li class="pc-item">
          <a href="{{ route ('teacher.teacherdashboard')}}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
            <span class="pc-mtext">Teacher's Dashboard</span>
          </a>
        </li>

    <!-- View Assign Subject -->
    <li class="pc-item">
      <a href="{{ route('teacher.ViewAssign')}}" class="pc-link">
        <span class="pc-micon"><i class="ti ti-school"></i></span>
        <span class="pc-mtext">View Assign Subject</span>
      </a>
    </li>
    
    <!-- Manage Attendance -->
    <li class="pc-item">
      <a href="{{ route('teacher.Manage')}}" class="pc-link">
        <span class="pc-micon"><i class="ti ti-clipboard-check"></i></span>
        <span class="pc-mtext">Manage Attendance</span>
      </a>
    </li>
    
    <!-- Manage Assessment -->
    <li class="pc-item">
      <a href="{{ route('teacher.Manages')}}" class="pc-link">
        <span class="pc-micon"><i class="ti ti-file-text"></i></span>
        <span class="pc-mtext">Manage Assessment</span>
      </a>
    </li>

    <!-- Submit Grades -->
    <li class="pc-item">
      <a href="{{ route('teacher.Grades')}}" class="pc-link">
        <span class="pc-micon"><i class="ti ti-upload"></i></span>
        <span class="pc-mtext">Submit Grades</span>
      </a>
    </li>

    @php
        $hasDeanAccount = \App\Models\DeanAccount::where('username', Auth::guard('teacher')->user()->username)->exists();
    @endphp

    @if($hasDeanAccount)
    <!-- Switch Role -->
    <li class="pc-item">
      <a href="javascript:void(0)" onclick="switchRole()" class="pc-link">
        <span class="pc-micon"><i class="ti ti-refresh"></i></span>
        <span class="pc-mtext">Switch Role</span>
      </a>
    </li>
    @endif
  </ul> 
</div>
