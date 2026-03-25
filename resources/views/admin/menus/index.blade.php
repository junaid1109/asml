@extends('layouts.admin')

@section('title', 'Menu Management')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Menu Items</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Menu Item
            </a>
        </div>
    </div>

    @if($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(count($menus) > 0)
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Order</th>
                        <th>Label</th>
                        <th>Route/URL</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="menu-list">
                    @foreach($menus as $menu)
                    <tr class="menu-item" data-id="{{ $menu->id }}" draggable="true">
                        <td>
                            <input type="number" class="form-control form-control-sm order-input" value="{{ $menu->order }}" style="width: 80px;">
                        </td>
                        <td>{{ $menu->label }}</td>
                        <td>
                            @if($menu->route_name)
                            <span class="badge bg-info">{{ $menu->route_name }}</span>
                            @else
                            <span class="badge bg-secondary">{{ $menu->url }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge @if($menu->active) bg-success @else bg-danger @endif">
                                @if($menu->active) Active @else Inactive @endif
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <!-- <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form> -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        <button id="save-order" class="btn btn-success">
            <i class="bi bi-check-circle"></i> Save Order
        </button>
    </div>
    @else
    <div class="alert alert-info">
        No menu items yet. <a href="{{ route('admin.menus.create') }}">Create one</a>
    </div>
    @endif
</div>

<script>
document.getElementById('save-order').addEventListener('click', function() {
    const items = [];
    document.querySelectorAll('.menu-item').forEach((row, index) => {
        items.push({
            id: row.dataset.id,
            order: row.querySelector('.order-input').value
        });
    });

    fetch('{{ route("admin.menus.reorder") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
        },
        body: JSON.stringify({ items: items })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            alert('Menu order saved successfully!');
            location.reload();
        }
    });
});

// Drag and drop reordering
let draggedRow = null;

document.querySelectorAll('.menu-item').forEach(row => {
    row.addEventListener('dragstart', function() {
        draggedRow = this;
        this.style.opacity = '0.5';
    });

    row.addEventListener('dragend', function() {
        this.style.opacity = '1';
    });

    row.addEventListener('dragover', function(e) {
        e.preventDefault();
        if(this !== draggedRow) {
            this.parentNode.insertBefore(draggedRow, this);
        }
    });
});
</script>
@endsection
