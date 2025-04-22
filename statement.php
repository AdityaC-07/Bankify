<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header('location:login.php');
    exit;
}
?>

<?php
$con = new mysqli('localhost', 'root', '', 'bankify');

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$ar = $con->query("SELECT * FROM useraccounts WHERE id = '$_SESSION[userid]'");
$userData = $ar->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Account Statements | Bankify</title>
    <link href="images/bankify_symbol.jpg" rel="icon">
    <link href="images/bankify_symbol.jpg" rel="apple-touch-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="bankify.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <style>
        body {
            background-image: url('images/finance-background.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.85);
            z-index: -1;
        }
        
        .navbar {
            background-color: #1a237e !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        .navbar-brand {
            color: #ffffff !important;
            font-weight: bold;
        }
        
        .navbar-light .navbar-nav .nav-link {
            color: #ffffff !important;
            transition: all 0.3s ease;
        }
        
        .navbar-light .navbar-nav .nav-link:hover, 
        .navbar-light .navbar-nav .nav-link.active {
            color: #ffc107 !important;
        }
        
        .logo-img {
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .container {
            margin-top: 30px;
            margin-bottom: 30px;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .card-header {
            background-color: #1a237e;
            color: white;
            font-size: 1.25rem;
            font-weight: bold;
            padding: 15px;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .card-footer {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: center;
        }
        
        .alert {
            border-radius: 10px;
            margin-bottom: 15px;
            padding: 15px;
            border-left: 5px solid;
        }
        
        .alert-secondary {
            border-left-color: #6c757d;
        }
        
        .alert-success {
            border-left-color: #28a745;
        }
        
        .alert-danger {
            border-left-color: #dc3545;
        }
        
        .alert-warning {
            border-left-color: #ffc107;
        }
        
        .alert-info {
            border-left-color: #17a2b8;
        }
        
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #212529;
            font-weight: bold;
        }
        
        .dropdown-menu {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .dropdown-item {
            padding: 10px 20px;
        }
        
        .dropdown-divider {
            margin: 5px 0;
        }
        
        .user-action img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 5px;
        }
        
        .page-title {
            text-align: center;
            margin-bottom: 25px;
            color: #1a237e;
            font-weight: bold;
        }
        
        /* Transaction Icons */
        .transaction-icon {
            margin-right: 10px;
            font-size: 1.1rem;
        }
        
        /* Action Buttons */
        .action-btn {
            background-color: #1a237e;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 30px;
            transition: all 0.3s ease;
            margin: 0 5px;
        }
        
        .action-btn:hover {
            background-color: #0d47a1;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            color: white;
        }
        
        .download-btn {
            background-color: #28a745;
        }
        
        .download-btn:hover {
            background-color: #218838;
        }
        
        .print-btn {
            background-color: #17a2b8;
        }
        
        .print-btn:hover {
            background-color: #138496;
        }
        
        /* Filter Options */
        .filter-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 10px;
            flex-wrap: wrap;
        }
        
        .form-group {
            margin-bottom: 0;
            margin-right: 10px;
            flex-grow: 1;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        
        .date-filters {
            display: flex;
            gap: 10px;
            flex-grow: 1;
        }
        
        .download-section {
            margin-top: 20px;
            text-align: center;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 10px;
        }
        
        .download-title {
            font-weight: bold;
            color: #1a237e;
            margin-bottom: 15px;
        }
        
        .format-options {
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        
        .format-btn {
            padding: 10px 20px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            color: white;
            font-weight: bold;
        }
        
        .format-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            color: white;
            text-decoration: none;
        }
        
        .pdf-btn {
            background-color: #dc3545;
        }
        
        .pdf-btn:hover {
            background-color: #c82333;
        }
        
        .excel-btn {
            background-color: #28a745;
        }
        
        .excel-btn:hover {
            background-color: #218838;
        }
        
        .csv-btn {
            background-color: #fd7e14;
        }
        
        .csv-btn:hover {
            background-color: #e76b00;
        }
        
        .format-icon {
            margin-right: 8px;
            font-size: 1.2rem;
        }
        
        @media (max-width: 768px) {
            .filter-options {
                flex-direction: column;
                align-items: stretch;
            }
            
            .form-group, .date-filters {
                margin-bottom: 10px;
                margin-right: 0;
                flex-direction: column;
            }
            
            .action-buttons {
                flex-direction: column;
                width: 100%;
            }
            
            .action-btn {
                margin: 5px 0;
            }
            
            .format-options {
                flex-direction: column;
            }
            
            .format-btn {
                width: 100%;
                margin: 5px 0;
            }
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-xl navbar-light bg-light">
    <a href="home.php" class="navbar-brand">
        <img src="images/bankify_symbol.jpg" width="45" alt="" class="logo-img">
        <b>Bankify</b>
    </a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
        <div class="navbar-nav">
            <a href="home.php" class="nav-item nav-link"><i class="fas fa-home"></i> Home</a>
            <a href="#" class="nav-item nav-link active"><i class="fas fa-file-invoice"></i> Account Statements</a>
            <a href="funds_transfer.php" class="nav-item nav-link"><i class="fas fa-exchange-alt"></i> Funds Transfer</a>
        </div>
        <div class="navbar-nav ml-auto">
            <a href="#" class="btn btn-warning" data-toggle="tooltip" title="Your current Account Balance">
                <i class="fas fa-wallet"></i> Balance: Rs.<?php echo number_format($userData['deposit'], 2); ?>
            </a>
            <a href="notice.php" class="nav-item nav-link notifications">
                <i class="fas fa-bell"></i>
            </a>
            <div class="nav-item dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle user-action">
                    <img src="<?php echo "images/" . $userData['profile']; ?>" alt="Profile">
                    <?php echo $userData['name']; ?>
                </a>
                <div class="dropdown-menu">
                    <a href="profile.php" class="dropdown-item"><i class="fas fa-user"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <a href="logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="container">
    <h2 class="page-title">Your Account Statements</h2>
    
    <div class="filter-options">
        <div class="form-group">
            <label for="transaction-type">Filter by type:</label>
            <select class="form-control" id="transaction-type">
                <option value="all">All Transactions</option>
                <option value="withdraw">Withdrawals</option>
                <option value="deposit">Deposits</option>
                <option value="transfer">Transfers</option>
                <option value="deduction">Deductions</option>
            </select>
        </div>
        
        <div class="date-filters">
            <div class="form-group">
                <label for="date-from">From:</label>
                <input type="date" class="form-control" id="date-from">
            </div>
            
            <div class="form-group">
                <label for="date-to">To:</label>
                <input type="date" class="form-control" id="date-to">
            </div>
        </div>
        
        <div class="action-buttons">
            <button class="btn action-btn" id="apply-filter">
                <i class="fas fa-filter"></i> Apply Filter
            </button>
            
            <button class="btn action-btn print-btn" onclick="window.print()">
                <i class="fas fa-print"></i> Print
            </button>
        </div>
    </div>
    
    <div class="download-section">
        <h4 class="download-title"><i class="fas fa-download"></i> Download Transaction Statement</h4>
        <p>Download your account statement in your preferred format for your records.</p>
        
        <div class="format-options">
            <a href="download_statement.php?format=pdf&userid=<?php echo $_SESSION['userid']; ?>" class="format-btn pdf-btn">
                <i class="fas fa-file-pdf format-icon"></i> PDF Format
            </a>
            
            <a href="download_statement.php?format=excel&userid=<?php echo $_SESSION['userid']; ?>" class="format-btn excel-btn">
                <i class="fas fa-file-excel format-icon"></i> Excel Format
            </a>
            
            <a href="download_statement.php?format=csv&userid=<?php echo $_SESSION['userid']; ?>" class="format-btn csv-btn">
                <i class="fas fa-file-csv format-icon"></i> CSV Format
            </a>
        </div>
    </div>
    
    <div class="card mx-auto mt-4">
        <div class="card-header text-center">
            <i class="fas fa-history"></i> Transaction History
        </div>
        <div class="card-body">
            <?php
            $array = $con->query("SELECT * FROM transaction WHERE userid = '$userData[id]' ORDER BY date DESC");
            if ($array->num_rows > 0) {
                while ($row = $array->fetch_assoc()) {
                    if ($row['action'] == 'withdraw') {
                        echo "<div class='alert alert-secondary'><i class='fas fa-arrow-alt-circle-down transaction-icon'></i>You withdrew Rs." . number_format($row['debit'], 2) . " from your account on " . date('F j, Y g:i A', strtotime($row['date'])) . "</div>";
                    }
                    if ($row['action'] == 'deposit') {
                        echo "<div class='alert alert-success'><i class='fas fa-arrow-alt-circle-up transaction-icon'></i>You deposited Rs." . number_format($row['credit'], 2) . " into your account on " . date('F j, Y g:i A', strtotime($row['date'])) . "</div>";
                    }
                    if ($row['action'] == 'deduction') {
                        echo "<div class='alert alert-danger'><i class='fas fa-minus-circle transaction-icon'></i>A deduction of Rs." . number_format($row['debit'], 2) . " was made from your account on " . date('F j, Y g:i A', strtotime($row['date'])) . " for $row[other]</div>";
                    }
                    if ($row['action'] == 'transfer') {
                        echo "<div class='alert alert-warning'><i class='fas fa-paper-plane transaction-icon'></i>A transfer of Rs." . number_format($row['debit'], 2) . " was made from your account on " . date('F j, Y g:i A', strtotime($row['date'])) . " to account no. $row[other]</div>";
                    }
                }
            } else {
                echo "<div class='alert alert-info'><i class='fas fa-info-circle transaction-icon'></i>No transactions found.</div>";
            }
            ?>
        </div>
        <div class="card-footer text-muted">
            <div class="d-flex justify-content-between align-items-center">
                <span><i class="fas fa-calendar-alt"></i> Statement Period: <span id="period-display">All Time</span></span>
                <span><i class="fas fa-exchange-alt"></i> Total Transactions: <?php echo $array->num_rows; ?></span>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    
    // Set default date values
    const today = new Date();
    const thirtyDaysAgo = new Date();
    thirtyDaysAgo.setDate(today.getDate() - 30);
    
    // Format dates for input fields
    $('#date-to').val(formatDate(today));
    $('#date-from').val(formatDate(thirtyDaysAgo));
    
    // Update period display
    updatePeriodDisplay();
    
    // Filter functionality (client-side filtering)
    $("#apply-filter").click(function(){
        filterTransactions();
        updatePeriodDisplay();
    });
    
    $("#transaction-type").change(function(){
        filterTransactions();
    });
    
    function filterTransactions() {
        const type = $("#transaction-type").val();
        const dateFrom = new Date($("#date-from").val());
        const dateTo = new Date($("#date-to").val());
        dateTo.setHours(23, 59, 59, 999); // Include the entire "to" day
        
        $(".alert").each(function() {
            let show = true;
            
            // Filter by type
            if (type !== "all") {
                if (!$(this).text().toLowerCase().includes(type)) {
                    show = false;
                }
            }
            
            // Filter by date if valid dates are provided
            if (!isNaN(dateFrom) && !isNaN(dateTo)) {
                const transactionDateText = $(this).text().match(/on ([A-Za-z]+ \d+, \d+ \d+:\d+ [AP]M)/);
                if (transactionDateText && transactionDateText[1]) {
                    const transactionDate = new Date(transactionDateText[1]);
                    if (transactionDate < dateFrom || transactionDate > dateTo) {
                        show = false;
                    }
                }
            }
            
            $(this).toggle(show);
        });
    }
    
    function updatePeriodDisplay() {
        const dateFrom = $("#date-from").val();
        const dateTo = $("#date-to").val();
        
        if (dateFrom && dateTo) {
            const fromFormatted = new Date(dateFrom).toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });
            
            const toFormatted = new Date(dateTo).toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });
            
            $("#period-display").text(fromFormatted + " - " + toFormatted);
        } else {
            $("#period-display").text("All Time");
        }
    }
    
    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }
});
</script>
</body>
</html>
