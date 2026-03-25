@extends('layouts.admin')

@section('title', 'Contacts - Admin')
@section('page-title', 'Contact Messages')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">Contact Messages</div>
      <div style="overflow-x: auto;">
        <table class="table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Subject</th>
              <th>Date</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($contacts as $contact)
            <tr style="@if(!$contact->is_read) background-color: #f0f8ff; @endif">
              <td>{{ $contact->name }}</td>
              <td>{{ $contact->email }}</td>
              <td>{{ $contact->subject }}</td>
              <td>{{ $contact->created_at->format('M d, Y H:i') }}</td>
              <td>
                <span class="badge @if($contact->is_read) badge-success @else badge-warning @endif">
                  @if($contact->is_read) Read @else Unread @endif
                </span>
              </td>
              <td>
                <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-sm btn-primary">View</a>
                <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" style="display:inline;" onsubmit="return confirm('Are you sure?');">
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
        {{ $contacts->links() }}
      </div>
    </div>
  </div>
</div>

@endsection
