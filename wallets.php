<?php
    session_start();

    if(!isset($_SESSION['userEmail'])) {
        header("Location: login.php");
        exit();
    }
    $userEmail = $_SESSION['userEmail']; 

    require_once("includes/db_conn.php");

    $info = "SELECT customeraccounts.customer_id, currencywallet.wallets_id, currencywallet.currency_id, currencywallet.amount, currencywallet.frozen, currencywallet.proof
                FROM customeraccounts
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
            <h3 class="text-center">Your Wallets</h3>
            <?php
                if (isset($_POST["submit"])) {
                    $newWallet = $_POST['selectCurrency'];

                    $info_id = $info_results->fetch_assoc();
                    $id = $info_id["customer_id"];

                    $checkWallets = "SELECT wallets_id FROM currencywallet WHERE customer_id = '$id' AND currency_id = '$newWallet'";
                    $check_results = $conn->query($checkWallets);
                    
                    if (mysqli_num_rows($check_results) == 1) {
                        echo "<div class='alert alert-danger'>You already have this currency wallet.</div>";
                    } elseif (strlen($newWallet) > 3) {
                        echo "<div class='alert alert-danger'>Select a currency.</div>";
                    } else {
                        $addWallet = "INSERT INTO currencywallet (customer_id, currency_id, amount) VALUES ('$id', '$newWallet', 0)";
                    if ($conn->query($addWallet) === TRUE) {
                        echo "<div class='alert alert-success'>Wallet Added. <a href='wallets.php'>Refresh</a></div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error adding wallet: " . $conn->error . "</div>";
                    }
                    }
                }

                if (isset($_POST["submitDelete"])) {
                    $toDelete = $_POST['delWallet'];

                    $errors = array();

                    mysqli_data_seek($info_results, 0);
                    $wallets = $info_results->fetch_object();
                    $id = $wallets->customer_id;

                    $checkMain = "SELECT currency_id, amount, frozen FROM currencywallet WHERE customer_id = '$id' AND wallets_id = '$toDelete'";
                    $checkResults = $conn->query($checkMain);
                    $check = mysqli_fetch_assoc($checkResults);

                    if ($check['amount'] > 0) {
                        array_push($errors, "The wallet must be empty to delete it.");
                    }
                    if ($check['currency_id'] == "GBP") {
                        array_push($errors, "You can not delete your GBP wallet.");
                    } 
                    if (strlen($toDelete) > 3) {
                        array_push($errors, "Select a wallet to delete.");
                    }
                    if ($check['frozen'] == "True") {
                        array_push($errors, "You can not delete a frozen wallet.");
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

                if (isset($_POST["submitProof"])) {
                    $errors = array();
                    $target_dir = "userUploads/";
                    $target_file = $target_dir . basename($_FILES["recipt"]["name"]);
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    $walletID = $_POST['walletId'];

                    $check = getimagesize($_FILES["recipt"]["tmp_name"]);
                    if ($check == false) {
                        array_push($errors, "File is not an image.");
                    }
                    if ($_FILES["recipt"]["size"] > 500000) {
                        array_push($errors, "This file is too large");
                    }
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                        array_push($errors, "Only JPG, JPEG, and PNG files are allowed.");
                    }

                    if (count($errors)>0) {
                        foreach($errors as $error) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    } else {
                        if (move_uploaded_file($_FILES["recipt"]["tmp_name"], $target_file)) {
                            $image_path = $target_file;
                            $uploadRecipt = "UPDATE currencywallet SET proof = '$image_path' WHERE wallets_id = '$walletID'";
                            if ($conn->query($uploadRecipt) === TRUE) {
                                echo "<div class='alert alert-success'>Recipt Upload Successful.</div>";
                            } else {
                                echo "<div class='alert alert-danger'>Error Uploading Recipt: " . $conn->error . "</div>";
                            }
                        }
                    }

                }
            ?>
            <?php 
                mysqli_data_seek($info_results, 0);
                while ($obj = $info_results->fetch_object()) {
                    if ($obj->frozen == 'False') {
                        echo "<div class='card wb-75 mb-3'>";
                            echo "<div class='card-body'>";

                            echo "<h5 class='card-title'>Currency: {$obj->currency_id}</h5>";
                            echo "<p class='card-text'>Balance: {$obj->amount}</p>";

                            echo "</div>";
                        echo "</div>";
                    } else {
                        echo "<div class='card text-bg-info wb-75 mb-3'>"; 
                            echo "<div class='card-body'>";

                            echo "<h5 class='card-title'>Currency: {$obj->currency_id}</h5>";
                            echo "<p class='card-text'>Balance: {$obj->amount}</p>";

                            echo "<form action='wallets.php' method='POST' enctype='multipart/form-data'>";
                                echo "<div class='form-group'>";
                                    echo "<input type='hidden' id='walletId' name='walletId' value='{$obj->wallets_id}'>";
                                    echo "<label for='recipt'>Upload Proof of funds: </label>";
                                    echo "<input type='file' name='recipt' id='recipt' class='form-control' accept='image/png, image/jpeg' />";
                                echo "</div>";
                                echo "<div class='form-group'>";
                                    echo "<input type='submit' name='submitProof' value='Submit Recipt' class='btn btn-primary' >";
                                echo "</div>";
                            echo "</form>";

                            echo "</div>";
                        echo "</div>";
                    }
                }
            ?>
        </div>
        <div class="container">
            <div class="add-wallet">
                <h4>Add Wallet</h4>
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
                <h4>Delete Wallets</h4>
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