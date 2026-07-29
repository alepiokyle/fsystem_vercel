<x-parent-component>
    <div class="container mt-4">
        <h3 class="page-header">📝 Behavior Notes</h3>

        @if($children->count() > 0)
            @foreach($children as $child)
                <!-- Card for Behavior Summary -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Child's Behavior Overview for {{ $child['name'] }}</h5>
                        <p class="text-muted">Here’s a summary based on your child’s recent grades (Average: {{ $child['average'] }}):</p>

                        <!-- Behavior Message based on average grade -->
                        <div class="alert {{ $child['alert_class'] }}">
                            <strong>{{ $child['behavior_title'] }}:</strong> {{ $child['behavior_message'] }}
                        </div>

                        <!-- Optional Teacher Remark -->
                        <div class="alert alert-info">
                            <strong>Teacher's Remark:</strong> {{ $child['remark'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="alert alert-warning">No children found associated with this account.</div>
        @endif
    </div>
</x-parent-component>
