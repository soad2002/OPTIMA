@extends('Const_Layouts.master')

@section('title', 'Admin - Users')

@section('content')
<div class="container" style="margin:40px auto;">
    <h2>Users</h2>
    <p><a href="{{ route('admin.dashboard') }}">Back to Dashboard</a></p>
    <table class="table">
        <thead>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($users as $u)
                <tr>
                    <td>{{ $u->id }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->role }}</td>
                    <td><!-- future actions --></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>
@endsection
