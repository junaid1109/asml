@extends('layouts.admin')

@section('title', 'Edit Portfolio - Admin')
@section('page-title', 'Edit Portfolio Item')

@section('content')

<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">Edit Portfolio Item</div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.portfolios.update', $portfolio) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="form-group mb-3">
            <label>Title *</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $portfolio->title) }}" required>
            @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group mb-3">
            <label>Category</label>
            <input type="text" name="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category', $portfolio->category) }}" placeholder="e.g., Gold, Precious Metals, Mining">
            @error('category')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $portfolio->description) }}</textarea>
            @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group mb-3">
            <label>Image</label>
            @if($portfolio->image)
            <div style="margin-bottom: 10px;">
              <img src="{{ asset('storage/' . $portfolio->image) }}" alt="{{ $portfolio->title }}" style="max-width: 200px; max-height: 150px; border-radius: 4px;">
              <br><small class="text-muted">Current image</small>
            </div>
            @endif
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
            <small class="form-text text-muted">Upload a new image to replace the current one</small>
            @error('image')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group mb-3">
            <label>Link</label>
            <input type="url" name="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link', $portfolio->link) }}" placeholder="https://example.com">
            <small class="form-text text-muted">Link to project or portfolio page</small>
            @error('link')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group mb-3">
            <label>Icon Class</label>
            <input type="text" name="icon" class="form-control @error('icon') is-invalid @enderror" value="{{ old('icon', $portfolio->icon) }}" placeholder="e.g., bi-star, bi-briefcase">
            <small class="form-text text-muted">Bootstrap icon class (optional)</small>
            @error('icon')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group mb-3">
            <label>Display Order</label>
            <input type="number" name="display_order" class="form-control @error('display_order') is-invalid @enderror" value="{{ old('display_order', $portfolio->display_order) }}" min="0">
            <small class="form-text text-muted">Lower numbers appear first</small>
            @error('display_order')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group mb-3">
            <label>
              <input type="checkbox" name="is_active" value="1" @if(old('is_active', $portfolio->is_active)) checked @endif>
              Active (Show on Portfolio page)
            </label>
          </div>

          <button type="submit" class="btn btn-primary">Update Portfolio Item</button>
          <a href="{{ route('admin.portfolios.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
