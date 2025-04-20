<?php
include 'profile.php';

$dob = $_POST["dob"];
$email = $_POST["email"];
$phonenumber = $_POST["phonenumber"];
$occupation = $_POST["occupation"];
$city = $_POST["city"];

$servername = "localhost";
$username = "root";
$password = "";
$db = "bankify"; // Updated database name

$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE useraccounts 
        SET dob='$dob', email='$email', phonenumber='$phonenumber', occupation='$occupation', city='$city' 
        WHERE id='$_SESSION[userid]'";

if ($conn->query($sql) === TRUE) {
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('Data Successfully Updated');
    window.location.href='profile.php';
    </script>");
} else {
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('Data not Updated');
    window.location.href='home.php';
    </script>");
}

$conn->close();
?>