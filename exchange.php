<?php
    require_once("includes/api_conn.php");
    $curl = curl_init($api_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response_json = curl_exec($curl);

    $response_data = json_decode($response_json, true);
    
    if ($response_data && isset($response_data['conversion_rates'])) {
        $exchange_rates = $response_data['conversion_rates'];
    } else {
        echo "Failed to retrieve exchange rates";
        exit;
    } 
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
                    <th>Shorthand</th>
                    <th>Rate</th>
                </thead>
                <tbody>
                    <?php
                        foreach ($exchange_rates as $currency => $rate) {
                            echo "<tr>
                                    <td>{$currency}</td>
                                    <td>{$rate}</td>
                                </tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>