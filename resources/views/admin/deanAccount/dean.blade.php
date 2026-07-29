<x-admin-component>
    <style>
        body {
            background-color: #e6e9ec;
            font-family: Arial, sans-serif;
            color: #333;
        }

        /* Card style for the table container */
        .glass-card {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .glass-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        /* Table style */
        .glass-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }

        .glass-table thead {
            background: #f0f0f0;
        }

        .glass-table th, .glass-table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
            vertical-align: middle;
        }

        /* Badges */
        .badge {
            font-size: 0.8rem;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .bg-light-success { background: #e8f5e9; color: #388e3c; }
        .bg-light-danger { background: #ffebee; color: #c62828; }

        /* Buttons */
        .btn {
            font-size: 0.8rem;
            padding: 5px 10px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }

        .btn-warning {
            background: #fff3e0;
            color: #f57c00;
        }

        .btn-info {
            background: #e0f7fa;
            color: #0288d1;
        }
    </style>

    <x-slot:page_title>
        Dean Accounts
    </x-slot>

    <div class="page-header mb-4">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Dean Accounts Management</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dean Accounts</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Dean Accounts Table -->
    <div class="glass-card">
        <?php
        $deans = [
            ['name' => 'John Smith', 'department' => 'Computer Science', 'status' => 'Active', 'last_login' => '2025-08-10 14:30'],
            ['name' => 'Maria Santos', 'department' => 'Business Administration', 'status' => 'Suspended', 'last_login' => '2025-08-09 09:12']
        ];
        ?>
        <table class="glass-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Last Login</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($deans as $dean): ?>
                    <tr>
                        <td><?= $dean['name'] ?></td>
                        <td><?= $dean['department'] ?></td>
                        <td>
                            <span class="badge <?= $dean['status'] === 'Active' ? 'bg-light-success' : 'bg-light-danger' ?>">
                                <?= $dean['status'] ?>
                            </span>
                        </td>
                        <td><?= $dean['last_login'] ?></td>
                        <td>
                            <button class="btn btn-warning">Suspend / Activate</button>
                            <button class="btn btn-info">Reset Password</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</x-admin-component>
