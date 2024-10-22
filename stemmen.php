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

// Voting process
if (isset($_POST['vote'])) {
    $voter_id = $conn->real_escape_string($_POST['voter_id']);
    $party_id = $conn->real_escape_string($_POST['party_id']);
    
    // Check if the voter has already voted
    $check_sql = "SELECT COUNT(*) as vote_count FROM votes WHERE voter_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $voter_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $vote_count = $check_result->fetch_assoc()['vote_count'];
    $check_stmt->close();

    if ($vote_count == 0) {
        $sql = "INSERT INTO votes (voter_id, party_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $voter_id, $party_id);
        if ($stmt->execute()) {
            $message = "<p class='success'>Uw stem is succesvol uitgebracht. Bedankt voor het stemmen!</p>";
        } else {
            $message = "<p class='error'>Er is een fout opgetreden bij het uitbrengen van uw stem. Probeer het opnieuw.</p>";
        }
        $stmt->close();
    } else {
        $message = "<p class='error'>U heeft al gestemd. Elke burger mag slechts één keer stemmen.</p>";
    }
}

// Fetch parties
$parties_sql = "SELECT * FROM parties ORDER BY name";
$parties_result = $conn->query($parties_sql);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stem op een Politieke Partij</title>
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
        input[type="text"], select {
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
    <h1>Stem op een Politieke Partij</h1>

    <?php echo $message; ?>

    <form method="post">
        <input type="text" name="voter_id" placeholder="Uw naam" required>
        <select name="party_id" required>
            <option value="">Kies een partij</option>
            <?php
            if ($parties_result->num_rows > 0) {
                while($row = $parties_result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
                }
            }
            ?>
        </select>
        <input type="submit" name="vote" value="Breng uw stem uit">
    </form>
</body>
</html>

<?php
$conn->close();
?>