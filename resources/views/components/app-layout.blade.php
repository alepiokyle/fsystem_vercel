<div class="flex min-h-screen bg-gray-900 text-gray-100">
    @include('Admin.sidebar')

    <main class="flex-1 overflow-y-auto p-6">
        {{ $slot }}
    </main>
</div>
