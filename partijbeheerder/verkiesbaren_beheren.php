<?php
session_start();
require '../includes/db.php';

// Controleer of de gebruiker een partijbeheerder is
if ($_SESSION['role'] !== 'partijbeheerder') {
    header('Location: ../login.php');
    exit;
}

// Haal de partij_id op van de ingelogde partijbeheerder
$partij_id = $_SESSION['partij_id'];

// Verkiesbaren ophalen die tot deze partij behoren
$stmt = $pdo->prepare("SELECT g.id, g.naam, k.positie FROM gebruikers g
    LEFT JOIN kandidaten_volgorde k ON g.id = k.kandidaat_id AND k.verkiezing_id IS NULL
    WHERE g.partij_id = ?");
$stmt->execute([$partij_id]);
$verkiesbaren = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Kandidaat verwijderen
if (isset($_POST['verwijder'])) {
    $kandidaat_id = $_POST['kandidaat_id'];
    $stmt = $pdo->prepare("UPDATE gebruikers SET partij_id = NULL WHERE id = ?");
    $stmt->execute([$kandidaat_id]);
    header("Location: verkiesbaren_beheren.php");
    exit;
}

// Positie aanpassen
if (isset($_POST['update_posities'])) {
    foreach ($_POST['posities'] as $kandidaat_id => $positie) {
        $stmt = $pdo->prepare("INSERT INTO kandidaten_volgorde (kandidaat_id, positie, verkiezing_id) 
            VALUES (?, ?, NULL) 
            ON DUPLICATE KEY UPDATE positie = ?");
        $stmt->execute([$kandidaat_id, $positie, $positie]);
    }
    header("Location: verkiesbaren_beheren.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Verkiesbaren beheren</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <h2>Verkiesbaren Beheren</h2>

    <form method="POST" action="verkiesbaren_beheren.php">
        <table>
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Positie</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($verkiesbaren as $verkiesbare): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($verkiesbare['naam']); ?></td>
                        <td>
                            <input type="number" name="posities[<?php echo $verkiesbare['id']; ?>]" 
                                   value="<?php echo htmlspecialchars($verkiesbare['positie'] ?? ''); ?>">
                        </td>
                        <td>
                            <button type="submit" name="verwijder" value="Verwijder">Verwijderen</button>
                            <input type="hidden" name="kandidaat_id" value="<?php echo $verkiesbare['id']; ?>">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" name="update_posities">Posities Bijwerken</button>
    </form>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
