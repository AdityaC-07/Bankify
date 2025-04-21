<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Bankify</title>
    <link href="images/bankify_symbol.jpg" rel="icon">
    <link href="images/bankify_symbol.jpg" rel="apple-touch-icon">
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

        .login-panel {
            text-align: center !important;
        }
    </style>
</head>

<?php
    $con = new mysqli('localhost', 'root', '', 'bankify');

    $error = "";
    if (isset($_POST['userlogin'])) {
        $error = "";
        $user = $_POST['email'];
        $pass = $_POST['password'];

        $result = $con->query("SELECT * FROM userAccounts WHERE email='$user' AND password='$pass'");
        if ($result->num_rows > 0) { 
            session_start();
            $data = $result->fetch_assoc();
            $_SESSION['userid'] = $data['id'];
            $_SESSION['user'] = $data;
            header('location:home.php?id=' . $_SESSION['userid']);
        } else {
            echo '<script>alert("Username or password is incorrect. Please try again!")</script>';
        }
    }
?>

<body scroll="no">
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form login-form">
                <form method="POST" autocomplete="">
                    <h2 class="login-panel">User Login</h2>
                    <p class="login-panel">Login with your email and password.</p>

                    <div class="form-group">
                        <input class="form-control" type="email" name="email" placeholder="Email Address" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control button btn btn-primary" type="submit" name="userlogin" value="Login">
                    </div>
                    <div class="link login-link login-panel">
                        Not a member? <a href="manager_login.php">Manager Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
