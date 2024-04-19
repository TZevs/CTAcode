<?php
    session_start(); // Start session.
    unset($_SESSION); // Remove session variables.
    session_destroy(); // Destroy session.
    session_write_close(); // Close write of the session.
    header("Location: ../login.php"); // Redirect to login page.
    exit;
?>