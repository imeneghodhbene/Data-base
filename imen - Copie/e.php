<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier les Coordonnées d'Étudiant</title>
</head>
<body>
    <h1>Modifier les Coordonnées d'Étudiant</h1>

    <?php
    // Etablir la connexion à la base de données
    $conn = new mysqli("localhost", "root", "", "inscription2");

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion a échoué: " . $conn->connect_error);
    }

    // Vérifier si l'ID de l'étudiant à modifier est défini
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Récupérer les anciennes coordonnées de l'étudiant
        $stmt = $conn->prepare("SELECT idetud, nometud, prenometud FROM etudiant WHERE idetud = ?");
        if ($stmt === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($idetud, $nometud, $prenometud);
        $stmt->fetch();
        $stmt->close();
    } else {
        echo "ID de l'étudiant non spécifié.";
        $conn->close();
        exit();
    }

    // Si le formulaire est soumis pour mettre à jour les coordonnées
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_nometud = htmlspecialchars($_POST["nometud"]);
        $new_prenometud = htmlspecialchars($_POST["prenometud"]);

        // Mettre à jour les coordonnées de l'étudiant dans la base de données
        $update_stmt = $conn->prepare("UPDATE etudiant SET nometud = ?, prenometud = ? WHERE idetud = ?");
        if ($update_stmt === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }
        $update_stmt->bind_param("sss", $new_nometud, $new_prenometud, $id);
        
        if ($update_stmt->execute()) {
            echo "<p>Coordonnées mises à jour avec succès pour l'étudiant ID: $id</p>";
        } else {
            echo "<p>Erreur lors de la mise à jour des coordonnées: " . htmlspecialchars($update_stmt->error) . "</p>";
        }

        $update_stmt->close();
    }

    // Afficher le formulaire avec les anciennes coordonnées de l'étudiant
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=$id"; ?>" method="post">
        <label for="nometud">Nom :</label>
        <input type="text" id="nometud" name="nometud" value="<?php echo htmlspecialchars($nometud); ?>"><br><br>
        <label for="prenometud">Prénom :</label>
        <input type="text" id="prenometud" name="prenometud" value="<?php echo htmlspecialchars($prenometud); ?>"><br><br>
        <input type="submit" value="Modifier">
    </form>

    <br>
    <a href="menu1.html">Revenir au menu</a>

    <?php
    // Fermer la connexion à la base de données
    $conn->close();
    ?>
</body>
</html>
