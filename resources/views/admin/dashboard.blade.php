@extends('Const_Layouts.master')

@section('title', 'Admin Dashboard')

@section('content')
<div class="section admin-dashboard">
    <div class="container">
        <div class="admin-header" style="display:flex;justify-content:space-between;align-items:center;">
            <div>
                <h2>Admin Dashboard</h2>
                <p class="muted">Welcome back, {{ auth()->user()->name }}.</p>
            </div>
            <div>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:inline-block;">
                    @csrf
                    <button class="primary-btn" type="submit">Logout</button>
                </form>
            </div>
        </div>

        <div class="admin-cards" style="display:flex;gap:20px;margin-top:20px;flex-wrap:wrap;">
            <div class="admin-card">
                <div class="card-title">Products</div>
                <div class="card-value">{{ \App\Models\Laptop::count() }}</div>
                <div class="card-action"><a href="{{ route('admin.products.index') }}">Manage products</a></div>
            </div>
            <div class="admin-card">
                <div class="card-title">Users</div>
                <div class="card-value">{{ \App\Models\User::count() }}</div>
                <div class="card-action"><a href="{{ route('admin.users.index') }}">Manage users</a></div>
            </div>
            <div class="admin-card">
                <div class="card-title">Wishlist Items</div>
                <div class="card-value">{{ \App\Models\WishlistItem::count() }}</div>
                <div class="card-action"><a href="{{ route('admin.users.index') }}">View users</a></div>
            </div>
            <div class="admin-card">
                <div class="card-title">Cart Items</div>
                <div class="card-value">{{ \App\Models\CartItem::count() }}</div>
                <div class="card-action"><a href="{{ route('admin.users.index') }}">View carts</a></div>
            </div>
        </div>

        <div class="admin-panels" style="display:flex;gap:20px;margin-top:30px;flex-wrap:wrap;">
            <div class="admin-panel" style="flex:1;min-width:320px;">
                <h4>Recent Products</h4>
                <table class="admin-table">
                    <thead>
                        <tr><th>ID</th><th>Name</th><th>Brand</th><th>Price (DB)</th><th></th></tr>
                    </thead>
                    <tbody>
                    @foreach(\App\Models\Laptop::orderBy('created_at','desc')->limit(8)->get() as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>{{ Str::limit($p->name ?: $p->description, 60) }}</td>
                            <td>{{ $p->brand }}</td>
                            <td>{{ $p->price }}</td>
                            <td><a href="/admin/products/{{ $p->id }}/edit">Edit</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="admin-panel" style="width:360px;min-width:280px;">
                <h4>Recent Users</h4>
                <table class="admin-table compact">
                    <thead>
                        <tr><th>ID</th><th>Name</th><th>Email</th></tr>
                    </thead>
                    <tbody>
                    @foreach(\App\Models\User::orderBy('created_at','desc')->limit(8)->get() as $u)
                        <tr>
                            <td>{{ $u->id }}</td>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div style="margin-top:16px;">
                    <a href="{{ route('admin.users.index') }}" class="primary-btn">View all users</a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
