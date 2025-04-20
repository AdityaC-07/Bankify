<?php 
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) { 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Bankify</title>
    <link href="images/bankify_symbol.jpg" rel="icon">
    <link href="images/bankify_symbol.jpg" rel="apple-touch-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
    <div class="d-flex justify-content-center align-items-center flex-column" style="min-height: 100vh;">
        <img src="images/bankify_symbol.jpg" alt="Bankify Logo" style="width: 150px; height: 150px;">
        <h1 class="text-center display-4" style="margin-top: 20px; font-size: 2rem;"><?=$_SESSION['user_full_name']?></h1>
        <a href="logout.php" class="btn btn-warning mt-3">Logout</a>
    </div>
</body>
</html>
<?php
} else {
    header("Location: login.php");
    exit;
}
?>