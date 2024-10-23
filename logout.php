<?php
session_start();

// Verwijder alle sessievariabelen
$_SESSION = array();

// Als je cookies gebruikt om de sessie op te slaan
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Vernietig de sessie
session_destroy();

// Verwijs de gebruiker door naar de loginpagina
header("Location: login.php");
exit;
