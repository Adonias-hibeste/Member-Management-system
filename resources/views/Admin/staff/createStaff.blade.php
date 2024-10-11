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
            <i class="fas fa-plus"></i> Add Staff
        </div>
        <div class="card-body">
            <form action="{{ route('admin.staff.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required
                            placeholder="Enter full name" />
                    </div>
                    <div class="col-md-6">
                        <label for="gender" class="form-label">Gender</label>
                        <select name="gender" class="form-select" required>
                            <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required
                            placeholder="Enter email address" />
                    </div>
                    <div class="col-md-6">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" name="phone_number" id="phone_number"
                            value="{{ old('phone_number') }}" required placeholder="Enter phone number" />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" value="{{ old('address') }}" name="address" class="form-control" required
                            placeholder="Enter address" />
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <input class="form-control" name="password" type="password" required placeholder="Enter password" />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="formfile" class="form-label">insert photo</label>
                        <input type="file" value="{{ old('image') }}" name="image" class="form-control" required
                            id="formfile" />
                    </div>

                </div>

                <div class="mb-3">
                    <label for="roles" class="form-label">Assign Roles</label>
                    <div id="roles">
                        @foreach ($roles as $role)
                            <div class="form-check">
                                <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="form-check-input"
                                    id="role-{{ $role->id }}" />
                                <label for="role-{{ $role->id }}" class="form-check-label">{{ $role->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Add Staff</button>
            </form>
        </div>
    </div>
@endsection
