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
                                    <div class="step-indicator">
                                        <div class="step active" id="step1-indicator">1. Profile</div>
                                        <div class="step" id="step2-indicator">2. Account Details</div>
                                        <div class="step" id="step3-indicator">3. Payment</div>
                                    </div>

                                    <form action="{{ route('admin.registerPost') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="current_step" id="currentStep"
                                            value="{{ $currentStep }}">

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                @foreach ($errors->all() as $error)
                                                    <div>{{ $error }}</div>
                                                @endforeach
                                            </div>
                                        @endif

                                        <!-- Step 1: Profile -->
                                        <div class="step-content" id="step1"
                                            style="display: {{ $currentStep == 1 ? 'block' : 'none' }};">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    @foreach ($errors->all() as $error)
                                                        <div>{{ $error }}</div>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="first_name" type="text"
                                                    value="{{ old('first_name') }}" required />
                                                <label for="first_name">First Name</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="last_name" type="text"
                                                    value="{{ old('last_name') }}" required />
                                                <label for="last_name">Last Name</label>
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
                                                <input class="form-control" name="profile_image" type="file" />
                                                <label for="profile_image">Profile Image</label>
                                            </div>
                                            <button type="button" class="btn btn-primary"
                                                onclick="showStep(2)">Next</button>
                                        </div>

                                        <!-- Step 2: Account Details -->
                                        <div class="step-content" id="step2"
                                            style="display: {{ $currentStep == 2 ? 'block' : 'none' }};">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    @foreach ($errors->all() as $error)
                                                        <div>{{ $error }}</div>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="user_name" type="text"
                                                    value="{{ old('user_name') }}" required />
                                                <label for="user_name">User Name</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="email" type="email"
                                                    value="{{ old('email') }}" required />
                                                <label for="email">Email</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="password" type="password" required />
                                                <label for="password">Password</label>
                                            </div>
                                            <button type="button" class="btn btn-primary"
                                                onclick="showStep(1)">Back</button>
                                            <button type="button" class="btn btn-primary"
                                                onclick="showStep(3)">Next</button>
                                        </div>

                                        <!-- Step 3: Payment -->
                                        <div class="step-content" id="step3"
                                            style="display: {{ $currentStep == 3 ? 'block' : 'none' }};">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    @foreach ($errors->all() as $error)
                                                        <div>{{ $error }}</div>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <div class="mb-3">
                                                <label for="membershipType">Membership Type</label>
                                                <select class="form-select" id="membershipType"
                                                    name="membershipType">
                                                    <option disabled selected>Choose Membership Type</option>
                                                    <option value="basic">Basic</option>
                                                    <option value="premium">Premium</option>
                                                    <option value="vip">VIP</option>
                                                </select>
                                            </div>
                                            <button type="button" class="btn btn-primary"
                                                onclick="showStep(2)">Back</button>
                                            <button class="btn btn-success" type="submit">Sign Up</button>
                                        </div>
                                    </form>

                                    <script>
                                        function showStep(step) {
                                            document.getElementById('currentStep').value = step;
                                            document.getElementById('step1').style.display = step == 1 ? 'block' : 'none';
                                            document.getElementById('step2').style.display = step == 2 ? 'block' : 'none';
                                            document.getElementById('step3').style.display = step == 3 ? 'block' : 'none';
                                        }
                                    </script>


                                    <script>
                                        function showStep(step) {
                                            document.getElementById('currentStep').value = step;
                                            document.getElementById('step1').style.display = step == 1 ? 'block' : 'none';
                                            document.getElementById('step2').style.display = step == 2 ? 'block' : 'none';
                                            document.getElementById('step3').style.display = step == 3 ? 'block' : 'none';
                                        }
                                    </script>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showStep(step) {
            // Hide all steps
            document.querySelector('#step1').style.display = 'none';
            document.querySelector('#step2').style.display = 'none';
            document.querySelector('#step3').style.display = 'none';

            // Show the selected step
            document.querySelector('#step' + step).style.display = 'block';

            // Update step indicator styles
            document.querySelector('#step1-indicator').classList.remove('active');
            document.querySelector('#step2-indicator').classList.remove('active');
            document.querySelector('#step3-indicator').classList.remove('active');
            document.querySelector('#step' + step + '-indicator').classList.add('active');
        }
    </script>
</body>

</html>
