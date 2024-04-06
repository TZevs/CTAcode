<?php
    require_once("includes/db_conn.php");
    $customerInfo = "SELECT * FROM customeraccounts
                        INNER JOIN currencywallet ON currencywallet.customer_id = customeraccounts.customer_id"; 
    $info_results = $conn->query($customerInfo);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href  ="styles/main.css" />
        <script src="https://kit.fontawesome.com/683ed5d49e.js" crossorigin="anonymous"></script>
        <title>Customers</title>
    </head>
    <body>
        <header>
            <div class="header-logo">
                <h1 class="header-logo-text">C.T.A</h1>
                <p class="header-logo-text">Currency Transfer Application</p>
            </div>
            <nav class="header-navbar">
                <ul class="header-navbar-list">
                    <li class="header-navbar-list-item item-active"><a href="customers.php">Customer Management</a></li>
                    <li class="header-navbar-list-item"><a href="exchange.php">Exchange Rates</a></li>
                    <li class="header-navbar-list-item"><a href="account.php"><i class="fa-solid fa-user"></i></a></li>
                </ul>
            </nav>
        </header>
        <div class="container">
            <h2 class="text-center">Customers</h2>
            <?php
                while ($obj = $info_results->fetch_object()) {
                    echo "<div class='card'>";

                        echo "<div class='card-header'>";
                        echo "Customer ID: {$obj->customer_id}";

                        echo "<form action='' method='POST'>
                            <div class='form-group'>
                                <input type='checkbox' name='suspend' id='suspend'>
                                <label for='suspend'>Suspend Account</label>
                                <input type='submit' value='Confirm Suspension' class='btn btn-dark btn-sm'>
                            </div>
                        </form>";
                        echo "</div>";

                        echo "<div class='card-body'>";
                            echo "<h5>Name: {$obj->first_name} {$obj->middle_name} {$obj->last_name}</h5>";
                            echo "<h6>Email Address: {$obj->email_address}</h6>";
                        echo "</div>";

                    echo "</div>";
                }
            ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
