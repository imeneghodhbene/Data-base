<?php
function renderCorrectionForm($idprof, $nomprof, $prenomprof) {
    echo '<br>';
    echo '<form action="ins.php" method="post">';
    echo '<p>idprof : <input type="text" name="idprof" value="' . htmlspecialchars($idprof) . '" required></p>';
    echo '<p>nomprof : <input type="text" name="nomprof" value="' . htmlspecialchars($nomprof) . '"></p>';
    echo '<p>Prenomprof : <input type="text" name="prenomprof" value="' . htmlspecialchars($prenomprof) . '"></p>';
    echo '<input type="submit" value="Corriger">';
    echo '</form>';
}

if (isset($_POST["idprof"])) {
    $idprof = htmlspecialchars($_POST["idprof"]);
    $nomprof = isset($_POST["nomprof"]) ? htmlspecialchars($_POST["nomprof"]) : '';
    $prenomprof = isset($_POST["prenomprof"]) ? htmlspecialchars($_POST["prenomprof"]) : '';

    // Establish database connection using mysqli
    $conn = new mysqli("localhost", "root", "", "inscription2");

    // Check if connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if idprof already exists
    $checkidprof = $conn->prepare("SELECT idprof FROM prof WHERE idprof = ?");
    if ($checkidprof === false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }
    $checkidprof->bind_param("s", $idprof);
    $checkidprof->execute();
    $checkidprof->store_result();

    if ($checkidprof->num_rows > 0) {
        // Update existing record
        $updateStmt = $conn->prepare("UPDATE prof SET nomprof = ?, prenomprof = ? WHERE idprof = ?");
        if ($updateStmt === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }

        // Bind parameters
        $updateStmt->bind_param("sss", $nomprof, $prenomprof, $idprof);

        // Execute the statement
        if ($updateStmt->execute()) {
            // Afficher un message de succès en utilisant JavaScript
            echo '<script type="text/javascript">';
            echo 'alert("Étudiant mis à jour avec succès!");';
            echo '</script>';
        } else {
            echo "Échec de la mise à jour : " . htmlspecialchars($updateStmt->error);
            renderCorrectionForm($idprof, $nomprof, $prenomprof);
        }

        // Close the statement
        $updateStmt->close();
    } else {
        // Insert new record
        $insertStmt = $conn->prepare("INSERT INTO prof (idprof, nomprof, prenomprof) VALUES (?, ?, ?)");
        if ($insertStmt === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }

        // Bind parameters
        $insertStmt->bind_param("sss", $idprof, $nomprof, $prenomprof);

        // Execute the statement
        if ($insertStmt->execute()) {
            // Afficher un message de succès en utilisant JavaScript
            echo '<script type="text/javascript">';
            echo 'alert("Étudiant ajouté avec succès!");';
            echo '</script>';
        } else {
            echo "Étudiant non ajouté : " . htmlspecialchars($insertStmt->error);
            renderCorrectionForm($idprof, $nomprof, $prenomprof);
        }

        // Close the statement
        $insertStmt->close();
    }

    // Close the connection
    $checkidprof->close();
    $conn->close();
} else {
    echo "Les champs requis sont manquants.";
}
?>
cliquer <a href="modp.html"> ici</a> pour modifier les coordonnées <br>
cliquer <a href="menu1.html"> ici</a> pour revenir au menu