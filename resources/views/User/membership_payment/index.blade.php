@extends('User.UserLayout.layout')
@section('content')
    <div class="container">
        <div class="payment-form">
            <h2>Payment Form</h2>
            {{--
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @elseif(isset($success))
                <div class="alert alert-success">
                    {{ $success }}
                </div>
                <a href="{{ route('admin.payment.generate-pdf', ['paymentId' => $paymentId]) }}"
                    class="btn btn-primary mt-3">Download Receipt</a>
            @endif --}}

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <form action="{{ route('user.payment.process') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="memberName" class="form-label">Member Name</label>
                    <input type="text" class="form-control" id="memberName" name="memberName"
                        value="{{ $profile->user->full_name }}" required readonly>
                </div>
                <div class="mb-3">
                    <label for="membershipType" class="form-label">Membership Type</label>
                    <input type="text" class="form-control" id="membershipType" name="membershipType"
                        value="{{ $profile->membership->name }}" required readonly>
                </div>

                <div class="mb-3">
                    <label for="amount" class="form-label">Amount to Pay</label>
                    <input type="number" class="form-control" id="amount" name="amount" value="{{ $amount }}"
                        required readonly>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Proceed to Pay</button>
            </form>
        </div>
    </div>
@endsection
