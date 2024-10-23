<?php
session_start();

// Controleer of de gebruiker een admin is
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

include '../includes/header.php';
?>

<h2>Admin Dashboard</h2>
<p>Welkom, admin! Wat wil je doen?</p>

<ul>
    <li><a href="verkiezing_uit_schrijven.php">Verkiezing Uitschrijven</a></li>
    <li><a href="partijen_goedkeuren.php">Partijen Goedkeuren</a></li>
</ul>

<?php include '../includes/footer.php'; ?>
