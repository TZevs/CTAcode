<?php
    session_start();

    if(!isset($_SESSION['userEmail'])) {
        header("Location: login.php");
        exit();
    }
    $userEmail = $_SESSION['userEmail'];
    
    require_once("includes/db_conn.php");
    $userId = "SELECT customer_id FROM customeraccounts WHERE email_address = '$userEmail'";
    $id_result = mysqli_query($conn, $userId);
    $id = mysqli_fetch_assoc($id_result);

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
        <script src="scripts/convert.js"></script>
        <script src="https://kit.fontawesome.com/683ed5d49e.js" crossorigin="anonymous"></script>
        <title>Account</title>
    </head>
    <body>
        <?php include("includes/customerNav.php") ?>

        <div class="container center">
            <div>
                <h2>Exchange</h2>
                <?php
                    if (isset($_POST["submit"])) {
                        $before = $_POST['amount'];
                        $from = $_POST['from'];
                        $to = $_POST['to'];
                        $after = $_POST['converted']; // Check this has not been changed.
                        $checkId = $id['customer_id'];

                        $errors = array();

                        $from_wallet = "SELECT currency_id, amount FROM currencywallet WHERE customer_id = '$checkId' AND currency_id = '$from'";
                        $from_results = mysqli_query($conn, $from_wallet);
                        $fRow = mysqli_fetch_assoc($from_results);

                        $to_wallet = "SELECT currency_id, amount FROM currencywallet WHERE customer_id = '$checkId' AND currency_id = '$to'";
                        $to_results = mysqli_query($conn, $to_wallet);
                        $tRow = mysqli_fetch_assoc($to_results);

                        if(empty($before) OR empty($after)) {
                            array_push($errors, "Make sure you have entered an amount and converted it.");
                        }
                        if ($before < 1) {
                            array_push($errors, "Amount must be more than 1.");
                        }
                        if (mysqli_num_rows($from_results) != 1 OR mysqli_num_rows($to_results) != 1) {
                            array_push($errors, "You do not have the wallets for this transaction.");
                        }
                        if ($fRow['amount'] < $before) {
                            array_push($errors, "You do not have enough money in the ${from} wallet.");
                        }

                        if (count($errors)>0) {
                            foreach ($errors as $error) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        } else {
                            $fromAmount = $fRow['amount'] - $before; 
                            $toAmount = $tRow['amount'] + $after;
                            $updateFrom = "UPDATE currencywallet SET amount = '$fromAmount' WHERE customer_id = '$checkId' AND currency_id = '$from'";
                            $updateTo = "UPDATE currencywallet SET amount = '$toAmount' WHERE customer_id = '$checkId' AND currency_id = '$to'";
                            
                            if ($conn->query($updateFrom) === TRUE AND $conn->query($updateTo) === TRUE) {
                                echo "<div class='alert alert-success'>Transaction Successful. <a href='customers.php'>Refresh.</a> <a href='wallets.php'>Go to Wallets.</a></div>";
                            } else {
                                echo "<div class='alert alert-danger'>Error updating wallets: " . $conn->error . "</div>";
                            }
                        }
                    }
                ?>
                <form action="transaction.php" method="POST">
                    <h3>Wallet to Wallet</h3>
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
                        <input type="number" name="converted" id="converted" class="form-control" Placeholder="Converted Amount:" readonly> 
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" value="Transfer" class="btn btn-primary btn-inline">
                    </div>
                </form>
                <div class="form-group">
                    <button onclick="convertCurrency()" class="btn btn-warning btn-inline">Convert</button>
                </div>
            </div>  
            <div>
                <form action="" method="POST">
                    <h3>Bank to Wallet</h3>
                    <p>As this is a UK based application you must use a UK bank account.</p>
                    <div class="form-group">
                        <label for="amountFB">Amount:</label>
                        <input type="number" name="amountFB" id="amountFB" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for=""></label>
                        <input type="text" name="" id="" class="form-control"> 
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submitFromBank" class="btn btn-warning" value="Transfer">
                    </div>
                </form>
            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>