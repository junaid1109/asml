@extends('layouts.admin')

@section('title', 'Pages - Admin')
@section('page-title', 'Pages Management')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        Pages
        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary" style="float: right;">+ Add Page</a>
      </div>
      <div style="overflow-x: auto;">
        <table class="table">
          <thead>
            <tr>
              <th>Title</th>
              <th>Slug</th>
              <th>Type</th>
              <th>Status</th>
              <th>Modified</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($pages as $page)
            <tr>
              <td>{{ $page->title }}</td>
              <td>{{ $page->slug }}</td>
              <td>{{ $page->page_type }}</td>
              <td>
                <span class="badge @if($page->published) badge-success @else badge-danger @endif">
                  @if($page->published) Published @else Draft @endif
                </span>
              </td>
              <td>{{ $page->updated_at->format('M d, Y') }}</td>
              <td>
                <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-primary">Edit</a>
                <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div style="padding: 20px;">
        {{ $pages->links() }}
      </div>
    </div>
  </div>
</div>

@endsection
