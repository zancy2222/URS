

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
        <h1>University of Rizal System - Morong</h1>
        <h2>Facilities E-Monitoring and Scheduling System</h2>
    </div>

    <form action="" method="post">
        <div class="container">
            <div class="form-container">
                <h3>ACCOUNT</h3>
                <select name="Account_Type" id="account_type" required>
                    <option value="">Select Account Type</option>
                </select>
                <!-- Admin Selection -->
                <div id="admin_selection" style="display: none;">
                    <h3>ADMIN</h3>
                    <select name="admin-select" id="admin-select">
                        <option value="">Select Admin Account</option> 
                    </select>
                </div>

                <!-- Organization Selection -->
                <div id="org_selection" style="display: none;">
                    <h3>COLLEGE</h3>
                    <select id="college-select">
                        <option value="">Select College Department</option>
                    </select>
                    <h3>ORG</h3>
                    <select name="org-select" id="org-select">
                        <option value="">Select an Organization</option>
                    </select>
                </div>

                <!-- Office Selection -->
                <div id="office_selection" style="display: none;">
                    <h3>OFFICE</h3>
                    <select name="office-select" id="office-select">
                        <option value="">Select Office Account</option>
                    </select>
                </div>

                <h3>PASSWORD</h3>
                <input type="password" name="password" id="password" placeholder="Password" value="" required>
                <a href="#">Forgot Password</a>
                
                <button type="submit">Login</button>
            </div>
        </div>
    </form>

    <!--JAVASCRIPT CODES-->
    <script>
document.addEventListener('DOMContentLoaded', function() {
    var accountTypeSelect = document.getElementById('account_type');
    var adminSelect = document.getElementById('admin-select');
    var collegeSelect = document.getElementById('college-select');
    var officeSelect = document.getElementById('office-select');
    var orgSelect = document.getElementById('org-select');

    // Fetch Account Types
    var xhrAccountTypes = new XMLHttpRequest();
    xhrAccountTypes.open('GET', 'Partials/fetch_account_types.php', true);
    xhrAccountTypes.onload = function() {
        if (this.status == 200) {
            accountTypeSelect.innerHTML += this.responseText;
        }
    };
    xhrAccountTypes.send();

    // Event listener for account type change
    accountTypeSelect.addEventListener('change', function() {
        var accountType = this.value.toLowerCase();

        if (accountType === 'admin') {
            // Fetch Admin Accounts
            var xhrAdmin = new XMLHttpRequest();
            xhrAdmin.open('GET', 'Partials/fetch_admin.php', true);
            xhrAdmin.onload = function() {
                if (this.status == 200) {
                    adminSelect.innerHTML = this.responseText;
                    document.getElementById('admin_selection').style.display = 'block';
                    document.getElementById('org_selection').style.display = 'none';
                    document.getElementById('office_selection').style.display = 'none';
                }
            };
            xhrAdmin.send();
        } else if (accountType === 'student leader') {
            // Fetch College Departments
            var xhrCollege = new XMLHttpRequest();
            xhrCollege.open('GET', 'Partials/fetch_departments.php', true);
            xhrCollege.onload = function() {
                if (this.status == 200) {
                    collegeSelect.innerHTML = this.responseText;
                    document.getElementById('org_selection').style.display = 'block';
                    document.getElementById('admin_selection').style.display = 'none';
                    document.getElementById('office_selection').style.display = 'none';
                }
            };
            xhrCollege.send();
        } else if (accountType === 'office') {
            // Fetch Office Accounts
            var xhrOffice = new XMLHttpRequest();
            xhrOffice.open('GET', 'Partials/fetch_office.php', true);
            xhrOffice.onload = function() {
                if (this.status == 200) {
                    officeSelect.innerHTML = this.responseText;
                    document.getElementById('office_selection').style.display = 'block';
                    document.getElementById('admin_selection').style.display = 'none';
                    document.getElementById('org_selection').style.display = 'none';
                }
            };
            xhrOffice.send();
        } else {
            // Hide all selections if no valid account type is selected
            document.getElementById('admin_selection').style.display = 'none';
            document.getElementById('org_selection').style.display = 'none';
            document.getElementById('office_selection').style.display = 'none';
        }
    });

    // Event listener for college department change to fetch organizations
    collegeSelect.addEventListener('change', function() {
        var departmentId = this.value;

        var xhrOrg = new XMLHttpRequest();
        xhrOrg.open('POST', 'Partials/fetch_orgs.php', true);
        xhrOrg.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhrOrg.onload = function() {
            if (this.status == 200) {
                orgSelect.innerHTML = this.responseText;
            }
        };
        xhrOrg.send('department=' + departmentId);
    });

    // Handling password input events (optional based on your needs)
    var inputPassword = document.getElementById('password');
    inputPassword.addEventListener('input', function() {
        console.log('Password Input Changed:', inputPassword.value);
    });
});

    </script>
    
</body>
</html>
