<?php
    // May not be required - Back up if the php in register.php fails.
    require_once("includes/db_conn.php");

    $firstName = $_POST["firstname"];
    $middleName = $_POST["middlename"];
    $lastName = $_POST["lastname"];
    $email = $_POST["email"];
    $dob = $_POST["dob"];
    $password = $_POST["input_password"];
    $confirmPassword = $_POST["confirm_password"];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO customeraccounts (first_name, middle_name, last_name, email_address, password, dob) VALUES ('$firstName','$middleName','$lastName','$email','$dob','$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        echo "Successfully Registered.";
        header("Location: login.php");
    } else {
        die("Something went wrong");
    }

    $exsitingEmails = "SELECT * FROM customeraccounts WHERE email_Address = '$email'";
                    $emailResults = $conn->query($exsitingEmails);
                    if ($emailResults === 1) {
                        array_push($errors, "Email already has an account.");
                    
        }

        define("DB_SERVER", "127.0.0.1");
    define("DB_USERNAME", "root");
    define("DB_PASSWORD", "");
    define("DB_NAME", "cta_schema");
?>