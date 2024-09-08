<?php
if (isset($_POST["id"]) && isset($_POST["nom"]) && isset($_POST["prenom"])) {
    $id = htmlspecialchars($_POST["id"]);
    $nom = htmlspecialchars($_POST["nom"]);
    $prenom = htmlspecialchars($_POST["prenom"]);

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
        // Student with this ID already exists
        echo '<script>alert("Étudiant avec cet ID existe déjà.");</script>';
    } else {
        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO etudiant (id, nom, prenom) VALUES (?, ?, ?)");
        if ($stmt === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }

        // Bind parameters
        $stmt->bind_param("sss", $id, $nom, $prenom);

        // Execute the statement
        if ($stmt->execute()) {
            // JavaScript alert on success
            echo '<script>alert("Étudiant ajouté avec succès!");</script>';
        } else {
            echo "Échec lors de l'ajout de l'étudiant : " . htmlspecialchars($stmt->error);
        }

        // Close the statement
        $stmt->close();
    }

    // Close the connection
    $checkId->close();
    $conn->close();
} else {
    echo "Les champs requis sont manquants.";
}
?>
<br>
cliquer <a href="modif.html"> ici</a> pour modifier les coordonnées <br>
cliquer <a href="menu1.html"> ici</a> pour revenir au menu
