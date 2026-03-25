@extends('layouts.admin')

@section('title', 'Edit Menu Item')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Edit Menu Item</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.menus.update', $menu) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Label *</label>
                            <input type="text" name="label" class="form-control @error('label') is-invalid @enderror" 
                                   placeholder="e.g., Services, About, Contact" value="{{ old('label', $menu->label) }}" required>
                            @error('label')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Route Name</label>
                            <select name="route_name" class="form-control @error('route_name') is-invalid @enderror">
                                <option value="">-- Select Route --</option>
                                @foreach($routes as $routeName => $label)
                                <option value="{{ $routeName }}" @if(old('route_name', $menu->route_name) == $routeName) selected @endif>
                                    {{ $label }} ({{ $routeName }})
                                </option>
                                @endforeach
                            </select>
                            @error('route_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2">Or enter a custom URL below</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Custom URL</label>
                            <input type="url" name="url" class="form-control @error('url') is-invalid @enderror" 
                                   placeholder="e.g., https://example.com" value="{{ old('url', $menu->url) }}">
                            @error('url')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2">If route is not selected, provide URL here</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Order</label>
                            <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" 
                                   placeholder="0" value="{{ old('order', $menu->order) }}" required>
                            @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2">Lower numbers appear first</small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="active" name="active" value="1" 
                                       @if(old('active', $menu->active)) checked @endif>
                                <label class="form-check-label" for="active">
                                    Active (Show in Menu)
                                </label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Update Menu Item
                            </button>
                            <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
