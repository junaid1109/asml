@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>About Paragraphs</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.about-paragraphs.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Paragraph
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
                        <th>Details Preview</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paragraphs as $paragraph)
                    <tr>
                        <td>{{ $paragraph->title }}</td>
                        <td>{{ Str::limit(strip_tags($paragraph->details), 50) }}</td>
                        <td>
                            @if($paragraph->is_active)
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $paragraph->display_order }}</td>
                        <td>
                            <a href="{{ route('admin.about-paragraphs.edit', $paragraph) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('admin.about-paragraphs.destroy', $paragraph) }}" method="POST" style="display:inline;">
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
                        <td colspan="5" class="text-center text-muted">No paragraphs found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
