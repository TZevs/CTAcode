<?php
    session_start();
    
    if(!isset($_SESSION['userEmail'])) {
        header("Location: login.php");
        exit();
    }
    
    $userEmail = $_SESSION['userEmail'];
    
    require_once("includes/db_conn.php");
    $user = "SELECT customer_id FROM customeraccounts WHERE email_address = '$userEmail'";
    $userResult = mysqli_query($conn, $user);
    $id = mysqli_fetch_assoc($userResult);

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
        <link rel="stylesheet" media="only screen and (max-width: 720px)" href="styles/mobile.css" />
        <script src="scripts/convert.js"></script>
        <script src="https://kit.fontawesome.com/683ed5d49e.js" crossorigin="anonymous"></script>
        <title>Account</title>
    </head>
    <body>
        <?php include("includes/customerNav.php") ?>

        <div class="container">
            <div>
                <?php
                    if (isset($_POST["submit"])) {
                        $before = $_POST['amount'];
                        $from = $_POST['from'];
                        $to = $_POST['to'];
                        $after = $_POST['converted']; 

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
                        } elseif ($fRow['amount'] < $before) {
                            array_push($errors, "You do not have enough money in your wallet.");
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
                                echo "<div class='alert alert-success'>Transaction Successful. <a href='transaction.php'>Refresh.</a> <a href='wallets.php'>Go to Wallets.</a></div>";
                            } else {
                                echo "<div class='alert alert-danger'>Error updating wallets: " . $conn->error . "</div>";
                            }
                        }
                    }
                ?>
                <form action="transaction.php" method="POST">
                    <h3 class="text-center">Wallet to Wallet</h3>
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
                        <input type="submit" name="submit" value="Transfer" class="btn btn-warning">
                    </div>
                </form>
                <div class="form-group">
                    <button onclick="convertCurrency()" class="btn btn-primary">Convert</button>
                </div>
            </div>  
        </div>

        <div class="container">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Bank to Wallet
                    </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <?php
                                if (isset($_POST["submitFromBank"])) {
                                    $amount = $_POST['amountFB'];
                                    $cardNum = $_POST['cardNum'];
                                    $holderName = $_POST['cardHolder'];
                                    $expiryDate = $_POST['exDate'];
                                    $securityCode = $_POST['secCode']; 
                                    
                                    $transferDate = date("Y/m/d");
                                    $checkId = $id['customer_id'];

                                    $mainWallet = "SELECT customer_id, amount, frozen FROM currencywallet WHERE customer_id = '$checkId' AND currency_id = 'GBP'"; 
                                    $mainResult = $conn->query($mainWallet);
                                    $GBP = mysqli_fetch_assoc($mainResult);
                                    $isFrozen = $GBP['frozen'];
                                    $currentAmount = $GBP['amount'];
                                    $checkId = $GBP['customer_id'];

                                    $errors = array();

                                    if(empty($amount) OR empty($cardNum) OR empty($holderName) OR empty($expiryDate) OR empty($securityCode)) {
                                        array_push($errors, "Ensure All fields have a value.");
                                    } 
                                    if ($amount < 5 OR $amount > 1000000) {
                                        array_push($errors, "Amount must be within the limit.");
                                    }
                                    if ($isFrozen == "True") {
                                        array_push($errors, "This wallet is Frozen.");
                                    }

                                    if (count($errors)>0) {
                                        foreach ($errors as $error) {
                                            echo "<div class='alert alert-danger'>$error</div>";
                                        }
                                    } else {
                                        $newBalance = $currentAmount + $amount;
                                        $addTransaction = "INSERT INTO transactions (customer_id, name_on_card, acc_number, sort_code, expiry_date, amount_sent, transfer_date) VALUES ('$checkId', '$holderName', '$cardNum', '$securityCode', '$expiryDate', '$amount', '$transferDate')";
                                        $updateWallet = "UPDATE currencywallet SET amount = '$newBalance' WHERE customer_id = '$checkId' AND currency_id = 'GBP'";
                                        if ($conn->query($addTransaction) === TRUE && $conn->query($updateWallet)) {
                                            echo "<div class='alert alert-success'>Transaction Successful. <a href='wallets.php'>Go to Wallets.</a></div>";
                                        } else {
                                            echo "<div class='alert alert-danger'>Error updating wallets or adding transaction: " . $conn->error . "</div>";
                                        }
                                    }
                                }
                            ?>
                            <form action="transaction.php" method="POST">
                                <p>As this is a UK based application you must use a UK bank account.</p>
                                <div class="form-group">
                                    <label for="amountFB">Amount:</label>
                                    <input type="number" name="amountFB" id="amountFB" class="form-control" min="5" step="5" Placeholder="Minimum £5">
                                </div>
                                <div class="form-group">
                                    <label for="cardNum">Card Details:</label>
                                    <input type="text" name="cardNum" id="cardNum" class="form-control" Placeholder="Card Number"> 
                                </div>
                                <div class="form-group">
                                    <input type="text" name="cardHolder" id="cardHolder" class="form-control" Placeholder="Cardholder Name"> 
                                </div>
                                <div class="row g-3">
                                    <div class="col">
                                        <input type="text" name="exDate" id="exDate" class="form-control" Placeholder="Expiry Date"> 
                                    </div>
                                    <div class="col">
                                        <input type="number" name="secCode" id="secCode" class="form-control" Placeholder="Security Code"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address1">Billing Address:</label>
                                    <input type="text" name="address1" id="address1" class="form-control" Placeholder="Address Line 1" > 
                                </div>
                                <div class="form-group">
                                    <input type="text" name="address2" id="address2" class="form-control" Placeholder="Address Line 2"> 
                                </div>
                                <div class="row g-3">
                                    <div class="col">
                                        <input type="text" name="city" id="city" class="form-control" Placeholder="City" > 
                                    </div>
                                    <div class="col">
                                        <input type="text" name="pCode" id="pCode" class="form-control" Placeholder="Postcode" > 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submitFromBank" class="btn btn-warning" value="Transfer">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Wallet to Bank
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <?php   
                                if (isset($_POST["submitToBank"])) {
                                    $amount = $_POST['amountTB'];
                                    $fWallet = $_POST['fromWallet'];
                                    $accountName = $_POST['accName'];
                                    $BIC = $_POST['bankCode'];
                                    $accIbanNum = $_POST['accNum'];

                                    $checkId = $id['customer_id'];

                                    $fromWallet = "SELECT customer_id, amount, frozen FROM currencywallet WHERE customer_id = '$checkId' AND currency_id = '$fWallet'"; 
                                    $fromResult = $conn->query($fromWallet);
                                    $from = mysqli_fetch_assoc($fromResult);
                                    $isFrozen = $from['frozen'];
                                    $currentAmount = $from['amount'];

                                    $newBalance = $currentAmount - $amount;
                                    $transferDate = date("Y/m/d");

                                    $errors = array();

                                    if(empty($amount) OR empty($fWallet) OR empty($accountName) OR empty($BIC) OR empty($accIbanNum)) {
                                        array_push($errors, "Ensure all fields have a value.");
                                    } 
                                    if (mysqli_num_rows($fromResult) < 0) {
                                        array_push($errors, "You do not have this wallet.");
                                    }
                                    if ($newBalance < 0) {
                                        array_push($errors, "Not enough money in your wallet.");
                                    }
                                    if ($isFrozen == 'True') {
                                        array_push($errors, "This wallet is frozen.");
                                    }
                                    if ($amount < 5 OR $amount > 1000000) {
                                        array_push($errors, "Amount must be within the limit.");
                                    }

                                    if (count($errors)>0) {
                                        foreach ($errors as $error) {
                                            echo "<div class='alert alert-danger'>$error</div>";
                                        }
                                    } else {
                                        $updateWallet = "UPDATE currencywallet SET amount = '$newBalance' WHERE customer_id = '$checkId' AND currency_id = '$fWallet'";
                                        $addTransaction = "INSERT INTO transactions (customer_id, recipient_name, iban_number, bic_code, from_wallet, amount_sent, transfer_date) VALUES ('$checkId', '$accountName', '$accIbanNum', '$BIC', '$fWallet', '$amount', '$transferDate')";
                                        if ($conn->query($updateWallet) === TRUE AND $conn->query($addTransaction) === TRUE) {
                                            echo "<div class='alert alert-success'>Transaction Successful. <a href='transaction.php'>Refresh.</a> <a href='wallets.php'>Go to Wallets.</a></div>";
                                        } else {
                                            echo "<div class='alert alert-danger'>Error updating wallets or adding transaction: " . $conn->error . "</div>";
                                        }
                                    }

                                }
                            ?>
                            <form action="transaction.php" method="POST">
                                <div class="form-group">
                                    <label for="amountTB">Amount:</label>
                                    <input type="number" name="amountTB" id="amountTB" class="form-control" min="5" step="5">
                                </div>
                                <div class="form-group">
                                    <select name="fromWallet" id="fromWallet" class="form-control">
                                        <option selected>Select Wallet</option>
                                        <?php 
                                            $checkId = $id['customer_id'];
                                            $userWallets = "SELECT wallets_id, currency_id FROM currencywallet WHERE customer_id = '$checkId'";
                                            $walletResults = mysqli_query($conn, $userWallets);

                                            while ($wallets = $walletResults->fetch_object()) {
                                                echo "<option value='{$wallets->currency_id}'>{$wallets->currency_id}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="accName">Account Details:</label>
                                    <input type="text" name="accName" id="accName" class="form-control" Placeholder="Recipeient Name" >
                                </div>
                                <div class="form-group">
                                    <input type="text" name="bankCode" id="bankCode" class="form-control" Placeholder="Bank Code (BIC)" >
                                </div>
                                <div class="form-group">
                                    <input type="text" name="accNum" id="accNum" class="form-control" Placeholder="IBAN / Account Number">
                                </div>
                                <div class="form-group">
                                    <label for="accName">Recipient Address:</label>
                                    <input type="text" name="address1" id="address1" class="form-control" Placeholder="Address Line 1"> 
                                </div>
                                <div class="form-group">
                                    <input type="text" name="address2" id="address2" class="form-control" Placeholder="Address Line 2"> 
                                </div>
                                <div class="form-group">
                                    <input type="text" name="country" id="country" class="form-control" Placeholder="Country"> 
                                </div>
                                <div class="form-group">
                                    <input type="text" name="state" id="state" class="form-control" Placeholder="State / County"> 
                                </div>
                                <div class="row g-3">
                                    <div class="col">
                                        <input type="text" name="city" id="city" class="form-control" Placeholder="City"> 
                                    </div>
                                    <div class="col">
                                        <input type="text" name="pCode" id="pCode" class="form-control" Placeholder="Postcode"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="reference">Reference:</label>
                                    <input type="text" name="reference" id="reference" class="form-control"> 
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submitToBank" class="btn btn-warning" value="Transfer">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>