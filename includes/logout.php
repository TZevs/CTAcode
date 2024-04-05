<?php
    // Dosent work get a 404 not found.
    session_start();
    session_unset();
    session_destroy();
    header("Location: /login.php");
    exit();  
?>