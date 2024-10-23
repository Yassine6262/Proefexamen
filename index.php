<?php
session_start();
require 'includes/db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
?>

<?php include 'includes/header.php'; ?>

<h2>Welkom bij het digitale stemsysteem!</h2>
<p>Log in om verder te gaan.</p>
<a href="login.php">Inloggen</a><br>
<!-- Voeg de registratielink hieronder toe -->
<a href="register.php">Nog geen account? Registreer hier</a>

<?php include 'includes/footer.php'; ?>
