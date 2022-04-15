<?php
    // Initialize session.
    session_start();
    // Remove cookies.
    setcookie(session_name(), '', 100);
    // Unset session.
    $_SESSION = array();
    // Destroy session.
    session_destroy();
    // Go to login.
    header("location:index.php");
?>