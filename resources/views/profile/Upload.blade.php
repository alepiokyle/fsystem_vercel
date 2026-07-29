<x-app-layout>
    <div class="flex pt-0 pb-12 w-full">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-gray-200 shadow-sm rounded-lg p-6 border-r border-gray-700 ml-0">
            <div class="mb-8 text-2xl font-bold text-red-600">
               GradeWise
            </div>
            <nav class="space-y-4">
              
                <a href="#" class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700">
                    <span class="ml-2">Upload Subjects</span>
                </a>
                <a href="#" class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700">
                    <span class="ml-2">View Student Grades</span>
                </a>
                <a href="#" class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700">
                    <span class="ml-2">Teacher Account</span>
                </a>
                <a href="#" class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700">
                    <span class="ml-2">Student Account</span>
                </a>
                <a href="#" class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700">
                    <span class="ml-2">Parent Account</span>
                </a>
                <div class="text-gray-400 uppercase text-xs font-semibold mt-6 mb-2">Others</div>
                <a href="#" class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700">
                    <span class="ml-2">Settings</span>
                </a>
                <a href="#" class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700">
                    <span class="ml-2">Logout</span>
                </a>
            </nav>
        </aside>

        <main class="flex-1 bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-100">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        
        <!-- Total Teachers Card -->
        <div class="bg-gray-800 rounded-lg p-4 shadow">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-400">Total Teachers</h3>
                <i class="fas fa-chalkboard-teacher text-xl text-blue-400"></i>
            </div>
            <p class="mt-1 text-2xl font-semibold text-white">12</p>
            <p class="text-gray-400 text-sm mt-1">Active teachers</p>
        </div>

        <!-- Total Students Card -->
        <div class="bg-gray-800 rounded-lg p-4 shadow">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-400">Total Students</h3>
                <i class="fas fa-user-graduate text-xl text-yellow-300"></i>
            </div>
            <p class="mt-1 text-2xl font-semibold text-white">346</p>
            <p class="text-gray-400 text-sm mt-1">Enrolled students</p>
        </div>

        <!-- Pending Grades Card -->
        <div class="bg-gray-800 rounded-lg p-4 shadow">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-400">Pending Grades</h3>
                <i class="fas fa-clock text-xl text-orange-400"></i>
            </div>
            <p class="mt-1 text-2xl font-semibold text-white">24</p>
            <p class="text-gray-400 text-sm mt-1">Waiting approval</p>
        </div>

        <!-- Notifications Card -->
        <div class="bg-gray-800 rounded-lg p-4 shadow">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-400">Notifications</h3>
                <i class="fas fa-bell text-xl text-green-400"></i>
            </div>
            <p class="mt-1 text-2xl font-semibold text-white">7</p>
            <p class="text-gray-400 text-sm mt-1">Unread alerts</p>
        </div>
        
    </div>