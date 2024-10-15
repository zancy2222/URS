<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['account_type'] != 1) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URSMFEMSS Homepage</title>
    <!--BOOTSTRAP LINK-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>

        @font-face { 
        font-family: "Hussar Bold Web Edition";
        src: url("https://db.onlinewebfonts.com/t/60020c76d48f22e20a23b37c056cb339.eot");
        src: url("https://db.onlinewebfonts.com/t/60020c76d48f22e20a23b37c056cb339.eot?#iefix")format("embedded-opentype"),
        url("https://db.onlinewebfonts.com/t/60020c76d48f22e20a23b37c056cb339.woff2")format("woff2"),
        url("https://db.onlinewebfonts.com/t/60020c76d48f22e20a23b37c056cb339.woff")format("woff"),
        url("https://db.onlinewebfonts.com/t/60020c76d48f22e20a23b37c056cb339.ttf")format("truetype"),
        url("https://db.onlinewebfonts.com/t/60020c76d48f22e20a23b37c056cb339.svg#Hussar Bold Web Edition")format("svg");
        }

        .navbar-brand {
            font-family: Hussar Bold Web Edition;
        }  

        #mainNavbar {
            height: auto;
        }
            
        #mainNavbar .navbar-brand {
            font-size: 1em;
        } 

        .bg-primary-custom {
            background-color: #004AAD !important;
        }

        .navbar-nav .nav-item .nav-link {
            background-color: white;
            font-size: 12px;
        }
        
        #mainNavbar .navbar-nav .nav-item .nav-link {
            color:#004AAD;
            padding:2px;
            padding-left:5px;
            width: 180px;
            height: 25px;
        }

        #mainNavbar .navbar-nav .nav-item .nav-link img {
            width: 20px; height: 20px;
        }

        #mainNavbar .dropdown-menu .dropdown-item {
            font-size: 13px; color: #004AAD; padding: 0px; margin-right:5px;
        }
        
        .dropdown-item {
            font-size: 12px;
        }

        /*dropdown images sizing*/
        #mainNavbar .dropdown-menu .dropdown-item img {
            width: 20px; height: 20px; margin:5px;
        }

        .navbar-nav .nav-item {
            margin-right: 15px; 
        }

        @media only screen and (max-width: 960px) {
        #mainNavbar .navbar-brand {
            font-size: 1em;
            font-weight: bold;
        } 

        .navbar-nav .nav-item .nav-link {
            background-color: white;
            font-size: 12px;
        }
        
        .dropdown-item {
            font-size: 10px;
        }

        .navbar-nav .nav-item {
            margin-right: 5px; 
        }
        }

        
        .legend-section {
            margin-top: 20px;
        }

        .legend-title {
            font-family: 'Arial', sans-serif;
            font-weight: bold;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }

        .status-approve {
            background-color: green;
        }

        .status-pending {
            background-color: blue;
        }

        .status-reject {
            background-color: red;
        }

        .status-onhold {
            background-color: orange;
        }

        .upcoming-events-section {
            background-color: #004AAD;
            color: white;
            padding: 15px;
        }

        .event-list {
            height: 300px;
            overflow-y: auto;
            background-color: white;
            color: white;
            padding: 15px;
            margin-top: 10px;
        }

        .table {
            margin-top: 15px;
            background-color: white;
        }

        /* Dropdown container styling */
        .mb-3 {
            margin-bottom: 1.5rem;
            /* Adjust spacing as needed */
        }

        /* Label styling */
        .form-label {
            font-family: 'Microsoft Sans Serif', sans-serif;
            /* Font family */
            font-size: 16px;
            /* Font size */
            font-weight: 600;
            /* Font weight */
            color: #333;
            /* Label color */
            margin-bottom: 0.5rem;
            /* Space between label and dropdown */
        }

        /* Dropdown select styling */
        .form-select {
            display: block;
            /* Ensures the select takes full width */
            width: 100%;
            /* Full width */
            padding: 0.375rem 0.75rem;
            /* Padding inside the dropdown */
            font-size: 14px;
            /* Font size */
            line-height: 1.5;
            /* Line height */
            color: #495057;
            /* Text color */
            background-color: #fff;
            /* Background color */
            background-clip: padding-box;
            /* Background clip */
            border: 1px solid #ced4da;
            /* Border color */
            border-radius: 0.375rem;
            /* Border radius */
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            /* Transition effects */
        }

        /* Dropdown focus styling */
        .form-select:focus {
            border-color: #80bdff;
            /* Border color on focus */
            outline: 0;
            /* Remove default outline */
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            /* Box shadow on focus */
        }

        /* Option styling */
        .form-select option {
            color: #495057;
            /* Option text color */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-label {
                font-size: 14px;
                /* Smaller font on mobile */
            }

            .form-select {
                font-size: 12px;
                /* Smaller font on mobile */
            }
        }
/* Form container styling */
#registrationForm {
    background-color: #f9f9f9;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Form labels */
#registrationForm label {
    font-weight: 500;
    color: #333;
    margin-bottom: 5px;
    display: block;
}

/* Form inputs and selects */
#registrationForm input, 
#registrationForm select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

/* Focus state */
#registrationForm input:focus, 
#registrationForm select:focus {
    outline: none;
    border-color: #ff4d6d;
    box-shadow: 0 0 5px rgba(255, 77, 109, 0.5);
}

/* Responsive styles for smaller screens */
@media (max-width: 576px) {
    #registrationForm {
        padding: 20px;
    }

    #registrationForm input, 
    #registrationForm select {
        font-size: 14px;
    }

    #registrationForm button {
        font-size: 14px;
    }
}

    </style>


</head>

<body class="d-flexbox vw-100 vh-100">

    <!--HEADER-->        
    <!-- First Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary-custom" id="mainNavbar">
        <a class="navbar-brand" href="index.php">University of Rizal System - Morong Facilities E-Monitoring and Scheduling System</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse navbar-expand" id="navbarSupportedContent">
            <ul class="ml-auto navbar-nav">
            <li id="vbr" class="nav-item">
                    <a class="nav-link rounded-pill" href="view_booking.php">
                        <img src="Header_Images/vbr.png" alt="Icon" />
                        View Booking Requests
                    </a>
                </li>

                <li id="acc" class="nav-item dropdown">
                    <a class="nav-link rounded-pill dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="Header_Images/account.png" alt="Icon" />
                        Account&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a id="admin1" class="dropdown-item" href="Profile.php" id="profileLink">
                            <img src="Header_Images/account.png" alt="Icon" />
                            Profile</a>
                             <a id="admin2" class="dropdown-item" href="Accounts.php">
                                <img src="Header_Images/switch_account.png" alt="Icon" />
                                Switch to Admin Account
                            </a>
  
                        <a id="signout" class="dropdown-item" href="../login.php">
                            <img src="Header_Images/sign_out.png" alt="Icon" />
                            Log out</a>
                    </div>

                </li>

            </ul>
        </div>
    </nav>
    <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <form id="registrationForm" action="register.php" method="POST"> 
                <label for="username">Username:</label>
                <input type="text" name="username" required><br>

                <label for="account_type">Account Type:</label>
                <select name="account_type" id="account_type" required>
                    <option value="">Select Account Type</option>
                    <option value="1">Admin</option>
                    <option value="2">Student Leader</option>
                    <option value="3">Office</option>
                </select><br>

                <!-- Admin Account (if Admin) -->
                <div id="admin_fields" style="display: none;">
                    <label for="admin_account">Admin Account:</label>
                    <select name="admin_account" id="admin_account">
                        <!-- Admin accounts will be populated via AJAX -->
                    </select><br>
                </div>

                <!-- College and Org (if Student Leader) -->
                <div id="student_leader_fields" style="display: none;">
                    <label for="department">College Department:</label>
                    <select name="department" id="department">
                        <!-- Departments will be populated via AJAX -->
                    </select><br>

                    <label for="org">Organization:</label>
                    <select name="org" id="org">
                        <!-- Organizations will be populated based on the department selection via AJAX -->
                    </select><br>
                </div>

                <!-- Office (if Office) -->
                <div id="office_fields" style="display: none;">
                    <label for="office">Office:</label>
                    <select name="office" id="office">
                        <!-- Offices will be populated via AJAX -->
                    </select><br>
                </div>

                <label for="password">Password:</label>
                <input type="password" name="password" required><br>

                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>
        </div>
    </div>
</div>

    <!-- FullCalendar JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script>
        $(document).ready(function() {
            $('#account_type').change(function() {
                var accountType = $(this).val();
                if (accountType == '1') {
                    $('#admin_fields').show();
                    $('#student_leader_fields').hide();
                    $('#office_fields').hide();
                    // Fetch admin accounts via AJAX
                    $.ajax({
                        url: 'get_data.php',
                        type: 'POST',
                        data: { account_type: accountType },
                        success: function(response) {
                            $('#admin_account').html(response);
                        }
                    });
                } else if (accountType == '2') {
                    $('#student_leader_fields').show();
                    $('#admin_fields').hide();
                    $('#office_fields').hide();
                    // Fetch departments via AJAX
                    $.ajax({
                        url: 'get_data.php',
                        type: 'POST',
                        data: { account_type: accountType },
                        success: function(response) {
                            $('#department').html(response);
                        }
                    });
                } else if (accountType == '3') {
                    $('#office_fields').show();
                    $('#admin_fields').hide();
                    $('#student_leader_fields').hide();
                    // Fetch offices via AJAX
                    $.ajax({
                        url: 'get_data.php',
                        type: 'POST',
                        data: { account_type: accountType },
                        success: function(response) {
                            $('#office').html(response);
                        }
                    });
                } else {
                    $('#admin_fields').hide();
                    $('#student_leader_fields').hide();
                    $('#office_fields').hide();
                }
            });

            // Fetch organizations when department is selected
            $('#department').change(function() {
                var departmentId = $(this).val();
                $.ajax({
                    url: 'get_data.php',
                    type: 'POST',
                    data: { department_id: departmentId },
                    success: function(response) {
                        $('#org').html(response);
                    }
                });
            });
        });
    </script>

</body>
</html>