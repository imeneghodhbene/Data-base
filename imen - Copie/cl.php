<?php
function showAlert($message) {
    echo "<script type='text/javascript'>alert('$message');</script>";
}

if (isset($_POST["idcl"]) && isset($_POST["nomcl"])) {
    $idcl = htmlspecialchars($_POST["idcl"]);
    $nomcl = htmlspecialchars($_POST["nomcl"]);

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
        showAlert("Classe avec cet ID existe déjà.");
    } else {
        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO classe (idcl, nomcl) VALUES (?, ?)");
        if ($stmt === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }

        // Bind parameters
        $stmt->bind_param("ss", $idcl, $nomcl);

        // Execute the statement
        if ($stmt->execute()) {
            showAlert("Classe ajoutée");
        } else {
            showAlert("Classe non ajoutée: " . htmlspecialchars($stmt->error));
        }

        // Close the statement
        $stmt->close();
    }

    // Close the connection
    $checkId->close();
    $conn->close();
} else {
    showAlert("Les champs requis sont manquants.");
}
?>
<br>
cliquer <a href="modcl.html"> ici</a> pour modifier les coordonnées
<br>cliquer <a href="menu1.html"> ici</a> pour revenir au menu
