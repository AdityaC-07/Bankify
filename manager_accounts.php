<?php
session_start();
if (!isset($_SESSION['loginid'])) {
    header('location:manager_login.php');
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
      <link rel="stylesheet" href="bankify.css">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
   </head>

   <?php 
   require 'includes/function.php'; 
   $con = new mysqli('localhost', 'root', '', 'bankify');
   ?>

   <?php 
   if (isset($_GET['delete'])) {
       if ($con->query("DELETE FROM feedback WHERE feedbackid = '$_GET[delete]'")) {
           header("location:manager_feedback.php");
       }
   }
   ?>

   <body>
      <nav>
         <div class="logo">
            <img src="images/bankify_symbol.jpg" width="45" alt="" class="logo-img">
            Bankify
         </div>
         <input type="checkbox" id="click">
         <label for="click" class="menu-btn">Menu</label>
         <ul>
            <li><a href="manager_home.php">Home</a></li>
            <li><a href="manager_accounts.php" class="active">Accounts</a></li>
            <li><a href="addnewaccount.php">Add New Account</a></li>
            <li><a href="manager_feedback.php">Feedback</a></li>
            <li><a href="logout.php">Logout</a></li>
         </ul>
      </nav>

      <?php
      if (isset($_POST['saveAccount'])) {
          if (!$con->query("INSERT INTO login (email, password, type) VALUES ('$_POST[email]', '$_POST[password]', 'cashier')")) {
              echo "<div class='alert alert-danger'>Failed. Error: " . $con->error . "</div>";
          }
      }
      if (isset($_GET['del']) && !empty($_GET['del'])) {
          $con->query("DELETE FROM login WHERE id = '$_GET[del]'");
      }
      $array = $con->query("SELECT * FROM login WHERE type='cashier'");
      ?>

      <div class="container">
         <div>
            <div class="card-header">
               <h4 style="color:#CC3300;">All Staff Accounts
                  <button class="btn btn-outline-danger btn-sm float-right" data-toggle="modal" data-target="#exampleModal">Add New Account</button>
               </h4>
            </div>
            <div>
               <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                     <tr>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Account Type</th>
                        <th></th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                     if ($array->num_rows > 0) {
                         while ($row = $array->fetch_assoc()) {
                             echo "<tr>";
                             echo "<td>" . $row['email'] . "</td>";
                             echo "<td>" . $row['password'] . "</td>";
                             echo "<td>" . $row['type'] . "</td>";
                             echo "<td><a href='manager_accounts.php?del=$row[id]' class='btn btn-danger btn-sm'>Delete</a></td>";
                             echo "</tr>";
                         }
                     }
                     ?>
                  </tbody>
               </table>
            </div>
         </div>

         <!-- Modal -->
         <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">New Cashier Account</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <form method="POST">
                        Enter Details
                        <input class="form-control w-75 mx-auto" type="email" name="email" required placeholder="Email">
                        <input class="form-control w-75 mx-auto" type="password" name="password" required placeholder="Password">
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     <button type="submit" name="saveAccount" class="btn btn-primary">Save Account</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>