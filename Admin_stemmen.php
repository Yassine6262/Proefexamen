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

// Create (C in CRUD)
if (isset($_POST['add_party'])) {
    $party_name = $conn->real_escape_string($_POST['party_name']);
    $sql = "INSERT INTO parties (name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $party_name);
    $stmt->execute();
    $stmt->close();
}

// Read (R in CRUD)
$sql = "SELECT * FROM parties";
$result = $conn->query($sql);

// Update (U in CRUD)
if (isset($_POST['update_party'])) {
    $party_id = $conn->real_escape_string($_POST['party_id']);
    $new_name = $conn->real_escape_string($_POST['new_name']);
    $sql = "UPDATE parties SET name = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_name, $party_id);
    $stmt->execute();
    $stmt->close();
}

// Delete (D in CRUD)
if (isset($_POST['delete_party'])) {
    $party_id = $conn->real_escape_string($_POST['party_id']);
    $sql = "DELETE FROM parties WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $party_id);
    $stmt->execute();
    $stmt->close();
}

// Voting
if (isset($_POST['vote'])) {
    $voter_id = $conn->real_escape_string($_POST['voter_id']);
    $party_id = $conn->real_escape_string($_POST['party_id']);
    
    // Controleer of de kiezer al gestemd heeft
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
        $stmt->execute();
        $stmt->close();
        echo "<p>Uw stem is succesvol uitgebracht.</p>";
    } else {
        echo "<p>U heeft al gestemd.</p>";
    }
}

// Stem resultaten ophalen
$results_sql = "SELECT parties.name, COUNT(votes.id) as vote_count
                FROM parties
                LEFT JOIN votes ON parties.id = votes.party_id
                GROUP BY parties.id
                ORDER BY vote_count DESC";
$results = $conn->query($results_sql);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stemmen op Politieke Partijen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1, h2 {
            color: #2c3e50;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
        }
        input[type="submit"]:hover {
            background-color: #2980b9;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background-color: #fff;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .party-list p {
            background-color: #fff;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .party-list form {
            display: inline;
            margin: 0 5px;
        }
        .party-list input[type="submit"] {
            padding: 5px 10px;
            font-size: 0.9em;
        }
        .success, .error {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <h1>Stemmen op Politieke Partijen</h1>

    <!-- Add Party Form -->
    <h2>Voeg een nieuwe partij toe</h2>
    <form method="post">
        <input type="text" name="party_name" required placeholder="Partijnaam">
        <input type="submit" name="add_party" value="Toevoegen">
    </form>

    <!-- List Parties and Update/Delete Forms -->
    <h2>Lijst van Partijen</h2>
    <div class="party-list">
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<p>" . htmlspecialchars($row['name']) . " 
                <form method='post'>
                    <input type='hidden' name='party_id' value='" . $row['id'] . "'>
                    <input type='text' name='new_name' placeholder='Nieuwe naam' required>
                    <input type='submit' name='update_party' value='Bijwerken'>
                </form>
                <form method='post'>
                    <input type='hidden' name='party_id' value='" . $row['id'] . "'>
                    <input type='submit' name='delete_party' value='Verwijderen'>
                </form>
            </p>";
        }
    } else {
        echo "<p>Geen partijen gevonden.</p>";
    }
    ?>
    </div>

   

    <!-- Display Voting Results -->
    <h2>Huidige Stemresultaten</h2>
    <ul>
    <?php
    if ($results->num_rows > 0) {
        while($row = $results->fetch_assoc()) {
            echo "<li>" . htmlspecialchars($row['name']) . ": " . $row['vote_count'] . " stemmen</li>";
        }
    } else {
        echo "<li>Nog geen stemmen uitgebracht.</li>";
    }
    ?>
    </ul>
</body>
</html>
<?php
$conn->close();
?>