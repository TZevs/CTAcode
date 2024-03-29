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
                <form action="includes/calculate.php" method="POST">
                    <?php
                        require_once("includes/db_conn.php");

                        echo "<div class='form-group'>";
                        echo "<label for='walletFrom'>Wallet Sender:</label>";
                        echo "<select name='walletFrom' id='walletfrom'>";
                            echo "<option selected>From</option>";
                            /*
                            while ($obj = $wallets->fetch_object()) {
                                echo "<option value='{$obj->wallet}'></option>";
                            }
                            */
                            echo "</select>";
                        echo "</div>";

                        echo "<div class='form-group'>";
                        echo "<label for='walletTo'>Wallet Sender:</label>";
                        echo "<select name='walletTo' id='walletto'>";
                            echo "<option selected>To</option>";
                            /* 
                            while ($obj = $wallets->fetch_object()) {
                                echo "<option value='{$obj->wallet}'></option>";
                            } 
                            */
                            echo "</select>";
                        echo "</div>";
                    ?>
                </form>
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