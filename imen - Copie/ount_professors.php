// Execute the statement
if ($stmt->execute()) {
    showAlert("Prof ajouté");

    // Count total number of professors
    $countProfessors = $conn->query("SELECT COUNT(*) AS total FROM prof")->fetch_assoc();
    if ($countProfessors && isset($countProfessors['total'])) {
        showAlert("Nombre total de professeurs : " . $countProfessors['total']);
    } else {
        showAlert("Erreur lors du calcul du nombre total de professeurs.");
    }
} else {
    showAlert("Prof non ajouté: " . htmlspecialchars($stmt->error));
}
