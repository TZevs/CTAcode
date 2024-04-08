<?php
    /*session_start();

    if(!isset($_SESSION['userEmail'])) {
        header("Location: login.php");
        exit();
    }
    $customerEmail = $_SESSION['userEmail'];
    */
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href  ="styles/main.css" />
        <script src="scripts/convert.js"></script>
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
                <h2>Wallet To Wallet</h2>
                    <div class="form-group">
                        <label for="amount">Amount:</label>
                        <input type="number" id="amount" name="amount" class="form-control" min="0" step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="from">From:</label>
                        <select name="from" id="from" class="form-control">
                            <option selected>...</option>
                            <option value="EUR">EUR - Euro</option>
                            <option value="GBP">GBP - British Pound</option>
                            <option value="USD">USD - American Dollar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="to">To:</label>
                        <select name="to" id="to" class="form-control">
                            <option selected>...</option>
                            <option value="EUR">EUR - Euro</option>
                            <option value="GBP">GBP - British Pound</option>
                            <option value="USD">USD - American Dollar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button onclick="convertCurrency()" class="btn btn-info">Convert</button>
                    </div>

                    <div id="result"></div>
            </div>
            <div id="transaction-form">
                <form action="" method="POST">
                    <h4>Confirm Transaction</h4>
                    <div class="form-group">
                        <label for="from" id="currencyFrom"></label>
                        <input type="text" id="oldAmount" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="to" id="currencyTo"></label>
                        <input type="text" id="newAmount" class="form-control" readonly>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Confirm Transaction">
                </form>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>