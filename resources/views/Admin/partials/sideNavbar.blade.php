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
                    data-bs-target="#collapseNewsUpdates" aria-expanded="false" aria-controls="collapseNewsUpdates">
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

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseEvents"
                    aria-expanded="false" aria-controls="collapseEvents">
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

                <a class="nav-link" href="{{ route('admin.viewProducts') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> Products
                </a>

                <a class="nav-link" href="{{ route('admin.catagories') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Catagories
                </a>

                <a class="nav-link" href="{{ route('admin.order.view') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>orders
                </a>


                <a class="nav-link" href="{{ route('admin.makeOrder') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>make orders
                </a>

            </div>
        </div>
    </nav>
</div>
