<?php


// Initialiseer variabelen om formuliergegevens en fouten op te slaan
$errors = [];
$success_message = '';

// Verwerk het formulier bij verzending
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Haal de ingevoerde partijnaam op en trim witte ruimtes
    $partij_naam = trim($_POST['partij_naam'] ?? '');

    // Controleer of de partijnaam is ingevoerd
    if (empty($partij_naam)) {
        $errors[] = "Partijnaam is verplicht.";
    }

    // Als er geen fouten zijn, voeg de partij toe aan de database
    if (empty($errors)) {
        // SQL-query om de partij toe te voegen
        $sql = "INSERT INTO partijen (naam) VALUES (?)";

        // Voorbereiden van de SQL-query om SQL-injecties te voorkomen
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("", $partij_naam);

            if ($stmt->execute()) {
                $success_message = "Partij is succesvol toegevoegd!";
                // Leeg de velden na succesvolle verzending
                $partij_naam = '';
            } else {
                $errors[] = "Fout bij het toevoegen van de partij: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $errors[] = "Fout bij het voorbereiden van de query: " . $conn->error;
        }
    }
}

// Sluit de databaseverbinding
// $conn->close();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Politieke Partij Toevoegen</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Nieuwe Politieke Partij Toevoegen</h2>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if ($success_message): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="mb-3">
                <label for="partij_naam" class="form-label">Partijnaam *</label>
                <input type="text" class="form-control" id="partij_naam" name="partij_naam" 
                       value="<?php echo htmlspecialchars($partij_naam ?? ''); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Partij Toevoegen</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
