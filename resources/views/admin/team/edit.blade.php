@extends('layouts.admin')

@section('title', 'Edit Team Member - Admin')
@section('page-title', 'Edit Team Member')

@section('content')

<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">Edit Team Member</div>
      <div class="card-body" style="padding: 20px;">
        <form method="POST" action="{{ route('admin.team.update', $team) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="form-group">
            <label>Name *</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $team->name) }}" required>
            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>Position *</label>
            <input type="text" name="position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position', $team->position) }}" required>
            @error('position')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>Bio</label>
            <textarea name="bio" id="bioEditor" class="form-control @error('bio') is-invalid @enderror" rows="4">{{ old('bio', $team->bio) }}</textarea>
            @error('bio')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>Image</label>
            @if($team->image)
            <div class="mb-2">
              <img src="{{ asset('storage/' . $team->image) }}" alt="Team Member" style="max-width: 200px;">
            </div>
            @endif
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
            @error('image')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $team->email) }}">
            @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $team->phone) }}">
            @error('phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>Twitter URL</label>
            <input type="url" name="twitter" class="form-control @error('twitter') is-invalid @enderror" value="{{ old('twitter', $team->twitter) }}">
            @error('twitter')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>LinkedIn URL</label>
            <input type="url" name="linkedin" class="form-control @error('linkedin') is-invalid @enderror" value="{{ old('linkedin', $team->linkedin) }}">
            @error('linkedin')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>Facebook URL</label>
            <input type="url" name="facebook" class="form-control @error('facebook') is-invalid @enderror" value="{{ old('facebook', $team->facebook) }}">
            @error('facebook')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>Instagram URL</label>
            <input type="url" name="instagram" class="form-control @error('instagram') is-invalid @enderror" value="{{ old('instagram', $team->instagram) }}">
            @error('instagram')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>Order</label>
            <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $team->order) }}">
            @error('order')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>
              <input type="checkbox" name="published" value="1" @if(old('published', $team->published)) checked @endif>
              Published
            </label>
          </div>

          <button type="submit" class="btn btn-primary">Update Team Member</button>
          <a href="{{ route('admin.team.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
  ClassicEditor
    .create(document.getElementById('bioEditor'), {
      toolbar: ['heading', '|', 'bold', 'italic', 'link', '|', 'bulletedList', 'numberedList', '|', 'imageUpload', '|', 'undo', 'redo'],
      image: {
        toolbar: ['imageTextAlternative', '|', 'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight', '|', 'imageStyle:full', 'imageStyle:side'],
        styles: [
          'full',
          'side',
          'alignLeft',
          'alignCenter',
          'alignRight'
        ],
        resizeOptions: [
          {
            name: 'resizeImage:original',
            label: 'Default image width',
            value: null
          },
          {
            name: 'resizeImage:50',
            label: '50% page width',
            value: '50'
          },
          {
            name: 'resizeImage:75',
            label: '75% page width',
            value: '75'
          }
        ],
        resizeUnit: '%',
        upload: {
          types: ['jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff']
        }
      },
      simpleUpload: {
        uploadUrl: '{{ route("admin.upload.image") }}'
      }
    })
    .catch(error => {
      console.error(error);
    });
</script>

@endsection
