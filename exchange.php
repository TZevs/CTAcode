<?php
    require_once("includes/db_conn.php");
    $exchange = "SELECT * FROM currencies";
    $exchange_result = $conn->query($exchange);
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
                    <li class="header-navbar-list-item item-active"><a href="exchange.php">Exchange Rates</a></li>
                    <li class="header-navbar-list-item"><a href="account.php"><i class="fa-solid fa-user"></i></a></li>
                </ul>
            </nav>
        </header>

        <div class="container">
            <h2>Currency Exchange Rates</h2>
            <table class="table table-striped table-hover table-bordered">
                <tr>
                    <th>Currency</th>
                    <th>Rate</th>
                    <th>Highest in last year</th>
                    <th>Lowest in last year</th>
                </tr>
                <?php
                    while ($obj = $exchange_result->fetch_object()) {
                        echo "<tr>";
                        echo "<th>{$obj->currency_name}</th>";
                        echo "<th>{$obj->currency_name}</th>"; // Exchange Rate 
                        echo "<th>{$obj->currency_name}</th>"; // Highest rate
                        echo "<th>{$obj->currency_name}</th>";  // Lowest Rate
                        echo "</tr>";
                    }
                ?>
            </table>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>