<?php
function showAlert($message) {
    echo "<script type='text/javascript'>alert('$message');</script>";
}

function renderCorrectionForm($idmat, $nommat) {
    echo '<br>';
    echo '<form action="mat.php" method="post">';
    echo '<p>Id : <input type="text" name="idmat" value="' . htmlspecialchars($idmat) . '" required></p>';
    echo '<p>Nom : <input type="text" name="nommat" value="' . htmlspecialchars($nommat) . '"></p>';
    echo '<input type="submit" value="Corriger">';
    echo '</form>';
}

if (isset($_POST["idmat"])) {
    $idmat = htmlspecialchars($_POST["idmat"]);
    $nommat = isset($_POST["nommat"]) ? htmlspecialchars($_POST["nommat"]) : '';

    // Establish database connection using mysqli
    $conn = new mysqli("localhost", "root", "", "inscription2");

    // Check if connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if ID already exists
    $checkId = $conn->prepare("SELECT idmat FROM matiere WHERE idmat = ?");
    if ($checkId === false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }
    $checkId->bind_param("s", $idmat);
    $checkId->execute();
    $checkId->store_result();

    if ($checkId->num_rows > 0) {
        // Update existing record
        $updateStmt = $conn->prepare("UPDATE matiere SET nommat = ? WHERE idmat = ?");
        if ($updateStmt === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }

        // Bind parameters
        $updateStmt->bind_param("ss", $nommat, $idmat);

        // Execute the statement
        if ($updateStmt->execute()) {
            showAlert("Matière mise à jour");
        } else {
            showAlert("Échec de la mise à jour : " . htmlspecialchars($updateStmt->error));
            renderCorrectionForm($idmat, $nommat);
        }

        // Close the statement
        $updateStmt->close();
    } else {
        // Insert new record
        $insertStmt = $conn->prepare("INSERT INTO matiere (idmat, nommat) VALUES (?, ?)");
        if ($insertStmt === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }

        // Bind parameters
        $insertStmt->bind_param("ss", $idmat, $nommat);

        // Execute the statement
        if ($insertStmt->execute()) {
            showAlert("Matière ajoutée");
        } else {
            showAlert("Matière non ajoutée : " . htmlspecialchars($insertStmt->error));
            renderCorrectionForm($idmat, $nommat);
        }

        // Close the statement
        $insertStmt->close();
    }

    // Close the connection
    $checkId->close();
    $conn->close();
} else {
    showAlert("Les champs requis sont manquants.");
}
?>
<br>
cliquer <a href="modmat.html">ici</a> pour modifier les coordonnées
<br>cliquer <a href="menu1.html">ici</a> pour revenir au menu
