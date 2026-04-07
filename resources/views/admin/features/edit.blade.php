@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Edit Feature</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.features.update', $feature) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $feature->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $feature->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="icon_file" class="form-label">Icon Image</label>
                    @if($feature->icon_file)
                    <div class="mb-2">
                        <label>Current Icon:</label>
                        <img src="{{ asset('storage/' . $feature->icon_file) }}" alt="{{ $feature->title }}" style="max-width: 150px; max-height: 150px;">
                    </div>
                    @endif
                    <input type="file" class="form-control @error('icon_file') is-invalid @enderror" id="icon_file" name="icon_file" accept="image/*">
                    <small class="form-text text-muted">Leave empty to keep current icon. Accepted: JPEG, PNG, GIF, WebP (Max 2MB)</small>
                    @error('icon_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="display_order" class="form-label">Display Order</label>
                    <input type="number" class="form-control @error('order') is-invalid @enderror" id="display_order" name="order" value="{{ old('order', $feature->order) }}">
                    @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $feature->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        Active
                    </label>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update Feature</button>
                    <a href="{{ route('admin.features.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
