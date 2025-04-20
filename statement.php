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
    <link rel="stylesheet" href="bankify.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
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
            <a href="home.php" class="nav-item nav-link">Home</a>
            <a href="account.php" class="nav-item nav-link">Accounts</a>
            <a href="#" class="nav-item nav-link active">Account Statements</a>
            <a href="funds_transfer.php" class="nav-item nav-link">Funds Transfer</a>
        </div>
        <div class="navbar-nav ml-auto">
            <a href="#" class="btn btn-warning" data-toggle="tooltip" title="Your current Account Balance">
                Account Balance: Rs.<?php echo $userData['deposit']; ?>
            </a>
            <a href="notice.php" class="nav-item nav-link notifications">
                <i class="fa fa-bell-o"></i>
            </a>
            <div class="nav-item dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle user-action">
                    <img src="<?php echo "images/" . $userData['profile']; ?>" width="100px" alt="image">
                    <?php echo $userData['name']; ?>
                </a>
                <div class="dropdown-menu">
                    <a href="profile.php" class="dropdown-item"><i class="fa fa-user-o"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <a href="logout.php" class="dropdown-item"><i class="material-icons">&#xE8AC;</i> Logout</a>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="container">
    <div class="card mx-auto">
        <div class="card-header text-center">
            Transactions on Your Account
        </div>
        <div class="card-body">
            <?php
            $array = $con->query("SELECT * FROM transaction WHERE userid = '$userData[id]' ORDER BY date DESC");
            if ($array->num_rows > 0) {
                while ($row = $array->fetch_assoc()) {
                    if ($row['action'] == 'withdraw') {
                        echo "<div class='alert alert-secondary'>You withdrew Rs.$row[debit] from your account on $row[date]</div>";
                    }
                    if ($row['action'] == 'deposit') {
                        echo "<div class='alert alert-success'>You deposited Rs.$row[credit] into your account on $row[date]</div>";
                    }
                    if ($row['action'] == 'deduction') {
                        echo "<div class='alert alert-danger'>A deduction of Rs.$row[debit] was made from your account on $row[date] for $row[other]</div>";
                    }
                    if ($row['action'] == 'transfer') {
                        echo "<div class='alert alert-warning'>A transfer of Rs.$row[debit] was made from your account on $row[date] to account no. $row[other]</div>";
                    }
                }
            } else {
                echo "<div class='alert alert-info'>No transactions found.</div>";
            }
            ?>
        </div>
        <div class="card-footer text-muted"></div>
    </div>
</div>
</body>
</html>