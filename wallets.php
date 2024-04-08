<?php
    session_start();

    if(!isset($_SESSION['userEmail'])) {
        header("Location: login.php");
        exit();
    }
    $customerEmail = $_SESSION['userEmail'];

    require_once("includes/db_conn.php");

    $info = "SELECT * FROM customeraccounts
                INNER JOIN currencywallet ON currencywallet.customer_id = customeraccounts.customer_id
                WHERE customeraccounts.email_address = '$customerEmail'";
    $info_results = $conn->query($info);

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
                    <li class="header-navbar-list-item item-active"><a href="wallets.php">Wallets</a></li>
                    <li class="header-navbar-list-item"><a href="transaction.php">Transactions</a></li>
                    <li class="header-navbar-list-item"><a href="exchange.php">Exchange Rates</a></li>
                    <li class="header-navbar-list-item"><a href="account.php"><i class="fa-solid fa-user"></i></a></li>
                </ul>
            </nav>
        </header>

        <div class="container">
            <h3>Your Wallets</h3>
            <?php 
                while ($obj = $info_results->fetch_object()) {
                    echo "<div class='card wb-75 mb-3'>";
                    echo "<div class='card-body'>";
                        echo "<h5 class='card-title'>Currency: {$obj->curreny_id}</h5>";
                        echo "<p class='card-text'>Balance: {$obj->amount}</p>";
                        echo "<a class='btn btn-info' data-bs-toggle='collapse' href='#hiddenTransactions' role='button' aria-expanded='false'>
                                Transactions
                            </a>";
                        echo "<div class='collapse' id='hiddenTransactions'>
                                <div class='card card-body'>
                                    <h6>Transactions for this wallet</h6>
                                </div>
                            </div>";
                    echo "</div>";
                echo "</div>";
                }
            ?>
            <h5>Add Wallet</h5>
                <div class="add-wallet">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="selectCurrency">Select Currency:</label>
                                <select name="selectCurrency" id="selectCurrency">
                                    <option selected>...</option>
                                        
                                </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="+" name="submit" class="btn btn-warning">
                        </div>
                    </form>
                </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>