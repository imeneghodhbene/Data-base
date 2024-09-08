<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcul des Statistiques</title>
</head>
<body>
    <h1>Calcul des Statistiques</h1>

    <!-- Formulaire pour calculer le nombre d'étudiants -->
    <h2>Nombre Total d'Étudiants</h2>
    <form action="" method="post">
        <input type="submit" name="calculate_students" value="Calculer">
    </form>

    <?php
    // Etablir la connexion à la base de données
    $conn = new mysqli("localhost", "root", "", "inscription2");

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion a échoué: " . $conn->connect_error);
    }

    // Fonction pour compter le nombre d'étudiants
    function countStudents($conn) {
        $result = $conn->query("SELECT COUNT(*) AS count FROM etudiant"); // Assurez-vous de remplacer 'etudiant' par le nom réel de votre table
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['count'];
        } else {
            return 0;
        }
    }

    // Si le bouton "Calculer" pour les étudiants est cliqué
    if (isset($_POST['calculate_students'])) {
        $totalStudents = countStudents($conn);
        echo "<p>Nombre total d'étudiants : $totalStudents</p>";
    }
    ?>

    <br>

    <!-- Formulaire pour calculer le nombre de professeurs -->
    <h2>Nombre Total de Professeurs</h2>
    <form action="" method="post">
        <input type="submit" name="calculate_professors" value="Calculer">
    </form>

    <?php
    // Fonction pour compter le nombre de professeurs
    function countProfessors($conn) {
        $result = $conn->query("SELECT COUNT(*) AS count FROM prof");
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['count'];
        } else {
            return 0;
        }
    }

    // Si le bouton "Calculer" pour les professeurs est cliqué
    if (isset($_POST['calculate_professors'])) {
        $totalProfessors = countProfessors($conn);
        echo "<p>Nombre total de professeurs : $totalProfessors</p>";
    }
    ?>

    <br>

    <!-- Formulaire pour calculer le nombre de classes -->
    <h2>Nombre Total de Classes</h2>
    <form action="" method="post">
        <input type="submit" name="calculate_classes" value="Calculer">
    </form>

    <?php
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

    // Si le bouton "Calculer" pour les classes est cliqué
    if (isset($_POST['calculate_classes'])) {
        $totalClasses = countClasses($conn);
        echo "<p>Nombre total de classes : $totalClasses</p>";
    }
    ?>

    <br>

    <!-- Formulaire pour calculer le nombre de matières -->
    <h2>Nombre Total de Matières</h2>
    <form action="" method="post">
        <input type="submit" name="calculate_subjects" value="Calculer">
    </form>

    <?php
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

    // Si le bouton "Calculer" pour les matières est cliqué
    if (isset($_POST['calculate_subjects'])) {
        $totalSubjects = countSubjects($conn);
        echo "<p>Nombre total de matières : $totalSubjects</p>";
    }

    // Fermer la connexion
    $conn->close();
    ?>

    <br>
    <a href="menu1.html">Revenir au menu</a>
</body>
</html>
