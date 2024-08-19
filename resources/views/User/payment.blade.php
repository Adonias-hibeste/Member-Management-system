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
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-2" href="{{ url('user/userdashboard') }}">Member Management System</a>

        <button class="btn btn-link btn-sm order-0 order-lg-0 ms-5" id="sidebarToggle"><i
                class="fas fa-bars"></i></button>
        <ul class="navbar-nav ms-auto ms-md-45 me-10 me-lg-5">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
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
                        <a class="nav-link" href="user.payment">💳 Payments</a>
                    </div>
                </div>
            </nav>
        </div>

        <div class="container">
            <div class="view-account">
                <section class="module">
                    <div class="module-inner">
                        <div class="side-bar">
                            <div class="user-info">
                                <img class="img-profile img-circle img-responsive center-block"
                                    src="https://bootdey.com/img/Content/avatar/avatar1.png" alt />
                                <ul class="meta list list-unstyled">
                                    <li class="name">
                                        Rebecca Sanders
                                        <label class="label label-info">UX Designer</label>
                                    </li>
                                    <li class="email">
                                        <a href="#"><span class="__cf_email__"
                                                data-cfemail="2c7e494e494f4f4d027f6c5b494e5f455849024f4341">[email&#160;protected]</span></a>
                                    </li>
                                    <li class="activity">Last logged in: Today at 2:18pm</li>
                                </ul>
                            </div>
                        </div>
                        <div class="content-panel">
                            <h2 class="title">Billing</h2>
                            <div class="billing">
                                <div class="secure text-center margin-bottom-md">
                                    <h3 class="margin-bottom-md text-success">
                                        <span class="fs1 icon" aria-hidden="true" data-icon=""></span>
                                        Secure credit card payment<br />
                                        <small>This is a secure 128-bit SSL encrypted payment</small>
                                    </h3>
                                    <div class="accepted-cards">
                                        <ul class="list-inline">
                                            <li>
                                                <img src="https://www.uxfordev.com/demo/1.0.6/assets/images/payment-icon-set/icons/visa-curved-32px.png"
                                                    alt="Visa" />
                                            </li>
                                            <li>
                                                <img src="https://www.uxfordev.com/demo/1.0.6/assets/images/payment-icon-set/icons/mastercard-curved-32px.png"
                                                    alt="MasterCard" />
                                            </li>
                                            <li>
                                                <img src="https://www.uxfordev.com/demo/1.0.6/assets/images/payment-icon-set/icons/maestro-curved-32px.png"
                                                    alt="Maestro" />
                                            </li>
                                            <li>
                                                <img src="https://www.uxfordev.com/demo/1.0.6/assets/images/payment-icon-set/icons/american-express-curved-32px.png"
                                                    alt="American Express" />
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <form id="billing" class="form-horizontal" method="Post"
                                    action="{{ route('user.payment.process') }}" role="form">
                                    @csrf
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Name on Card</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Your name" />
                                            <p class="help-block">As it appears on the card</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Card Number </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                placeholder="••••  ••••  ••••  ••••" />
                                            <p class="help-block">
                                                The 16 digits on the front of your credit card.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Expiration Date</label>
                                        <div class="col-sm-9 form-inline">
                                            <select class="form-control">
                                                <option value="01">01</option>
                                                <option value="01">02</option>
                                                <option value="01">03</option>
                                                <option value="01">04</option>
                                                <option value="01">05</option>
                                                <option value="01">06</option>
                                                <option value="01">07</option>
                                                <option value="01">08</option>
                                            </select>
                                            <span class="divider">/</span>
                                            <select class="form-control">
                                                <option value="01">2015</option>
                                                <option value="01">2016</option>
                                                <option value="01">2017</option>
                                                <option value="01">2018</option>
                                                <option value="01">2019</option>
                                                <option value="01">2020</option>
                                                <option value="01">2021</option>
                                                <option value="01">2022</option>
                                            </select>
                                            <p class="help-block">
                                                The date your credit card expires. Find this on the
                                                front of your credit card.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Security Code</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" style="width: 120px"
                                                placeholder="CVC" />
                                            <p class="help-block">
                                                The last 3 digits displayed on the back of your credit
                                                card.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="address">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Address</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder="Address" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-5 col-sm-offset-3">
                                                <input type="text" class="form-control" placeholder="City" />
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control"
                                                    placeholder="Zip/Postal" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-5 col-sm-offset-3">
                                                <input type="text" class="form-control" placeholder="Country" />
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" placeholder="State" />
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="action-wrapper text-center">
                                        <h4 class="notes margin-bottom-sm">
                                            You'll be charged
                                            <span class="text-stronger">$99/year</span>
                                        </h4>
                                        <div class="action-btn">
                                            <button class="btn btn-success btn-lg">
                                                Make Payment
                                                <i class="fa fa-chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
