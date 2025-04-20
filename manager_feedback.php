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
            <li><a href="manager_accounts.php">Accounts</a></li>
            <li><a href="addnewaccount.php">Add New Account</a></li>
            <li><a href="#" class="active">Feedback</a></li>
            <li><a href="logout.php">Logout</a></li>
         </ul>
      </nav>

      <div class="container">
         <div class="card w-100 text-center">
            <div class="card-header">
               <h4 style="text-align:center; color:#CC3300;">Feedback from Account Holders</h4>
            </div>
            <div class="card-body">
               <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                     <tr>
                        <th scope="col">From</th>
                        <th scope="col">Account No.</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Message</th>
                        <th scope="col"></th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                     $array = $con->query("SELECT * FROM useraccounts, feedback WHERE useraccounts.id = feedback.userid");
                     if ($array->num_rows > 0) {
                         while ($row = $array->fetch_assoc()) {
                     ?>
                     <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['accountno']; ?></td>
                        <td><?php echo $row['phonenumber']; ?></td>
                        <td><?php echo $row['message']; ?></td>
                        <td>
                           <a href="manager_feedback.php?delete=<?php echo $row['feedbackid']; ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete this Message">Delete</a>
                        </td>
                     </tr>
                     <?php
                         }
                     }
                     ?>
                  </tbody>
               </table>
            </div>
            <div class="card-footer text-muted"></div>
         </div>
      </div>
   </body>
</html>