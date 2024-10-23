<?php
$host = 'localhost';
$dbname = 'stem_systeem';
$username = 'root';  // Pas aan indien nodig
$password = '';      // Pas aan indien nodig

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Databaseverbinding mislukt: " . $e->getMessage());
}
?>
