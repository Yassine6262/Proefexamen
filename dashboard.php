<?php
session_start();
require 'includes/db.php';

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Haal de rol van de ingelogde gebruiker op
$role = $_SESSION['role'];

// Verwijs naar het juiste dashboard op basis van de rol
if ($role == 'admin') {
    header('Location: admin/admin_dashboard.php');
} elseif ($role == 'gemeente') {
    header('Location: gemeente/gemeente_dashboard.php');
} elseif ($role == 'stemgerechtigde') {
    header('Location: stemgerechtigde/stemgerechtigde_dashboard.php');
} elseif ($role == 'partijbeheerder') {
    header('Location: partijbeheerder/partijbeheerder_dashboard.php');
} else {
    echo "Onbekende rol!";
}
exit;
