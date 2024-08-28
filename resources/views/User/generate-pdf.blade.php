<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .details {
            margin-bottom: 20px;
        }

        .details strong {
            display: inline-block;
            width: 150px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>{{ $title }}</h2>
        <h2>{{ $date }}</h2>

        <div class="details">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Membership Type</th>
                        <th>Payment Method</th>
                        <th>Amount</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payment as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->member_name }}</td>
                            <td>{{ $user->membership_type }}</td>
                            <td>{{ $user->payment_method }}</td>
                            <td>{{ $user->amount }}</td>
                            <td>{{ $user->created_at->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="footer">
            <p>Thank you for visiting!</p>
        </div>
    </div>
</body>

</html>
