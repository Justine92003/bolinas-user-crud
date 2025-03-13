@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Details</h1>
    <p><strong>ID:</strong> {{ $user->id }}</p>
    <p><strong>Name:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit User</a>
    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete User</button>
    </form>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to User List</a>
</div>
@endsection