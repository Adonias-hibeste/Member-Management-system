@extends('Admin.Adminlayout.layout')

@section('content')
    <div class="container-fluid px-4">
        <div class="card shadow mt-4">
            <h2 class="mb-0">Order Details - #{{ $order->id }}</h2>

            <div class="card-body">
                <!-- Order Info -->
                <div class="mb-6">
                    <h5 class="text-muted">Order Information</h5>
                    <hr>
                    <p><strong>Ordered by:</strong>
                        @if ($order->user)
                            <span class="badge bg-success">{{ $order->user->full_name }}</span>
                        @else
                            <span class="badge bg-danger">User not found</span>
                        @endif
                    </p>
                    <p><strong>Order Date:</strong> <span class="text-muted">{{ $order->order_date }}</span></p>
                    <p><strong>Payment Status:</strong>
                        @if ($order->payment_status == 'Paid')
                            <span class="badge bg-success">Paid</span>
                        @else
                            <span class="badge bg-warning">Pending</span>
                        @endif
                    </p>
                    <p><strong>Total Amount:</strong> <span class="text-muted">{{ $order->total_amount }} birr</span></p>
                </div>

                <!-- Order Items -->
                <div class="mb-4">
                    <h5 class="text-muted">Order Items</h5>
                    <hr>
                    @if ($order->order_item->count() > 0)
                        <table class="table table-bordered table-hover">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>Product Name</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-right">Price (ETB)</th>
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
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-right">{{ $item->price }} birr</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-warning">No items available in this order.</p>
                    @endif
                </div>

                <!-- Show Receipt Button -->
                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#receiptModal">
                    Show Receipt
                </button>
                <a href="{{ route('admin.order.view') }}" class="btn btn-primary">Back to Orders</a>
            </div>
        </div>
    </div>

    <!-- Receipt Modal -->
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="receiptModalLabel">Order Receipt - #{{ $order->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('Admin.reciept.orderReciept', ['order' => $order])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button onclick="window.print()" class="btn btn-primary">Print Receipt</button>
                </div>
            </div>
        </div>
    </div>
@endsection
