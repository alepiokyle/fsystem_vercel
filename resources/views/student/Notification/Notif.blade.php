<x-student-components>
    <div class="container mt-4">
        <h3 class="page-header mb-4">🔔 Notifications</h3>

        <!-- Filter & Actions -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <select class="form-select">
                    <option>All Notifications</option>
                    <option>Unread</option>
                    <option>Read</option>
                </select>
            </div>
            <button class="btn btn-sm btn-outline-primary">Mark All as Read</button>
        </div>

        <!-- Notifications List -->
        <div class="list-group shadow-sm">
            @forelse($notifications as $notification)
                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start {{ $notification['is_read'] ? '' : 'bg-light' }}">
                    <div>
                        <h6 class="mb-1"><i class="ti ti-clipboard-check text-success"></i> {{ $notification['title'] }}</h6>
                        <p class="mb-1 small text-muted">{{ $notification['message'] }}</p>
                        <small class="text-primary">{{ $notification['time'] }}</small>
                    </div>
                    @if(!$notification['is_read'])
                        <span class="badge bg-primary rounded-pill">New</span>
                    @endif
                </a>
            @empty
                <div class="list-group-item text-center text-muted">
                    No notifications available.
                </div>
            @endforelse
        </div>
    </div>
</x-student-components>
