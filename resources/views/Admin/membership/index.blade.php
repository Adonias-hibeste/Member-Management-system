@extends('Admin.Adminlayout.layout')
@section('content')
    <div class="container-fluid px-4">
        <div class="card mt-4">
            <div class="card-header">
                <h4 class="d-flex justify-content-between align-items-center">
                    Membership
                    <a href="{{ route('admin.membership.create') }}" class="btn btn-primary btn-sm">Add Membership</a>
                </h4>
            </div>
            <div class="card-body">
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                <table class="table table-bordered table-hover">
                    <thead style="background-color: #343a40; color: white;">
                        <tr>
                            <th>ID</th>
                            <th>MemberShip_Type</th>

                            <th>Price</th>

                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($memberships as $membership)
                            <tr>
                                <td>{{ $membership->id }}</td>
                                <td>{{ $membership->name }}</td>

                                <td>{{ $membership->price }}</td>


                                <td>
                                    <a href="{{ route('admin.membership.edit', $membership->id) }}"
                                        class="btn btn-primary">Edit</a>


                                    <form action="{{ route('admin.membership.destroy', $membership->id) }}" method="POST"
                                        style="display: inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this membership type?')">Delete</button>

                                    </form>
                                    {{-- <a href="" class="btn btn-primary"
                                        style="background-color: red; color: white; border-color: red;">Delete</a> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>




    {{-- <script>
            document.getElementById('sidebarToggle').addEventListener('click', function() {
                document.getElementById('layoutSidenav_nav').classList.toggle('sb-sidenav-toggled');
            });
        </script> --}}
@endsection
