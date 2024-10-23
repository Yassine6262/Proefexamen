<?php
session_start();

// Controleer of de gebruiker een partijbeheerder is
if ($_SESSION['role'] !== 'partijbeheerder') {
    header('Location: ../login.php');
    exit;
}

include '../includes/header.php';
?>

<h2>Partijbeheerder Dashboard</h2>
<p>Welkom, partijbeheerder! Wat wil je doen?</p>

<ul>
    <li><a href="kandidaten_beheren.php">Kandidaten Beheren</a></li>
    <li><a href="volgorde_kandidaten.php">Volgorde Kandidaten Voor Verkiezingen</a></li>
</ul>

<?php include '../includes/footer.php'; ?>
