<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nombre Total de Classes</title>
</head>
<body>
    <h1>Nombre Total de Classes</h1>
    <form action="" method="post">
        <input type="submit" name="calculate" value="Calculer">
    </form>

    <?php
    if (isset($_POST['calculate'])) {
        // Etablir la connexion à la base de données
        $conn = new mysqli("localhost", "root", "", "inscription2");

        // Vérifier la connexion
        if ($conn->connect_error) {
            die("La connexion a échoué: " . $conn->connect_error);
        }

        // Fonction pour compter le nombre de classes
        function countClasses($conn) {
            $result = $conn->query("SELECT COUNT(*) AS count FROM classe"); // Remplacez 'classes' par le nom réel de votre table
            if ($result) {
                $row = $result->fetch_assoc();
                return $row['count'];
            } else {
                return 0;
            }
        }

        // Afficher le nombre total de classes
        $totalClasses = countClasses($conn);
        echo "<p>Nombre total de classes: $totalClasses</p>";

        // Fermer la connexion
        $conn->close();
    }
    ?>

    <br>
    <a href="modcl.html">Modifier les classes</a><br>
    <a href="menu1.html">Revenir au menu</a>
    <?php
    if (isset($_POST['calculate'])) {
        // Etablir la connexion à la base de données
        $conn = new mysqli("localhost", "root", "", "inscription2");

        // Vérifier la connexion
        if ($conn->connect_error) {
            die("La connexion a échoué: " . $conn->connect_error);
        }

        // Fonction pour compter le nombre de matières
        function countSubjects($conn) {
            $result = $conn->query("SELECT COUNT(*) AS count FROM matiere"); // Remplacez 'matiere' par le nom réel de votre table
            if ($result) {
                $row = $result->fetch_assoc();
                return $row['count'];
            } else {
                return 0;
            }
        }

        // Afficher le nombre total de matières
        $totalSubjects = countSubjects($conn);
        echo "<p>Nombre total de matières: $totalSubjects</p>";

        // Fermer la connexion
        $conn->close();
    }
    ?>

    <br>
    <a href="modmat.html">Modifier les matières</a><br>
    <a href="menu1.html">Revenir au menu</a>
</body>
</html>
