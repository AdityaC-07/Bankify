<?php
session_start();
if (!isset($_SESSION['loginid'])) {
    header('location:manager_login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Bankify</title>
    <link href="images/bankify_symbol.jpg" rel="icon">
    <link href="images/bankify_symbol.jpg" rel="apple-touch-icon">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #fff;
        }
        .logo-img {
            margin-bottom: -5px;
        }
        nav {
            background-color: #343a40;
            padding: 10px 20px;
        }
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }
        nav ul li {
            margin: 0 10px;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        nav ul li a:hover,
        nav ul li a.active {
            background-color: #007bff;
            color: #fff;
        }
        .container {
            margin-top: 20px;
        }
        .card-body h1 {
            color: #CC3300;
            text-align: center;
            margin-bottom: 20px;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .btn-sm {
            font-size: 14px;
        }
    </style>
</head>
<?php require 'includes/db_conn.php'; ?>
<body>
    <nav>
        <div class="logo">
            <img src="images/bankify_symbol.jpg" width="45" alt="" class="logo-img">
            Bankify
        </div>
        <ul>
            <li><a class="active" href="#">Home</a></li>
            <li><a href="manager_accounts.php">Accounts</a></li>
            <li><a href="addnewaccount.php">Add New Account</a></li>
            <li><a href="manager_feedback.php">Feedback</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="card-body">
            <h1>Accounts</h1>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Profile Picture</th>
                            <th>Holder Name</th>
                            <th>Account No.</th>
                            <th>Gender</th>
                            <th>Current Balance</th>
                            <th>Account Type</th>
                            <th>Contact No.</th>
                            <th>Time</th>
                            <th>View</th>
                            <th>Send Notice</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $con = new mysqli('localhost', 'root', '', 'bankify');
                        if (isset($_GET['delete'])) {
                            if ($con->query("DELETE FROM useraccounts WHERE id = '$_GET[delete]'")) {
                                echo "<div class='alert alert-success'>Account deleted successfully.</div>";
                            } else {
                                echo "<div class='alert alert-danger'>Failed to delete account.</div>";
                            }
                        }

                        $array = $con->query("SELECT * FROM useraccounts");
                        if ($array->num_rows > 0) {
                            $i = 0;
                            while ($row = $array->fetch_assoc()) {
                                $i++;
                        ?>
                        <tr>
                            <th scope="row"><?php echo $i; ?></th>
                            <td>
                                <center><img src="<?php echo "images/" . $row['profile']; ?>" width="80px" height="80px" alt="image"></center>
                            </td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['accountno']; ?></td>
                            <td><?php echo $row['gender']; ?></td>
                            <td>Rs.<?php echo $row['deposit']; ?></td>
                            <td><?php echo $row['accounttype']; ?></td>
                            <td><?php echo $row['phonenumber']; ?></td>
                            <td><?php echo $row['time']; ?></td>
                            <td>
                                <a href="view.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm" data-toggle="tooltip" title="View More Info">View</a>
                            </td>
                            <td>
                                <a href="manager_notice.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Send Notice</a>
                            </td>
                            <td>
                                <a href="manager_home.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete this Account">Delete</a>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='12'>No accounts found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>