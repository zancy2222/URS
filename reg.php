<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
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

        <button type="submit">Register</button>
    </form>

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
