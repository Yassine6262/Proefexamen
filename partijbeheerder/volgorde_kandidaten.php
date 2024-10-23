<?php
session_start();
require '../includes/db.php';

// Controleer of de gebruiker een partijbeheerder is
if ($_SESSION['role'] !== 'partijbeheerder') {
    header('Location: ../login.php');
    exit;
}

// Haal alle geaccepteerde kandidaten van de partij op
$partij_id = $_SESSION['partij_id'];
$stmt = $pdo->prepare("SELECT * FROM gebruikers WHERE partij_id = ? AND status = 'geaccepteerd'");
$stmt->execute([$partij_id]);
$kandidaten = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verwerk de nieuwe volgorde
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $volgorde = $_POST['volgorde'];

    foreach ($volgorde as $positie => $kandidaat_id) {
        $stmt = $pdo->prepare("UPDATE kandidaten_volgorde SET positie = ? WHERE kandidaat_id = ?");
        $stmt->execute([$positie + 1, $kandidaat_id]);
    }

    echo "Volgorde succesvol opgeslagen!";
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Volgorde Kandidaten Voor Verkiezingen</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <h2>Volgorde Kandidaten Voor Verkiezingen</h2>

    <form method="POST" action="volgorde_kandidaten.php">
        <ol>
            <?php foreach ($kandidaten as $kandidaat): ?>
                <li>
                    <select name="volgorde[]">
                        <?php foreach ($kandidaten as $optie): ?>
                            <option value="<?php echo $optie['id']; ?>">
                                <?php echo htmlspecialchars($optie['naam']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </li>
            <?php endforeach; ?>
        </ol>
        <button type="submit">Volgorde Opslaan</button>
    </form>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
