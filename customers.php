<?php
    session_start();

    if(!isset($_SESSION['userEmail'])) {
         header("Location: login.php");
         exit();
    }
    $userEmail = $_SESSION['userEmail'];
 
    require_once("includes/db_conn.php");
    $customerInfo = "SELECT DISTINCT customeraccounts.customer_id, first_name, middle_name, last_name, email_address, suspension, currencywallet.currency_id, currencywallet.amount FROM customeraccounts
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
                if (isset($_POST["submit"])) {
                    $id = $_POST['customerid'];
                
                    $databaseStatus = "SELECT suspension FROM customeraccounts WHERE customer_id = '$id'";
                    $status_result = mysqli_query($conn, $databaseStatus);
                    $currentStatus = mysqli_fetch_assoc($status_result)['suspension'];
                    
                    $newStatus = $currentStatus == 'True' ? 'False' : 'True';
                
                    $updateSuspend = "UPDATE customeraccounts SET suspension='$newStatus' WHERE customer_id = '$id'"; 
                    if ($conn->query($updateSuspend) === TRUE) {
                        echo "<div class='alert alert-success'>Update Successful. <a href='customers.php'>Refresh.</a></div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error updating suspension: " . $conn->error . "</div>";
                    }
                }
                ?>
                <?php 
                $processedCustomerIDs = array();
                while ($obj = $info_results->fetch_object()) {
                    if (!in_array($obj->customer_id, $processedCustomerIDs)) {
                        $processedCustomerIDs[] = $obj->customer_id;
                        echo "<form action='customers.php' method='POST'>";
                            echo "<div class='card'>";

                                echo "<div class='card-header'>";
                                    echo "<h5>Customer ID: {$obj->customer_id}</h5>";
                                    echo "<p>Is Suspended: <b>{$obj->suspension}</b></p>";
                                    echo "<input type='checkbox' name='suspend' id='suspend' class='check-input'>";
                                    echo "<label for='suspend'>Toggle Suspension</label>";
                                echo "</div>";

                                echo "<div class='card-body'>";
                                    echo "<p>Name: {$obj->first_name} {$obj->middle_name} {$obj->last_name}</p>";
                                    echo "<p>Email Address: {$obj->email_address}</p>";
                                    echo "<a class='btn btn-dark' data-bs-toggle='collapse' href='#hiddenWallets' role='button' aria-expanded='false'>Wallets</a>";

                                    echo "<div class='collapse' id='hiddenWallets'>
                                            <h6>Wallets for this account.</h6>

                                            <a class='btn btn-secondary btn-sm' data-bs-toggle='collapse' href='#hiddenTransactions' role='button' aria-expanded='false'>Transactions</a>
                                            <div class='collapse' id='hiddenTransactions'>
                                                <h6>Transactions for this wallet.</h6>
                                            </div>";

                                    echo "</div>";

                                echo "</div>";
                                echo "<div class='card-footer'>
                                        <input type='number' Placeholder='Confirm Customer ID' name='customerid' class='form-control' required>
                                        <div class='form-group'>
                                            <input type='submit' name='submit' value='Update' class='btn btn-primary btn-sm'>
                                        </div>
                                    </div>";
                            echo "</div>";
                        echo "</form>";
                    }
                }
            ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
