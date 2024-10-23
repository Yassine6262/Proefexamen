<?php
session_start();
require '../includes/db.php'; // Make sure this path is correct

// Controleer of de gebruiker is ingelogd en of ze admin rechten hebben
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

// Als het formulier wordt verzonden
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = $_POST['naam'];
    $beschrijving = $_POST['beschrijving'];

    // Validatie
    if (empty($naam)) {
        $error = "Partijnaam is verplicht!";
    } else {
        // Voeg de partij toe aan de database
        $stmt = $conn->prepare("INSERT INTO partijen (naam, beschrijving) VALUES (?, ?)");
        $stmt->bind_param('ss', $naam, $beschrijving);

        if ($stmt->execute()) {
            $success = "Partij succesvol toegevoegd!";
        } else {
            $error = "Er ging iets mis tijdens het toevoegen van de partij!";
        }

        $stmt->close();
    }
}
?>

<?php include '../includes/header.php'; ?>

<h2>Partij Registreren</h2>

<!-- Weergeven van eventuele fout- of succesmeldingen -->
<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php elseif (isset($success)): ?>
    <p style="color: green;"><?php echo $success; ?></p>
<?php endif; ?>

<!-- Formulier voor het registreren van een nieuwe partij -->
<form action="add_partij.php" method="post">
    <label for="naam">Partij Naam:</label>
    <input type="text" id="naam" name="naam" required><br>

    <label for="beschrijving">Beschrijving:</label>
    <textarea id="beschrijving" name="beschrijving"></textarea><br>

    <button type="submit">Partij Toevoegen</button>
</form>

<?php include '../includes/footer.php'; ?>
