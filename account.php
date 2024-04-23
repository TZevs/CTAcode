<?php
    session_start();

    if(!isset($_SESSION['userEmail'])) {
        header("Location: login.php");
        exit();
    }
    $userEmail = $_SESSION['userEmail'];

    require_once("includes/db_conn.php");

    $customerInfo = "SELECT * FROM customeraccounts WHERE email_address = '$userEmail'";
    $customer_result = mysqli_query($conn, $customerInfo);
    $customer = mysqli_fetch_assoc($customer_result);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href  ="styles/main.css" />
        <script src="https://kit.fontawesome.com/683ed5d49e.js" crossorigin="anonymous"></script>
        <title>Account</title>
    </head>
    <body>
        <?php include("includes/customerNav.php") ?>

        <div class="container">
            <h2 class="text-center">Account Details</h2>
            <?php
            echo "<div class='card text-bg-warning border-3 border-black'>";
                echo "<div class='card-body'>";
                    echo "<p> Name: " . $customer['first_name'] . ' ' . $customer['middle_name'] . ' ' . $customer['last_name'] . "</p>";
                    echo "<p> Date of Birth: " . $customer['dob'] . "</p>";
                    echo "<p> Email Address: " . $customer['email_address'] . "</p>";
                echo "</div>";
            echo "</div>";
            ?>
            <?php
                if (isset($_POST["submit"])) {
                    $oldPassword = $_POST['currentpassword'];
                    $newPassword = $_POST['input_password'];
                    $id = $customer['customer_id'];

                    $errors = array();

                    if ($oldPassword != $customer['password']) {
                        array_push($errors, "Incorrect current password.");
                    }
                    if (empty($newPassword) OR empty($oldPassword)) {
                        array_push($errors, "Enter both old and new passwords.");
                    }
                    if(strlen($newPassword)<8) {
                        array_push($errors, "Password must be at least 8 characters long.");
                    }
                    if ($oldPassword == $newPassword) {
                        array_push($errors, "Old and New passwords should not match.");
                    }

                    $updatePassword = "UPDATE customeraccounts SET password = '$newPassword' WHERE customer_id = '$id'";

                    if (count($errors)>0) {
                        foreach ($errors as $error) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    } else if ($conn->query($updatePassword) === TRUE) {
                        echo "<div class='alert alert-success'>Your password has been updated. <a href='account.php'>Refresh</a></div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error updating password: " . $conn->error . "</div>";
                    }
                }
            ?>
            <form action="account.php" method="POST">
                <div class="form-group">
                    <label for="currentpassword">To Change Password:</label>
                    <input type="password" class="form-control" id="currentpassword" name="currentpassword" placeholder="Current Password">
                </div>
                <div class="form-group"> 
                    <input type="password" class="form-control" id="input_password" name="input_password" placeholder="New Password">
                </div>
                <div class="form-group">
                    <input type="submit" value="Update" name="submit" class="btn btn-primary">
                </div>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>