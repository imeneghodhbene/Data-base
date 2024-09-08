<?php
function showAlert($message) {
    echo "<script type='text/javascript'>alert('$message');</script>";
}

if (isset($_POST["idprof"]) && isset($_POST["nomprof"]) && isset($_POST["prenomprof"])) {
    $idprof = htmlspecialchars($_POST["idprof"]);
    $nomprof = htmlspecialchars($_POST["nomprof"]);
    $prenomprof = htmlspecialchars($_POST["prenomprof"]);

    // Establish database connection using mysqli
    $conn = new mysqli("localhost", "root", "", "inscription2");

    // Check if connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if ID already exists
    $checkId = $conn->prepare("SELECT idprof FROM prof WHERE idprof = ?");
    if ($checkId === false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }
    $checkId->bind_param("s", $idprof);
    $checkId->execute();
    $checkId->store_result();

    if ($checkId->num_rows > 0) {
        showAlert("Prof avec cet ID existe déjà.");
    } else {
        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO prof (idprof, nomprof, prenomprof) VALUES (?, ?, ?)");
        if ($stmt === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }

        // Bind parameters
        $stmt->bind_param("sss", $idprof, $nomprof, $prenomprof);

        // Execute the statement
        if ($stmt->execute()) {
            showAlert("Prof ajouté");
        } else {
            showAlert("Prof non ajouté: " . htmlspecialchars($stmt->error));
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
cliquer <a href="modp.html"> ici</a> pour modifier les coordonnées <br>
cliquer <a href="menu1.html"> ici</a> pour revenir au menu
