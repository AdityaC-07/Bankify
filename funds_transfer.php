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
    <title>Funds Transfer | Bankify</title>
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
            background-color: #f0f0f0;
            background-image: url('home.jpg');
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
            background-color: rgba(240, 240, 240, 0.85);
            z-index: -1;
        }
        
        .navbar {
            background-color: #333333 !important;
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
            color: #ffb400 !important;
        }
        
        .logo-img {
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .container {
            margin-top: 2rem;
            margin-bottom: 30px;
        }
        
        .card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border: none;
            overflow: hidden;
        }
        
        .card-header {
            background-color: #333333;
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
            background-color: #ffb400;
            border-color: #ffb400;
            color: #333333;
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
            color: #333333;
            font-weight: bold;
        }
        
        .bg-white {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border: none;
            overflow: hidden;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-control {
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 10px 15px;
            height: auto;
        }
        
        .btn-primary {
            background-color: #333333;
            border-color: #333333;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 30px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: #555555;
            border-color: #555555;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 0 5px 5px 0;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
        }
        
        .input-group-append {
            margin-left: -1px;
        }
        
        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .tip-item {
            opacity: 0;
            animation: fadeIn 1s ease-in-out forwards;
        }
        
        .tip-item:nth-child(1) { animation-delay: 0.5s; }
        .tip-item:nth-child(2) { animation-delay: 0.7s; }
        .tip-item:nth-child(3) { animation-delay: 0.9s; }
        .tip-item:nth-child(4) { animation-delay: 1.1s; }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media (max-width: 768px) {
            .form-group {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>

<?php
$con = new mysqli('localhost', 'root', '', 'bankify');

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$ar = $con->query("SELECT * FROM useraccounts WHERE id = '$_SESSION[userid]'");
$userData = $ar->fetch_assoc();

// Define the setBalance function
function setBalance($amount, $type, $accountNo) {
    global $con;
    if ($type === 'debit') {
        $query = "UPDATE useraccounts SET deposit = deposit - $amount WHERE accountno = '$accountNo'";
    } elseif ($type === 'credit') {
        $query = "UPDATE useraccounts SET deposit = deposit + $amount WHERE accountno = '$accountNo'";
    } else {
        return false;
    }
    return $con->query($query);
}

// Define the makeTransaction function
function makeTransaction($action, $amount, $otherAccountNo) {
    global $con, $userData;
    $userId = $userData['id'];
    $query = "INSERT INTO transaction (userid, action, debit, other) VALUES ('$userId', '$action', '$amount', '$otherAccountNo')";
    return $con->query($query);
}
?>

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
            <a href="statement.php" class="nav-item nav-link"><i class="fas fa-file-invoice"></i> Account Statements</a>
            <a href="funds_transfer.php" class="nav-item nav-link active"><i class="fas fa-exchange-alt"></i> Funds Transfer</a>
        </div>
        <div class="navbar-nav ml-auto">
            <a href="#" class="btn btn-warning" data-toggle="tooltip" title="Your current Account Balance">
                <i class="fas fa-wallet"></i> Account Balance: ₹<?php echo number_format($userData['deposit'], 2); ?>
            </a>
            <a href="notice.php" class="nav-item nav-link notifications">
                <i class="fas fa-bell"></i> Notifications
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

<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card feature-card mb-4">
                <div class="card-header">
                    <i class="fas fa-paper-plane"></i> Bank Transfer
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="form-group">
                            <label>Receiver Account Number</label>
                            <div class="input-group">
                                <input type="text" name="otherNo" placeholder="Enter Receiver Account Number" class="form-control" required>
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="submit" name="get">Get Account Info</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php
                    if (isset($_POST['get'])) {
                        $array2 = $con->query("SELECT * FROM otheraccounts WHERE accountno = '$_POST[otherNo]'");
                        $array3 = $con->query("SELECT * FROM useraccounts WHERE accountno = '$_POST[otherNo]'");
                        if ($array2->num_rows > 0) {
                            $row2 = $array2->fetch_assoc();
                            echo "
                            <form method='POST'>
                                <div class='form-group'>
                                    <label>Account No.</label>
                                    <input type='text' value='$row2[accountno]' name='otherNo' class='form-control' readonly required>
                                </div>
                                <div class='form-group'>
                                    <label>Account Holder Name</label>
                                    <input type='text' class='form-control' value='$row2[holdername]' readonly required>
                                </div>
                                <div class='form-group'>
                                    <label>Account Holder Bank Name</label>
                                    <input type='text' class='form-control' value='$row2[bankname]' readonly required>
                                </div>
                                <div class='form-group'>
                                    <label>Enter Amount for Transfer</label>
                                    <input type='number' name='amount' class='form-control' min='3000' max='$userData[deposit]' required>
                                </div>
                                <button type='submit' name='transfer' class='btn btn-primary btn-block'>Transfer</button>
                            </form>";
                        } elseif ($array3->num_rows > 0) {
                            $row2 = $array3->fetch_assoc();
                            echo "
                            <form method='POST'>
                                <div class='form-group'>
                                    <label>Account No.</label>
                                    <input type='text' value='$row2[accountno]' name='otherNo' class='form-control' readonly required>
                                </div>
                                <div class='form-group'>
                                    <label>Account Holder Name</label>
                                    <input type='text' class='form-control' value='$row2[name]' readonly required>
                                </div>
                                <div class='form-group'>
                                    <label>Enter Amount for Transfer</label>
                                    <input type='number' name='amount' class='form-control' min='3000' max='$userData[deposit]' required>
                                </div>
                                <button type='submit' name='transferSelf' class='btn btn-primary btn-block'>Transfer</button>
                            </form>";
                        } else {
                            echo "<div class='alert alert-danger'><i class='fas fa-exclamation-circle'></i> Account No. $_POST[otherNo] does not exist</div>";
                        }
                    }

                    if (isset($_POST['transferSelf'])) {
                        $amount = $_POST['amount'];
                        setBalance($amount, 'debit', $userData['accountno']);
                        setBalance($amount, 'credit', $_POST['otherNo']);
                        makeTransaction('transfer', $amount, $_POST['otherNo']);
                        echo "<script>alert('Transfer Successful');window.location.href='funds_transfer.php'</script>";
                    }

                    if (isset($_POST['transfer'])) {
                        $amount = $_POST['amount'];
                        setBalance($amount, 'debit', $userData['accountno']);
                        makeTransaction('transfer', $amount, $_POST['otherNo']);
                        echo "<script>alert('Transfer Successful');window.location.href='funds_transfer.php'</script>";
                    }
                    ?>
                </div>
            </div>

            <div class="card feature-card" id="transactions">
                <div class="card-header text-center">
                    <i class="fas fa-history"></i> Recent Transfers
                </div>
                <div class="card-body">
                    <?php
                    $array = $con->query("SELECT * FROM transaction WHERE userid = '$userData[id]' AND action = 'transfer' ORDER BY date DESC");
                    if ($array->num_rows > 0) {
                        while ($row = $array->fetch_assoc()) {
                            echo "<div class='alert alert-warning tip-item'><i class='fas fa-paper-plane transaction-icon'></i>Transfer of ₹" . number_format($row['debit'], 2) . " made to account no. $row[other] on " . date('F j, Y g:i A', strtotime($row['date'])) . "</div>";
                        }
                    } else {
                        echo "<div class='alert alert-info tip-item'><i class='fas fa-info-circle transaction-icon'></i>You have made no transfers yet.</div>";
                    }
                    ?>
                </div>
                <div class="card-footer text-muted">
                    <div class="d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-exchange-alt"></i> Total Transfers: <?php echo $array->num_rows; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
</body>
</html>
