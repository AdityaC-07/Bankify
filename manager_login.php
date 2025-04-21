<?php
// Start the session
session_start();

// Database connection
$con = new mysqli('localhost', 'root', '', 'bankify');

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if login form was submitted
if (isset($_POST['login'])) {
    $user = $_POST['email'];
    $pass = $_POST['password'];

    // Query to check manager credentials
    $result = $con->query("SELECT * FROM manager WHERE email='$user' AND password='$pass'");

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $_SESSION['loginid'] = $data['id'];
        header('location:manager_home.php');
        exit;
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
    <title>Manager Login | Bankify</title>
    <link href="image.png" rel="icon">
    <link href="image.png" rel="apple-touch-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>
        body {
            background-image: url('image.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            overflow: hidden;
        }

        .form.login-form {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            margin-top: 100px;
        }

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
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form login-form">
                <form method="POST" autocomplete="off">
                    <h2 class="text-center1">Manager Login</h2>
                    <p class="text-center1">Login with your email and password.</p>

                    <div class="form-group">
                        <input class="form-control" type="email" name="email" placeholder="Email Address" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control btn btn-primary" type="submit" name="login" value="Login">
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
