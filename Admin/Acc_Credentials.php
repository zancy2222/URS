<?php
session_start();

// Ensure user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['account_type'] != 1) {
    header("Location: login.php");
    exit();
}

// Database connection
include 'partials/db_conn.php';

// Fetch account details for the logged-in user
$username = $_SESSION['username'];
$adminAccountId = $_SESSION['admin_account_id'];

$sql = "SELECT account_name FROM admin_account WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $adminAccountId);
$stmt->execute();
$stmt->bind_result($accountName);
$stmt->fetch();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URSMFEMSS Homepage</title>
    <!--BOOTSTRAP LINK-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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
            color: #004AAD;
            padding: 2px;
            padding-left: 5px;
            width: 180px;
            height: 25px;
        }

        #mainNavbar .navbar-nav .nav-item .nav-link img {
            width: 20px;
            height: 20px;
        }

        #mainNavbar .dropdown-menu .dropdown-item {
            font-size: 13px;
            color: #004AAD;
            padding: 0px;
            margin-right: 5px;
        }

        .dropdown-item {
            font-size: 12px;
        }

        /*dropdown images sizing*/
        #mainNavbar .dropdown-menu .dropdown-item img {
            width: 20px;
            height: 20px;
            margin: 5px;
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

        .credentials-header {
            background-color: #004AAD;
            color: white;
            font-weight: bold;
            padding: 10px;
            font-size: 16px;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
        }

        .credentials-body {
            border: 1px solid #004AAD;
            padding: 15px;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }

        .credentials-body p {
            margin: 0;
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
                <?php if (!isset($_SESSION['is_osds']) || !$_SESSION['is_osds']): ?>
                    <li id="vbr" class="nav-item">
                        <a class="nav-link rounded-pill" href="view_booking.php">
                            <img src="Header_Images/vbr.png" alt="Icon" />
                            View Booking Requests
                        </a>
                    </li>

                    <li id="pbr" class="nav-item">
                        <a class="nav-link rounded-pill" href="Process_booking.php">
                            <img src="Header_Images/pbr.png" alt="Icon" />
                            Process Booking Requests
                        </a>
                    </li>
                <?php endif; ?>

                <li id="acc" class="nav-item dropdown">
                    <a class="nav-link rounded-pill dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="Header_Images/account.png" alt="Icon" />
                        Account&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a id="admin1" class="dropdown-item" href="Acc_Credentials.php" id="profileLink">
                            <img src="Header_Images/account.png" alt="Icon" />
                            Profile</a>
                        <?php if (isset($_SESSION['is_osds']) && $_SESSION['is_osds']): ?>
                            <a id="admin2" class="dropdown-item" href="Accounts.php">
                                <img src="Header_Images/switch_account.png" alt="Icon" />
                                Switch to Admin Account
                            </a>
                        <?php endif; ?>

                        <a id="signout" class="dropdown-item" href="../logout.php">
                            <img src="Header_Images/sign_out.png" alt="Icon" />
                            Log out</a>
                    </div>

                </li>

            </ul>
        </div>
    </nav>
    <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Account credentials card -->
            <div class="credentials-card">
                <div class="credentials-header">ACCOUNT CREDENTIALS:</div>
                <div class="credentials-body">
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
                    <p><strong>Account Type:</strong> Admin</p>
                    <p><strong>Account Name:</strong> <?php echo htmlspecialchars($accountName); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- FullCalendar JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>

</html>