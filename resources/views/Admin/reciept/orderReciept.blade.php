<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head>

<body class="bg-gray-100 text-gray-900 antialiased min-h-screen flex items-center justify-center">
    <section class="bg-white shadow-lg rounded-lg w-full max-w-3xl p-8">
        <!-- Logo and Title -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center space-x-4">
                <!-- Company Logo -->
                <img src="{{ asset('uploads/logo/companylogo.png') }}" alt="Company Logo"
                    class="w-16 h-16 object-cover">
                <div>
                    <h1 class="text-3xl font-bold uppercase tracking-wide">Receipt</h1>
                    <p class="text-sm text-gray-600">Transaction Ref: {{ $order->tx_ref }}</p>
                </div>
            </div>
            <!-- Print Button -->
            {{-- <div id="printButton">
                <button onclick="window.print()" class="text-gray-500 hover:text-black transition duration-200">
                    Print Receipt
                </button>
            </div> --}}
        </div>

        <!-- Business & Customer Info -->
        <div class="flex justify-between mb-8">
            <div>
                <h2 class="font-semibold text-lg">From:</h2>
                <p>Test Business</p>
                <p>TIN: Test TIN</p>
                <p>Phone: 09123456789</p>
                <p>Address: Test Address</p>
            </div>
            <div class="text-right">
                <h2 class="font-semibold text-lg">To:</h2>
                <p>{{ $order->user->full_name }}</p>
                <p>Email: {{ $order->user->email }}</p>
                <p>Phone: {{ $order->orderDetail->phone }}</p>
                <p>Address: {{ $order->orderDetail->city }},Woreda: {{ $order->orderDetail->woreda }}, House No:
                    {{ $order->orderDetail->house_no }}</p>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="border-t border-gray-300 pt-4 mb-6">
            <h3 class="text-xl font-semibold mb-3">Order Summary</h3>
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-gray-600 border-b">
                        <th class="pb-2">Product</th>
                        <th class="pb-2 text-right">Quantity</th>
                        <th class="pb-2 text-right">Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->order_item as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td class="text-right">{{ $item->quantity }}</td>
                            <td class="text-right">{{ $item->price }} ETB</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Payment Details -->
        <div class="border-t border-gray-300 pt-4">
            <h3 class="text-xl font-semibold mb-3">Payment Details</h3>
            <p><strong>Status:</strong> {{ $order->payment_status }}</p>
            <p><strong>Payment Date:</strong> {{ $order->order_date }}</p>
            <p><strong>Total Amount Paid:</strong> {{ $order->total_amount }} ETB</p>
        </div>

        <!-- Footer -->
        <footer class="mt-8 text-center text-sm text-gray-500">
            <p>Thank you for choosing Test Business!</p>
        </footer>
    </section>

    <script>
        function printReceipt() {
            window.print();
        }
    </script>
</body>

</html>
