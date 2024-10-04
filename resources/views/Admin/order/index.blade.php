@extends('Admin.Adminlayout.layout')
@section('content')
    <div class="container-fluid px-4">
        <div class="card mt-4">
            <div class="card-header">
                <h4 class="d-flex justify-content-between align-items-center">
                    Order List
                </h4>
            </div>
            <div class="card-body">
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                <table class="table table-bordered table-hover">
                    <thead style="background-color: #343a40; color: white;">
                        <tr>
                            <th>ID</th>
                            <th>Ordered by</th>
                            <th>Order Date</th>
                            <th>Payment Status</th>
                            <th>Total Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>
                                    @if ($order->user)
                                        {{ $order->user->full_name }}
                                    @else
                                        <span class="text-danger">User not found</span>
                                    @endif
                                </td>

                                <td>{{ $order->order_date }}</td>

                                <td>
                                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select name="payment_status" class="form-control payment-status-dropdown"
                                            {{ $order->payment_status == 'paid' ? 'disabled' : '' }}>
                                            <option value="pending"
                                                {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>
                                                Paid</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-success mt-2">Update</button>
                                    </form>
                                </td>

                                <td>{{ $order->total_amount }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary">View</a>
                                    <form action="{{ route('admin.orders.delete', $order->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this order?');">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Disable the dropdown once "Paid" is selected
        document.querySelectorAll('.payment-status-dropdown').forEach(function(dropdown) {
            dropdown.addEventListener('change', function() {
                if (this.value === 'paid') {
                    this.disabled = true;
                }
            });
        });
    </script>
@endsection
