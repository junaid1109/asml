@extends('layouts.admin')

@section('title', 'Create Page - Admin')
@section('page-title', 'Create Page')

@section('content')

<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">Create New Page</div>
      <div class="card-body" style="padding: 20px;">
        <form method="POST" action="{{ route('admin.pages.store') }}" enctype="multipart/form-data">
          @csrf

          <div class="form-group">
            <label>Title *</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
            @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>Page Type</label>
            <select name="page_type" class="form-control @error('page_type') is-invalid @enderror">
              <option value="static" @if(old('page_type') == 'static') selected @endif>Static</option>
              <option value="about" @if(old('page_type') == 'about') selected @endif>About</option>
              <option value="terms" @if(old('page_type') == 'terms') selected @endif>Terms</option>
              <option value="privacy" @if(old('page_type') == 'privacy') selected @endif>Privacy</option>
            </select>
            @error('page_type')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>Display Location *</label>
            <select name="display_location" class="form-control @error('display_location') is-invalid @enderror" required>
              <option value="">-- Select Location --</option>
              <option value="header" @if(old('display_location') == 'header') selected @endif>Header Only</option>
              <option value="footer" @if(old('display_location') == 'footer') selected @endif>Footer Only</option>
              <option value="both" @if(old('display_location', 'both') == 'both') selected @endif>Both Header and Footer</option>
            </select>
            @error('display_location')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>Content *</label>
            <textarea id="content-editor" name="content" class="form-control @error('content') is-invalid @enderror" rows="10">{{ old('content') }}</textarea>
            <div id="content-error" class="invalid-feedback" style="display: none;">Content is required</div>
            @error('content')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
            @error('image')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>Meta Description</label>
            <textarea name="meta_description" class="form-control @error('meta_description') is-invalid @enderror" rows="2">{{ old('meta_description') }}</textarea>
            @error('meta_description')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>Meta Keywords</label>
            <input type="text" name="meta_keywords" class="form-control @error('meta_keywords') is-invalid @enderror" value="{{ old('meta_keywords') }}">
            @error('meta_keywords')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>
              <input type="checkbox" name="published" value="1" @if(old('published', true)) checked @endif>
              Published
            </label>
          </div>

          <button type="submit" class="btn btn-primary">Create Page</button>
          <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  let contentEditor;

  class CustomUploadAdapter {
    constructor(loader) {
      this.loader = loader;
    }

    upload() {
      return this.loader.file.then(file => new Promise((resolve, reject) => {
        const formData = new FormData();
        formData.append('upload', file);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

        fetch('{{ route("admin.upload.image") }}', {
          method: 'POST',
          body: formData,
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.url) {
            resolve({ default: data.url });
          } else {
            reject('Upload failed');
          }
        })
        .catch(error => reject(error));
      }));
    }

    abort() {
      // Abort upload
    }
  }

  ClassicEditor.create(document.querySelector('#content-editor'), {
    toolbar: {
      items: [
        'heading', '|',
        'bold', 'italic', 'underline', 'strikethrough', '|',
        'bulletedList', 'numberedList', '|',
        'link', 'imageUpload', 'blockQuote', 'codeBlock', '|',
        'insertTable', '|',
        'undo', 'redo'
      ]
    },
    heading: {
      options: [
        { model: 'paragraph', title: 'Paragraph' },
        { model: 'heading1', view: 'h1', title: 'Heading 1' },
        { model: 'heading2', view: 'h2', title: 'Heading 2' },
        { model: 'heading3', view: 'h3', title: 'Heading 3' }
      ]
    },
    image: {
      toolbar: ['imageTextAlternative', '|', 'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight', '|', 'imageStyle:full', 'imageStyle:side'],
      styles: [
        'full',
        'side',
        'alignLeft',
        'alignCenter',
        'alignRight'
      ]
    }
  })
  .then(editor => {
    contentEditor = editor;
    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
      return new CustomUploadAdapter(loader);
    };
  })
  .catch(err => console.error('Content Editor:', err));

  // Sync editor data back to textarea before form submission
  document.querySelector('form').addEventListener('submit', function(e) {
    if (contentEditor) {
      const content = contentEditor.getData();
      document.querySelector('#content-editor').value = content;
      
      // Validate content is not empty
      if (!content || content.trim() === '') {
        e.preventDefault();
        document.getElementById('content-error').style.display = 'block';
        document.querySelector('.form-group').classList.add('has-error');
        return false;
      } else {
        document.getElementById('content-error').style.display = 'none';
        document.querySelector('.form-group').classList.remove('has-error');
      }
    }
  });
</script>

@endsection
