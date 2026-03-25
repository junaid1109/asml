@extends('layouts.admin')

@section('title', 'Home Sections - Admin')
@section('page-title', 'Home Page Sections')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        Home Page Sections
      </div>
      <div style="overflow-x: auto;">
        <table class="table">
          <thead>
            <tr>
              <th>Section Name</th>
              <th>Title</th>
              <th>Order</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($sections as $section)
            @if($section->section_name != 'advisory_intro' && !str_contains($section->section_name, 'advisory_text_block'))
            <tr>
              <td><strong>{{ ucwords(str_replace('-', ' ', $section->section_name)) }}</strong></td>
              <td>{{ substr($section->title, 0, 50) }}{{ strlen($section->title) > 50 ? '...' : '' }}</td>
              <td>{{ $section->display_order }}</td>
              <td>
                <span class="badge @if($section->is_active) badge-success @else badge-danger @endif">
                  @if($section->is_active) Active @else Inactive @endif
                </span>
              </td>
              <td>
                <a href="{{ route('admin.home-sections.edit', $section) }}" class="btn btn-sm btn-primary">Edit</a>
                <!-- <form method="POST" action="{{ route('admin.home-sections.destroy', $section) }}" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form> -->
              </td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
      </div>

      @if($sections->count() === 0)
      <div style="padding: 20px; text-align: center;">
        <p class="text-muted">No sections found. <a href="{{ route('admin.home-sections.create') }}">Create one</a></p>
      </div>
      @endif
    </div>
  </div>
</div>

@endsection
