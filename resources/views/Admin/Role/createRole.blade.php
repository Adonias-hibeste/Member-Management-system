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
            <i class="fas fa-plus"></i> Add Role
        </div>
        <div class="card-body">
            <form action="{{ route('admin.catagory.store') }}" method="POST">
                @csrf

                <div class="my-2">
                    <div class="col-12 col-md-6">
                        <label for="name">Role Name</label>
                        <input type="text" name="role_name" class="form-control">
                    </div>

                </div>

                <div>
                    <label for="permission">Choose Permission </label>
                </div>
                <div class="form-check">
                    @foreach ($permissions as $permission)
                        <div>
                            <input type="checkbox" name="permission[]" value="{{ $permission->id }}">
                            <label for="permission-{{ $permission->id }}"
                                class="form-check-label">{{ $permission->name }}</label>
                        </div>
                </div>
                @endforeach
        </div>





        <button type="submit" class="btn btn-primary mt-3">Add Role</button>
        </form>
    </div>
    </div>

@endsection
