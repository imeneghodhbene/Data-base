<?php
// Établir la connexion à la base de données en utilisant MySQLi
$conn = new mysqli("localhost", "root", "", "inscription2");

// Vérifier si la connexion a réussi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Préparer la requête SQL pour compter le nombre total d'étudiants
$sql = "SELECT COUNT(*) AS total_students FROM etudiant";
$result = $conn->query($sql);

if ($result) {
    // Récupérer le résultat de la requête
    $row = $result->fetch_assoc();
    $totalStudents = $row['total_students'];

    // Retourner le résultat en format JSON
    echo json_encode(array('total_students' => $totalStudents));
} else {
    // Retourner une erreur en format JSON
    echo json_encode(array('error' => 'Erreur lors de l\'exécution de la requête : ' . htmlspecialchars($conn->error)));
}

// Fermer la connexion à la base de données
$conn->close();
?>
