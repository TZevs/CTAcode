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
                    <li class="header-navbar-list-item item-active"><a href="login.php">Login</a></li>
                    <li class="header-navbar-list-item"><a href="register.php">Register</a></li>
                </ul>
            </nav>
        </header>

        <div class="container">
            <h2 class="text-center">Login</h2>
            <?php 
                require_once("includes/db_conn.php");

                if ($_SERVER["REQUEST_METHOD"] == "POST") { 
                    session_start();

                    require_once("includes/db_conn.php");

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $userEmail = trim($_POST['email']);
                        $password_input = $_POST['input_password'];

                        if (empty($userEmail) OR empty($password_input)) {
                            echo "<div class='alert alert-danger'>Enter your email and password.</div>";
                        }

                        // Using prepared statements to prevent SQL injection
                        $customer_query = "SELECT email_address, password, suspension FROM customeraccounts WHERE email_address = ? LIMIT 1";
                        $customer_stmt = mysqli_prepare($conn, $customer_query);
                        mysqli_stmt_bind_param($customer_stmt, "s", $userEmail);
                        mysqli_stmt_execute($customer_stmt);
                        mysqli_stmt_store_result($customer_stmt);

                        if (mysqli_stmt_num_rows($customer_stmt) == 1) {
                            mysqli_stmt_bind_result($customer_stmt, $db_email, $db_Hashed_Password, $is_suspended);
                            mysqli_stmt_fetch($customer_stmt);
                            
                        // Verifying password
                        if (password_verify($password_input, $db_Hashed_Password)) {
                            if ($is_suspended == 'True') {
                                echo "<div class='alert alert-danger'>Your account is suspended.</div>";
                            } else {
                            // Regenerate session ID to prevent session fixation
                                session_regenerate_id(true);
                                $_SESSION['userEmail'] = $userEmail;
                                mysqli_stmt_close($customer_stmt);
                                mysqli_close($conn);
                                header("Location: wallets.php");
                                exit();
                            }
                        } else {
                            echo "<div class='alert alert-danger'>Incorrect password.</div>";
                        }
                    } else {
                        // Check admin account
                        $admin_query = "SELECT type_id, email_address FROM adminaccount WHERE email_address = ? AND admin_password = ? LIMIT 1";
                        $admin_stmt = mysqli_prepare($conn, $admin_query);
                        mysqli_stmt_bind_param($admin_stmt, "ss", $userEmail, $password_input);
                        mysqli_stmt_execute($admin_stmt);
                        mysqli_stmt_store_result($admin_stmt);

                        if (mysqli_stmt_num_rows($admin_stmt) == 1) {
                            session_regenerate_id(true);
                            $_SESSION['userEmail'] = $userEmail;
                            mysqli_stmt_close($admin_stmt);
                            mysqli_close($conn);
                            header("Location: customers.php");
                            exit();
                        } else {
                            echo "<div class='alert alert-danger'>Invalid email or password. <a href='login.php'>Please try again.</a></div>";
                            }
                        }
                    } else {
                        header("Location: login.php");
                        exit();
                    }
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