<?php
session_start();
require '../includes/db.php';

// Controleer of de gebruiker een admin is
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Haal de niet-goedgekeurde partijen op
$stmt = $pdo->prepare("SELECT * FROM partijen WHERE goedgekeurd = 0");
$stmt->execute();
$partijen = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Als een partij goedgekeurd moet worden
if (isset($_GET['goedgekeurd'])) {
    $partij_id = $_GET['goedgekeurd'];
    $update_stmt = $pdo->prepare("UPDATE partijen SET goedgekeurd = 1 WHERE id = ?");
    $update_stmt->execute([$partij_id]);

    header('Location: partijen_goedkeuren.php');
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Partijen Goedkeuren</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <h2>Partijen Goedkeuren</h2>
    <?php if (count($partijen) > 0): ?>
        <ul>
            <?php foreach ($partijen as $partij): ?>
                <li>
                    <?php echo htmlspecialchars($partij['naam']); ?>
                    <a href="partijen_goedkeuren.php?goedgekeurd=<?php echo $partij['id']; ?>">Goedkeuren</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Er zijn momenteel geen partijen om goed te keuren.</p>
    <?php endif; ?>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
