<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Member Management System</title>
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

        /* Adjusted style for a smaller dashboard image */
        .dashboard-image {
            width: 100%;
            max-width: 400px;
            height: auto;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            object-fit: cover;
            margin: 20px auto;
            display: block;
        }

        .dashboard-image:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-2" href="{{ url('user/userdashboard') }}">Member Management</a>

        <button class="btn btn-link btn-sm order-0 order-lg-0 ms-5" id="sidebarToggle"><i
                class="fas fa-bars"></i></button>
        <ul class="navbar-nav ms-auto ms-md-45 me-10 me-lg-5">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    {{-- <li><a class="dropdown-item" href="#!">Activity Log</a></li> --}}
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="{{ route('user.logout') }}">Logout</a></li>
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
                        <a class="nav-link" href="{{ url('user/userdashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <div class="sb-sidenav-menu-heading">Manage</div>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseBlogPost" aria-expanded="false" aria-controls="collapseBlogPost">
                            <div class="sb-nav-link-icon">📝</div> <!-- Memo icon -->
                            Member Profile
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseBlogPost" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('user.createprofile') }}">Register Member</a>
                                <a class="nav-link" href="{{ url('/user/profile') }}">View Profile</a>
                            </nav>
                        </div>


                        <a class="nav-link" href="{{ route('user.eventRegister') }}">👤 Register for Events</a>
                        <a class="nav-link" href="{{ route('user.payment.form') }}">💳 Payments</a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="row">
                        <img src="{{ asset('admin/images/imageU.jpg') }}" alt="Dashboard Image" class="dashboard-image">
                        <img src="{{ asset('admin/images/imgU.jpg') }}" alt="Dashboard Image" class="dashboard-image">
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">Total Registered Member
                                    <h2>{{ $registered_member }}</h2>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="{{ url('') }}">View
                                        Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Total Registered Events
                                    <h2>{{ $event_registers }}</h2>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link"
                                        href="{{ url('/user/eventRegister') }}">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">
                                    Total Payment Paid
                                    <h2>{{ $payment_made }}</h2>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="{{ url('') }}">View
                                        Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>





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
    <script src="{{ asset('admin/js/scripts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('admin/js/datatables-simple-demo.js') }}"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('layoutSidenav_nav').classList.toggle('sb-sidenav-toggled');
        });
    </script>
</body>

</html>
