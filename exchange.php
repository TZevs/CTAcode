<?php
    require_once("includes/db_conn.php");
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
            <table class="table table-striped">
                <thead class="table-dark">
                    <th>Currency</th>
                    <th>Rate</th>
                    <th>Highest in last year</th>
                    <th>Lowest in last year</th>
                </thead>
                <?php
                    $rates = "SELECT * FROM currency";
                    $rates_result = $conn->query($rates);

                    while ($obj = $rates_result->fetch_object()) {
                        echo "<tr>";
                        echo "<th>{$obj->currency_name}</th>";
                        echo "<th>{$obj->currency_rate}</th>"; 
                        echo "<th>{$obj->highest_rate}</th>"; 
                        echo "<th>{$obj->lowest_rate}</th>"; 
                        echo "</tr>";
                    }
                ?>
            </table>
            <div class="container-exchange-updates">
                <h3>Update Currency Exchange Rates:</h3>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="selectCurrency">Select Currency:</label>
                        <select name="selectCurrency" id="selectCurrency">
                            <option selected>...</option>
                            <?php
                                $updateRates = "SELECT currency_name, shorthand FROM currency";
                                $update_results = $conn->query($updateRates);

                                while ($obj = $update_results->fetch_object()) {
                                    echo "<option value='{$obj->currency_id}'>{$obj->shorthand} : {$obj->currency_name}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="newRate">New Exchange Rate:</label>
                        <input type="number" name="newRate" id="newRate" class="form-control" min="0" step="0.01">
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="highRate">New Highest Rate (last 52wks):</label>
                            <input type="number" name="highRate" id="highRate" class="form-control" min="0" step="0.01">
                        </div>
                        <div class="form-group col">
                            <label for="lowRate">New Lowest Rate (last 52wks):</label>
                            <input type="number" name="lowRate" id="lowRate" class="form-control" min="0" step="0.01">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Update" name="submit" class="btn btn-warning">
                    </div>
                </form>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>