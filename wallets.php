<?php
    session_start();

    if(!isset($_SESSION['userEmail'])) {
        header("Location: login.php");
        exit();
    }
    $userEmail = $_SESSION['userEmail']; 

    require_once("includes/db_conn.php");

    $info = "SELECT * FROM customeraccounts
                INNER JOIN currencywallet ON currencywallet.customer_id = customeraccounts.customer_id
                WHERE customeraccounts.email_address = '$userEmail'";
    $info_results = $conn->query($info);

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
            <h3>Your Wallets</h3>
            <?php
                if (isset($_POST["submit"])) {
                    $newWallet = $_POST['selectCurrency'];

                    mysqli_data_seek($info_results, 0);
                    $id = $info_results->fetch_object();

                    $addWallet = "INSERT INTO currencywallet (customer_id, currency_id, amount) VALUES ($id->customer_id, '$newWallet', 0)";
                    if ($conn->query($addWallet) === TRUE) {
                        echo "<div class='alert alert-success'>Wallet Added. <a href='wallets.php'>Refresh</a></div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error adding wallet: " . $conn->error . "</div>";
                    }
                }

                if (isset($_POST["submitDelete"])) {
                    $toDelete = $_POST['delWallet'];

                    $errors = array();

                    mysqli_data_seek($info_results, 0);
                    $wallets = $info_results->fetch_object();

                    if ($wallets->amount <= 0) {
                        array_push($errors, "The wallet must be empty to delete it.");
                    }

                    if (count($errors)>0) {
                        foreach($errors as $error) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    } else {
                        $deleteWallet = "DELETE FROM currencywallet WHERE wallets_id = '$toDelete'";
                        if ($conn->query($deleteWallet) === TRUE) {
                            echo "<div class='alert alert-success'>Delete Update Successful. <a href='wallets.php'>Refresh</a>.</div>";
                        } else {
                            echo "<div class='alert alert-danger'>Error Updating DB: " . $conn->error . "</div>";
                        }
                    }
                }
            ?>
            <?php 
                mysqli_data_seek($info_results, 0);
                while ($obj = $info_results->fetch_object()) {
                    echo "<div class='card wb-75 mb-3'>";
                    echo "<div class='card-body'>";
                        echo "<h5 class='card-title'>Currency: {$obj->currency_id}</h5>";
                        echo "<p class='card-text'>Balance: {$obj->amount}</p>";
                        echo "<a class='btn btn-info' data-bs-toggle='collapse' href='#hiddenTransactions' role='button' aria-expanded='false'>
                                Transactions
                            </a>";
                        echo "<div class='collapse' id='hiddenTransactions'>
                                <div class='card card-body'>
                                    <h6>Transactions for this wallet</h6>
                                </div>
                            </div>";
                    echo "</div>";
                echo "</div>";
                }
            ?>

                <div class="add-wallet">
                    <h5>Add Wallet</h5>
                    <form action="wallets.php" method="POST">
                        <div class="form-group">
                            <select name="selectCurrency" id="selectCurrency" class="form-select">
                                <option selected>Select a Currency: </option>
                                <?php 
                                $currencyOptions = "SELECT * FROM currency";
                                $option_results = $conn->query($currencyOptions);

                                while ($options = mysqli_fetch_assoc($option_results)) {
                                    echo "<option value='" . $options["currency_id"] . "'>" . $options["currency_id"] . " - " . $options["currency_name"] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Add Wallet" name="submit" class="btn btn-warning">
                        </div>
                    </form>
                </div>

                <div class="delete-wallet">
                    <h5>Delete Wallets</h5>
                    <form action="wallets.php" method="POST">
                        <div class="form-group">
                            <select name="delWallet" id="delWallet" class="form-select">
                                <option selected>Wallet to Delete</option>
                                <?php
                                    mysqli_data_seek($info_results, 0);
                                    while ($obj = $info_results->fetch_object()) {
                                        echo "<option value='{$obj->wallets_id}'>{$obj->currency_id}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Delete Wallet" name="submitDelete" class="btn btn-danger">
                        </div>
                    </form>
                </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>