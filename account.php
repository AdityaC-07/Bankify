<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header('location:login.php');
    exit;
}
require 'includes/db_conn.php';

$con = new mysqli('localhost', 'root', '', 'bankify');
$ar = $con->query("SELECT * FROM useraccounts WHERE id = '$_SESSION[userid]'");
$userData = $ar->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bankify</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/bankify.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
        background-color: #f8f9fa;
        font-family: 'Poppins', sans-serif;
    }
    .navbar {
        background-color: #343a40;
    }
    .navbar-brand {
        font-size: 1.5rem;
        font-weight: bold;
        color: #ffffff !important;
    }
    .navbar-nav .nav-link {
        color: #ffffff !important;
        font-size: 1rem;
        margin-right: 15px;
    }
    .navbar-nav .nav-link:hover {
        color: #ffc107 !important;
    }
    .navbar-text {
        color: #ffffff;
        font-size: 1rem;
        font-weight: bold;
    }
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
    }
    .card h2 {
        font-size: 1.8rem;
        font-weight: bold;
        color: #343a40;
    }
    .card p {
        font-size: 1rem;
        color: #6c757d;
        margin-bottom: 10px;
    }
    .container {
        margin-top: 30px;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
  <a class="navbar-brand" href="home.php"><b>Bankify</b></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
      <li class="nav-item active"><a class="nav-link" href="account.php">Accounts</a></li>
      <li class="nav-item"><a class="nav-link" href="statement.php">Statements</a></li>
      <li class="nav-item"><a class="nav-link" href="funds_transfer.php">Transfer</a></li>
    </ul>
    <span class="navbar-text">Welcome, <?php echo $userData['name']; ?></span>
  </div>
</nav>

<div class="container">
  <div class="card p-4">
    <h2>Your Account Summary</h2>
    <p><strong>Account Number:</strong> <?php echo $userData['accountno']; ?></p>
    <p><strong>Balance:</strong> ₹<?php echo $userData['deposit']; ?></p>
  </div>
</div>

</body>
</html>
