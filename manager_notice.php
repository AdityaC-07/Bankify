<?php
session_start();
if (!isset($_SESSION['loginid'])) {
    header('location:manager_login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Notice | Bankify</title>
    <link href="images/bankify_symbol.jpg" rel="icon">
    <link href="images/bankify_symbol.jpg" rel="apple-touch-icon">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="bankify.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
    <?php
    $con = new mysqli('localhost', 'root', '', 'bankify');
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $array = $con->query("SELECT * FROM useraccounts WHERE id = '$_GET[id]'");
    $row = $array->fetch_assoc();
    ?>

    <script type="text/javascript">
        $(window).on('load', function() {
            $('#exampleModal').modal({ backdrop: 'static', keyboard: false });
        });
    </script>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Send Notice to <?php echo htmlspecialchars($row['name']); ?></h5>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <div class="form-group">
                            <input type="hidden" name="userid" value="<?php echo htmlspecialchars($row['id']); ?>">
                            <label for="recipient-name" class="col-form-label">Recipient:</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['name']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Message:</label>
                            <textarea class="form-control" maxlength="50" name="notice" required></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <a href="manager_home.php" class="btn btn-secondary">Close</a>
                    <button type="submit" name="send" class="btn btn-primary">Send Notice</button>
                </div>
                <?php
                if (isset($_POST['send'])) {
                    if ($con->query("INSERT INTO notice (notice, userid) VALUES ('" . $con->real_escape_string($_POST['notice']) . "', '" . $con->real_escape_string($_POST['userid']) . "')")) {
                        echo "<div class='alert alert-success'>Notice sent successfully!</div>";
                        echo "<div class='alert'>Redirecting in 3 seconds...</div>";
                        header('refresh:3; url=manager_home.php');
                        exit;
                    } else {
                        echo "<div class='alert alert-danger'>Error: " . $con->error . "</div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>