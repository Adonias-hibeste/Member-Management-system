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
            <i class="fas fa-plus"></i>
            Add New News
        </div>
        <div class="card-body">
            <form action="{{ url('admin/createnews') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="name">News Name</label>
                    <input type="text" name="name" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea name="description" id="mysummernote" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label> Upload Image</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Add News</button>
            </form>

        </div>

    </div>




    {{-- <script>
            document.getElementById('sidebarToggle').addEventListener('click', function() {
                document.getElementById('layoutSidenav_nav').classList.toggle('sb-sidenav-toggled');
            });
        </script> --}}
@endsection
