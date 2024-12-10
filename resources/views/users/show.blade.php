@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Details</h1>

    <div class="card mb-3">
        <div class="card-header">
            <h2>{{ $user->name }}</h2>
        </div>
        <div class="card-body">
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Status:</strong> <span class="badge {{ $user->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                {{ ucfirst($user->status) }}
            </span></p>
            <p><strong>Roles:</strong>
                @foreach($user->roles as $role)
                    <span class="badge bg-primary">{{ $role->name }}</span>
                @endforeach
            </p>
        </div>
        <div class="card-footer">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to Users</a>
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit User</a>
        </div>
    </div>
</div>
@endsection
