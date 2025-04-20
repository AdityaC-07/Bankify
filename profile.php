<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header('location:login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Bankify</title>
<link href="images/bankify_symbol.jpg" rel="icon">
<link href="images/bankify_symbol.jpg" rel="apple-touch-icon"> 
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merienda+One">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.scss">
</head>

<?php 
$con = new mysqli('localhost', 'root', '', 'bankify');

$ar = $con->query("SELECT * FROM useraccounts WHERE id = '$_SESSION[userid]'");
$userData = $ar->fetch_assoc();
?>

<style>
body {
    background: #eeeeee;
}
.navbar {
    background: #fff;
    padding: 16px;
    border-bottom: 1px solid #d6d6d6;
    box-shadow: 0 0 4px rgba(0,0,0,.1);
}
.navbar .navbar-brand {
    color: #555;
    font-family: 'Poppins', sans-serif;
}
.profile-container {
    margin-top: 30px;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
.profile-container h3 {
    margin-bottom: 20px;
    font-weight: bold;
}
.profile-container .profile-info {
    margin-bottom: 15px;
}
.profile-container .profile-info label {
    font-weight: bold;
    color: #555;
}
.profile-container .profile-info span {
    color: #333;
}
</style>

<body>
<nav class="navbar navbar-expand-xl navbar-light bg-light">
    <a href="home.php" class="navbar-brand"><img src="images/bankify_symbol.jpg" width="45" alt="" class="logo-img"><b>Bankify</b></a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
        <div class="navbar-nav">
            <a href="home.php" class="nav-item nav-link">Home</a>
            <a href="account.php" class="nav-item nav-link">Accounts</a>
            <a href="statement.php" class="nav-item nav-link">Account Statements</a>
            <a href="funds_transfer.php" class="nav-item nav-link">Funds Transfer</a>
        </div>
        <div class="navbar-nav ml-auto">
            <a href="#" class="btn btn-warning" data-toggle="tooltip" title="Your current Account Balance">Account Balance: Rs.<?php echo $userData['deposit']; ?></a>
            <a href="logout.php" class="btn btn-danger ml-3">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="profile-container">
        <h3>Your Profile</h3>
        <div class="profile-info">
            <label>Name:</label>
            <span><?php echo $userData['name']; ?></span>
        </div>
        <div class="profile-info">
            <label>Email:</label>
            <span><?php echo $userData['email']; ?></span>
        </div>
        <div class="profile-info">
            <label>Phone Number:</label>
            <span><?php echo $userData['phonenumber']; ?></span>
        </div>
        <div class="profile-info">
            <label>Address:</label>
            <span><?php echo $userData['address']; ?></span>
        </div>
        <div class="profile-info">
            <label>City:</label>
            <span><?php echo $userData['city']; ?></span>
        </div>
        <div class="profile-info">
            <label>Gender:</label>
            <span><?php echo $userData['gender']; ?></span>
        </div>
        <div class="profile-info">
            <label>Date of Birth:</label>
            <span><?php echo $userData['dob']; ?></span>
        </div>
        <div class="profile-info">
            <label>Account Number:</label>
            <span><?php echo $userData['accountno']; ?></span>
        </div>
        <div class="profile-info">
            <label>Account Type:</label>
            <span><?php echo $userData['accounttype']; ?></span>
        </div>
        <div class="profile-info">
            <label>Current Balance:</label>
            <span>Rs.<?php echo $userData['deposit']; ?></span>
        </div>
    </div>
</div>
</body>
</html>