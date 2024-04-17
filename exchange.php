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
        <?php include("includes/customerNav.php") ?>

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