
@extends('admin.mainlayout.layout')

@section('title', 'Stock')
@section('page-title', 'Stock')

@section('content')
    <div class="row">
        <div class="container">
            <h1>Stock Management</h1>
    
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <a href="{{ route('stocks.create') }}" class="btn btn-primary mb-3">Add Stock</a>

            <table class="table">
                <thead>
                    <tr>
                        <th>Sl.No</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $serial = 1; @endphp
                    @foreach($stocks as $stock)
                        <tr>
                            <td>{{ $serial++ }}</td>
                            <td>{{ $stock->product->name }}</td>
                            <td>{{ $stock->quantity }}</td>
                            <td>{{ $stock->price }}</td>
                            <td>
                                <a href="{{ route('stocks.edit', $stock->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $stocks->links() }}
            
        </div>
    </div>
@endsection

