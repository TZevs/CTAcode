<?php
    session_start();

    if(!isset($_SESSION['userEmail'])) {
        header("Location: login.php");
        exit();
    }
    $userEmail = $_SESSION['userEmail'];
    
    require_once("includes/db_conn.php");
    $currencyOptions = "SELECT * FROM currency";
    $option_results = $conn->query($currencyOptions);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href  ="styles/main.css" />
        <script src="scripts/converts.js"></script>
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
                    <li class="header-navbar-list-item"><a href="wallets.php">Wallets</a></li>
                    <li class="header-navbar-list-item item-active"><a href="transaction.php">Transactions</a></li>
                    <li class="header-navbar-list-item"><a href="exchange.php">Exchange Rates</a></li>
                    <li class="header-navbar-list-item"><a href="account.php"><i class="fa-solid fa-user"></i></a></li>
                </ul>
            </nav>
        </header>

        <div class="container">
            <div>
                <h2>Exchange</h2>
                <form action="" method="POST">
                    <div class="form-group">
                        <input type="number" id="amount" name="amount" class="form-control" min="0" step="0.01" Placeholder="Enter an Amount to Exchange:">
                    </div>
                    <div class="form-group">
                        <select name="from" id="from" class="form-control">
                            <option selected>Select Currency From:</option>
                            <?php 
                                mysqli_data_seek($option_results, 0);
                                while ($option = mysqli_fetch_assoc($option_results)) {
                                    echo "<option value='" . $option["currency_id"] . "'>" . $option["currency_id"] . " - " . $option["currency_name"] . "</option>";
                                }
                                ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="to" id="to" class="form-control">
                            <option selected>Select Currency To:</option>
                            <?php 
                                mysqli_data_seek($option_results, 0);
                                while ($options = mysqli_fetch_assoc($option_results)) {
                                    echo "<option value='" . $options["currency_id"] . "'>" . $options["currency_id"] . " - " . $options["currency_name"] . "</option>";
                                }
                                ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button onclick="convertCurrency()" class="btn btn-info">Convert</button>
                    </div>
                    <div id="result"></div>
                </form>
            </div>  
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>