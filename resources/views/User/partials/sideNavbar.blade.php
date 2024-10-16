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
                <a class="nav-link" href="{{ route('user.membership.payment') }}">💳 Payments</a>
                <a class="nav-link" href="{{ route('user.makeOrder') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>make orders
                </a>
            </div>
        </div>
    </nav>
</div>
