@extends('layouts.admin')

@section('title', 'View Contact - Admin')
@section('page-title', 'Contact Message')

@section('content')

<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">Contact Message Details</div>
      <div class="card-body" style="padding: 20px;">
        <div class="form-group">
          <label><strong>Name:</strong></label>
          <p>{{ $contact->name }}</p>
        </div>

        <div class="form-group">
          <label><strong>Email:</strong></label>
          <p><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
        </div>

        @if($contact->phone)
        <div class="form-group">
          <label><strong>Phone:</strong></label>
          <p>{{ $contact->phone }}</p>
        </div>
        @endif

        <div class="form-group">
          <label><strong>Subject:</strong></label>
          <p>{{ $contact->subject }}</p>
        </div>

        <div class="form-group">
          <label><strong>Message:</strong></label>
          <p>{{ nl2br(e($contact->message)) }}</p>
        </div>

        <div class="form-group">
          <label><strong>Received:</strong></label>
          <p>{{ $contact->created_at->format('M d, Y H:i A') }}</p>
        </div>

        <div>
          <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" style="display:inline;" onsubmit="return confirm('Are you sure?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
          </form>
          <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">Back</a>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
