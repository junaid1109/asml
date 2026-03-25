@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Features</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.features.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Feature
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Icon</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($features as $feature)
                    <tr>
                        <td>{{ $feature->title }}</td>
                        <td>
                            @if($feature->icon_file)
                            <img src="{{ asset('storage/' . $feature->icon_file) }}" alt="{{ $feature->title }}" style="max-width: 50px; max-height: 50px;">
                            @else
                            <span class="text-muted">No icon</span>
                            @endif
                        </td>
                        <td>
                            @if($feature->is_active)
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $feature->display_order }}</td>
                        <td>
                            <a href="{{ route('admin.features.edit', $feature) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('admin.features.destroy', $feature) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No features found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
