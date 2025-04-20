<?php
// Connect to database
$con = new mysqli('localhost', 'root', '', 'charusat_bank');

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Query to get all managers
$result = $con->query("SELECT * FROM manager");

echo "<h2>Current Managers in Database</h2>";
echo "<table border='1'>
<tr>
<th>ID</th>
<th>Email</th>
<th>Password</th>
<th>Type</th>
<th>Date</th>
</tr>";

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>" . $row["id"] . "</td>
        <td>" . $row["email"] . "</td>
        <td>" . $row["password"] . "</td>
        <td>" . $row["type"] . "</td>
        <td>" . $row["date"] . "</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No managers found</td></tr>";
}
echo "</table>";

// Close connection
$con->close();
?>