<?php
session_start();
if (!isset($_SESSION['loginid'])) {
    header('location:manager_login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Bankify</title>
    <link href="images/bankify_symbol.jpg" rel="icon">
    <link href="images/bankify_symbol.jpg" rel="apple-touch-icon">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="bankify.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<?php require 'includes/db_conn.php'; ?>
<?php require 'includes/function.php'; ?>
<body>
    <nav>
        <div class="logo">
            <img src="images/bankify_symbol.jpg" width="45" alt="" class="logo-img">
            Bankify
        </div>
        <input type="checkbox" id="click">
        <label for="click" class="menu-btn">
            <i class="fas fa-bars"></i>
        </label>
        <ul>
            <li><a class="active" href="manager_home.php">Home</a></li>
            <li><a href="#">Accounts</a></li>
            <li><a href="addnewaccount.php">Add New Account</a></li>
            <li><a href="manager_feedback.php">Feedback</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="card-body">
        <?php
        $con = new mysqli('localhost', 'root', '', 'bankify');
        $array = $con->query("SELECT * FROM useraccounts WHERE id = '$_GET[id]'");
        $row = $array->fetch_assoc();
        ?>
        <h1 style="text-align:center; color:#CC3300;">Account No: <?php echo $row['accountno']; ?></h1>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>Name</td>
                        <th><?php echo $row['name']; ?></th>
                        <td>Account No</td>
                        <th><?php echo $row['accountno']; ?></th>
                    </tr>
                    <tr>
                        <td>Current Balance</td>
                        <th><?php echo $row['deposit']; ?></th>
                        <td>Account Type</td>
                        <th><?php echo $row['accounttype']; ?></th>
                    </tr>
                    <tr>
                        <td>Aadhaar Card</td>
                        <th><?php echo $row['aadhaar']; ?></th>
                        <td>City</td>
                        <th><?php echo $row['city']; ?></th>
                    </tr>
                    <tr>
                        <td>Contact Number</td>
                        <th><?php echo $row['phonenumber']; ?></th>
                        <td>Address</td>
                        <th><?php echo $row['address']; ?></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>