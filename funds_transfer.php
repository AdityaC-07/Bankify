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
    <title>Bankify</title>
    <link href="images/bankify_symbol.jpg" rel="icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merienda+One">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="bankify.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <a href="home.php" class="nav-item nav-link">Home</a>
            <a href="statement.php" class="nav-item nav-link">Account Statements</a>
            <a href="funds_transfer.php" class="nav-item nav-link active">Funds Transfer</a>
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

<div class="container py-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="bg-white rounded-lg shadow-sm p-5">
                <h5><i class="fa fa-university fa-lg"></i> Bank Transfer</h5>
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
                        echo "<div class='alert alert-danger'>Account No. $_POST[otherNo] does not exist</div>";
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

                $array = $con->query("SELECT * FROM transaction WHERE userid = '$userData[id]' AND action = 'transfer' ORDER BY date DESC");
                if ($array->num_rows > 0) {
                    while ($row = $array->fetch_assoc()) {
                        echo "<div class='alert alert-warning'>Transfer of Rs.$row[debit] made to account no. $row[other] on $row[date]</div>";
                    }
                } else {
                    echo "<div class='alert alert-info'>You have made no transfers yet.</div>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
