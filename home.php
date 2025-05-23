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

// Get current offers
$currentOffers = [
    [
        'title' => 'Personal Loan Offer',
        'description' => 'Get personal loans at just 8.5% interest rate with zero processing fees until May 30, 2025.',
        'icon' => 'fas fa-money-bill-wave'
    ],
    [
        'title' => 'Fixed Deposit Bonus',
        'description' => 'Open a new FD for 5+ years and get additional 0.5% interest rate for senior citizens.',
        'icon' => 'fas fa-piggy-bank'
    ],
    [
        'title' => 'Credit Card Cashback',
        'description' => '5% cashback on all utility bill payments using Bankify Platinum Credit Card.',
        'icon' => 'fas fa-credit-card'
    ]
];

// Get financial tips
$financialTips = [
    'Create an emergency fund with 3-6 months of expenses for unexpected situations.',
    'Automate your savings by setting up automatic transfers to a separate savings account.',
    'Review your account statements regularly to track spending patterns and identify areas to save.',
    'Consider diversifying your investments across different asset classes to manage risk.'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bankify - Your Trusted Banking Partner</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="assets/css/bankify.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      background-image: url('home.jpg');
      background-size: cover;
      background-attachment: fixed;
      background-position: center;
      background-repeat: no-repeat;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .container {
      margin-top: 2rem;
    }
    
    .card {
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
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
    
    .feature-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }
    
    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .offer-card {
      border-left: 4px solid #007bff;
      background-color: rgba(0, 123, 255, 0.05);
    }
    
    .tip-item {
      opacity: 0;
      animation: fadeIn 1s ease-in-out forwards;
    }
    
    .tip-item:nth-child(1) { animation-delay: 2s; }
    .tip-item:nth-child(2) { animation-delay: 2.5s; }
    .tip-item:nth-child(3) { animation-delay: 3s; }
    .tip-item:nth-child(4) { animation-delay: 3.5s; }
    
    @keyframes typing {
      from { width: 0 }
      to { width: 100% }
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .icon-container {
      font-size: 2rem;
      color: #007bff;
      margin-bottom: 15px;
    }
    
    .account-summary-card {
      padding: 2rem;
      text-align: center;
    }
    
    .account-balance {
      font-size: 2.5rem;
      font-weight: bold;
      color: #28a745;
      margin: 1.5rem 0;
    }
    
    .account-number {
      font-size: 1.2rem;
      color: #6c757d;
      margin-bottom: 1rem;
    }
    
    .footer {
      background-color: rgba(52, 58, 64, 0.9);
      color: #ffffff;
      padding: 20px 0;
      margin-top: 40px;
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
  <!-- Welcome Card -->
  <div class="card p-4">
    <h2 class="animated-text">Welcome to Bankify, <?php echo $userData['name']; ?></h2>
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
  
  <!-- Account Summary - Enlarged -->
  <div class="card">
    <div class="account-summary-card">
      <h3><i class="fas fa-chart-line mr-2"></i> Account Summary</h3>
      <div class="account-number">
        Account #: <?php echo substr($userData['accountno'], 0, 4) . '****' . substr($userData['accountno'], -4); ?>
      </div>
      <div class="account-balance">
        ₹<?php echo $userData['deposit']; ?>
      </div>
      <div class="row">
        <div class="col-md-6 mx-auto">
          <a href="statement.php" class="btn btn-lg btn-outline-primary btn-block">View Transactions</a>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Current Offers -->
  <div class="card p-4">
    <h4><i class="fas fa-gift mr-2"></i> Current Offers</h4>
    <div class="row mt-3">
      <?php foreach ($currentOffers as $offer): ?>
      <div class="col-md-4 mb-3">
        <div class="card p-3 offer-card feature-card h-100">
          <div class="icon-container">
            <i class="<?php echo $offer['icon']; ?>"></i>
          </div>
          <h5><?php echo $offer['title']; ?></h5>
          <p><?php echo $offer['description']; ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  
  <!-- Financial Tips -->
  <div class="card p-4">
    <h4><i class="fas fa-lightbulb mr-2"></i> Financial Tips</h4>
    <div class="row mt-3">
      <div class="col-md-6">
        <ul class="list-group">
          <?php foreach ($financialTips as $index => $tip): ?>
          <li class="list-group-item tip-item">
            <i class="fas fa-check-circle text-success mr-2"></i>
            <?php echo $tip; ?>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="col-md-6">
        <div class="card p-3 bg-light">
          <h5>Financial Health Check</h5>
          <p>Use our financial health assessment tool to get personalized recommendations for improving your financial wellness.</p>
          <button class="btn btn-primary">Start Assessment</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h5>Bankify</h5>
        <p>Your trusted banking partner since 1995. Providing innovative financial solutions for over 25 years.</p>
      </div>
      <div class="col-md-4">
        <h5>Contact Us</h5>
        <p><i class="fas fa-phone mr-2"></i> 1800-123-4567</p>
        <p><i class="fas fa-envelope mr-2"></i> support@bankify.com</p>
      </div>
      <div class="col-md-4">
        <h5>Follow Us</h5>
        <div class="d-flex">
          <a href="#" class="mr-3"><i class="fab fa-facebook fa-2x"></i></a>
          <a href="#" class="mr-3"><i class="fab fa-twitter fa-2x"></i></a>
          <a href="#" class="mr-3"><i class="fab fa-instagram fa-2x"></i></a>
          <a href="#" class="mr-3"><i class="fab fa-linkedin fa-2x"></i></a>
        </div>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-12 text-center">
        <p class="mb-0">&copy; 2025 Bankify. All rights reserved.</p>
      </div>
    </div>
  </div>
</footer>

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
