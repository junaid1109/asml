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
                    <label for="content-editor" class="form-label">Details <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('details') is-invalid @enderror" id="content-editor" name="details" required>{{ old('details', $aboutParagraph->details) }}</textarea>
                    <div id="content-error" class="invalid-feedback" style="display: none;">Details is required</div>
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

    // Wait for CKEditor to load
    function initializeEditor() {
        if (typeof window.ClassicEditor === 'undefined') {
            setTimeout(initializeEditor, 100);
            return;
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
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeEditor);
    } else {
        initializeEditor();
    }

    // Sync editor data back to textarea before form submission
    document.querySelector('form').addEventListener('submit', function(e) {
        if (contentEditor) {
            const content = contentEditor.getData();
            document.querySelector('#content-editor').value = content;
            
            // Validate content is not empty
            if (!content || content.trim() === '') {
                e.preventDefault();
                document.getElementById('content-error').style.display = 'block';
                document.querySelector('.mb-3').classList.add('has-error');
                return false;
            } else {
                document.getElementById('content-error').style.display = 'none';
                document.querySelector('.mb-3').classList.remove('has-error');
            }
        }
    });
</script>
@endsection
