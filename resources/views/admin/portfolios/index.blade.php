@extends('layouts.admin')

@section('title', 'Portfolio - Admin')
@section('page-title', 'Portfolio Management')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span>Portfolio Items</span>
        <a href="{{ route('admin.portfolios.create') }}" class="btn btn-primary btn-sm">Add Portfolio Item</a>
      </div>
      <div class="card-body">
        @if($portfolios->isEmpty())
          <p class="text-muted">No portfolio items yet. <a href="{{ route('admin.portfolios.create') }}">Add one now</a>.</p>
        @else
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Order</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($portfolios as $portfolio)
              <tr>
                <td>
                  @if($portfolio->image)
                    <img src="{{ asset('storage/' . $portfolio->image) }}" alt="{{ $portfolio->title }}" style="max-width: 40px; max-height: 40px; margin-right: 10px; border-radius: 4px; vertical-align: middle;">
                  @endif
                  {{ $portfolio->title }}
                </td>
                <td>{{ $portfolio->category ?? '-' }}</td>
                <td>
                  @if($portfolio->is_active)
                    <span class="badge bg-success">Active</span>
                  @else
                    <span class="badge bg-secondary">Inactive</span>
                  @endif
                </td>
                <td>{{ $portfolio->display_order }}</td>
                <td>
                  <a href="{{ route('admin.portfolios.edit', $portfolio) }}" class="btn btn-warning btn-sm">Edit</a>
                  <form method="POST" action="{{ route('admin.portfolios.destroy', $portfolio) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>
  </div>
</div>

@endsection
