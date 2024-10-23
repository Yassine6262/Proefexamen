<?php
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Controleer of de gebruikersnaam al bestaat
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $userExists = $stmt->fetchColumn();

    if ($userExists > 0) {
        echo "Deze gebruikersnaam is al in gebruik. Kies een andere.";
    } else {
        // Voeg de nieuwe gebruiker toe als de gebruikersnaam uniek is
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$username, $password, $role]);

        echo "Registratie succesvol!";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Registreren</title>
</head>
<body>
    <h2>Registreren</h2>
    <form method="POST" action="register.php">
        <input type="text" name="username" placeholder="Gebruikersnaam" required><br>
        <input type="password" name="password" placeholder="Wachtwoord" required><br>
        <select name="role">
            <option value="admin">Admin</option>
            <option value="gemeente">Gemeente</option>
            <option value="stemgerechtigde">Stemgerechtigde</option>
            <option value="partijbeheerder">Partijbeheerder</option>
        </select><br>
        <button type="submit">Registreren</button>
    </form>
</body>
</html>
