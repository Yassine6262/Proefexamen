<?php
// Database connection
$servername = "localhost";
$username = "root";  // Vervang dit door uw MySQL-gebruikersnaam
$password = "";      // Vervang dit door uw MySQL-wachtwoord
$dbname = "voting_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

// Adding party process
if (isset($_POST['add_party'])) {
    $party_name = $conn->real_escape_string($_POST['party_name']);

    // Check if the party name is empty
    if (!empty($party_name)) {
        // Check if party name already exists
        $check_sql = "SELECT COUNT(*) as count FROM parties WHERE name = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $party_name);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $row = $check_result->fetch_assoc();

        if ($row['count'] > 0) {
            // Party name already exists
            $message = "<p class='error'>Deze partijnaam bestaat al. Kies een andere naam.</p>";
        } else {
            // Party name doesn't exist, proceed to insert
            $sql = "INSERT INTO parties (name) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $party_name); // Bind de partijnaam aan de query
            if ($stmt->execute()) {
                $message = "<p class='success'>De partij is succesvol toegevoegd!</p>";
            } else {
                $message = "<p class='error'>Er is een fout opgetreden bij het toevoegen van de partij. Probeer het opnieuw.</p>";
            }
            $stmt->close();
        }
        $check_stmt->close();
    } else {
        $message = "<p class='error'>De partijnaam mag niet leeg zijn.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voeg een Politieke Partij Toe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #2c3e50;
            text-align: center;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #2980b9;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    
    <h1>Voeg een Politieke Partij Toe</h1>

    <?php echo $message; ?>

    <form method="post">
        <input type="text" name="party_name" placeholder="Partijnaam" required>
        <input type="submit" name="add_party" value="Partij Toevoegen">
    </form>
</body>
</html>

<?php
$conn->close();
?>
