<?php 


include('database.php');

if(isset($_POST['submitiha'])){
    if(isset($_POST['competence'])){
        $competenceJSON = $_POST['competence'];
        $competence = json_decode($competenceJSON, true);

        // Generate placeholders for the IN clause
        $placeholders = rtrim(str_repeat('?, ', count($competence)), ', ');
        
        $sql = "SELECT DISTINCT c.id_candidat, c.nom, c.prenom
                FROM candidat c
                JOIN comp_candidat cc ON c.id_candidat = cc.id_candidat
                JOIN competences comp ON cc.id_comp = comp.id_comp
                WHERE comp.nom_comp IN ($placeholders)
                ORDER BY c.id_candidat DESC";

        $stmt = $PDO->prepare($sql);
        
        // Bind each value separately
        $i = 1;
        foreach($competence as $comp){
            $stmt->bindValue($i++, $comp);
        }
        
        // Exécution de la requête  
        $stmt->execute();
        
        if($stmt->rowCount() > 0){
            // Afficher les résultats
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo $row['nom']."&nbsp;&nbsp;".$row['prenom']."<br/>";
            }
        } else {
            echo "Aucun candidat trouvé pour les compétences sélectionnées.";
        }
        
    } else {
        echo "Le champ de formulaire competence n'existe pas dans la requête POST.";
    }
} else {
    echo "Le formulaire n'a pas été soumis.";
}



?>