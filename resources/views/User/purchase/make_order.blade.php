@extends('User.Userlayout.layout')
@section('content')
    <div class="container">
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="{{ asset('uploads/products/' . $product->images->first()->image) }}" class="card-img-top"
                            alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <p><strong>Price:</strong> {{ $product->unit_price }} birr</p>
                            <p><strong>Available Quantity:</strong> {{ $product->quantity }}</p>

                            @if ($product->quantity > 0)
                                <button class="btn btn-primary add-to-cart" data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}" data-price="{{ $product->unit_price }}"
                                    data-quantity="{{ $product->quantity }}">Add to Cart</button>
                            @else
                                <button class="btn btn-danger" disabled>Sold Out</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Cart Icon -->
        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#cartModal">
            <i class="fas fa-shopping-cart"></i>
            <span class="badge bg-danger cart-count">0</span> <!-- Cart count -->
        </a>

        <!-- Cart Modal (to display selected products) -->
        <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cartModalLabel">Your Cart</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="cartItemsContainer">
                            <!-- Cart items will be dynamically inserted here -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        {{-- id="checkoutButton" --}}
                        <a href="{{ route('user.purchaseOrderDetail') }}"> <button
                                class="btn btn-success">Checkout</button> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Load cart items from server
            loadCart();

            // Add to Cart
            const addToCartButtons = document.querySelectorAll('.add-to-cart');
            addToCartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.dataset.id;

                    fetch('{{ route('user.cart.add') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                product_id: productId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            document.querySelector('.cart-count').innerText = data.cartCount;
                            loadCart(); // Reload cart after adding product
                        })
                        .catch(error => alert(error.message));
                });
            });
        });

        // Load cart items from server
        function loadCart() {
            fetch('{{ route('user.cart.show') }}', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const cartItemsContainer = document.getElementById('cartItemsContainer');
                    cartItemsContainer.innerHTML = ''; // Clear previous cart content

                    if (Object.keys(data.cart).length === 0) {
                        cartItemsContainer.innerHTML = '<p>Your cart is empty.</p>';
                    } else {
                        data.cart.forEach(item => {
                            const totalPrice = (item.quantity * item.unit_price).toFixed(2);
                            const imagePath = item.image ? `/uploads/products/${item.image}` :
                                '/uploads/products/default_image.jpg';

                            cartItemsContainer.innerHTML += `
                            <div class="cart-item mb-3">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img src="${imagePath}" class="img-fluid" alt="${item.name}">
                                    </div>
                                    <div class="col-md-6">
                                        <h6>${item.name}</h6>
                                        <p>Unit Price: ${item.unit_price} birr</p>
                                        <div class="d-flex">
                                            <button class="btn btn-sm btn-danger remove-item-btn" data-id="${item.id}">Remove</button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" class="form-control item-quantity" min="1" max="${item.available_quantity}" value="${item.quantity}" data-id="${item.id}">
                                        <p>Total Price: ${totalPrice} birr</p>
                                    </div>
                                </div>
                            </div>`;
                        });
                    }
                })
                .catch(error => alert('Error loading cart: ' + error.message));
        }

        // Update cart item quantity
        // Update cart item quantity
        document.getElementById('cartItemsContainer').addEventListener('input', function(e) {
            if (e.target.classList.contains('item-quantity')) {
                const productId = e.target.dataset.id;
                const newQuantity = e.target.value;

                fetch('{{ route('user.cart.update') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            quantity: newQuantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            loadCart(); // Reload cart to reflect changes
                        } else {
                            alert(data.error);
                        }
                    })
                    .catch(error => alert('Error updating quantity: ' + error.message));
            }
        });


        // Remove item functionality
        document.getElementById('cartItemsContainer').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-item-btn')) {
                const productId = e.target.dataset.id;

                fetch('{{ route('user.cart.remove') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_id: productId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.querySelector('.cart-count').innerText = data.cartCount;
                        loadCart(); // Reload cart after removing product
                    })
                    .catch(error => alert('Error removing item: ' + error.message));
            }
        });
    </script>


    {{-- addd the script below on the order payment details page --}}


    <style>
        .cart-icon {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 1000;
        }

        .cart-icon .cart-count {
            background-color: red;
            border-radius: 50%;
            padding: 2px 6px;
            margin-left: 5px;
        }

        .modal-dialog {
            max-width: 800px;
        }

        .cart-item {
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
    </style>
@endsection
