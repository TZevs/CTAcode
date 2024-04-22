<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href  ="styles/main.css" />
        <script src="https://kit.fontawesome.com/683ed5d49e.js" crossorigin="anonymous"></script>
        <title>Register</title>
    </head>
    <body>
        <header>
            <div class="header-logo">
                <h1 class="header-logo-text">C.T.A</h1>
                <p class="header-logo-text">Currency Transfer Application</p>
            </div>
            <nav class="header-navbar">
                <ul class="header-navbar-list">
                    <li class="header-navbar-list-item"><a href="index.php">Home</a></li>
                    <li class="header-navbar-list-item item-active"><a href="register.php">Register</a></li>
                    <li class="header-navbar-list-item"><a href="login.php">Login</a></li>
                </ul>
            </nav>
        </header>

        <div class="container">
            <h2 class="text-center">Register For an Account</h2>
            <?php
                require_once("includes/db_conn.php");

                if (isset($_POST["submit"])) {
                    $firstName = $_POST["firstname"];
                    $middleName = $_POST["middlename"];
                    $lastName = $_POST["lastname"];
                    $email = $_POST["email"];
                    $dob = $_POST["dob"];
                    $password = $_POST["input_password"];
                    $confirmPassword = $_POST["confirm_password"];

                    $errors = array();

                    if (empty($firstName) OR empty($lastName) OR empty($email) OR empty($dob) OR empty($password) OR empty($confirmPassword)) {
                        array_push($errors, "Fields with * are required.");
                    }
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        array_push($errors, "Email is not valid.");
                    }
                    if(strlen($password)<8) {
                        array_push($errors, "Password must be at least 8 characters long.");
                    }
                    if ($password!==$confirmPassword) {
                        array_push($errors, "Passwords do not match.");
                    }                 
                    
                    $hashed_Password = password_hash($password, PASSWORD_DEFAULT);

                    if (count($errors)>0) {
                        foreach ($errors as $error) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    } else {
                        $addRecord = "INSERT INTO customeraccounts (first_name, middle_name, last_name, email_address, password, dob) VALUES ('$firstName','$middleName','$lastName','$email','$hashed_Password','$dob')";
                        if ($conn->query($addRecord) === TRUE) {
                            // $addWallet = "INSERT INTO currencywallet (customer_id, currency_id, amount) VALUES ('', 'GBP', 0)";
                            // Find the customer_id of the most recent customer and add 1. 
                            echo "<div class='alert alert-success'>Successfully Registered. <a href='login.php'>Login.</a></div>";
                        } else {
                            echo "<div class='alert alert-danger'>Error adding account: " . $conn->error . "</div>";
                        }
                    }
                }
            ?>
            <form action="register.php" method="POST">
                <div class="form-group">
                    <input type="text" placeholder="First Name *" name="firstname" class="form-control">
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Middle Name" name="middlename" class="form-control">
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Last Name *" name="lastname" class="form-control">
                </div>
                <div class="form-group">
                    <input type="email" placeholder="Email Address *" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <input type="date" placeholder="Date of Birth *" name="dob" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Passsword *" name="input_password" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Confirm Password *" name="confirm_password" class="form-control">
                </div>
                <div class="form-btn">
                    <input type="submit" value="Register" name="submit" class="btn btn-warning">
                </div>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>