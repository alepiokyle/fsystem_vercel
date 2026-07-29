<x-admin-component>
  <style>
    .card {
      background: #fff;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      max-width: 1000px;
      margin: 20px auto;
      position: relative;
    }

    .card h2 {
      margin: 0 0 20px;
      font-size: 22px;
      color: #333;
    }

    .add-btn {
      position: absolute;
      top: 20px;
      right: 20px;
      background: none;
      color: #333;
      border: 1px solid #ccc;
      border-radius: 6px;
      padding: 8px 12px;
      display: flex;
      align-items: center;
      cursor: pointer;
      font-size: 14px;
      transition: background 0.3s ease, border-color 0.3s ease;
    }
    .add-btn:hover {
      background: #f0f0f0;
      border-color: #999;
    }
    .add-btn i {
      margin-right: 6px;
      font-size: 16px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    table th, table td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    table th {
      background: #f0f0f0;
      color: #333;
    }

    .status-active {
      color: green;
      font-weight: bold;
    }
    .status-inactive {
      color: red;
      font-weight: bold;
    }

    .actions button {
      margin-right: 5px;
      padding: 5px 10px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 13px;
    }
    .actions .suspend { background: #ff9800; color: white; }
    .actions .delete { background: #f44336; color: white; }

    /* Modal */
    .modal {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
    }
    .modal-content {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      width: 400px;
      position: relative;
      animation: fadeIn 0.3s ease;
    }
    .modal-content h3 {
      margin: 0 0 15px;
    }
    .modal-content label {
      display: block;
      margin-top: 10px;
      font-weight: bold;
      font-size: 14px;
    }
    .modal-content input,
    .modal-content select {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ddd;
      border-radius: 6px;
    }
    .modal-content .form-actions {
      display: flex;
      justify-content: space-between;
      margin-top: 15px;
    }
    .modal-content button {
      padding: 10px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
    }
    .btn-cancel { background: #ccc; color: #333; }
    .btn-cancel:hover { background: #bbb; }
    .btn-create { background: #4CAF50; color: white; }
    .btn-create:hover { background: #45a049; }

    .close-btn {
      position: absolute;
      top: 10px; right: 15px;
      cursor: pointer;
      font-size: 18px;
      font-weight: bold;
      color: #555;
    }
    .close-btn:hover { color: red; }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Mobile Responsiveness */
    @media (max-width: 767px) {
      .card {
        padding: 16px;
        margin: 16px;
        border-radius: 8px;
      }

      .card h2 {
        font-size: 18px;
        margin-bottom: 16px;
      }

      .add-btn {
        position: static;
        width: 100%;
        margin-bottom: 16px;
        justify-content: center;
        padding: 12px;
        font-size: 16px;
      }

      table {
        font-size: 14px;
        margin-top: 0;
      }

      table th, table td {
        padding: 8px 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }

      table th:nth-child(7),
      table td:nth-child(7) {
        width: 120px;
        min-width: 120px;
      }

      .actions {
        display: flex;
        flex-direction: column;
        gap: 4px;
      }

      .actions button {
        width: 100%;
        padding: 8px 6px;
        font-size: 12px;
        min-height: 32px;
      }

      /* Stack table on very small screens */
      @media (max-width: 480px) {
        table {
          display: block;
          border: none;
        }

        table thead {
          display: none;
        }

        table tbody,
        table tr,
        table td {
          display: block;
          width: 100%;
        }

        table tr {
          border: 1px solid #e9ecef;
          border-radius: 8px;
          margin-bottom: 12px;
          padding: 12px;
          background: #fff;
        }

        table td {
          border: none;
          padding: 4px 0;
          text-align: left;
        }

        table td:before {
          content: attr(data-label) ": ";
          font-weight: bold;
          display: inline-block;
          min-width: 80px;
          color: #666;
        }

        .actions {
          margin-top: 8px;
          padding-top: 8px;
          border-top: 1px solid #eee;
        }
      }

      /* Modal adjustments */
      .modal-content {
        width: 90%;
        max-width: 400px;
        padding: 16px;
      }

      .modal-content h3 {
        font-size: 18px;
      }

      .modal-content label {
        font-size: 14px;
      }

      .modal-content input,
      .modal-content select {
        font-size: 16px; /* Prevent zoom on iOS */
        padding: 12px;
      }

      .modal-content .form-actions {
        flex-direction: column;
        gap: 8px;
      }

      .modal-content button {
        width: 100%;
        padding: 12px;
        font-size: 16px;
      }
    }
  </style>
  <div class="card">
    <h2>Staff Accounts (Deans & Teachers)</h2>
    @if(session('success'))
      <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 6px;">
        {{ session('success') }}
      </div>
    @endif
    @if($errors->any())
      <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px; border-radius: 6px;">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <button class="add-btn" onclick="openModal()">
      <i class="fas fa-user-plus"></i> Add Staff
    </button>

    <!-- Filter Buttons -->
    <div style="margin-bottom: 20px; display: flex; gap: 10px;">
      <a href="{{ route('view.addstaff', ['filter' => 'deans']) }}" class="filter-btn {{ $filter === 'deans' ? 'active' : '' }}" style="padding: 8px 16px; background: {{ $filter === 'deans' ? '#007bff' : '#f0f0f0' }}; color: {{ $filter === 'deans' ? 'white' : '#333' }}; border: 1px solid #ccc; border-radius: 6px; text-decoration: none; font-size: 14px;">Deans</a>
      <a href="{{ route('view.addstaff', ['filter' => 'teachers']) }}" class="filter-btn {{ $filter === 'teachers' ? 'active' : '' }}" style="padding: 8px 16px; background: {{ $filter === 'teachers' ? '#007bff' : '#f0f0f0' }}; color: {{ $filter === 'teachers' ? 'white' : '#333' }}; border: 1px solid #ccc; border-radius: 6px; text-decoration: none; font-size: 14px;">Teachers</a>
    </div>

    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>Staff ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Department</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($deans as $dean)
          <tr>
            <td data-label="Staff ID">D-{{ $dean->id }}</td>
            <td data-label="Name">{{ $dean->name }}</td>
            <td data-label="Email">{{ $dean->username }}</td>
            <td data-label="Role">Dean</td>
            <td data-label="Department">{{ $dean->profile->department->name ?? 'N/A' }}</td>
            <td data-label="Status"><span class="{{ $dean->is_active ? 'status-active' : 'status-inactive' }}">{{ $dean->is_active ? 'Active' : 'Inactive' }}</span></td>
            <td data-label="Actions" class="actions">
              <form method="POST" action="{{ route('admin.dean.suspend', $dean->id) }}" style="display:inline;">
                @csrf
                @method('PATCH')
                <button class="suspend">{{ $dean->is_active ? 'Suspend' : 'Activate' }}</button>
              </form>
              <form method="POST" action="{{ route('admin.dean.destroy', $dean->id) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button class="delete">Delete</button>
              </form>
            </td>
          </tr>
          @endforeach
          @foreach($teachers as $teacher)
          <tr>
            <td data-label="Staff ID">T-{{ $teacher->id }}</td>
            <td data-label="Name">{{ $teacher->name }}</td>
            <td data-label="Email">{{ $teacher->username }}</td>
            <td data-label="Role">Teacher</td>
            <td data-label="Department">{{ $teacher->profile->department->name ?? 'N/A' }}</td>
            <td data-label="Status"><span class="{{ $teacher->is_active ? 'status-active' : 'status-inactive' }}">{{ $teacher->is_active ? 'Active' : 'Inactive' }}</span></td>
            <td data-label="Actions" class="actions">
              <form method="POST" action="{{ route('admin.teacher.suspend', $teacher->id) }}" style="display:inline;">
                @csrf
                @method('PATCH')
                <button class="suspend">{{ $teacher->is_active ? 'Suspend' : 'Activate' }}</button>
              </form>
              <form method="POST" action="{{ route('admin.teacher.destroy', $teacher->id) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button class="delete">Delete</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal" id="addStaffModal">
    <div class="modal-content">
      <span class="close-btn" onclick="closeModal()">&times;</span>
      <form method="POST" action="{{ route('admin.addstaff.store') }}">
        @csrf
        <h3>Create Dean / Teacher Account</h3>

        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" placeholder="Enter full name" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter email" required>

        <label for="role">Role</label>
        <select id="role" name="role" onchange="toggleDepartment()" required>
          <option value="Dean">Dean</option>
          <option value="Teacher">Teacher</option>
        </select>

        <div id="departmentRow">
          <label for="department">Department</label>
          <input type="text" id="department" name="department" placeholder="Enter department">
        </div>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter password" required>

        <div class="form-actions">
          <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
          <button type="submit" class="btn-create">Create Account</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function resetModal() {
      document.getElementById("name").value = '';
      document.getElementById("email").value = '';
      document.getElementById("role").value = 'Dean';
      document.getElementById("department").value = '';
      document.querySelector("#addStaffModal form").action = "{{ route('admin.addstaff.store') }}";
      document.querySelector("#addStaffModal form").method = "POST";
      document.querySelector(".btn-create").textContent = "Create";
      document.querySelector("h3").textContent = "Create Dean / Teacher Account";
      toggleDepartment();
    }

    function openModal() {
      resetModal();
      document.getElementById("addStaffModal").style.display = "flex";
    }
    function closeModal() {
      document.getElementById("addStaffModal").style.display = "none";
      resetModal();
    }

    function toggleDepartment() {
      const role = document.getElementById("role").value;
      const deptRow = document.getElementById("departmentRow");
      const deptInput = document.getElementById("department");
      if (role === "Teacher") {
        deptRow.style.display = "none";
        deptInput.removeAttribute("required");
      } else {
        deptRow.style.display = "block";
        deptInput.setAttribute("required", "required");
      }
    }
  </script>
</x-admin-component>
