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
                    $userPassword = $_POST['input_password'];

                    $hashed_password = hash('sha256', $userPassword);

                    $sql = "SELECT * FROM customeraccounts WHERE email_address = '$userEmail' AND 'password' = '$hashed_password'";
                    $result = $conn->query($sql);
                    
                    if (empty($userEmail) OR empty($userPassword)) {
                        echo "<div class='alert alert-danger'>Please enter your email and password.</div>";
                    }

                    if (mysqli_num_rows($result) == 1) {
                        $user = mysqli_fetch_assoc($result);
                        $_SESSION['userEmail'] = $userPassword;

                        if ($user['suspended'] === 'False') {
                            header("Location: wallets.php");
                            exit();
                        } else {
                            echo "<div class='alert alert-danger'>Sorry, this account has been suspended.</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Sorry, this login does not match an account. <a href='login.php'>Please try again.</a></div>";
                    }
                    mysqli_close($conn);
                }
            ?>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <input type="email" placeholder="Enter Email" name="email" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <input type="password" placeholder="Passsword" name="input_password" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" value="Login" name="login" class="btn btn-primary">
                    <input type="submit" value="Admin Login" name="adminlogin" class="btn btn-warning">
                </div>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>