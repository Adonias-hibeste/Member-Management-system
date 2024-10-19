@extends('Admin.Adminlayout.layout')
@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus"></i> Edit membership
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <div class="card-body">
            <form action="{{ route('admin.membership.edit', $membership->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="my-2">
                    <div class="col-12 col-md-6">
                        <label for="membership">MemberShip Name</label>
                        <input type="text" name="membership_name" value="{{ $membership->name }}" class="form-control">
                    </div>

                </div>

                <div class="form-group mb-3">
                    <label for="price">price</label>
                    <input type="text" name="price" class="form-control" value="{{ $membership->price }}">
                </div>





                <button type="submit" class="btn btn-primary mt-3">Edit membership</button>
            </form>
        </div>
    </div>


@endsection
