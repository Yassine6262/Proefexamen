<?php
session_start();
if(isset($_SESSION['user'])) {
    header("Location: welcome.php"); // Redirect naar beveiligde pagina
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f2f2f2; }
        .container { width: 300px; margin: 100px auto; background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px 0px #aaa; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 10px; background-color: #5cb85c; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #4cae4c; }
        .reset-link { display: block; text-align: center; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Inloggen</h2>
        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Gebruikersnaam" required>
            <input type="password" name="password" placeholder="Wachtwoord" required>
            <button type="submit">Inloggen</button>
        </form>
        <a href="reset_password.php" class="reset-link">Wachtwoord vergeten?</a>
    </div>
</body>
</html>
