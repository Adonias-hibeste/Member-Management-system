<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Payment Form</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('admin/css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        /* Navbar and Sidebar */
        .navbar,
        .sb-sidenav {
            background-color: #FFFFFF !important;
            /* White background */
        }

        .navbar-brand,
        .nav-link,
        .dropdown-item {
            color: #172C41 !important;
            /* Dark blue text */
        }

        .navbar-brand:hover,
        .nav-link:hover,
        .dropdown-item:hover {
            color: #2DCC70 !important;
            /* Green text on hover */
        }

        /* Background */
        body {
            background-color: #E5E5E5 !important;
            /* Light gray background */
        }

        /* Bold text links for Admin Dashboard, Dashboard, Blog Post, Events, etc. */
        .navbar-brand,
        .nav-link,
        .dropdown-item,
        .sb-sidenav-menu-heading,
        .sb-sidenav .nav-link {
            font-weight: bold !important;
            /* Make text bold */
        }

        /* Styling for icons in sidebar to increase visibility */
        .sb-nav-link-icon,
        .fas,
        .fa-tachometer-alt,
        .fa-angle-down {
            color: #172C41 !important;
            /* Dark blue color for icons */
            font-size: 1.2em !important;
            /* Increase icon size */
        }

        /* Specific bold styling for navbar links */
        .navbar-brand.ps-2 {
            font-weight: bold !important;
            color: #172C41 !important;
            /* Consistent dark blue color */
        }


        /* Buttons */
        .btn,
        .btn-link {
            background-color: #2DCC70 !important;
            /* Green background */
            color: #FFFFFF !important;
            /* White text */
            border-color: #2DCC70 !important;
            /* Green border */
        }

        .btn:hover,
        .btn-link:hover {
            background-color: #1EBB5B !important;
            /* Darker green on hover */
            border-color: #1EBB5B !important;
            /* Darker green border on hover */
        }

        /* Text */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p {
            color: #172C41 !important;
            /* Dark blue text */
        }

        small {
            color: #A0A8B1 !important;
            /* Light gray text */
        }

        .navbar-brand {
            margin-right: 40px;
            /* Adjusted spacing */
            font-weight: bold !important;
            /* Bold text */
        }

        .navbar-nav {
            margin-left: auto;
        }

        .sb-sidenav-menu-heading {
            color: #000000 !important;
        }

        /* Bold links in the sidebar */
        #layoutSidenav_nav .nav-link,
        #layoutSidenav_nav .sb-sidenav-menu-heading {
            font-weight: bold !important;
        }

        .payment-form {
            max-width: 600px;
            margin: 50px auto;
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .payment-form h2 {
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-2" href="{{ url('admin/dashboard') }}">Admin Dashboard</a>

        <button class="btn btn-link btn-sm order-0 order-lg-0 ms-5" id="sidebarToggle"><i
                class="fas fa-bars"></i></button>
        <ul class="navbar-nav ms-auto ms-md-45 me-10 me-lg-5">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ route('admin.settings') }}">Settings</a></li>
                    {{-- <li><a class="dropdown-item" href="#!">Activity Log</a></li> --}}
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="{{ route('admin.logout') }}">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="{{ url('admin/dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <div class="sb-sidenav-menu-heading">Manage</div>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseBlogPost" aria-expanded="false" aria-controls="collapseBlogPost">
                            <div class="sb-nav-link-icon">📝</div> <!-- Memo icon -->
                            Blog Post
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseBlogPost" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('admin.createpost') }}">Add Post</a>
                                <a class="nav-link" href="{{ url('/admin/post') }}">View Post</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseNewsUpdates" aria-expanded="false"
                            aria-controls="collapseNewsUpdates">
                            <div class="sb-nav-link-icon">📰</div> <!-- Newspaper icon -->
                            News and Updates
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseNewsUpdates" aria-labelledby="headingTwo"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('admin.createnews') }}">Add News</a>
                                <a class="nav-link" href="{{ url('/admin/news') }}">View News</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseEvents" aria-expanded="false" aria-controls="collapseEvents">
                            <div class="sb-nav-link-icon">🎉</div> <!-- Party popper icon -->
                            Events
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseEvents" aria-labelledby="headingThree"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('admin.createevents') }}">Add Events</a>
                                <a class="nav-link" href="{{ url('/admin/events') }}">View Events</a>
                            </nav>
                        </div>

                        <a class="nav-link" href="{{ route('admin.registeredusers') }}">👤 View Users</a>
                        <a class="nav-link" href="{{ route('admin.payment.form') }}">💳 Payments</a>
                    </div>
                </div>
            </nav>

        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container">
                    <div class="payment-form">
                        <h2>Payment Form</h2>

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
                        @endif


                        <form action="{{ route('admin.payment.process') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="memberName" class="form-label">Member Name</label>
                                <input type="text" class="form-control" id="memberName" name="memberName"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="membershipType" class="form-label">Membership Type</label>
                                <select class="form-select" id="membershipType" name="membershipType" required>
                                    <option selected disabled>Choose Membership Type</option>
                                    <option value="basic">Basic</option>
                                    <option value="premium">Premium</option>
                                    <option value="vip">VIP</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="paymentMethod" class="form-label">Payment Method</label>
                                <select class="form-select" id="paymentMethod" name="paymentMethod" required>
                                    <option selected disabled>Select Payment Method</option>
                                    <option value="telebirr">Telebirr</option>
                                    <option value="m-pesa">M-Pesa</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                </select>
                            </div>
                            <div id="mobileMoneyDetails" style="display:none;">
                                <div class="mb-3">
                                    <label for="phoneNumber" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="phoneNumber" name="phone_number"
                                        placeholder="Enter your mobile number">
                                </div>
                            </div>
                            <div id="bankTransferDetails" style="display:none;">
                                <div class="mb-3">
                                    <label for="bankName" class="form-label">Bank Name</label>
                                    <input type="text" class="form-control" id="bankName" name="bank_name"
                                        placeholder="Enter your bank name">
                                </div>
                                <div class="mb-3">
                                    <label for="accountNumber" class="form-label">Account Number</label>
                                    <input type="text" class="form-control" id="accountNumber"
                                        name="account_number" placeholder="Enter your account number">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount to Pay</label>
                                <input type="number" class="form-control" id="amount" name="amount"
                                    placeholder="Enter amount" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Proceed to Pay</button>
                        </form>
                    </div>
                </div>
            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright © Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            ·
                            <a href="#">Terms & Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('admin/js/scripts.js') }}">
        < /sc> <
        script src = "https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin = "anonymous" >
    </script>
    <script src="{{ asset('admin/js/datatables-simple-demo.js') }}"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('layoutSidenav_nav').classList.toggle('sb-sidenav-toggled');
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('paymentMethod').addEventListener('change', function() {
            var method = this.value;
            document.getElementById('mobileMoneyDetails').style.display = (method === 'telebirr' || method ===
                'm-pesa') ? 'block' : 'none';
            document.getElementById('bankTransferDetails').style.display = (method === 'bank_transfer') ? 'block' :
                'none';
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>