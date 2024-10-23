<?php
session_start();

// Controleer of de gebruiker een gemeente-gebruiker is
if ($_SESSION['role'] !== 'gemeente') {
    header('Location: ../login.php');
    exit;
}

include '../includes/header.php';
?>

<h2>Gemeente Dashboard</h2>
<p>Welkom, gemeente! Wat wil je doen?</p>

<ul>
    <li><a href="uitnodigingen_versturen.php">Uitnodigingen Versturen</a></li>
</ul>

<?php include '../includes/footer.php'; ?>
