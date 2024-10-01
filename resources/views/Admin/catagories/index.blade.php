@extends('Admin.layout.layout')
@section('content')
    <div class="container-fluid px-4">
        <div class="card mt-4">
            <div class="card-header">
                <h4 class="d-flex justify-content-between align-items-center">
                    Catagories
                    <a href="{{ route('admin.catagory.create') }}" class="btn btn-primary btn-sm">Add catagory</a>
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
                            <th>catagory Name</th>
                            <th>Description</th>

                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($catagories as $catagory)
                            <tr>
                                <td>{{ $catagory->id }}</td>
                                <td>{{ $catagory->name }}</td>
                                <td>{{ $catagory->description }}</td>


                                <td>
                                    <a href="" class="btn btn-primary">Edit</a>

                                    <a href="" class="btn btn-primary"
                                        style="background-color: red; color: white; border-color: red;">Delete</a>
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
