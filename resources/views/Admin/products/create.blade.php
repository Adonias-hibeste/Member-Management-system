@extends('Admin.layout.layout')
@section('content')
    <div class="card mb-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <div class="card-header">
            <i class="fas fa-plus"></i> Add Products
        </div>
        <div class="card-body">
            <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-2 my-2">
                    <div class="col-12 col-md-6">
                        <label for="name">Product Name</label>
                        <input type="text" name="Product_name" class="form-control">
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="name">Product Categories</label>
                        <select name="catagories" class="form-control">
                            @foreach ($catagories as $catagory)
                                <option value="{{ $catagory->id }}">{{ $catagory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" rows="4"></textarea>
                </div>

                <div class="row g-2 my-2">
                    <div class="col-12 col-md-6">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" class="form-control">

                    </div>

                    <div class="col-12 col-md-6">
                        <label for="unit_price">Unit Price</label>
                        <input type="text" name="unit_price" class="form-control">
                    </div>
                </div>

                <!-- Image Upload Section -->
                <div class="form-group mb-3">
                    <label>Images</label>
                    <input type="file" name="images[]" class="form-control" id="images" multiple>
                </div>

                <!-- Preview Images Section -->
                <div class="row" id="imagePreviewContainer"></div>

                <button type="submit" class="btn btn-primary mt-3">Add Product</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('images').addEventListener('change', function(e) {
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');

            // Clear the previous image previews only when new images are selected
            //  imagePreviewContainer.innerHTML = '';

            // Loop through the selected files and append them to the preview container
            Array.from(e.target.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const imgDiv = document.createElement('div');
                    imgDiv.classList.add('col-md-3', 'mb-3');
                    imgDiv.innerHTML = `
                        <div class="card">
                            <img src="${event.target.result}" class="card-img-top" alt="Image Preview">
                            <div class="card-body text-center">
                                <button type="button" class="btn btn-danger btn-sm remove-image-btn" data-index="${index}">Remove</button>
                            </div>
                        </div>
                    `;
                    imagePreviewContainer.appendChild(imgDiv);
                };
                reader.readAsDataURL(file);
            });

            // Handle removal of image previews
            imagePreviewContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-image-btn')) {
                    const index = e.target.getAttribute('data-index');
                    e.target.closest('.col-md-3').remove();
                    // Set the value of the removed file input to null
                    e.target.closest('form').elements['images[]'][index] = null;
                }
            });
        });
    </script>
@endsection
