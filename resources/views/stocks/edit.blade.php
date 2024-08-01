@extends('admin.mainlayout.layout')

@section('title', 'Edit Stock')
@section('page-title', 'Edit Stock')

@section('content')
    <div class="row">
        <div class="container">
            <h1>Edit Stock</h1>

            <!-- Display Validation Errors -->
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

            <form action="{{ route('stocks.update', $stock->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="product_id">Product</label>
                    <select id="product_id" name="product_id" class="form-control" required>
                        <option value="" disabled>Select a product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ $stock->product_id == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="form-control" required min="0" value="{{ $stock->quantity }}">
                </div>

                <div class="form-group">
                    <label for="single_price">Single Price</label>
                    <input type="number" id="single_price" name="single_price" class="form-control" required step="0.01" min="0" value="{{ $stock->product->price }}" readonly>
                </div>

                <div class="form-group">
                    <label for="price">Total Price</label>
                    <input type="number" id="price" name="price" class="form-control" required step="0.01" min="0" value="{{ $stock->price }}" readonly>
                </div>

                <button type="submit" class="btn btn-primary">Update Stock</button>
                <a href="{{ route('stocks.index') }}" class="btn btn-secondary">Back to Stock List</a>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#product_id').change(function() {
                var productId = $(this).val();
                $.ajax({
                    url: '/api/product/' + productId,
                    method: 'GET',
                    success: function(response) {
                        if (response && response.price) {
                            $('#single_price').val(response.price);
                            calculateTotalPrice();
                        } else {
                            console.log('Error: Product price not found.');
                        }
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr.responseText);
                    }
                });
            });

            $('#quantity, #single_price').on('input', function() {
                calculateTotalPrice();
            });

            function calculateTotalPrice() {
                var quantity = $('#quantity').val();
                var singlePrice = $('#single_price').val();
                var totalPrice = quantity * singlePrice;
                $('#price').val(totalPrice.toFixed(2));
            }

            calculateTotalPrice();
        });
    </script>
@endsection
