<?php
session_start();
if (!isset($_SESSION['loginid'])) {
    header('location:manager_login.php');
    exit;
}
require 'includes/db_conn.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $aadhaar = $_POST['aadhaar'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $profile = $_POST['profile'];
    $dob = $_POST['dob'];
    $accountno = $_POST['accountno'];
    $accounttype = $_POST['accounttype'];
    $deposit = $_POST['deposit'];
    $occupation = $_POST['occupation'];

    $sql = "INSERT INTO useraccounts (name, aadhaar, gender, email, phonenumber, city, address, password, profile, dob, accountno, accounttype, deposit, occupation) 
            VALUES ('$name', '$aadhaar', '$gender', '$email', '$phonenumber', '$city', '$address', '$password', '$profile', '$dob', '$accountno', '$accounttype', '$deposit', '$occupation')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success text-center'>Account added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Error: " . $conn->error . "</div>";
    }
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
            font-size: 14px;
            background-color: #f8f9fa;
        }
        .form-control, .custom-select {
            font-size: 14px;
        }
        .card-title {
            font-size: 18px;
            font-weight: bold;
        }
        .btn {
            font-size: 14px;
        }
        .custom-file-label {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        .custom-file-input:focus ~ .custom-file-label {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .invalid-feedback {
            font-size: 12px;
        }
        .navbar {
            font-size: 14px;
        }
        .card {
            margin-top: 20px;
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
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #fff;
        }
        .logo-img {
            margin-bottom: -5px;
        }
    </style>
</head>
<body>
    <nav>
        <div class="logo">
            <img src="images/bankify_symbol.jpg" width="45" alt="" class="logo-img">
            Bankify
        </div>
        <ul>
            <li><a href="manager_home.php">Home</a></li>
            <li><a href="manager_accounts.php">Accounts</a></li>
            <li><a href="addnewaccount.php" class="active">Add New Account</a></li>
            <li><a href="manager_feedback.php">Feedback</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="row">
            <div class="offset-md-2 col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <center>
                            <h4 class="card-title text-uppercase">New Account Form</h4>
                        </center>
                    </div>
                    <div class="card-body">
                        <form id="needs-validation" method="POST">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" id="name" pattern="[A-Za-z\s]+" name="name" placeholder="Enter Your Name" class="form-control" required />
                                        <div class="invalid-feedback">Please Enter Your Full Name</div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Aadhaar Card</label>
                                        <input type="tel" id="aadhaar" name="aadhaar" pattern="^\d{12}$" placeholder="Enter Your Aadhaar Card" class="form-control" required />
                                        <div class="invalid-feedback">Please Enter Your Aadhaar Card</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="Gender">Gender</label>
                                        <select name="gender" class="custom-select" required>
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                        <div class="invalid-feedback">Please choose gender</div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input type="email" name="email" class="form-control" pattern="^[a-zA-Z0-9]+[0-9]@gmail\.com$" id="email" placeholder="Email Address" required>
                                        <div class="invalid-feedback">Please provide a valid email.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <input type="number" name="phonenumber" pattern="[6789][0-9]{9}" class="form-control" maxlength="10" id="phonenumber" placeholder="Mobile Number" required />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="Password">Password</label>
                                        <input type="Password" name="password" class="form-control" maxlength="10" id="Password" placeholder="Enter Your Password" required>
                                        <div class="invalid-feedback">Please Enter a Password.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" name="city" class="form-control" id="city" placeholder="Enter Your City" required>
                                        <div class="invalid-feedback">Please Enter Your City</div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="Address">Address</label>
                                        <input type="Address" maxlength="50" name="address" class="form-control" id="Address" placeholder="Enter Your Address" required>
                                        <div class="invalid-feedback">Please provide a valid Address.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Profile Picture</label>
                                        <div class="custom-file">
                                            <input type="file" name="profile" class="custom-file-input" id="validatedCustomFile" required>
                                            <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                            <div class="invalid-feedback">Choose file for upload</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Date of Birth</label>
                                        <input type="date" name="dob" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="accountNo">Account Number</label>
                                        <input type="text" name="accountno" readonly value="<?php echo time(); ?>" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="Aadhaar">Account Type</label>
                                        <select name="accounttype" class="custom-select" required>
                                            <option value="Saving">Saving</option>
                                            <option value="Current">Current</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="Deposit">Deposit</label>
                                        <input type="number" name="deposit" min="3000" max="100000" class="form-control" required>
                                        <div class="invalid-feedback">Minimum amount Rs 3000 and Maximum amount Rs 100000</div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="Occupation">Occupation</label>
                                        <input type="text" name="occupation" class="form-control" required>
                                        <div class="invalid-feedback">Please Enter Your Occupation</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="float-right">
                                        <a href="manager_home.php" class="btn btn-danger rounded-0">Cancel</a>
                                        <button class="btn btn-primary rounded-0" name="submit" id="submit" type="submit">Register</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>