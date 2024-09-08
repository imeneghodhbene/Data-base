<?php
function renderCorrectionForm($idcl, $nomcl) {
    echo '<br>';
    echo '<form action="cl.php" method="post">';
    echo '<p>Id : <input type="text" name="idcl" value="' . htmlspecialchars($idcl) . '" required></p>';
    echo '<p>Nom : <input type="text" name="nomcl" value="' . htmlspecialchars($nomcl) . '"></p>';
    echo '<input type="submit" value="Corriger">';
    echo '</form>';
}

function showAlert($message) {
    echo "<script type='text/javascript'>alert('$message');</script>";
}

if (isset($_POST["idcl"])) {
    $idcl = htmlspecialchars($_POST["idcl"]);
    $nomcl = isset($_POST["nomcl"]) ? htmlspecialchars($_POST["nomcl"]) : '';

    // Establish database connection using mysqli
    $conn = new mysqli("localhost", "root", "", "inscription2");

    // Check if connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if ID already exists
    $checkId = $conn->prepare("SELECT idcl FROM classe WHERE idcl = ?");
    if ($checkId === false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }
    $checkId->bind_param("s", $idcl);
    $checkId->execute();
    $checkId->store_result();

    if ($checkId->num_rows > 0) {
        // Update existing record
        $updateStmt = $conn->prepare("UPDATE classe SET nomcl = ? WHERE idcl = ?");
        if ($updateStmt === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }

        // Bind parameters
        $updateStmt->bind_param("ss", $nomcl, $idcl);

        // Execute the statement
        if ($updateStmt->execute()) {
            showAlert("Classe mise à jour");
        } else {
            showAlert("Échec de la mise à jour : " . htmlspecialchars($updateStmt->error));
            renderCorrectionForm($idcl, $nomcl);
        }

        // Close the statement
        $updateStmt->close();
    } else {
        // Insert new record
        $insertStmt = $conn->prepare("INSERT INTO classe (idcl, nomcl) VALUES (?, ?)");
        if ($insertStmt === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }

        // Bind parameters
        $insertStmt->bind_param("ss", $idcl, $nomcl);

        // Execute the statement
        if ($insertStmt->execute()) {
            showAlert("Classe ajoutée");
        } else {
            showAlert("Classe non ajoutée : " . htmlspecialchars($insertStmt->error));
            renderCorrectionForm($idcl, $nomcl);
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
cliquer <a href="modcl.html">ici</a> pour modifier les coordonnées
<br>cliquer <a href="menu1.html"> ici</a> pour revenir au menu
