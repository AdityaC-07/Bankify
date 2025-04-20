<?php
// Start the session at the top of your file
session_start();

// Database connection
$con = new mysqli('localhost', 'root', '', 'bankify');

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if login form was submitted
if (isset($_POST['login'])) {
    $error = "";
    $user = $_POST['email'];
    $pass = $_POST['password'];
    
    // Query to check manager credentials
    $result = $con->query("SELECT * FROM manager WHERE email='$user' AND password='$pass'");
    
    if ($result->num_rows > 0) { 
        $data = $result->fetch_assoc();
        $_SESSION['loginid'] = $data['id'];
        header('location:manager_home.php');
        exit; // Always exit after a header redirect
    } else {
        echo '<script>alert("Username or password is incorrect. Please try again!")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Bankify</title>
    <link href="images/bankify_symbol.jpg" rel="icon">
    <link href="images/bankify_symbol.jpg" rel="apple-touch-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="bankify.css" rel="stylesheet">
</head>

<body scroll="no" style="overflow: hidden">
    <div class="image">
        <img src="images/bankify_background.jpg" alt="Bankify Background">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form login-form">
                <form method="POST" autocomplete="">
                    <h2 class="text-center1">Manager Login</h2>
                    <p class="text-center1">Login with your email and password.</p>
                    <style>
                        .text-center1 {
                            text-align: center !important;
                            color: red;
                        }
                        h6 {
                            overflow: hidden;
                            text-align: center;
                        }
                        h6:before,
                        h6:after {
                            background-color: #000;
                            content: "";
                            display: inline-block;
                            height: 1px;
                            position: relative;
                            vertical-align: middle;
                            width: 30%;
                        }
                        h6:before {
                            right: 0.5em;
                            margin-left: -50%;
                        }
                        h6:after {
                            left: 0.5em;
                            margin-right: -50%;
                        }
                    </style>
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" placeholder="Email Address" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group1">
                        <input class="form-control button" type="submit" name="login" value="Login">
                    </div>
                    <br>
                    <div class="link login-link text-center">Not a member? <a href="login.php">User Login</a></div>
                    <h6>or</h6>
                    <center><a href="cashier.php">Cashier Login</a></center>
                </form>
            </div>
        </div>
    </div>
</body>
</html>