<?php
session_start();
require '../includes/db.php';

// Controleer of de gebruiker een admin is
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = $_POST['naam'];
    $type = $_POST['type'];
    $startdatum = $_POST['startdatum'];
    $einddatum = $_POST['einddatum'];

    // Voeg de verkiezing toe aan de database
    $stmt = $pdo->prepare("INSERT INTO verkiezingen (naam, type, startdatum, einddatum) VALUES (?, ?, ?, ?)");
    $stmt->execute([$naam, $type, $startdatum, $einddatum]);

    echo "Verkiezing succesvol uitgeschreven!";
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Verkiezing Uitschrijven</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <h2>Verkiezing Uitschrijven</h2>
    <form method="POST" action="verkiezing_uit_schrijven.php">
        <input type="text" name="naam" placeholder="Verkiezingsnaam" required><br>
        <select name="type">
            <option value="landelijk">Landelijk</option>
            <option value="regionaal">Regionaal</option>
        </select><br>
        <input type="date" name="startdatum" required><br>
        <input type="date" name="einddatum" required><br>
        <button type="submit">Verkiezing Uitschrijven</button>
    </form>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
