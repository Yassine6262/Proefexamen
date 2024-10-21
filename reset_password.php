<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Simpele validatie of e-mail bestaat
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Genereer nieuw wachtwoord (of stuur reset link)
        $new_password = bin2hex(random_bytes(4)); // Genereren van een random wachtwoord
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update het nieuwe wachtwoord in de database
        $sql = "UPDATE users SET password = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $hashed_password, $email);
        if ($stmt->execute()) {
            echo "Je nieuwe wachtwoord is: " . $new_password;
        } else {
            echo "Er is iets misgegaan!";
        }
    } else {
        echo "E-mail niet gevonden!";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wachtwoord Reset</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f2f2f2; }
        .container { width: 300px; margin: 100px auto; background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px 0px #aaa; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 10px; background-color: #5cb85c; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #4cae4c; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Wachtwoord</h2>
        <form action="" method="POST">
            <input type="email" name="email" placeholder="E-mail" required>
            <button type="submit">Reset Wachtwoord</button>
        </form>
    </div>
</body>
</html>
