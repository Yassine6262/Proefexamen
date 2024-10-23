<?php
session_start();
require '../includes/db.php';

// Controleer of de gebruiker een partijbeheerder is
if ($_SESSION['role'] !== 'partijbeheerder') {
    header('Location: ../login.php');
    exit;
}

// Haal alle leden van de partij op
$partij_id = $_SESSION['partij_id'];
$stmt = $pdo->prepare("SELECT * FROM gebruikers WHERE partij_id = ?");
$stmt->execute([$partij_id]);
$kandidaten = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verwerk het accepteren of verwijderen van een kandidaat
if (isset($_GET['accepteren'])) {
    $kandidaat_id = $_GET['accepteren'];
    $stmt = $pdo->prepare("UPDATE gebruikers SET status = 'geaccepteerd' WHERE id = ?");
    $stmt->execute([$kandidaat_id]);
    header('Location: kandidaten_beheren.php');
} elseif (isset($_GET['verwijderen'])) {
    $kandidaat_id = $_GET['verwijderen'];
    $stmt = $pdo->prepare("DELETE FROM gebruikers WHERE id = ?");
    $stmt->execute([$kandidaat_id]);
    header('Location: kandidaten_beheren.php');
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Kandidaten Beheren</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <h2>Kandidaten Beheren</h2>
    <ul>
        <?php foreach ($kandidaten as $kandidaat): ?>
            <li>
                <?php echo htmlspecialchars($kandidaat['naam']); ?>
                <?php if ($kandidaat['status'] == 'niet geaccepteerd'): ?>
                    <a href="kandidaten_beheren.php?accepteren=<?php echo $kandidaat['id']; ?>">Accepteren</a>
                <?php endif; ?>
                <a href="kandidaten_beheren.php?verwijderen=<?php echo $kandidaat['id']; ?>">Verwijderen</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
