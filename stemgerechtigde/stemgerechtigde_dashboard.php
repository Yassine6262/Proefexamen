<?php
session_start();

// Controleer of de gebruiker een stemgerechtigde is
if ($_SESSION['role'] !== 'stemgerechtigde') {
    header('Location: ../login.php');
    exit;
}

include '../includes/header.php';
?>

<h2>Stemgerechtigde Dashboard</h2>
<p>Welkom, stemgerechtigde! Wat wil je doen?</p>

<ul>
    <li><a href="stemmen.php">Stem uitbrengen</a></li>
</ul>

<?php include '../includes/footer.php'; ?>
