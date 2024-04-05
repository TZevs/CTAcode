<?php
    session_start();

    if(!isset($_SESSION['userEmail'])) {
        header("Location: login.php");
        exit();
    }
    $userEmail = $_SESSION['userEmail'];

    require_once("includes/db_conn.php");

    $userInfo = "SELECT * FROM customeraccounts WHERE email_address = '$userEmail'";
    $info_result = mysqli_query($conn, $userInfo);

    /*$stmt = $conn->prepare("SELECT * FROM customeraccounts WHERE email_address = ?");
    $stmt->bind_param('s', $_GET['email_address']);
    $stmt->execute();
    $result = $stmt->get_result();*/ 
    // Error: Attempt to read property 'first_name' on null.
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
        <header>
            <div class="header-logo">
                <h1 class="header-logo-text">C.T.A</h1>
                <p class="header-logo-text">Currency Transfer Application</p>
            </div>
            <nav class="header-navbar">
                <ul class="header-navbar-list">
                    <li class="header-navbar-list-item"><a href="index.php">Home</a></li>
                    <li class="header-navbar-list-item"><a href="wallets.php">Wallets</a></li>
                    <li class="header-navbar-list-item"><a href="transaction.php">Transactions</a></li>
                    <li class="header-navbar-list-item"><a href="exchange.php">Exchange Rates</a></li>
                    <li class="header-navbar-list-item item-active"><a href="account.php"><i class="fa-solid fa-user"></i></a></li>
                </ul>
            </nav>
        </header>

        <div class="container">
            <h2>Account Details</h2>
            <?php
            $user = mysqli_fetch_assoc($info_result);
            echo "<div>";
            echo "<h3> First Name: " . $user['first_name'] . "</h3>";
            echo "<h3> Middle Name: " . $user['middle_name'] . "</h3>";
            echo "<h3> Surname: " . $user['last_name'] . "</h3>";
            echo "<h3> Date of Birth: " . $user['dob'] . "</h3>";
            echo "<h3> Email Address: " . $user['email_address'] . "</h3>";
            echo "</div>";
            ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Change Email Address:</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="example@example.com">
                </div>
                <div class="form-group"> 
                    <label for="input_password">Change Password:</label>
                    <input type="password" class="form-control" id="input_password" name="input_password" placeholder="********">
                </div>
                <div class="row g-3">
                    <div class="col form-btn">
                        <input type="submit" value="Update" name="update" class="btn btn-warning">
                    </div>
                </div>
            </form>
            <div>
                <h4 class="btn btn-primary"><a href="includes/logout.php" class="links">Logout</a></h4>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>