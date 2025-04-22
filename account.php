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

// Fetch recent transactions
$transactions = $con->query("SELECT * FROM transactions WHERE userid = '$_SESSION[userid]' ORDER BY id DESC LIMIT 5");

// Fetch account balance history (for the chart)
$balanceHistory = $con->query("SELECT date, closing_balance FROM balance_history WHERE userid = '$_SESSION[userid]' ORDER BY date ASC LIMIT 7");
$balanceData = [];
while ($row = $balanceHistory->fetch_assoc()) {
    $balanceData[] = $row;
}
$balanceDataJson = json_encode($balanceData);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bankify - Your Account</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="assets/css/bankify.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
  <style>
    body {
        background-image: url('assets/images/finance-background.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        font-family: 'Poppins', sans-serif;
        position: relative;
    }
    
    body::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(248, 249, 250, 0.85);
        z-index: -1;
    }
    
    .navbar {
        background-color: #1a237e;
        padding: 15px 0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }
    
    .navbar-brand {
        font-size: 1.8rem;
        font-weight: bold;
        color: #ffffff !important;
        letter-spacing: 1px;
    }
    
    .navbar-nav .nav-link {
        color: #ffffff !important;
        font-size: 1rem;
        margin-right: 15px;
        transition: all 0.3s ease;
    }
    
    .navbar-nav .nav-link:hover, .navbar-nav .nav-item.active .nav-link {
        color: #ffc107 !important;
        transform: translateY(-2px);
    }
    
    .navbar-text {
        color: #ffffff;
        font-size: 1rem;
        font-weight: bold;
    }
    
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
        margin-bottom: 25px;
        transition: transform 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }
    
    .card h2 {
        font-size: 1.8rem;
        font-weight: bold;
        color: #1a237e;
        margin-bottom: 20px;
    }
    
    .card h3 {
        font-size: 1.4rem;
        color: #343a40;
        margin-bottom: 15px;
    }
    
    .card p {
        font-size: 1rem;
        color: #6c757d;
        margin-bottom: 10px;
    }
    
    .container {
        margin-top: 30px;
        padding-bottom: 30px;
    }
    
    .balance-amount {
        font-size: 2.2rem;
        font-weight: bold;
        color: #2e7d32;
    }
    
    .account-details {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    
    .quick-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }
    
    .action-btn {
        background-color: #1a237e;
        color: white;
        border: none;
        border-radius: 30px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }
    
    .action-btn:hover {
        background-color: #0d47a1;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    
    .transaction-item {
        padding: 12px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .transaction-item:last-child {
        border-bottom: none;
    }
    
    .transaction-date {
        color: #6c757d;
        font-size: 0.85rem;
    }
    
    .transaction-amount {
        font-weight: bold;
    }
    
    .credit {
        color: #2e7d32;
    }
    
    .debit {
        color: #c62828;
    }
    
    .feature-icon {
        font-size: 2rem;
        color: #1a237e;
        margin-bottom: 15px;
    }
    
    footer {
        background-color: #1a237e;
        color: white;
        padding: 15px 0;
        margin-top: 30px;
    }
    
    .welcome-section {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .welcome-section h1 {
        color: #1a237e;
        font-weight: bold;
    }
    
    @media (max-width: 768px) {
        .quick-actions {
            flex-direction: column;
        }
        
        .action-btn {
            margin-bottom: 10px;
            width: 100%;
        }
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="home.php">Bankify</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item"><a class="nav-link" href="home.php"><i class="fas fa-home"></i> Home</a></li>
        <li class="nav-item active"><a class="nav-link" href="account.php"><i class="fas fa-user-circle"></i> Accounts</a></li>
        <li class="nav-item"><a class="nav-link" href="statement.php"><i class="fas fa-file-invoice"></i> Statements</a></li>
        <li class="nav-item"><a class="nav-link" href="funds_transfer.php"><i class="fas fa-exchange-alt"></i> Transfer</a></li>
        <li class="nav-item"><a class="nav-link" href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
      </ul>
      <span class="navbar-text">
        <i class="fas fa-user"></i> Welcome, <?php echo $userData['name']; ?> | 
        <a href="logout.php" class="text-white"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </span>
    </div>
  </div>
</nav>

<div class="container">
  <div class="welcome-section">
    <h1>Your Banking Dashboard</h1>
    <p class="lead">View your accounts, check balances, and manage your finances all in one place.</p>
  </div>
  
  <div class="row">
    <div class="col-lg-8">
      <div class="card p-4">
        <h2>Account Summary</h2>
        <div class="account-details">
          <div class="row">
            <div class="col-md-6">
              <p><strong>Account Holder:</strong> <?php echo $userData['name']; ?></p>
              <p><strong>Account Number:</strong> <?php echo $userData['accountno']; ?></p>
              <p><strong>Account Type:</strong> <?php echo isset($userData['accounttype']) ? $userData['accounttype'] : 'Savings'; ?></p>
            </div>
            <div class="col-md-6 text-md-right">
              <p><strong>Available Balance</strong></p>
              <div class="balance-amount">₹<?php echo number_format($userData['deposit'], 2); ?></div>
              <p class="text-muted">Last updated: <?php echo date('d M Y H:i'); ?></p>
            </div>
          </div>
        </div>
        
        <div class="quick-actions">
          <a href="funds_transfer.php" class="btn action-btn"><i class="fas fa-paper-plane"></i> Send Money</a>
          <a href="bill_payments.php" class="btn action-btn"><i class="fas fa-file-invoice"></i> Pay Bills</a>
          <a href="statement.php" class="btn action-btn"><i class="fas fa-download"></i> Download Statement</a>
        </div>
      </div>
      
      <div class="card p-4">
        <h3><i class="fas fa-chart-line"></i> Balance History</h3>
        <canvas id="balanceChart" width="400" height="200"></canvas>
      </div>
    </div>
    
    <div class="col-lg-4">
      <div class="card p-4">
        <h3><i class="fas fa-history"></i> Recent Transactions</h3>
        <div class="transactions-list">
          <?php if($transactions->num_rows > 0): ?>
            <?php while($transaction = $transactions->fetch_assoc()): 
              $isCredit = $transaction['type'] == 'credit';
            ?>
              <div class="transaction-item">
                <div class="d-flex justify-content-between">
                  <div>
                    <strong><?php echo $transaction['description'] ?? ($isCredit ? 'Deposit' : 'Withdrawal'); ?></strong>
                    <div class="transaction-date"><?php echo date('d M Y, H:i', strtotime($transaction['date'])); ?></div>
                  </div>
                  <div class="transaction-amount <?php echo $isCredit ? 'credit' : 'debit'; ?>">
                    <?php echo $isCredit ? '+' : '-'; ?>₹<?php echo number_format($transaction['amount'], 2); ?>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <div class="text-center p-3">
              <i class="fas fa-receipt fa-2x text-muted mb-2"></i>
              <p>No recent transactions found.</p>
            </div>
          <?php endif; ?>
        </div>
        <div class="text-center mt-3">
          <a href="statement.php" class="btn btn-outline-primary btn-sm">View All Transactions</a>
        </div>
      </div>
      
      <div class="card p-4">
        <h3><i class="fas fa-bell"></i> Notifications</h3>
        <div class="notification-item">
          <p><i class="fas fa-info-circle text-info"></i> Your credit card statement is ready.</p>
          <p><i class="fas fa-gift text-success"></i> You have earned 500 reward points this month!</p>
          <p><i class="fas fa-percentage text-warning"></i> Limited time offer: Upgrade to Premium!</p>
        </div>
      </div>
    </div>
  </div>
  
  <div class="row mt-4">
    <div class="col-md-4">
      <div class="card p-4 text-center">
        <div class="feature-icon">
          <i class="fas fa-shield-alt"></i>
        </div>
        <h3>Secure Banking</h3>
        <p>All your transactions are protected with industry-leading security protocols.</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card p-4 text-center">
        <div class="feature-icon">
          <i class="fas fa-mobile-alt"></i>
        </div>
        <h3>Mobile Banking</h3>
        <p>Download our app for convenient banking on the go, anytime, anywhere.</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card p-4 text-center">
        <div class="feature-icon">
          <i class="fas fa-headset"></i>
        </div>
        <h3>24/7 Support</h3>
        <p>Our customer service team is available round the clock to assist you.</p>
      </div>
    </div>
  </div>
</div>

<footer class="text-center">
  <div class="container">
    <p>&copy; <?php echo date('Y'); ?> Bankify. All rights reserved.</p>
    <p>
      <a href="#" class="text-white">Privacy Policy</a> | 
      <a href="#" class="text-white">Terms of Service</a> | 
      <a href="#" class="text-white">Contact Us</a>
    </p>
  </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Balance history chart
  const balanceData = <?php echo $balanceDataJson ?: '[]'; ?>;
  if (balanceData.length > 0) {
    const labels = balanceData.map(item => {
      const date = new Date(item.date);
      return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    });
    
    const amounts = balanceData.map(item => parseFloat(item.closing_balance));
    
    const ctx = document.getElementById('balanceChart').getContext('2d');
    const balanceChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Account Balance',
          data: amounts,
          backgroundColor: 'rgba(26, 35, 126, 0.2)',
          borderColor: '#1a237e',
          borderWidth: 2,
          tension: 0.4,
          fill: true
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: false,
            grid: {
              color: '#e0e0e0'
            },
            ticks: {
              callback: function(value) {
                return '₹' + value;
              }
            }
          },
          x: {
            grid: {
              display: false
            }
          }
        },
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });
  } else {
    document.getElementById('balanceChart').parentNode.innerHTML = '<div class="text-center p-4"><i class="fas fa-chart-line fa-3x text-muted mb-3"></i><p>No balance history data available</p></div>';
  }
});
</script>
</body>
</html>
