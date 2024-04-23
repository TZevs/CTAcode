<?php
    session_start();
    require_once("includes/db_conn.php");
    
    if(!isset($_SESSION['userEmail'])) {
        header("Location: login.php");
        exit();

        $userEmail = $_SESSION['userEmail'];
        $checkAdmin = "SELECT email_address FROM adminaccount WHERE email_address = '$userEmail'";
        $adminResult = $conn->query($checkAdmin);

        if (mysqli_num_rows($adminResult) == 0) {
            header("Location: login.php");
            exit();
        }
    } 

    $userEmail = $_SESSION['userEmail'];
    $checkAdminId = "SELECT type_id FROM adminaccount WHERE email_address = '$userEmail'";
    $id_result = $conn->query($checkAdminId);
    $types = mysqli_fetch_assoc($id_result);
    $type = $types['type_id'];

    $typeName = "SELECT type_name FROM usertypes WHERE type_id = '$type'";
    $type_result = $conn->query($typeName);
    $name = mysqli_fetch_assoc($type_result)['type_name'];

    $customerInfo = "SELECT DISTINCT *
                    FROM customeraccounts
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
        <?php include("includes/staffNav.php") ?>

        <div class="container">
            <h2 class="text-center">Customers</h2>
            <p class="text-center">Your Job Title: <b><?php echo $name ?></b></p>
            <?php
                if (isset($_POST["submit"])) {
                    $id = $_POST['customerid'];
                
                    if (isset($_POST["suspend"])) {

                        $databaseStatus = "SELECT suspension FROM customeraccounts WHERE customer_id = '$id'";
                        $status_result = mysqli_query($conn, $databaseStatus);
                        $currentStatus = mysqli_fetch_assoc($status_result)['suspension'];
                        $newStatus = $currentStatus == 'True' ? 'False' : 'True';

                        if ($type == 2) {
                            $updateSuspend = "UPDATE customeraccounts SET suspension='$newStatus' WHERE customer_id = '$id'"; 
                            if ($conn->query($updateSuspend) === TRUE) {
                                echo "<div class='alert alert-success'>Update Successful. <a href='customers.php'>Refresh.</a></div>";
                            } else {
                                echo "<div class='alert alert-danger'>Error updating suspension: " . $conn->error . "</div>";
                            }
                        } else {
                            echo "<div class='alert alert-danger'>Only a System Admin can suspend a customer account.</div>";
                        } 
                    }
                    if (isset($_POST["freeze"])) {
                        foreach ($_POST["freeze"] as $walletId) {
                            
                            $databaseStatus = "SELECT frozen FROM currencywallet WHERE wallets_id = '$walletId'";
                            $status_result = mysqli_query($conn, $databaseStatus);
                            $currentStatus = mysqli_fetch_assoc($status_result)['frozen'];
                            $newStatus = $currentStatus == 'True' ? 'False' : 'True';
                        
                            if ($type == 3) {
                                $updateFreeze = "UPDATE currencywallet SET frozen = '$newStatus' WHERE wallets_id = '$walletId'"; 
                                if ($conn->query($updateFreeze) === TRUE) {
                                    echo "<div class='alert alert-success'>Update Successful. <a href='customers.php'>Refresh.</a></div>";
                                } else {
                                    echo "<div class='alert alert-danger'>Error Updating Frozen: " . $conn->error . "</div>";
                                }
                            } else {
                                echo "<div class='alert alert-danger'>Only a Financial Admin can freeze a customer wallet.</div>";
                            } 
                        }
                    }
                }
            ?>
            <?php 
                $customers = [];
                while ($obj = $info_results->fetch_object()) {
                    $customerId = $obj->customer_id;

                    if (!isset($customers[$customerId])) {
                        $customers[$customerId] = [
                            'customer_id' => $customerId,
                            'suspension' => $obj->suspension,
                            'name' => "{$obj->first_name} {$obj->middle_name} {$obj->last_name}",
                            'email' => $obj->email_address,
                            'wallets' => [],
                        ];
                    }
                            
                    $customers[$customerId]['wallets'][] = [
                        'wallet_id' => $obj->wallets_id,
                        'currency_id' => $obj->currency_id,
                        'balance' => $obj->amount,
                        'frozen' => $obj->frozen,
                        'limit' => $obj->amountLimit,
                    ];
                }
            ?>
            
            <?php foreach ($customers as $customer): ?>
                <form action='customers.php' method='POST'>
                    <div class='card border-3 border-black'>
                        <div class='card-header'>
                            <h5>Customer ID: <?php echo $customer['customer_id']; ?></h5>
                            <p>Is Suspended: <b><?php echo $customer['suspension']; ?></b></p>
                            <input type='checkbox' name='suspend[]' value='<?php echo $customer['customer_id']; ?>' id='suspend_<?php echo $customer['customer_id']; ?>' class='check-input'>
                            <label for='suspend_<?php echo $customer['customer_id']; ?>'>Toggle Suspension</label>
                        </div>

                        <div class='card-body text-bg-warning'>
                            <p>Name: <?php echo $customer['name']; ?></p>
                            <p>Email Address: <?php echo $customer['email']; ?></p>
                            <a class='btn btn-dark btn-sm' data-bs-toggle='collapse' href='#hiddenWallets_<?php echo $customer['customer_id']; ?>' role='button' aria-expanded='false'>Wallets</a>

                            <div class='collapse' id='hiddenWallets_<?php echo $customer['customer_id']; ?>'>
                                <?php foreach ($customer['wallets'] as $wallet): ?>
                                    <div class="card">
                                        <div class="card-header text-bg-primary">
                                            <p>Currency: <?php echo $wallet['currency_id']; ?></p>
                                        </div>
                                        <div class="card-body">
                                            <p>Balance: <?php echo $wallet['balance']; ?></p>
                                            <p>Is Frozen: <b><?php echo $wallet['frozen']; ?></b></p>
                                            <p>Wallet Limit: <?php echo $wallet['limit']; ?></p>
                                            <input type='checkbox' name='freeze[]' value='<?php echo $wallet['wallet_id']; ?>' id='freeze_<?php echo $wallet['wallet_id']; ?>' class='check-input'>
                                            <label for='freeze_<?php echo $wallet['wallet_id']; ?>'>Toggle Freeze</label>
                                        </div>
                                    </div>
                                    <br>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class='card-footer'>
                            <input type='hidden' name='customerid' id='customerid' value='<?php echo $customer['customer_id']; ?>'>
                            <input type='submit' name='submit' value='Update' class='btn btn-primary btn-sm'>
                        </div>
                    </div>
                </form>
                <br>
            <?php endforeach; ?>      
                    
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
