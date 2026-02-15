@extends('Const_Layouts.master')

@section('title', 'Admin - Products')

@section('content')
<div class="container" style="margin:40px auto;">
    <h2>Products</h2>
    <p><a href="{{ route('admin.dashboard') }}">Back to Dashboard</a></p>
    <table class="table">
        <thead>
            <tr><th>ID</th><th>Name</th><th>Price</th><th>Brand</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($products as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->price }}</td>
                    <td>{{ $p->brand }}</td>
                    <td><a href="/admin/products/{{ $p->id }}/edit">Edit</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $products->links() }}
</div>
@endsection
