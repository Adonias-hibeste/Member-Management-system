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
    <link href="{{asset('admin/css/styles.css')}}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        .navbar-brand {
            margin-right: 40px; /* Adjusted spacing */
        }
        .navbar-nav {
            margin-left: auto;
        }
    </style>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-2" href="{{ url('user/userdashboard') }}">Member Management System</a>

        <button class="btn btn-link btn-sm order-0 order-lg-0 ms-5" id="sidebarToggle"><i class="fas fa-bars"></i></button>
        <ul class="navbar-nav ms-auto ms-md-45 me-10 me-lg-5">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li><hr class="dropdown-divider" /></li>
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

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseBlogPost" aria-expanded="false" aria-controls="collapseBlogPost">
                        <div class="sb-nav-link-icon">📝</div> <!-- Memo icon -->
                        Member Profile
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseBlogPost" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
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
        <h1 class="mt-4">Edit Profile</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Edit Profile</li>
        </ol>
        <div class="card mb-4">
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <div class="card-header">
               <h4>Edit Profiles
               <a href="{{ url('user/profile')}}" class="btn btn-primary float-end" style="background-color: red; color: white;">BACK</a>
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ url('user/updateprofile/'.$profiles->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input type="text" name="name" value="{{ $profiles->name }}" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="placeOfBirth" class="form-label">Place of Birth</label>
                        <input type="text" class="form-control"name="place_of_birth" value="{{ $profiles->place_of_birth }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control"  name="dob" value="{{ $profiles->dob }}"
                               >
                    </div>

                    <div class="form-group mb-3">
                        <label for="fullAddress" class="form-label">Full Address</label>
                        <textarea class="form-control"  name="full_address" >{{ $profiles->full_address }}</textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nationality" class="form-label">Nationality</label>
                        <input type="text" class="form-control" name="nationality"  value="{{ $profiles->nationality }}"
                              >
                    </div>
                    <div class="form-group mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-control"  name="gender">
                            <option value="Male"  {{ $profiles->gender == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $profiles->gender == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control"  name="email" value="{{ $profiles->email }}""
                               >
                    </div>
                    <div class="form-group mb-3">
                        <label for="phoneNumber" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control"  name="phone_number" value="{{ $profiles->phone_number }}"
                              ">
                    </div>

                    <div class="form-group mb-3">
                        <label> Upload Image</label>
                        <input type="file" name="image"  class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="form-label"> Password </label>
                        <input type="password" class="form-control" name="password"
                              >
                    </div>
                    <h4 class="form-title">Type Of Membership</h4>
                    <div class="membership-options">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="membership_type" value="regular" {{ $profiles->membership_type == 'regular' ? 'checked' : '' }}
                                  >
                            <label class="form-check-label" for="regular">Regular (3 months)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="membership_type"  value="gold" {{ $profiles->membership_type == 'gold' ? 'checked' : '' }}
                                   >
                            <label class="form-check-label" for="gold">Gold (6 months)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="membership_type"   value="platinum" {{ $profiles->membership_type == 'platinum' ? 'checked' : '' }}
                                  >
                            <label class="form-check-label" for="platinum">Platinum (12 months)</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Profile</button>
                </form>
            </div>
        </div>
    </div>
</main>

    </div>
</div>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{asset('admin/js/scripts.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="{{asset('admin/js/datatables-simple-demo.js')}}"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            document.getElementById('layoutSidenav_nav').classList.toggle('sb-sidenav-toggled');
        });
    </script>
</body>
</html>
