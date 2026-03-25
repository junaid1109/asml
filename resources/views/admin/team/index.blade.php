@extends('layouts.admin')

@section('title', 'Team - Admin')
@section('page-title', 'Team Members Management')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        Team Members
        <a href="{{ route('admin.team.create') }}" class="btn btn-primary" style="float: right;">+ Add Team Member</a>
      </div>
      <div style="overflow-x: auto;">
        <table class="table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Position</th>
              <th>Email</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($teamMembers as $member)
            <tr>
              <td>{{ $member->name }}</td>
              <td>{{ $member->position }}</td>
              <td>{{ $member->email }}</td>
              <td>
                <span class="badge @if($member->published) badge-success @else badge-danger @endif">
                  @if($member->published) Published @else Hidden @endif
                </span>
              </td>
              <td>
                <a href="{{ route('admin.team.edit', $member) }}" class="btn btn-sm btn-primary">Edit</a>
                <form method="POST" action="{{ route('admin.team.destroy', $member) }}" style="display:inline;" onsubmit="return confirm('Are you sure?');">
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
        {{ $teamMembers->links() }}
      </div>
    </div>
  </div>
</div>

@endsection
