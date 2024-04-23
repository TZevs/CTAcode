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

    $walletInfo = "SELECT DISTINCT *
                    FROM customeraccounts
                    INNER JOIN currencywallet ON currencywallet.customer_id = customeraccounts.customer_id
                    WHERE currencywallet.frozen = 'True'";  
    $info_results = $conn->query($walletInfo);
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
            <h2 class="text-center">Legal</h2>
            <?php  
                while ($obj = $info_results->fetch_object()) {
                    if ($obj->frozen == 'True') {
                        echo "<div class='card border-3 border-black'>";

                            echo "<div class='card-header text-bg-info'>";
                                echo "<h5>Customer: {$obj->first_name} {$obj->middle_name} {$obj->last_name}</h5>";
                                echo "<p>Email Address: {$obj->email_address}</p>";
                                echo "<p>Is Suspended: <b>{$obj->suspension}</b></p>";
                            echo "</div>";

                            echo "<div class='card-body'>";
    
                                echo "<h5>Currency: {$obj->currency_id}</h5>";
                                echo "<p>Balance: {$obj->amount}</p>";

                                if (is_null($obj->proof)) {
                                    echo "<p>No file has been uploaded.</p>";
                                } else {
                                    $imagePath = $obj->proof;
                                    echo "<p>Recipt for transaction / Proof of Funds:</p>";
                                    echo "<img src='$imagePath' alt='Image of Proof' class='img-fluid'>";
                                }
    
                            echo "</div>";
                        echo "</div>";
                    }
                    echo "<br>";
                }
                
            ?>
                    
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>