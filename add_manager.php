<?php
// Connect to database
$con = new mysqli('localhost', 'root', '', 'bankify');

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// SQL to modify the password field from int to varchar
$sql = "ALTER TABLE manager MODIFY password VARCHAR(100) NOT NULL";

// Execute query
if ($con->query($sql) === TRUE) {
    echo "Table structure modified successfully. Password field is now VARCHAR(100)<br>";
    
    // Now create a manager with text password
    $email = 'manager3@gmail.com';
    $password = 'manager123';
    $type = 'manager';
    
    $insert_sql = "INSERT INTO manager (email, password, type) 
                   VALUES ('$email', '$password', '$type')";
                   
    if ($con->query($insert_sql) === TRUE) {
        echo "New manager account created successfully!<br>";
        echo "Email: " . $email . "<br>";
        echo "Password: " . $password . "<br>";
    } else {
        echo "Error creating manager: " . $con->error . "<br>";
    }
    
} else {
    echo "Error modifying table: " . $con->error;
}

// Close connection
$con->close();
?>