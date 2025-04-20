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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="bankify.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<?php
require 'includes/db_conn.php';
$con = new mysqli('localhost', 'root', '', 'bankify');

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$ar = $con->query("SELECT * FROM useraccounts WHERE id = '$_SESSION[userid]'");
$userData = $ar->fetch_assoc();
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
            <a href="home.php" class="nav-item nav-link">Home</a>
            <a href="account.php" class="nav-item nav-link">Accounts</a>
            <a href="statement.php" class="nav-item nav-link">Account Statements</a>
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

<div class="card w-75 mx-auto">
    <div class="card-header text-center">
        Notification from Bank
    </div>
    <div class="card-body">
        <?php
        $array = $con->query("SELECT * FROM notice WHERE userid = '$_SESSION[userid]' ORDER BY time DESC");
        if ($array->num_rows > 0) {
            while ($row = $array->fetch_assoc()) {
                echo "<div class='alert alert-info alert-dismissible d-flex align-items-center fade show'>
                        <i class='bi-info-circle-fill'></i>
                        <strong class='mx-2'>Info!</strong> $row[notice]
                        <a href='delete_notice.php' class='btn btn-danger btn-sm'><i class='bi bi-trash'></i></a>
                      </div>";
            }
        } else {
            echo "<div class='alert alert-info'>Notice box empty</div>";
        }
        ?>
    </div>
    <div class="card-footer text-muted"></div>
</div>
</body>
</html>