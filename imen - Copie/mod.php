<?php
function renderCorrectionForm($id, $nom, $prenom) {
    echo '<br>';
    echo '<form action="ins.php" method="post">';
    echo '<p>Id : <input type="text" name="id" value="' . htmlspecialchars($id) . '" required></p>';
    echo '<p>Nom : <input type="text" name="nom" value="' . htmlspecialchars($nom) . '"></p>';
    echo '<p>Prenom : <input type="text" name="prenom" value="' . htmlspecialchars($prenom) . '"></p>';
    echo '<input type="submit" value="Corriger">';
    echo '</form>';
}

if (isset($_POST["id"])) {
    $id = htmlspecialchars($_POST["id"]);
    $nom = isset($_POST["nom"]) ? htmlspecialchars($_POST["nom"]) : '';
    $prenom = isset($_POST["prenom"]) ? htmlspecialchars($_POST["prenom"]) : '';

    // Establish database connection using mysqli
    $conn = new mysqli("localhost", "root", "", "inscription2");

    // Check if connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if ID already exists
    $checkId = $conn->prepare("SELECT id FROM etudiant WHERE id = ?");
    if ($checkId === false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }
    $checkId->bind_param("s", $id);
    $checkId->execute();
    $checkId->store_result();

    if ($checkId->num_rows > 0) {
        // Update existing record
        $updateStmt = $conn->prepare("UPDATE etudiant SET nom = ?, prenom = ? WHERE id = ?");
        if ($updateStmt === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }

        // Bind parameters
        $updateStmt->bind_param("sss", $nom, $prenom, $id);

        // Execute the statement
        if ($updateStmt->execute()) {
            // Afficher un message de succès en utilisant JavaScript
            echo '<script type="text/javascript">';
            echo 'alert("Étudiant mis à jour avec succès!");';
            echo '</script>';
        } else {
            echo "Échec de la mise à jour : " . htmlspecialchars($updateStmt->error);
            renderCorrectionForm($id, $nom, $prenom);
        }

        // Close the statement
        $updateStmt->close();
    } else {
        // Insert new record
        $insertStmt = $conn->prepare("INSERT INTO etudiant (id, nom, prenom) VALUES (?, ?, ?)");
        if ($insertStmt === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }

        // Bind parameters
        $insertStmt->bind_param("sss", $id, $nom, $prenom);

        // Execute the statement
        if ($insertStmt->execute()) {
            // Afficher un message de succès en utilisant JavaScript
            echo '<script type="text/javascript">';
            echo 'alert("Étudiant ajouté avec succès!");';
            echo '</script>';
        } else {
            echo "Étudiant non ajouté : " . htmlspecialchars($insertStmt->error);
            renderCorrectionForm($id, $nom, $prenom);
        }

        // Close the statement
        $insertStmt->close();
    }

    // Close the connection
    $checkId->close();
    $conn->close();
} else {
    echo "Les champs requis sont manquants.";
}
?>
cliquer <a href="modif.html"> ici</a> pour modifier les coordonnées <br>
cliquer <a href="menu1.html"> ici</a> pour revenir au menu