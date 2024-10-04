@extends('Admin.Adminlayout.layout')

@section('content')
    <div class="container my-5">
        <div class="card">
            <div class="card-header">
                <h2>{{ $product->name }}</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Product Images Carousel -->
                    <div class="col-md-6">
                        @if ($product->images->isNotEmpty())
                            <div id="productImagesCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($product->images as $index => $image)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ asset('uploads/products/' . $image->image) }}"
                                                class="d-block w-100" alt="{{ $product->name }}">
                                        </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#productImagesCarousel"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#productImagesCarousel"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        @else
                            <img src="{{ asset('images/no_image_available.png') }}" class="img-fluid"
                                alt="No image available">
                        @endif
                    </div>

                    <!-- Product Details -->
                    <div class="col-md-6">
                        <h3>Description</h3>
                        <p>{{ $product->description }}</p>

                        <h4>Category</h4>
                        <p>{{ $product->catagory->name }}</p>

                        <h4>Quantity</h4>
                        <p>{{ $product->quantity }}</p>

                        <h4>Unit Price</h4>
                        <p>{{ number_format($product->unit_price, 2) }} birr</p>
                    </div>
                </div>
            </div>

            <!-- Add more details if needed -->
            <div class="card-footer text-end">
                <a href="{{ route('admin.viewProducts') }}" class="btn btn-secondary">Back to Products</a>
            </div>
        </div>
    </div>
@endsection
