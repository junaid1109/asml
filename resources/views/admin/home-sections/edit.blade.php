@extends('layouts.admin')

@section('title', 'Edit Home Section - Admin')
@section('page-title', 'Edit Home Page Section')

@section('content')

<script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/super-build/ckeditor.js"></script>

<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">Edit Section: {{ ucwords(str_replace('-', ' ', $homeSection->section_name)) }}</div>
      <div class="card-body" style="padding: 20px;">
        <form method="POST" action="{{ route('admin.home-sections.update', $homeSection) }}" enctype="multipart/form-data" id="section-form">
          @csrf
          @method('PUT')

          <div class="form-group">
            <label>Section Name (Unique identifier) *</label>
            <input type="text" class="form-control" value="{{ $homeSection->section_name }}" disabled>
            <input type="hidden" name="section_name" value="{{ $homeSection->section_name }}">
            <small class="form-text text-muted">Cannot be changed after creation</small>
          </div>

          @if($homeSection->section_name !== 'section-name')
          <div class="form-group">
            <label>Title *</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $homeSection->title) }}" required>
            @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>
        @if($homeSection->section_name !== 'hero')
          <div class="form-group">
            <label>Subtitle</label>
            <input type="text" name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle', $homeSection->subtitle) }}">
            @error('subtitle')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>
        @if($homeSection->section_name !== 'about')
          <div class="form-group">
            <label>Tagline (Sub-heading below Title)</label>
            <input type="text" name="tagline" class="form-control @error('tagline') is-invalid @enderror" value="{{ old('tagline', $homeSection->tagline) }}" placeholder="e.g., Discover what sets us apart">
            @error('tagline')<span class="invalid-feedback">{{ $message }}</span>@enderror
            <small class="form-text text-muted">This appears below the section title</small>
          </div>
        @endif
        @endif
          @elseif($homeSection->section_name === 'section-name')
          <div class="form-group">
            <label>Title *</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $homeSection->title) }}" required>
            @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>
          @endif

          @if($homeSection->section_name === 'section-name')
          <div class="form-group">
            <label>Subtitle</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $homeSection->description) }}</textarea>
            @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>
          @else
          <div class="form-group">
            <label>Description</label>
            <textarea name="description" id="editor-{{ $homeSection->id }}" class="form-control @error('description') is-invalid @enderror">{{ old('description', $homeSection->description) }}</textarea>
            @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>
          @endif

          @if($homeSection->section_name !== 'section-name')
           @if($homeSection->section_name !== 'hero' && $homeSection->section_name !== 'about')
          <div class="form-group">
            <label>Button Text</label>
            <input type="text" name="button_text" class="form-control @error('button_text') is-invalid @enderror" value="{{ old('button_text', $homeSection->button_text) }}">
            @error('button_text')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>Button Link</label>
            <input type="text" name="button_link" class="form-control @error('button_link') is-invalid @enderror" value="{{ old('button_link', $homeSection->button_link) }}" placeholder="e.g., /services or https://example.com">
            @error('button_link')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>
          @endif
          <div class="form-group">
            <label>Image</label>
            @if($homeSection->image)
            <div style="margin-bottom: 10px;">
              <img src="{{ asset('storage/' . $homeSection->image) }}" alt="{{ $homeSection->title }}" style="max-width: 200px; max-height: 150px;" id="image-preview">
              <br><small class="text-muted">Current image</small>
            </div>
            @endif
            <input type="file" name="image" id="image-input" class="form-control @error('image') is-invalid @enderror" accept="image/*">
            <small class="form-text text-muted">Upload a new image to replace the current one</small>
            <div id="preview-container" style="margin-top: 15px;"></div>
            @error('image')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>
          @endif

          <!-- Clients Section -->
          @if($homeSection->section_name === 'clients')
          <hr>
          <div class="form-group">
            <label><strong>Client Logos</strong></label>
            <small class="form-text text-muted d-block mb-3">Upload and manage client logos. They will display in the carousel on the homepage.</small>

            @php
              $clients = [];
              if (is_array($homeSection->content)) {
                $clients = $homeSection->content;
              } elseif (is_string($homeSection->content) && !empty($homeSection->content)) {
                $decoded = json_decode($homeSection->content, true);
                $clients = (is_array($decoded)) ? $decoded : [];
              }
            @endphp

            @if(count($clients) > 0)
            <div style="background: #d4edda; padding: 10px; border-radius: 5px; margin-bottom: 15px; border-left: 4px solid #28a745;">
              <small class="text-success"><strong>{{ count($clients) }} client logo(s) uploaded.</strong></small>
            </div>
            @else
            <div style="background: #fff3cd; padding: 10px; border-radius: 5px; margin-bottom: 15px; border-left: 4px solid #ffc107;">
              <small class="text-warning"><strong>No client logos yet.</strong></small>
            </div>
            @endif

            <div id="clients-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 15px; margin-bottom: 20px;">
              @foreach($clients as $index => $client)
              <div class="client-item-group" style="background: #f8f9fa; padding: 10px; border-radius: 5px; border: 2px solid #dee2e6; position: relative;">
                <img src="{{ asset('storage/' . $client['image']) }}" alt="Client {{ $index + 1 }}" style="max-width: 100%; max-height: 100px; display: block; margin: 0 auto 10px;">
                <input type="hidden" name="clients[{{ $index }}][image]" value="{{ $client['image'] }}">
                <button type="button" class="btn btn-danger btn-sm btn-block remove-client-btn" style="width: 100%;">Remove</button>
              </div>
              @endforeach
            </div>

            <div style="background: #e7f3ff; padding: 15px; border-radius: 5px; border: 2px dashed #007bff; margin-bottom: 15px;">
              <label style="margin-bottom: 10px; display: block;"><strong>Add New Client Logo</strong></label>
              <input type="file" name="new_client_image" id="new-client-image" class="form-control @error('new_client_image') is-invalid @enderror" accept="image/*">
              <small class="form-text text-muted">Select a logo image file (PNG, JPG, WebP recommended for transparent backgrounds)</small>
              <button type="button" class="btn btn-success btn-sm mt-2" id="add-client-btn">+ Add Client Logo</button>
              @error('new_client_image')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>

            <!-- Hidden container for new files -->
            <div id="new-clients-container" style="display: none;"></div>
          </div>
          @endif

          <!-- Work Process Section -->
          @if($homeSection->section_name === 'work-process')
          <hr>
          <div class="form-group">
            <label><strong>Work Process Steps</strong></label>
            <small class="form-text text-muted d-block mb-3">Manage the process steps displayed on the homepage. Each step includes a number, title, description, and features.</small>

            @php
              $steps = [];
              if (is_array($homeSection->content)) {
                $steps = $homeSection->content;
              } elseif (is_string($homeSection->content) && !empty($homeSection->content)) {
                $decoded = json_decode($homeSection->content, true);
                $steps = is_array($decoded) ? $decoded : [];
              }
            @endphp

            @if(count($steps) > 0)
            <div style="background: #d4edda; padding: 10px; border-radius: 5px; margin-bottom: 15px; border-left: 4px solid #28a745;">
              <small class="text-success"><strong>{{ count($steps) }} step(s) configured.</strong></small>
            </div>
            @else
            <div style="background: #fff3cd; padding: 10px; border-radius: 5px; margin-bottom: 15px; border-left: 4px solid #ffc107;">
              <small class="text-warning"><strong>No steps configured yet.</strong></small>
            </div>
            @endif

            <div id="steps-container">
              @foreach($steps as $index => $step)
              <div class="step-item-group" style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 15px; border-left: 4px solid #007bff;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                  <h5 style="margin: 0;">Step {{ $index + 1 }}</h5>
                  <button type="button" class="btn btn-danger btn-sm remove-step-btn">Remove Step</button>
                </div>

                <div class="row">
                  <div class="col-md-2">
                    <label style="font-size: 0.85rem; color: #666;">Step Number</label>
                    <input type="text" name="steps[{{ $index }}][number]" class="form-control" value="{{ $step['number'] ?? '' }}" placeholder="e.g., 01">
                  </div>
                  <div class="col-md-10">
                    <label style="font-size: 0.85rem; color: #666;">Title</label>
                    <input type="text" name="steps[{{ $index }}][title]" class="form-control" value="{{ $step['title'] ?? '' }}" placeholder="e.g., Research & Analysis">
                  </div>
                </div>

                <div class="form-group mt-3">
                  <label>Description</label>
                  <textarea name="steps[{{ $index }}][description]" class="form-control" placeholder="Step description..." rows="3">{{ $step['description'] ?? '' }}</textarea>
                </div>

                <div class="form-group">
                  <label><strong>Step Image</strong></label>
                  @if(!empty($step['image']))
                  <div style="margin-bottom: 10px;">
                    <img src="{{ asset($step['image']) }}" alt="Step Image" style="max-width: 150px; max-height: 100px;" id="image-preview-{{ $index }}">
                    <br><small class="text-muted">Current image</small>
                  </div>
                  @endif
                  <input type="file" name="steps[{{ $index }}][image_file]" class="form-control step-image-input" data-step="{{ $index }}" accept="image/*">
                  <input type="hidden" name="steps[{{ $index }}][image]" class="step-image-path" value="{{ $step['image'] ?? '' }}">
                  <small class="form-text text-muted">Upload a new image or leave blank to keep current one</small>
                  <div id="preview-container-{{ $index }}" style="margin-top: 10px;"></div>
                </div>

                <div class="form-group">
                  <label><strong>Features</strong></label>
                  <small class="form-text text-muted d-block mb-2">Add key features for this step (icon + text)</small>
                  <div class="features-container" data-step="{{ $index }}">
                    @php $features = $step['features'] ?? []; @endphp
                    @foreach($features as $fIndex => $feature)
                    <div class="feature-item-group" style="display: flex; gap: 10px; margin-bottom: 10px; background: white; padding: 10px; border-radius: 4px; border: 1px solid #dee2e6; align-items: flex-end;">
                      <div style="flex: 1;">
                        <label style="font-size: 0.8rem;">Icon Class</label>
                        <input type="text" name="steps[{{ $index }}][features][{{ $fIndex }}][icon]" class="form-control" value="{{ $feature['icon'] ?? 'bi-check-circle' }}" placeholder="bi-check-circle">
                        <small class="text-muted">Bootstrap icon class</small>
                      </div>
                      <div style="flex: 2;">
                        <label style="font-size: 0.8rem;">Text</label>
                        <input type="text" name="steps[{{ $index }}][features][{{ $fIndex }}][text]" class="form-control" value="{{ $feature['text'] ?? '' }}" placeholder="Feature text">
                      </div>
                      <button type="button" class="btn btn-danger btn-sm remove-feature-btn">×</button>
                    </div>
                    @endforeach
                  </div>
                  <button type="button" class="btn btn-info btn-sm add-feature-btn" data-step="{{ $index }}">+ Add Feature</button>
                </div>
              </div>
              @endforeach
            </div>

            <button type="button" class="btn btn-primary mt-3" id="add-step-btn">+ Add Process Step</button>
          </div>
          @endif

          <div class="form-group">
            <label>Display Order</label>
            <input type="number" name="display_order" class="form-control @error('display_order') is-invalid @enderror" value="{{ old('display_order', $homeSection->display_order) }}" min="0">
            <small class="form-text text-muted">Lower numbers appear first</small>
            @error('display_order')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <!-- Button Display Settings for Portfolio Conclusion -->
          @if($homeSection->section_name === 'portfolio-conclusion')
          <hr>
          <div class="form-group">
            <label><strong>Button Display Settings</strong></label>
            <small class="form-text text-muted d-block mb-3">Control which buttons appear on the frontend.</small>

            <div class="form-check mb-3">
              <input type="checkbox" id="portfolio_cta_button_enabled" name="portfolio_cta_button_enabled" class="form-check-input" value="1" @if(old('portfolio_cta_button_enabled', Setting::value('portfolio_cta_button_enabled') ?? true)) checked @endif>
              <label class="form-check-label" for="portfolio_cta_button_enabled">
                <strong>Enable "Start Conversation" Button</strong>
                <small class="d-block text-muted">Shows the primary CTA button</small>
              </label>
            </div>

            <div class="form-check">
              <input type="checkbox" id="portfolio_more_projects_button_enabled" name="portfolio_more_projects_button_enabled" class="form-check-input" value="1" @if(old('portfolio_more_projects_button_enabled', Setting::value('portfolio_more_projects_button_enabled') ?? true)) checked @endif>
              <label class="form-check-label" for="portfolio_more_projects_button_enabled">
                <strong>Enable "View All Projects" Button</strong>
                <small class="d-block text-muted">Shows the secondary button linking to all projects</small>
              </label>
            </div>
          </div>
          @endif

          <div class="form-group">
            <label>
              <input type="checkbox" name="is_active" value="1" @if(old('is_active', $homeSection->is_active)) checked @endif>
              Active (Show on homepage)
            </label>
          </div>

          <button type="submit" class="btn btn-primary">Update Section</button>
          <a href="{{ route('admin.home-sections.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  
  // ===== FORM REFERENCE =====
  const form = document.querySelector('#section-form');
  
  // ===== CLIENTS SECTION HANDLERS =====
  let clientCounter = 0;
  let clientFiles = []; // Store selected files
  const addClientBtn = document.getElementById('add-client-btn');
  const newClientImageInput = document.getElementById('new-client-image');
  const clientsContainer = document.getElementById('clients-container');

  if (addClientBtn && newClientImageInput) {
    addClientBtn.addEventListener('click', function(e) {
      e.preventDefault();
      const file = newClientImageInput.files[0];
      
      if (!file) {
        alert('Please select an image file');
        return;
      }

      if (!file.type.startsWith('image/')) {
        alert('Please select a valid image file');
        return;
      }

      if (file.size > 2 * 1024 * 1024) {
        alert('File size must be less than 2MB');
        return;
      }

      // Read file as data URL for preview
      const reader = new FileReader();
      reader.onload = function(event) {
        // Store the file object for later upload
        const fileIndex = clientCounter;
        clientFiles[fileIndex] = file;

        // Add preview to the container
        const tempId = 'client_' + clientCounter;
        const html = `
          <div class="client-item-group" id="${tempId}" style="background: #f8f9fa; padding: 10px; border-radius: 5px; border: 2px solid #28a745; position: relative;">
            <img src="${event.target.result}" alt="Client Logo" style="max-width: 100%; max-height: 100px; display: block; margin: 0 auto 10px;">
            <input type="hidden" name="clients[${fileIndex}][preview]" value="true">
            <input type="hidden" class="client-file-index" value="${fileIndex}">
            <small style="display: block; text-align: center; color: #28a745; margin-bottom: 8px; font-size: 0.8rem;">✓ Selected (${file.name})</small>
            <button type="button" class="btn btn-danger btn-sm btn-block remove-client-btn" style="width: 100%;">Remove</button>
          </div>
        `;
        
        if (clientsContainer) {
          clientsContainer.insertAdjacentHTML('beforeend', html);
        }

        clientCounter++;
        newClientImageInput.value = '';
      };
      reader.readAsDataURL(file);
    });
  }

  // Remove Client Button (Event Delegation)
  document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-client-btn')) {
      const clientItem = e.target.closest('.client-item-group');
      if (clientItem) {
        const fileIndex = clientItem.querySelector('.client-file-index')?.value;
        if (fileIndex !== undefined) {
          delete clientFiles[fileIndex];
        }
        clientItem.remove();
      }
    }
  });

  // Handle form submission - upload client files and update form
  if (form) {
    form.addEventListener('submit', function(e) {
      // Don't prevent default - we'll submit after file uploads if needed
      // For now, files are just stored in memory and will be uploaded with the form
      
      if (Object.keys(clientFiles).length > 0) {
        e.preventDefault();
        
        // Create FormData for file uploads
        const uploadFormData = new FormData();
        uploadFormData.append('_token', document.querySelector('input[name="_token"]').value);
        
        // Add files to FormData
        let fileCount = 0;
        Object.keys(clientFiles).forEach((index) => {
          if (clientFiles[index]) {
            uploadFormData.append(`clients_files[${index}]`, clientFiles[index]);
            fileCount++;
          }
        });
        
        if (fileCount > 0) {
          // Show loading state
          const submitBtn = form.querySelector('button[type="submit"]');
          const originalText = submitBtn ? submitBtn.textContent : 'Uploading...';
          if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Uploading files...';
          }
          
          // Upload files first
          fetch('{{ route("admin.upload.image") }}?batch=clients', {
            method: 'POST',
            body: uploadFormData,
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
            }
          })
          .then(response => response.json())
          .then(data => {
            console.log('Batch upload response:', data);
            
            if (data.files && Array.isArray(data.files)) {
              // Update form inputs with uploaded file paths
              data.files.forEach((file) => {
                if (file.index !== undefined && file.path) {
                  const input = form.querySelector(`input[name="clients[${file.index}][preview]"]`);
                  if (input) {
                    input.name = `clients[${file.index}][image]`;
                    input.value = file.path;
                    input.type = 'hidden';
                  }
                }
              });
            }
            
            // Now submit the form
            if (submitBtn) {
              submitBtn.disabled = false;
              submitBtn.textContent = originalText;
            }
            form.submit();
          })
          .catch(error => {
            console.error('File upload error:', error);
            if (submitBtn) {
              submitBtn.disabled = false;
              submitBtn.textContent = originalText;
            }
            alert('Error uploading files: ' + error.message + '. Try again or clear browser cache.');
          });
        } else {
          form.submit();
        }
      }
    });
  }
  
  // Image Preview
  const imageInput = document.getElementById('image-input');
  if (imageInput) {
    imageInput.addEventListener('change', function(e) {
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
  }

  // Stats Counter for unique names
  let statsCounter = {{ count($stats ?? []) }};

  // Add Stat Button
  const addStatBtn = document.getElementById('add-stat-btn');
  if (addStatBtn) {
    addStatBtn.addEventListener('click', function() {
      const container = document.getElementById('stats-container');
      if (!container) return;
      
      const html = `
        <div class="stat-item-group" style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 10px; border-left: 3px solid #007bff;">
          <div style="display: flex; gap: 10px; align-items: flex-start;">
            <div style="flex: 1;">
              <label style="font-size: 0.85rem; color: #666; margin-bottom: 5px; display: block;">Number</label>
              <input type="text" name="stats[${statsCounter}][number]" class="form-control stat-number" placeholder="e.g., 850" style="font-weight: 600; font-size: 1.2rem;">
            </div>
            <div style="flex: 2;">
              <label style="font-size: 0.85rem; color: #666; margin-bottom: 5px; display: block;">Label</label>
              <input type="text" name="stats[${statsCounter}][label]" class="form-control stat-label" placeholder="e.g., Projects Completed">
            </div>
            <div style="padding-top: 24px;">
              <button type="button" class="btn btn-danger btn-sm remove-stat-btn">Remove</button>
            </div>
          </div>
        </div>
      `;
      container.insertAdjacentHTML('beforeend', html);
      statsCounter++;
    });
  }

  // Remove Stat Button (Event Delegation)
  document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-stat-btn')) {
      e.target.closest('.stat-item-group').remove();
    }
  });

  // Initialize CKEditor for description field
  @if($homeSection->section_name !== 'section-name')
  const editorId = 'editor-{{ $homeSection->id }}';
  const editorElement = document.getElementById(editorId);
  
  if (editorElement && typeof ClassicEditor !== 'undefined') {
    let editor = null;
    
    ClassicEditor
      .create(editorElement, {
        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo'],
        ckfinder: {
          uploadUrl: "{{ route('admin.upload.image') }}"
        }
      })
      .then(instance => {
        editor = instance;
        
        // Before form submission, sync editor data to textarea
        if (form) {
          form.addEventListener('submit', function(e) {
            if (editor) {
              const data = editor.getData();
              editorElement.value = data;
            }
          });
        }
      })
      .catch(error => {
        console.error('CKEditor error:', error);
      });
  }
  @endif

  // ===== WORK PROCESS HANDLERS =====
  @php
    $stepsForJs = [];
    if ($homeSection->section_name === 'work-process') {
      if (is_array($homeSection->content)) {
        $stepsForJs = $homeSection->content;
      } elseif (is_string($homeSection->content) && !empty($homeSection->content)) {
        $decoded = json_decode($homeSection->content, true);
        $stepsForJs = is_array($decoded) ? $decoded : [];
      }
    }
  @endphp
  let stepCounter = {{ count($stepsForJs) }};
  let featureCounters = {};
  let stepImageFiles = {}; // Store step image files for upload

  const addStepBtn = document.getElementById('add-step-btn');
  if (addStepBtn) {
    addStepBtn.addEventListener('click', function() {
      const container = document.getElementById('steps-container');
      if (!container) return;

      featureCounters[stepCounter] = 0;

      const html = `
        <div class="step-item-group" style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 15px; border-left: 4px solid #007bff;">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h5 style="margin: 0;">Step ${stepCounter + 1}</h5>
            <button type="button" class="btn btn-danger btn-sm remove-step-btn">Remove Step</button>
          </div>

          <div class="row">
            <div class="col-md-2">
              <label style="font-size: 0.85rem; color: #666;">Step Number</label>
              <input type="text" name="steps[${stepCounter}][number]" class="form-control" placeholder="e.g., 01">
            </div>
            <div class="col-md-10">
              <label style="font-size: 0.85rem; color: #666;">Title</label>
              <input type="text" name="steps[${stepCounter}][title]" class="form-control" placeholder="e.g., Research & Analysis">
            </div>
          </div>

          <div class="form-group mt-3">
            <label>Description</label>
            <textarea name="steps[${stepCounter}][description]" class="form-control" placeholder="Step description..." rows="3"></textarea>
          </div>

          <div class="form-group">
            <label><strong>Step Image</strong></label>
            <input type="file" name="steps[${stepCounter}][image_file]" class="form-control step-image-input" data-step="${stepCounter}" accept="image/*">
            <input type="hidden" name="steps[${stepCounter}][image]" class="step-image-path" value="">
            <small class="form-text text-muted">Upload a step image</small>
            <div id="preview-container-${stepCounter}" style="margin-top: 10px;"></div>
          </div>

          <div class="form-group">
            <label><strong>Features</strong></label>
            <small class="form-text text-muted d-block mb-2">Add key features for this step (icon + text)</small>
            <div class="features-container" data-step="${stepCounter}"></div>
            <button type="button" class="btn btn-info btn-sm add-feature-btn" data-step="${stepCounter}">+ Add Feature</button>
          </div>
        </div>
      `;

      container.insertAdjacentHTML('beforeend', html);
      stepCounter++;
    });
  }

  // Handle step image preview and file storage
  document.addEventListener('change', function(e) {
    if (e.target.classList.contains('step-image-input')) {
      const file = e.target.files[0];
      const stepIndex = e.target.getAttribute('data-step');
      const previewContainer = document.getElementById(`preview-container-${stepIndex}`);

      if (file) {
        if (!file.type.startsWith('image/')) {
          alert('Please select a valid image file');
          return;
        }

        if (file.size > 2 * 1024 * 1024) {
          alert('File size must be less than 2MB');
          return;
        }

        // Store file for later upload
        stepImageFiles[stepIndex] = file;

        // Show preview
        const reader = new FileReader();
        reader.onload = function(event) {
          previewContainer.innerHTML = `
            <div style="background: #e7f3ff; padding: 10px; border-radius: 5px; border: 2px solid #007bff;">
              <img src="${event.target.result}" style="max-width: 150px; max-height: 100px; display: block; margin-bottom: 8px; border-radius: 4px;">
              <small style="display: block; color: #007bff; font-size: 0.9rem;">✓ Selected (${file.name})</small>
            </div>
          `;
        };
        reader.readAsDataURL(file);
      }
    }
  });

  // Remove Step (Event Delegation)
  document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-step-btn')) {
      e.target.closest('.step-item-group').remove();
    }

    // Add Feature
    if (e.target.classList.contains('add-feature-btn')) {
      const stepIndex = e.target.getAttribute('data-step');
      const container = e.target.parentElement.querySelector('.features-container');

      if (!featureCounters[stepIndex]) {
        featureCounters[stepIndex] = container ? container.querySelectorAll('.feature-item-group').length : 0;
      }

      const featureIndex = featureCounters[stepIndex];
      const html = `
        <div class="feature-item-group" style="display: flex; gap: 10px; margin-bottom: 10px; background: white; padding: 10px; border-radius: 4px; border: 1px solid #dee2e6; align-items: flex-end;">
          <div style="flex: 1;">
            <label style="font-size: 0.8rem;">Icon Class</label>
            <input type="text" name="steps[${stepIndex}][features][${featureIndex}][icon]" class="form-control" value="bi-check-circle" placeholder="bi-check-circle">
            <small class="text-muted">Bootstrap icon class</small>
          </div>
          <div style="flex: 2;">
            <label style="font-size: 0.8rem;">Text</label>
            <input type="text" name="steps[${stepIndex}][features][${featureIndex}][text]" class="form-control" placeholder="Feature text">
          </div>
          <button type="button" class="btn btn-danger btn-sm remove-feature-btn">×</button>
        </div>
      `;
      container.insertAdjacentHTML('beforeend', html);
      featureCounters[stepIndex]++;
    }

    // Remove Feature
    if (e.target.classList.contains('remove-feature-btn')) {
      e.target.closest('.feature-item-group').remove();
    }
  });

  // Handle form submission for work-process step images
  if (form && @php echo $homeSection->section_name === 'work-process' ? 'true' : 'false'; @endphp) {
    form.addEventListener('submit', function(e) {
      if (Object.keys(stepImageFiles).length > 0) {
        e.preventDefault();

        // Create FormData for file uploads
        const uploadFormData = new FormData();
        uploadFormData.append('_token', document.querySelector('input[name="_token"]').value);

        // Add files to FormData
        let fileCount = 0;
        Object.keys(stepImageFiles).forEach((stepIndex) => {
          if (stepImageFiles[stepIndex]) {
            uploadFormData.append(`step_images[${stepIndex}]`, stepImageFiles[stepIndex]);
            fileCount++;
          }
        });

        if (fileCount > 0) {
          // Show loading state
          const submitBtn = form.querySelector('button[type="submit"]');
          const originalText = submitBtn ? submitBtn.textContent : 'Uploading...';
          if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Uploading step images...';
          }

          // Upload files first
          fetch('{{ route("admin.upload.image") }}?batch=steps', {
            method: 'POST',
            body: uploadFormData,
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
            }
          })
          .then(response => response.json())
          .then(data => {
            console.log('Step images upload response:', data);

            if (data.files && Array.isArray(data.files)) {
              // Update form inputs with uploaded file paths
              data.files.forEach((file) => {
                if (file.index !== undefined && file.path) {
                  const pathInput = form.querySelector(`input[name="steps[${file.index}][image]"].step-image-path`);
                  if (pathInput) {
                    pathInput.value = file.path;
                  }
                }
              });
            }

            // Now submit the form
            if (submitBtn) {
              submitBtn.disabled = false;
              submitBtn.textContent = originalText;
            }
            form.submit();
          })
          .catch(error => {
            console.error('Step image upload error:', error);
            if (submitBtn) {
              submitBtn.disabled = false;
              submitBtn.textContent = originalText;
            }
            alert('Error uploading step images: ' + error.message);
          });
        } else {
          form.submit();
        }
      }
    });
  }

});
</script>

@endsection