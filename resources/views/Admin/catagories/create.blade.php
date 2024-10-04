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
            <i class="fas fa-plus"></i> Add catagory
        </div>
        <div class="card-body">
            <form action="{{ route('admin.catagory.store') }}" method="POST">
                @csrf

                <div class="my-2">
                    <div class="col-12 col-md-6">
                        <label for="name">Catagory Name</label>
                        <input type="text" name="catagory_name" class="form-control">
                    </div>

                </div>

                <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" rows="4"></textarea>
                </div>





                <button type="submit" class="btn btn-primary mt-3">Add catagory</button>
            </form>
        </div>
    </div>


@endsection
