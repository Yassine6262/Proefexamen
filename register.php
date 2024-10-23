<?php
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    
    // Controleer of velden zijn ingevuld
    if (empty($username) || empty($password) || empty($email)) {
        echo "Alle velden zijn verplicht!";
    } else {
        // Het wachtwoord beveiligen met password_hash()
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Voeg de gebruiker toe aan de database
        $sql = "INSERT INTO users (username, password, email, role, is_active, created_at) 
                VALUES (?, ?, ?, 'stemgerechtigde', TRUE, NOW())";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $hashed_password, $email);

        if ($stmt->execute()) {
            echo "Registratie succesvol!";
        } else {
            echo "Er is een fout opgetreden: " . $conn->error;
        }

        $stmt->close();
    }
}

$conn->close();
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
