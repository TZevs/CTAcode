<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href  ="styles/main.css" />
        <script src="scripts/functions.js"></script>
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
            <div class="transaction-tabs tabs">
                <button class="tablinks" onclick="openTransfers(event, 'wallet-wallet')">Wallet To Wallet</button>
                <button class="tablinks" onclick="openTransfers(event, 'bank-wallet')">Bank To Wallet</button>
            </div>

            <div id="wallet-wallet" class="tabcontent">
                <h2>Wallet To Wallet</h2>
                <span onclick="this.parentElement.style.display = 'none'" class="close">x</span>
                    <div class="form-group">
                        <label for="fromCurrency">From:</label>
                        <select name="fromCurrency" id="fromCurrency">
                            <option selected>...</option>
                            <?php
                                require_once("includes/db_conn.php");
                                $from_convert = "SELECT * FROM currencies";
                                $from_results = $conn->query($convert_rates);

                                while ($obj = $from_results->fetch_object()) {
                                    echo "<option value='{$obj->currency_id}'>{$obj->shorthand}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount:</label>
                        <input type="number" id="amount" min="0" step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="toCurrency">To:</label>
                        <select name="toCurrency" id="toCurrency">
                            <option selected>...</option>
                            <?php
                                require_once("includes/db_conn.php");
                                $to_convert = "SELECT * FROM currencies";
                                $to_results = $conn->query($to_convert);

                                while ($obj = $to_results->fetch_object()) {
                                    echo "<option value='{$obj->currency_id}'>{$obj->shorthand}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button id="convertbtn" class="btn btn-warning">Convert</button>
                    </div>
                    <div id="result"></div>
            </div>

            <div id="bank-wallet" class="tabcontent">
                <h2>Bank To Wallet</h2>
                <span onclick="this.parentElement.style.display = 'none'" class="close">x</span>
                <form action="" method="POST">
                    <div class="form-group">
                        
                    </div>
                </form>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>