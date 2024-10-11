@extends('Admin.Adminlayout.layout')
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
            <i class="fas fa-plus"></i> Edit Products
        </div>
        <div class="card-body">
            <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="row g-2 my-2">
                    <div class="col-12 col-md-6">
                        <label for="name">Product Name</label>
                        <input type="text" name="Product_name" value="{{ $product->name }}" class="form-control">
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="name">Product Categories</label>
                        <select name="catagories" class="form-control">
                            @foreach ($catagories as $catagory)
                                <option value="{{ $catagory->id }}"
                                    {{ $catagory->name == $product->catagory->name ? 'selected' : '' }}>
                                    {{ $catagory->name }}</option>
                            @endforeach

                        </select>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ $product->description }}</textarea>
                </div>

                <div class="row g-2 my-2">
                    <div class="col-12 col-md-6">
                        <label for="quantity">Quantity</label>
                        <input type="number" value="{{ $product->quantity }}" name="quantity" class="form-control">

                    </div>

                    <div class="col-12 col-md-6">
                        <label for="unit_price">Unit Price</label>
                        <input type="text" value="{{ $product->unit_price }}" name="unit_price" class="form-control">
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label>Current Product Images</label>
                    <div class="row" id="currentImagePreviewContainer">
                        @foreach ($product->images as $image)
                            <div class="col-md-3 mb-3 current-image">
                                <div class="card">
                                    <img src="{{ asset('uploads/products/' . $image->image) }}" class="card-img-top"
                                        alt="Current Image">
                                    <div class="card-body text-center">
                                        <button type="button"
                                            class="btn btn-danger btn-sm remove-current-image-btn">Remove</button>
                                        <input type="hidden" name="current_images[]" value="{{ $image }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- New Image Upload Section -->
                <div class="form-group mb-3">
                    <label>Images</label>
                    <input type="file" name="images[]" class="form-control" id="images" multiple>
                </div>

                <!-- Preview New Images Section -->
                <label>New Product Images</label>
                <div class="row" id="imagePreviewContainer"></div>


                <button type="submit" class="btn btn-primary mt-3">Edit Product</button>
            </form>
        </div>
    </div>
    <script>
        let selectedFiles = []; // Array to keep track of selected files

        // Handle removal of current images
        document.querySelectorAll('.remove-current-image-btn').forEach(button => {
            button.addEventListener('click', function() {
                const currentImageDiv = this.closest('.current-image');
                currentImageDiv.remove();
            });
        });

        // Handle new image uploads
        document.getElementById('images').addEventListener('change', function(e) {
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            imagePreviewContainer.innerHTML = ''; // Clear existing previews
            selectedFiles = []; // Reset selected files

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
                    selectedFiles.push(file); // Keep track of selected files
                };
                reader.readAsDataURL(file);
            });

            // Handle removal of new image previews
            imagePreviewContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-image-btn')) {
                    const index = e.target.getAttribute('data-index');
                    e.target.closest('.col-md-3').remove();

                    // Remove the file from the selectedFiles array
                    selectedFiles = selectedFiles.filter((_, i) => i !== parseInt(index));
                }
            });
        });

        // Override form submission to attach the new files
        document.querySelector('form').addEventListener('submit', function(e) {
            const dataTransfer = new DataTransfer(); // Create a new DataTransfer object

            // Add the selected files to the DataTransfer object
            selectedFiles.forEach(file => {
                dataTransfer.items.add(file);
            });

            // Override the file input's files property
            document.getElementById('images').files = dataTransfer.files;
        });
    </script>


@endsection
