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
        const selectedFiles = []; // Array to keep track of selected files

        document.getElementById('images').addEventListener('change', function(e) {
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            // Clear previous previews
            imagePreviewContainer.innerHTML = '';

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
                                <button type="button" class="btn btn-danger btn-sm remove-image-btn" data-index="${selectedFiles.length}">Remove</button>
                            </div>
                        </div>
                    `;
                    imagePreviewContainer.appendChild(imgDiv);
                    selectedFiles.push(file); // Keep track of selected files
                };
                reader.readAsDataURL(file);
            });

            // Handle removal of image previews
            imagePreviewContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-image-btn')) {
                    const index = e.target.getAttribute('data-index');
                    e.target.closest('.col-md-3').remove();
                    // Remove the file from the selectedFiles array
                    selectedFiles.splice(index, 1);
                    // Update the data-index for subsequent images
                    updateDataIndex();
                }
            });
        });

        // Update data-index for all remaining image buttons
        function updateDataIndex() {
            const buttons = document.querySelectorAll('.remove-image-btn');
            buttons.forEach((button, index) => {
                button.setAttribute('data-index', index);
            });
        }

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
