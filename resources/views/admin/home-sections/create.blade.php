@extends('layouts.admin')

@section('title', 'Create Home Section - Admin')
@section('page-title', 'Create Home Page Section')

@section('content')

<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">Create New Section</div>
      <div class="card-body" style="padding: 20px;">
        <form method="POST" action="{{ route('admin.home-sections.store') }}" enctype="multipart/form-data">
          @csrf

          <div class="form-group">
            <label>Section Name (Unique identifier) *</label>
            <input type="text" name="section_name" class="form-control @error('section_name') is-invalid @enderror" value="{{ old('section_name') }}" required placeholder="e.g., hero, about, team, services">
            <small class="form-text text-muted">Use lowercase with hyphens (e.g., hero, about, team, why-us)</small>
            @error('section_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>Title *</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
            @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>Subtitle</label>
            <input type="text" name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle') }}">
            @error('subtitle')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description') }}</textarea>
            @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>Button Text</label>
            <input type="text" name="button_text" class="form-control @error('button_text') is-invalid @enderror" value="{{ old('button_text') }}">
            @error('button_text')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>Button Link</label>
            <input type="text" name="button_link" class="form-control @error('button_link') is-invalid @enderror" value="{{ old('button_link') }}" placeholder="e.g., /services or https://example.com">
            @error('button_link')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" id="image-input" class="form-control @error('image') is-invalid @enderror" accept="image/*">
            <small class="form-text text-muted">Upload an image for this section</small>
            <div id="preview-container" style="margin-top: 15px;"></div>
            @error('image')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>
          <script>
          document.getElementById('image-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
              const reader = new FileReader();
              reader.onload = function(event) {
                let previewContainer = document.getElementById('preview-container');
                previewContainer.innerHTML = '<div style="margin-top: 10px;"><strong>Preview:</strong><br><img src="' + event.target.result + '" style="max-width: 300px; max-height: 300px; border-radius: 5px; margin-top: 10px;"></div>';
              };
              reader.readAsDataURL(file);
            }
          });
          </script>

          <div class="form-group">
            <label>Display Order</label>
            <input type="number" name="display_order" class="form-control @error('display_order') is-invalid @enderror" value="{{ old('display_order', 0) }}" min="0">
            <small class="form-text text-muted">Lower numbers appear first</small>
            @error('display_order')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <!-- Stats Section (for Hero/About/Stats sections) -->
          <div id="stats-section" style="display: none;">
            <div class="form-group">
              <label><strong>Stats Items (Numbers with Labels)</strong></label>
              <small class="form-text text-muted d-block mb-3">Add stat items with a number and label. Examples: 500+|Successful Projects, 98%|Client Satisfaction, 10+|Years Experience</small>
              
              <div id="stats-container">
                <!-- Stats will be added here -->
              </div>

              <button type="button" class="btn btn-sm btn-success" onclick="addStatItem()">+ Add Stat Item</button>
              <input type="hidden" name="content" id="content-field" value="[]">
            </div>
          </div>

          <div class="form-group">
            <label>
              <input type="checkbox" name="is_active" value="1" @if(old('is_active', true)) checked @endif>
              Active (Show on homepage)
            </label>
          </div>

          <button type="submit" class="btn btn-primary">Create Section</button>
          <a href="{{ route('admin.home-sections.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
function showStatsSection() {
  const sectionName = document.querySelector('input[name="section_name"]').value.toLowerCase();
  const statsSection = document.getElementById('stats-section');
  if (sectionName === 'hero' || sectionName === 'about' || sectionName === 'why-us' || sectionName.includes('stats')) {
    statsSection.style.display = 'block';
  } else {
    statsSection.style.display = 'none';
  }
}

function addStatItem() {
  const container = document.getElementById('stats-container');
  const html = `
    <div class="stat-item-group" style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 10px; border-left: 3px solid #007bff;">
      <div style="display: flex; gap: 10px; align-items: flex-start;">
        <div style="flex: 1;">
          <label style="font-size: 0.85rem; color: #666; margin-bottom: 5px; display: block;">Number</label>
          <input type="text" class="form-control stat-number" placeholder="e.g., 850" style="font-weight: 600; font-size: 1.2rem;">
        </div>
        <div style="flex: 2;">
          <label style="font-size: 0.85rem; color: #666; margin-bottom: 5px; display: block;">Label</label>
          <input type="text" class="form-control stat-label" placeholder="e.g., Projects Completed">
        </div>
        <div style="padding-top: 24px;">
          <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.parentElement.remove()">Remove</button>
        </div>
      </div>
    </div>
  `;
  container.insertAdjacentHTML('beforeend', html);
}

// Show stats section based on section name
document.addEventListener('DOMContentLoaded', function() {
  const sectionNameInput = document.querySelector('input[name="section_name"]');
  if (sectionNameInput) {
    sectionNameInput.addEventListener('change', showStatsSection);
    sectionNameInput.addEventListener('blur', showStatsSection);
  }

  // Update hidden field on form submit
  const form = document.querySelector('form');
  if (form) {
    form.addEventListener('submit', function() {
      const stats = [];
      document.querySelectorAll('.stat-item-group').forEach(group => {
        const number = group.querySelector('.stat-number').value;
        const label = group.querySelector('.stat-label').value;
        if (number || label) {
          stats.push({ number, label });
        }
      });
      const contentField = document.getElementById('content-field');
      if (contentField) {
        contentField.value = JSON.stringify(stats);
      }
    });
  }
});
</script>

@endsection
