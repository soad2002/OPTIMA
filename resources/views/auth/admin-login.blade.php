@extends('Const_Layouts.master')

@section('title', 'Admin Login')

@section('content')
<div class="container" style="max-width:480px;margin:40px auto;">
    <h2>Admin Login</h2>
    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label><input type="checkbox" name="remember"> Remember me</label>
        </div>
        <div class="form-group">
            <button type="submit" class="primary-btn">Login</button>
            <a href="{{ route('home') }}" class="btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
