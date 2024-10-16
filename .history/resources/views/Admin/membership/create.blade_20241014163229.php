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
            <i class="fas fa-plus"></i> Add membership
        </div>
        <div class="card-body">
            <form action="{{ route('admin.membership.store') }}" method="POST">
                @csrf

                <div class="my-2">
                    <div class="col-12 col-md-6">
                        <label for="membership">MemberShip Name</label>
                        <input type="text" name="membership_name" class="form-control">
                    </div>

                </div>

                {{-- <div class="my-2">
                    <div class="col-12 col-md-6">
                        <label for="duration">Duration</label>
                        <select name="duration" class="form-control" required>
                            <option value="">Select Duration</option>
                            <option value="1 month">1 Month</option>
                            <option value="3 months">3 Months</option>
                            <option value="6 months">6 Months</option>
                            <option value="1 year">1 Year</option>

                        </select>
                    </div>
                </div> --}}


                <div class="form-group mb-3">
                    <label for="price">price</label>
                    <input type="text" name="price" class="form-control">
                </div>





                <button type="submit" class="btn btn-primary mt-3">Add membership</button>
            </form>
        </div>
    </div>


@endsection
