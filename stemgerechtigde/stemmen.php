<?php
session_start();
require '../includes/db.php';

// Controleer of de gebruiker een stemgerechtigde is
if ($_SESSION['role'] !== 'stemgerechtigde') {
    header('Location: ../login.php');
    exit;
}

// Haal actieve verkiezingen op waarvoor de stemgerechtigde nog niet heeft gestemd
$stmt = $pdo->prepare("SELECT * FROM verkiezingen WHERE is_actief = 1 AND id NOT IN 
    (SELECT verkiezing_id FROM stemmen WHERE user_id = ?)");
$stmt->execute([$_SESSION['user_id']]);
$verkiezingen = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verwerk het stemmen
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $verkiezing_id = $_POST['verkiezing_id'];

    // Voeg de stem toe aan de database
    $stmt = $pdo->prepare("INSERT INTO stemmen (user_id, verkiezing_id, datum) VALUES (?, ?, NOW())");
    $stmt->execute([$_SESSION['user_id'], $verkiezing_id]);

    echo "Stem succesvol uitgebracht!";
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Stem uitbrengen</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <h2>Stem uitbrengen</h2>

    <?php if (count($verkiezingen) > 0): ?>
        <form method="POST" action="stemmen.php">
            <label for="verkiezing">Selecteer een verkiezing:</label>
            <select name="verkiezing_id" required>
                <?php foreach ($verkiezingen as $verkiezing): ?>
                    <option value="<?php echo $verkiezing['id']; ?>">
                        <?php echo htmlspecialchars($verkiezing['naam']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Stem uitbrengen</button>
        </form>
    <?php else: ?>
        <p>Er zijn momenteel geen actieve verkiezingen waarvoor je kunt stemmen, of je hebt al gestemd.</p>
    <?php endif; ?>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
