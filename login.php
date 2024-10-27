<?php
// Add cache control headers to prevent caching of the login page
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University of Rizal System - Morong Facilities E-Monitoring and Scheduling System</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700&display=swap');

        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            min-height: 90vh;
            background-color: #f0f0f0;
        }

        .container {
            background-color: #fff;
            padding: 35px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 410px;
            margin: auto;
        }

        .header {
            text-align: center;
            margin-bottom: 80px;
            margin-top: 20px;
            padding: 25px;
        }

        h1, h2 {
            margin: 0;
            font-size:xx-large;
            font-weight: 700;
        }

        h3 {
            margin-bottom: 10px;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            font-family: "Lora", serif;
        }
        .form-container h5{
            color: #F95150;
            padding: 0;
            margin: 0;
            
        }

        select, input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
            font-family: "Lora", serif;
        }

        a {
            color: #aaa;
            text-decoration: none;
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }

        a:hover {
            color: #000;
        }

        button {
            background-color: #000;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #3e8e41;
        }


    </style>
</head>
<body>
<div class="header">
    <a href="index.php" style="color:#000;">
        <h1>University of Rizal System - Morong</h1>
        <h2>Facilities E-Monitoring and Scheduling System</h2>
    </a>
</div>


    <form id="loginForm" action="partials/login_handler.php" method="POST">
    <div class="container">
    <div class="form-container">
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
                <!-- Organizations will be populated via AJAX -->
            </select><br>
        </div>

        <!-- Office (if Office) -->
        <div id="office_fields" style="display: none;">
            <label for="office">Office:</label>
            <select name="office" id="office">
                <!-- Offices will be populated via AJAX -->
            </select><br>
        </div>

        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

  

        <button type="submit">Login</button>
    </div>
    </div>
    </form>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                        url: 'partials/get_data.php',
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
                        url: 'partials/get_data.php',
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
                        url: 'partials/get_data.php',
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
                    url: 'partials/get_data.php',
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
