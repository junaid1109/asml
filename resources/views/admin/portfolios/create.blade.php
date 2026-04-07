@extends('layouts.admin')

@section('title', 'Add Portfolio Item - Admin')
@section('page-title', 'Add Portfolio Item')

@section('content')

<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">Create New Portfolio Item</div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.portfolios.store') }}" enctype="multipart/form-data">
          @csrf

          <div class="form-group mb-3">
            <label>Title *</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
            @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group mb-3">
            <label>Category</label>
            <input type="text" name="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category') }}" placeholder="e.g., Gold, Precious Metals, Mining">
            @error('category')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group mb-3">
            <label>Short Description</label>
            <input type="text" name="short_description" class="form-control @error('short_description') is-invalid @enderror" value="{{ old('short_description') }}" placeholder="Brief one-line description" maxlength="255">
            <small class="form-text text-muted">A short description for listing pages (max 255 characters)</small>
            @error('short_description')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control ckeditor @error('description') is-invalid @enderror" id="descriptionEditor" placeholder="Project description...">{{ old('description') }}</textarea>
            @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
            <small class="form-text text-muted">Upload a project image (JPEG, PNG, GIF, WebP)</small>
            @error('image')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group mb-3">
            <label>Banner Image</label>
            <input type="file" name="banner_image" class="form-control @error('banner_image') is-invalid @enderror" accept="image/*">
            <small class="form-text text-muted">Special banner image for the portfolio details page (recommended size: 1200x500px)</small>
            @error('banner_image')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group mb-3">
            <label>Link</label>
            <input type="url" name="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}" placeholder="https://example.com">
            <small class="form-text text-muted">Link to project or portfolio page</small>
            @error('link')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group mb-3">
            <label>Icon Class</label>
            <input type="text" name="icon" class="form-control @error('icon') is-invalid @enderror" value="{{ old('icon') }}" placeholder="e.g., bi-star, bi-briefcase">
            <small class="form-text text-muted">Bootstrap icon class (optional)</small>
            @error('icon')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group mb-3">
            <label>Display Order</label>
            <input type="number" name="display_order" class="form-control @error('display_order') is-invalid @enderror" value="{{ old('display_order', 0) }}" min="0">
            <small class="form-text text-muted">Lower numbers appear first</small>
            @error('display_order')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group mb-3">
            <label>
              <input type="checkbox" name="is_active" value="1" @if(old('is_active', true)) checked @endif>
              Active (Show on Portfolio page)
            </label>
          </div>

          <button type="submit" class="btn btn-primary">Create Portfolio Item</button>
          <a href="{{ route('admin.portfolios.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
