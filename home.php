<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header('location:login.php');
}
require 'includes/db_conn.php';
require 'includes/function.php';

$con = new mysqli('localhost', 'root', '', 'bankify');


$ar = $con->query("SELECT * FROM useraccounts WHERE id = '$_SESSION[userid]'");
$userData = $ar->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bankify</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/bankify.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      background-image: url('assets/images/banking-bg.jpg');
      background-size: cover;
      background-attachment: fixed;
      background-position: center;
      background-repeat: no-repeat;
    }
    
    .container {
      margin-top: 2rem;
    }
    
    .card {
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .animated-text {
      display: inline-block;
      overflow: hidden;
      white-space: nowrap;
      margin: 0;
      animation: typing 3.5s steps(40, end);
    }
    
    .welcome-subtitle {
      opacity: 0;
      animation: fadeIn 2s ease-in-out forwards;
      animation-delay: 1s;
    }
    
    .notification-box {
      border-left: 4px solid #dc3545;
      padding-left: 1rem;
      margin-top: 1.5rem;
    }
    
    @keyframes typing {
      from { width: 0 }
      to { width: 100% }
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="home.php"><b>Bankify</b></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div id="navbarCollapse" class="collapse navbar-collapse justify-content-between">
    <div class="navbar-nav">
      <a href="home.php" class="nav-item nav-link active">Home</a>
      <a href="account.php" class="nav-item nav-link">Accounts</a>
      <a href="statement.php" class="nav-item nav-link">Statements</a>
      <a href="funds_transfer.php" class="nav-item nav-link">Funds Transfer</a>
    </div>
    <div class="navbar-nav">
      <a class="btn btn-warning" href="#">Account Balance: ₹<?php echo $userData['deposit']; ?></a>
      <a href="notice.php" class="nav-item nav-link">Notifications</a>
      <button class="nav-item nav-link btn btn-link" data-toggle="modal" data-target="#exampleModal">Message</button>
      <div class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><?php echo $userData['name']; ?></a>
        <div class="dropdown-menu">
          <a href="profile.php" class="dropdown-item">Profile</a>
          <div class="dropdown-divider"></div>
          <a href="logout.php" class="dropdown-item">Logout</a>
        </div>
      </div>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <div class="card p-4">
    <h2 class="animated-text">Welcome to Bankify</h2>
    <p class="welcome-subtitle"><strong>Bankify</strong> is the biggest commercial bank in India. It is a private sector bank with 16 regional hubs and 57 zonal offices across the country.</p>

    <div class="notification-box">
      <p><span style="color: red; font-weight: bold;">Latest Notification:</span><br>
        <?php
          $noticeResult = $con->query("SELECT * FROM notice WHERE userid = '$_SESSION[userid]' ORDER BY time DESC");
          if ($noticeResult->num_rows > 0) {
            $row = $noticeResult->fetch_assoc();
            echo $row['notice'];
          } else {
            echo "Notice box empty";
          }
        ?>
      </p>
    </div>
  </div>
</div>

<!-- Modal for sending a message -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">New Message</h5>
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Recipient:</label>
            <input type="text" class="form-control" value="manager" readonly>
          </div>
          <div class="form-group">
            <label>Message:</label>
            <textarea class="form-control" name="msg" required></textarea>
          </div>
        </div>
        <?php
          if (isset($_POST['send'])) {
            if ($con->query("INSERT INTO feedback (message, userid) VALUES ('$_POST[msg]', '$_SESSION[userid]')")) {
              echo '<script>alert("Message sent successfully")</script>';
            } else {
              echo "<div class='alert alert-danger'>Not sent. Error: " . $con->error . "</div>";
            }
          }
        ?>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="send" class="btn btn-primary">Send Message</button>
        </div>
      </div>
    </form>
  </div>
</div>

</body>
</html>
