<?php
session_start();
require '../includes/db.php';

// Controleer of de gebruiker een gemeente-gebruiker is
if ($_SESSION['role'] !== 'gemeente') {
    header('Location: ../login.php');
    exit;
}

// Haal alle actieve verkiezingen op
$stmt = $pdo->prepare("SELECT * FROM verkiezingen WHERE is_actief = 1");
$stmt->execute();
$verkiezingen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Uitnodigingen Versturen</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <h2>Uitnodigingen Versturen</h2>
    <?php if (count($verkiezingen) > 0): ?>
        <ul>
            <?php foreach ($verkiezingen as $verkiezing): ?>
                <li>
                    Verkiezing: <?php echo htmlspecialchars($verkiezing['naam']); ?>
                    <button>Uitnodiging Versturen</button>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Er zijn momenteel geen actieve verkiezingen.</p>
    <?php endif; ?>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
