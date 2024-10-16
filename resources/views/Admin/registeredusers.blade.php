@extends('Admin.Adminlayout.layout')

@section('content')
    <div class="container-fluid px-4">
        <div class="card mt-4">
            <div class="card-header">
                <h4 class="d-flex justify-content-between align-items-center">
                    View Users
                </h4>
            </div>
            <div class="card-body">
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                <ul class="nav nav-tabs" id="manage" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="User_tab" data-bs-toggle="tab" data-bs-target="#Users"
                            type="button" role="tab" aria-controls="user-tab" aria-selected="true">users</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="Staff_tab" data-bs-toggle="tab" data-bs-target="#Staff" type="button"
                            role="tab" aria-controls="staff-tab" aria-selected="false">Staffs</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="Role_tab" data-bs-toggle="tab" data-bs-target="#Roles" type="button"
                            role="tab" aria-controls="role-tab" aria-selected="false">roles</button>
                    </li>
                </ul>
                <div class="tab-content mt-3">

                    <div class="tab-pane fade show active" id="Users">

                        <table class="table table-bordered table-hover">
                            <thead style="background-color: #343a40; color: white;">
                                <tr>
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th>Gender</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Paymentstatus</th>
                                    <th>membership expiry date</th>
                                    <th>Edit</th>


                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($profiles as $profile)
                                    <tr>
                                        <td>{{ $profile->user->id }}</td>
                                        <td>{{ $profile->user->full_name }}</td>
                                        <td>{{ $profile->gender }}</td>
                                        <td>{{ $profile->user->email }}</td>
                                        <td>{{ $profile->phone_number }}</td>
                                        <td>{{ $profile->member_payment_status }}</td>
                                        <td>{{ $profile->membership_endDate }}</td>

                                        <td>
                                            <a href="{{ url('admin/registeredusers/' . $profile->id) }}"
                                                class="btn btn-primary">Edit</a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane fade" id="Staff">
                        <h4 class="d-flex justify-content-between align-items-center">
                            {{-- Staffs --}}
                            <a href="{{ route('admin.createstaff') }}" class="btn btn-primary btn-sm">Add Staffs</a>
                        </h4>
                        <table class="table table-bordered table-hover">
                            <thead style="background-color: #343a40; color: white;">
                                <tr>
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th>Gender</th>
                                    <th>email</th>
                                    <th>phone_number</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            @foreach ($staffs as $staff)
                                <tbody>
                                    <td>{{ $staff->id }}</td>
                                    <td>{{ $staff->full_name }}</td>
                                    <td>{{ $staff->gender }}</td>
                                    <td>{{ $staff->email }}</td>
                                    <td>{{ $staff->phone }}</td>
                                    <td>{{ $staff->address }}</td>
                                    <td>{{ $staff->getRoleNames()->implode(',') }}</td>

                                </tbody>
                            @endforeach
                        </table>
                    </div>
                    <div class="tab-pane fade" id="Roles">
                        <h4 class="d-flex justify-content-between align-items-center">

                            <a href="{{ route('admin.addRole') }}" class="btn btn-primary btn-sm">Add role</a>
                        </h4>
                        <table class="table table-bordered table-hover">
                            <thead style="background-color: #343a40; color: white;">
                                <tr>

                                    <th>Role</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <div class="row g-2">
                                                <div style="margin-left: 12px; width:10px; padding-right: 55px;">

                                                    <a href="#"><i class="fa-solid fa-pen-to-square fa-2x"></i></a>

                                                </div>
                                                <div class="col" style="margin-right: 50px; width:5px;">

                                                    <button class="btn btn-danger btn-sm ms-0"
                                                        onclick="confirmDeletion({{ $role->id }})">X</button>
                                                    <form id="delete-form-{{ $role->id }}" action="#"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('delete')
                                                    </form>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
