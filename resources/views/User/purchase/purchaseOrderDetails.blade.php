@extends('User.UserLayout.layout')
@section('content')
    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif
                            <h3 class="text-center">Checkout Details</h3>
                            <form action="{{ route('checkout') }}" method="POST">
                                @csrf
                                <div class="form-floating mb-3">
                                    <input class="form-control @error('name') is-invalid @enderror" name="name"
                                        type="text" value="{{ old('name') }}" required />
                                    <label for="name">Name</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input class="form-control @error('email') is-invalid @enderror" name="email"
                                        type="email" value="{{ old('email') }}" required />
                                    <label for="email">Email</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input class="form-control @error('phone') is-invalid @enderror" name="phone"
                                        type="number" value="{{ old('phone') }}" required />
                                    <label for="phone">Phone Number</label>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input class="form-control @error('city') is-invalid @enderror" name="city"
                                        type="text" value="{{ old('city') }}" required />
                                    <label for="city">City</label>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input class="form-control @error('woreda') is-invalid @enderror" name="woreda"
                                        type="text" value="{{ old('woreda') }}" required />
                                    <label for="woreda">Woreda</label>
                                    @error('woreda')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input class="form-control @error('house_no') is-invalid @enderror" name="house_no"
                                        type="text" value="{{ old('house_no') }}" required />
                                    <label for="house_no">House No.</label>
                                    @error('house_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <button class="btn btn-primary btn-block" id="checkoutButton">Complete Checkout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- <script>
        document.getElementById('checkoutButton').addEventListener('click', function() {
            fetch('{{ route('checkout') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        alert('Order placed successfully!');
                        window.location.reload(); // Reload page or redirect as necessary
                    } else {
                        alert('Error: ' + data.error);
                    }
                })
                .catch(error => alert('Checkout error: ' + error.message));
        });
    </script> --}}
@endsection
