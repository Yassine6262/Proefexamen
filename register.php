<?php
// Verbinding met de database
$host = 'localhost';
$dbname = 'proefexamen';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Controleer of het formulier is ingediend
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registratie Pagina</title>
</head>
<body>
    <h2>Registreren</h2>
    <form action="register.php" method="post">
        <label for="username">Gebruikersnaam:</label><br>
        <input type="text" id="username" name="username"><br><br>

        <label for="password">Wachtwoord:</label><br>
        <input type="password" id="password" name="password"><br><br>

        <label for="email">E-mail:</label><br>
        <input type="email" id="email" name="email"><br><br>

        <input type="submit" value="Registreer">
    </form>
</body>
</html>
