@extends('Admin.Adminlayout.layout')
@section('content')
    <div class="container-fluid px-4">
        <div class="card mt-4">
            <div class="card-header">
                <h4>Order Details - #{{ $order->id }}</h4>
            </div>
            <div class="card-body">
                <p><strong>Ordered by:</strong>
                    @if ($order->user)
                        {{ $order->user->full_name }}
                    @else
                        <span class="text-danger">User not found</span>
                    @endif
                </p>
                <p><strong>Order Date:</strong> {{ $order->order_date }}</p>
                <p><strong>Payment Status:</strong> {{ $order->payment_status }}</p>
                <p><strong>Total Amount:</strong> {{ $order->total_amount }} birr</p>

                <h5>Order Items:</h5>
                @if ($order->order_item->count() > 0)
                    <table class="table table-bordered table-hover">
                        <thead style="background-color: #343a40; color: white;">
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->order_item as $item)
                                <tr>
                                    <td>
                                        @if ($item->product)
                                            {{ $item->product->name }}
                                        @else
                                            <span class="text-danger">Product not found</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->price }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No items available in this order.</p>
                @endif

                <a href="{{ route('admin.order.view') }}" class="btn btn-primary">Back to Orders</a>
            </div>
        </div>
    </div>
@endsection
