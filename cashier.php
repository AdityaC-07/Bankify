<?php
$con = new mysqli('localhost', 'root', '', 'charusat_bank');
if (isset($_POST['cashierLogin'])) {
    $error = "";
    $user = $_POST['email'];
    $pass = $_POST['password'];

    $result = $con->query("SELECT * FROM login WHERE email='$user' AND password='$pass'");
    if ($result->num_rows > 0) {
        session_start();
        $data = $result->fetch_assoc();
        $_SESSION['cashid'] = $data['id'];
        header('location:cashier_index.php');
        exit;
    } else {
        echo '<script>alert("Username or password wrong, try again!")</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Charusat Bank</title>
    <link href="charusat_symbol.jpg" rel="icon">
    <link href="charusat_symbol.jpg" rel="apple-touch-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            background-image: url('charusat_bank.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 100vh;
            overflow: hidden;
        }

        .login-form {
            background-color: rgba(255, 255, 255, 0.92);
            padding: 30px;
            margin-top: 100px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        }

        .text-center1 {
            text-align: center !important;
            color: green;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form login-form">
                <form method="POST" autocomplete="off">
                    <h2 class="text-center1">Cashier Login</h2>
                    <p class="text-center1">Login with your email and password.</p>

                    <div class="form-group">
                        <input class="form-control" type="email" name="email" placeholder="Email Address" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" placeholder="Password" required>
                    </div>

                    <div class="form-group">
                        <input class="form-control btn btn-success" type="submit" name="cashierLogin" value="Login">
                    </div>

                    <br>
                    <div class="link login-link text-center">
                        Not a member? <a href="manager_login.php">Manager Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
