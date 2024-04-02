<?php
    session_start();

    if(!isset($_SESSION['userEmail'])) {
        header("Location: login.php");
        exit();
    }
    $userEmail = $_SESSION['userEmail'];

    //require_once("includes/db_conn.php");
    /*
    $sql = "SELECT * FROM customeraccounts WHERE email_address = '$userEmail'";
    $result = $conn->query($customer);
    $customer = mysqli_fetch_assoc($result);
    $id = $customer['customer_ID'];

    $wallet = "SELECT * FROM currencywallets WHERE customer_id = '$id'";
    $wallet_results = $conn->query($wallet);
    */

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
                    <li class="header-navbar-list-item item-active"><a href="wallets.php">Wallets</a></li>
                    <li class="header-navbar-list-item"><a href="transaction.php">Transactions</a></li>
                    <li class="header-navbar-list-item"><a href="exchange.php">Exchange Rates</a></li>
                    <li class="header-navbar-list-item"><a href="account.php"><i class="fa-solid fa-user"></i></a></li>
                </ul>
            </nav>
        </header>

        <div class="container">
            <h4>Main Wallet</h4>
            <?php /*
                echo "<div class='card wb-75 mb-3'>";
                    echo "<div class='card-body'>";
                        echo "<h5 class='card-title'>Currency: {$obj->currency}</h5>";
                        echo "<p class='card-text'>Balance: {$obj->amount}</p>";
                    echo "</div>";
                echo "</div>";
            */
            ?>

            <h4>Currency Wallets</h4>
                <div class='card wb-75 mb-3'>
                    <div class='card-body'>
                        <h5 class='card-title'>Currency: {$obj->currency_sign} - {$obj->currency_name}</h5>
                        <p class='card-text'>Balance: {$obj->currency_sign}</p>
                        <a class='btn btn-info' data-bs-toggle='collapse' href='#hiddenTransactions' role='button' aria-expanded='false'>
                            Transactions
                        </a>
                        <div class='collapse' id='hiddenTransactions'>
                            <div class="card card-body">
                                <h6>Transactions for this wallet</h6>
                            </div>
                        </div>
                    </div>
                </div>
            <h5>Add Wallet</h5>
                <div class="add-wallet">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="selectCurrency">Select Currency:</label>
                                <select name="selectCurrency" id="selectCurrency">
                                    <option selected>...</option>
                                    <?php
                                        require_once("includes/db_conn.php");
                                        $walletCurrency = "SELECT currency_name, shorthand FROM currencies";
                                        $wallet_results = $conn->query($updateRates);

                                        while ($obj = $wallet_results->fetch_object()) {
                                            echo "<option value='{$obj->currency_id}'>{$obj->shorthand} : {$obj->currency_name}</option>";
                                        }
                                    ?>
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