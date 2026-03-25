@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Edit About Paragraph</h2>

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
            <form action="{{ route('admin.about-paragraphs.update', $aboutParagraph) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $aboutParagraph->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="details" class="form-label">Details <span class="text-danger">*</span></label>
                    <textarea class="form-control editor @error('details') is-invalid @enderror" id="details" name="details" required>{{ old('details', $aboutParagraph->details) }}</textarea>
                    @error('details')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="display_order" class="form-label">Display Order</label>
                    <input type="number" class="form-control @error('display_order') is-invalid @enderror" id="display_order" name="display_order" value="{{ old('display_order', $aboutParagraph->display_order) }}">
                    @error('display_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $aboutParagraph->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        Active
                    </label>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update Paragraph</button>
                    <a href="{{ route('admin.about-paragraphs.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5-super-build.js"></script>
<script>
    const editors = {};
    document.querySelectorAll('.editor').forEach(el => {
        CKEDITOR.SuperBuild
            .create(el, {
                toolbar: {
                    items: [
                        'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'outdent', 'indent'
                    ]
                },
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3' }
                    ]
                }
            })
            .then(editor => {
                editors[el.id] = editor;
            })
            .catch(error => console.error(error));
    });
</script>
@endsection
