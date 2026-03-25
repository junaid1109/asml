@extends('layouts.admin')

@section('title', 'Settings - Admin')
@section('page-title', 'Settings')

@section('content')

<div class="row">
  <div class="col-md-10">
    <div class="card">
      <div class="card-header">Website Settings</div>
      <div class="card-body" style="padding: 0;">
        
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="settingsTabs" role="tablist" style="border-bottom: 2px solid #e9ecef; padding: 0 20px; margin: 0;">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general-content" type="button" role="tab" aria-controls="general-content" aria-selected="true" style="padding: 15px 20px; border: none; border-bottom: 3px solid transparent;">
              <i class="bi bi-gear"></i> General
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="hero-tab" data-bs-toggle="tab" data-bs-target="#hero-content" type="button" role="tab" aria-controls="hero-content" aria-selected="false" style="padding: 15px 20px; border: none; border-bottom: 3px solid transparent;">
              <i class="bi bi-play-circle"></i> Hero Section
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social-content" type="button" role="tab" aria-controls="social-content" aria-selected="false" style="padding: 15px 20px; border: none; border-bottom: 3px solid transparent;">
              <i class="bi bi-link-45deg"></i> Social Media
            </button>
          </li>
        </ul>

        <style>
          #settingsTabs .nav-link {
            color: #666;
            font-weight: 500;
          }
          #settingsTabs .nav-link:hover {
            color: #0ea5e9;
          }
          #settingsTabs .nav-link.active {
            color: #0ea5e9;
            border-bottom-color: #0ea5e9 !important;
            background: transparent;
          }

          /* Tab pane visibility */
          .tab-pane {
            display: none;
          }

          .tab-pane.show {
            display: block;
          }

          .tab-pane.active {
            display: block;
          }

          .tab-pane.show.active {
            display: block;
          }
        </style>

        <!-- Tabs Content -->
        <div class="tab-content" id="settingsTabContent" style="padding: 20px;">
          <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
            @csrf

            <!-- GENERAL TAB -->
            <div class="tab-pane fade show active" id="general-content" role="tabpanel" aria-labelledby="general-tab">
              <h4 class="mb-3">General Settings</h4>

              <div class="form-group">
                <label>Site Logo</label>
                @if(isset($settings['site_logo']) && $settings['site_logo'])
                <div style="margin-bottom: 10px;">
                  <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Site Logo" style="max-width: 200px; max-height: 100px;">
                  <br><small class="text-muted">Current logo</small>
                </div>
                @endif
                <input type="file" name="site_logo" id="logo-input" class="form-control @error('site_logo') is-invalid @enderror" accept="image/*">
                <small class="form-text text-muted">Upload a new logo to replace the current one. Max 2MB</small>
                <div id="logo-preview" style="margin-top: 15px;"></div>
                @error('site_logo')<span class="invalid-feedback">{{ $message }}</span>@enderror
              </div>

              <script>
              document.getElementById('logo-input')?.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                  const reader = new FileReader();
                  reader.onload = function(event) {
                    let previewContainer = document.getElementById('logo-preview');
                    previewContainer.innerHTML = '<div style="margin-top: 10px;"><strong>Preview:</strong><br><img src="' + event.target.result + '" style="max-width: 200px; max-height: 100px; border-radius: 5px; margin-top: 10px;"></div>';
                  };
                  reader.readAsDataURL(file);
                }
              });
              </script>

              <div class="form-group">
                <label>Favicon</label>
                @if(isset($settings['site_favicon']) && $settings['site_favicon'])
                <div style="margin-bottom: 10px;">
                  <img src="{{ asset('storage/' . $settings['site_favicon']) }}" alt="Favicon" style="max-width: 64px; max-height: 64px; border: 1px solid #ddd; padding: 5px;">
                  <br><small class="text-muted">Current favicon</small>
                </div>
                @endif
                <input type="file" name="site_favicon" id="favicon-input" class="form-control @error('site_favicon') is-invalid @enderror" accept="image/*">
                <small class="form-text text-muted">Upload a favicon (icon that appears in browser tab). Recommended: 32x32 or 64x64 PNG. Max 1MB</small>
                <div id="favicon-preview" style="margin-top: 15px;"></div>
                @error('site_favicon')<span class="invalid-feedback">{{ $message }}</span>@enderror
              </div>

              <script>
              document.getElementById('favicon-input')?.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                  const reader = new FileReader();
                  reader.onload = function(event) {
                    let previewContainer = document.getElementById('favicon-preview');
                    previewContainer.innerHTML = '<div style="margin-top: 10px;"><strong>Preview:</strong><br><img src="' + event.target.result + '" style="max-width: 64px; max-height: 64px; border: 1px solid #ddd; padding: 5px; border-radius: 5px; margin-top: 10px;"></div>';
                  };
                  reader.readAsDataURL(file);
                }
              });
              </script>

              <div class="form-group">
                <label>Site Name</label>
                <input type="text" name="site_name" class="form-control @error('site_name') is-invalid @enderror" value="{{ old('site_name', $settings['site_name'] ?? 'AMS') }}">
                @error('site_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
              </div>

              <div class="form-group">
                <label>Site Tagline</label>
                <input type="text" name="site_tagline" class="form-control @error('site_tagline') is-invalid @enderror" value="{{ old('site_tagline', $settings['site_tagline'] ?? 'Professional Business Solutions') }}">
                @error('site_tagline')<span class="invalid-feedback">{{ $message }}</span>@enderror
              </div>

              <div class="form-group">
                <label>Site Email</label>
                <input type="email" name="site_email" class="form-control @error('site_email') is-invalid @enderror" value="{{ old('site_email', $settings['site_email'] ?? 'info@ams.com') }}">
                @error('site_email')<span class="invalid-feedback">{{ $message }}</span>@enderror
              </div>

              <div class="form-group">
                <label>Site Phone</label>
                <input type="tel" name="site_phone" class="form-control @error('site_phone') is-invalid @enderror" value="{{ old('site_phone', $settings['site_phone'] ?? '') }}">
                @error('site_phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
              </div>

              <div class="form-group">
                <label>Site Fax</label>
                <input type="tel" name="site_fax" class="form-control @error('site_fax') is-invalid @enderror" value="{{ old('site_fax', $settings['site_fax'] ?? '') }}">
                @error('site_fax')<span class="invalid-feedback">{{ $message }}</span>@enderror
              </div>

              <div class="form-group">
                <label>Site Address</label>
                <textarea name="site_address" class="form-control @error('site_address') is-invalid @enderror" rows="3">{{ old('site_address', $settings['site_address'] ?? '') }}</textarea>
                @error('site_address')<span class="invalid-feedback">{{ $message }}</span>@enderror
              </div>

              <div class="form-group">
                <label>Site Description</label>
                <textarea name="site_description" class="form-control @error('site_description') is-invalid @enderror" rows="4">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
                @error('site_description')<span class="invalid-feedback">{{ $message }}</span>@enderror
              </div>

              <div class="form-group">
                <label>Footer Description</label>
                <textarea name="footer_description" class="form-control @error('footer_description') is-invalid @enderror" rows="3">{{ old('footer_description', $settings['footer_description'] ?? '') }}</textarea>
                @error('footer_description')<span class="invalid-feedback">{{ $message }}</span>@enderror
              </div>

              <button type="submit" class="btn btn-primary mt-3">Save Settings</button>
            </div>

            <!-- HERO SECTION TAB -->
            <div class="tab-pane fade" id="hero-content" role="tabpanel" aria-labelledby="hero-tab">
              <h4 class="mb-3">Hero Section Settings</h4>

              <div class="form-group">
                <label>Demo Video URL</label>
                <input type="url" name="demo_video_url" class="form-control @error('demo_video_url') is-invalid @enderror" value="{{ old('demo_video_url', $settings['demo_video_url'] ?? 'https://www.youtube.com/watch?v=Y7f98aduVJ8') }}" placeholder="https://www.youtube.com/watch?v=...">
                <small class="form-text text-muted">YouTube or Vimeo URL for the hero section demo video</small>
                @error('demo_video_url')<span class="invalid-feedback">{{ $message }}</span>@enderror
              </div>

              <div class="form-group">
                <label>Demo Video File Upload</label>
                @if(isset($settings['demo_video_file']) && $settings['demo_video_file'])
                <div style="margin-bottom: 10px;">
                  <video width="200" height="120" controls style="border-radius: 5px;">
                    <source src="{{ asset('storage/' . $settings['demo_video_file']) }}" type="video/mp4">
                    Your browser does not support the video tag.
                  </video>
                  <br><small class="text-muted">Current video</small>
                </div>
                @endif
                <input type="file" name="demo_video_file" id="video-input" class="form-control @error('demo_video_file') is-invalid @enderror" accept="video/mp4,video/webm,video/ogg,video/quicktime,video/x-msvideo">
                <small class="form-text text-muted">Upload MP4, WebM, OGG, MOV, or AVI video files. Max 100MB. Plays if no YouTube/Vimeo URL is set.</small>
                <div id="video-preview" style="margin-top: 15px;"></div>
                @error('demo_video_file')<span class="invalid-feedback">{{ $message }}</span>@enderror
              </div>

              <hr>
              <h4 class="mb-3">Hero Section Button Display</h4>

              <div class="form-group">
                <div class="form-check">
                  <input type="checkbox" name="hero_cta_button_enabled" id="hero_cta_button_enabled" class="form-check-input" value="1" @if($settings['hero_cta_button_enabled'] ?? true)checked @endif>
                  <label class="form-check-label" for="hero_cta_button_enabled">
                    <strong>Enable "Get Started Today" Button</strong>
                    <small class="d-block text-muted">Show/hide the CTA button in the hero section</small>
                  </label>
                </div>
              </div>

              <div class="form-group">
                <div class="form-check">
                  <input type="checkbox" name="demo_video_button_enabled" id="demo_video_button_enabled" class="form-check-input" value="1" @if($settings['demo_video_button_enabled'] ?? true)checked @endif>
                  <label class="form-check-label" for="demo_video_button_enabled">
                    <strong>Enable "Watch Demo" Button</strong>
                    <small class="d-block text-muted">Show/hide the demo video button in the hero section</small>
                  </label>
                </div>
              </div>

              <button type="submit" class="btn btn-primary mt-3">Save Settings</button>
            </div>

            <!-- SOCIAL MEDIA TAB -->
            <div class="tab-pane fade" id="social-content" role="tabpanel" aria-labelledby="social-tab">
              <h4 class="mb-3">Social Media Links</h4>

              <div class="form-group">
                <label>Facebook URL</label>
                <input type="url" name="facebook_url" class="form-control @error('facebook_url') is-invalid @enderror" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}">
                @error('facebook_url')<span class="invalid-feedback">{{ $message }}</span>@enderror
              </div>

              <div class="form-group">
                <label>Twitter URL</label>
                <input type="url" name="twitter_url" class="form-control @error('twitter_url') is-invalid @enderror" value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}">
                @error('twitter_url')<span class="invalid-feedback">{{ $message }}</span>@enderror
              </div>

              <div class="form-group">
                <label>LinkedIn URL</label>
                <input type="url" name="linkedin_url" class="form-control @error('linkedin_url') is-invalid @enderror" value="{{ old('linkedin_url', $settings['linkedin_url'] ?? '') }}">
                @error('linkedin_url')<span class="invalid-feedback">{{ $message }}</span>@enderror
              </div>

              <div class="form-group">
                <label>Instagram URL</label>
                <input type="url" name="instagram_url" class="form-control @error('instagram_url') is-invalid @enderror" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}">
                @error('instagram_url')<span class="invalid-feedback">{{ $message }}</span>@enderror
              </div>

              <button type="submit" class="btn btn-primary mt-3">Save Settings</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById('video-input')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(event) {
        let previewContainer = document.getElementById('video-preview');
        previewContainer.innerHTML = '<div style="margin-top: 10px;"><strong>Preview:</strong><br><video width="200" height="120" controls style="border-radius: 5px; margin-top: 10px;"><source src="' + event.target.result + '" type="video/mp4">Your browser does not support the video tag.</video></div>';
      };
      reader.readAsDataURL(file);
    }
  });

  // Initialize Bootstrap tabs
  document.addEventListener('DOMContentLoaded', function() {
    const triggerTabList = [].slice.call(document.querySelectorAll('#settingsTabs button'));
    triggerTabList.forEach(function(triggerEl) {
      const tabTrigger = new bootstrap.Tab(triggerEl);
      triggerEl.addEventListener('click', function(event) {
        event.preventDefault();
        tabTrigger.show();
      });
    });
  });
</script>

@endsection
