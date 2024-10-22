<?php

// Database connectie configuratie
$servername = "localhost";
$username = "root";  // Vervang dit door uw MySQL-gebruikersnaam
$password = "";      // Vervang dit door uw MySQL-wachtwoord
$dbname = "voting_system"; // De naam van de database

// Maak verbinding met de database
$conn = new mysqli($servername, $username, $password, $dbname);


// Check connectie
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verwerk het formulier wanneer het wordt verzonden
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $resume_path = "";

    // Bestand upload verwerking
    if(isset($_FILES['resume'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["resume"]["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check bestandsformaat
        if($fileType != "pdf" && $fileType != "doc" && $fileType != "docx") {
            echo "Sorry, alleen PDF, DOC & DOCX bestanden zijn toegestaan.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["resume"]["tmp_name"], $target_file)) {
                $resume_path = $target_file;
            } else {
                echo "Sorry, er was een probleem met het uploaden van je bestand.";
            }
        }
    }

    // Voeg kandidaat toe aan database
    $sql = "INSERT INTO candidates (firstname, lastname, email, phone, resume_path, created_at) 
            VALUES ('$firstname', '$lastname', '$email', '$phone', '$resume_path', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Kandidaat succesvol toegevoegd!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kandidaat Toevoegen</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Nieuwe Kandidaat Toevoegen</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="firstname" class="form-label">Voornaam</label>
                <input type="text" class="form-control" id="firstname" name="firstname" required>
            </div>
            
            <div class="mb-3">
                <label for="lastname" class="form-label">Achternaam</label>
                <input type="text" class="form-control" id="lastname" name="lastname" required>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            
            <div class="mb-3">
                <label for="phone" class="form-label">Telefoonnummer</label>
                <input type="tel" class="form-control" id="phone" name="phone">
            </div>
            
            <div class="mb-3">
                <label for="resume" class="form-label">CV Upload (PDF, DOC, DOCX)</label>
                <input type="file" class="form-control" id="resume" name="resume" accept=".pdf,.doc,.docx">
            </div>
            
            <button type="submit" class="btn btn-primary">Kandidaat Toevoegen</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>