@extends('Admin.Adminlayout.layout')
@section('content')
    <div class="container-fluid px-4">
        <div class="card mt-4">
            <div class="card-header">
                <h4 class="d-flex justify-content-between align-items-center">
                    Products
                    <a href="{{ route('admin.createProduct') }}" class="btn btn-primary btn-sm">Add Product</a>
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
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>quantity</th>
                            <th>unit price</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->unit_price }}</td>

                                <td>
                                    <a href="{{ route('admin.viewProducts.details', $product->id) }}"
                                        class="btn btn-primary">view</a>

                                    <a href="{{ route('admin.product.edit', $product->id) }}"
                                        class="btn btn-primary">Edit</a>

                                    <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure ypu want to remove this product?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>




    {{-- <script>
            document.getElementById('sidebarToggle').addEventListener('click', function() {
                document.getElementById('layoutSidenav_nav').classList.toggle('sb-sidenav-toggled');
            });
        </script> --}}
@endsection
