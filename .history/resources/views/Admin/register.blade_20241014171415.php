<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Style for the step indicators */
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .step-indicator .step {
            width: 30%;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            background-color: #f1f1f1;
        }

        .step-indicator .step.active {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Create Account</h3>
                                </div>
                                <div class="card-body">
                                    <!-- Step Indicator -->
                                    {{-- <div class="step-indicator">
                                        <div class="step active" id="step1-indicator">1. Profile</div>
                                        <div class="step" id="step2-indicator">2. Account Details</div>
                                        <div class="step" id="step3-indicator">3. Payment</div>
                                    </div> --}}

                                    <form action="{{ route('admin.registerPost') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="step-content">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    @foreach ($errors->all() as $error)
                                                        <div>{{ $error }}</div>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="full_name" type="text"
                                                    value="{{ old('full_name') }}" required />
                                                <label for="full_name">Full Name</label>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="age" type="number" min="18"
                                                    max="100" value="{{ old('age') }}" required />
                                                <label for="age">Age</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="phone_number" type="text"
                                                    value="{{ old('phone_number') }}" required />
                                                <label for="phone_number">Phone Number</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="address" type="text"
                                                    value="{{ old('address') }}" required />
                                                <label for="address">Address</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <select name="gender" class="form-control" required>
                                                    <option value="male"
                                                        {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                                    <option value="female"
                                                        {{ old('gender') == 'female' ? 'selected' : '' }}>Female
                                                    </option>
                                                </select>
                                                <label for="gender">Gender</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="email" type="email"
                                                    value="{{ old('email') }}" required />
                                                <label for="email">Email</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <select name="membership" class="form-control" required>
                                                    @foreach ($memberships as $membership)
                                                        <option value="{{ $membership->id }}"
                                                            {{ old('membership') == $membership->id ? 'selected' : '' }}>
                                                            {{ $membership->name }} / {{ $membership->price }} birr
                                                            per month
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label for="membership">Choose Membership</label>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="password" type="password" required />
                                            <label for="password">Password</label>
                                        </div>


                                        <button class="btn btn-success" type="submit">Sign Up</button>
                                </div>
                                </form>

                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="{{ route('admin.login') }}"> Sign in </a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </main>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
