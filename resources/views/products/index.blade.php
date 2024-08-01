@extends('admin.mainlayout.layout')

@section('title', 'Products')
@section('page-title', 'Products List')

@section('content')
    <div class="container">
        <h1>Products</h1>
        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
        
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Sl.No</th>
                    <th>Vendor</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        @php $serial = 1; @endphp
                        <td>{{ $serial++ }}</td>
                        <td>{{ $product->vendor->name ?? 'No Vendor' }}</td>
                        <td>{{ $product->name }}</td>
                        <td>${{ $product->price }}</td>
                        <td>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $products->links() }}
    </div>
@endsection
