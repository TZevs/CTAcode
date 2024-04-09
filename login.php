<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href  ="styles/main.css" />
        <script src="https://kit.fontawesome.com/683ed5d49e.js" crossorigin="anonymous"></script>
        <title>Login</title>
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
                    <li class="header-navbar-list-item"><a href="register.php">Register</a></li>
                    <li class="header-navbar-list-item item-active"><a href="login.php">Login</a></li>
                </ul>
            </nav>
        </header>

        <div class="container">
            <h2 class="text-center">Login</h2>
            <?php 
                session_start();

                require_once("includes/db_conn.php");

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $userEmail = trim($_POST['email']);
                    $password_input = $_POST['input_password'];

                    $customer = "SELECT * FROM customeraccounts WHERE email_address = '$userEmail' AND password = '$password_input'";
                    $customer_result = mysqli_query($conn, $customer);

                    $admin = "SELECT * FROM adminaccount WHERE email_address = '$userEmail' AND admin_password = '$password_input'";
                    $admin_result = mysqli_query($conn, $admin);
                    
                    $errors = array();

                    if (empty($userEmail) OR empty($password_input)) {
                        array_push($errors, "Enter your email and password. <a href='login.php'>Please try again.</a>");
                    }
                    $userOne = mysqli_fetch_assoc($customer_result);                    
                    /*if ($userOne['suspension'] != "False") {
                        array_push($errors, "Sorry, this account has been suspended.");
                    } */ 

                    if (count($errors) >0) {
                        foreach ($errors as $error) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    } else if (mysqli_num_rows($customer_result) === 1) {
                        $_SESSION['userEmail'] = $userEmail;
                        header("Location: wallets.php");
                    } else if (mysqli_num_rows($admin_result) === 1) {
                        $_SESSION['userEmail'] = $userEmail;
                        header("Location: customers.php");
                    } else {
                        echo "<div class='alert alert-danger'>Sorry, this login does not match an account. <a href='login.php'>Please try again.</a></div>";
                    }
                    mysqli_close($conn);
                }
            ?>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <input type="email" id="email" placeholder="Enter Email" name="email" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <input type="password" id="password" placeholder="Passsword" name="input_password" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" id="submit" value="Login" name="login" class="btn btn-primary">
                </div>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>