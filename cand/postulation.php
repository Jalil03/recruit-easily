<?php
    include('database.php');
    include('util.php');
    init_php_session();

    // Vérifier si la clé 'id' est définie dans la session
    if(isset($_SESSION['id']) && isset($_GET['id'])) {
        // Préparer et exécuter la requête d'insertion
        $rq = $PDO->prepare('INSERT INTO postule (id_candidat, id_offre) VALUES (?, ?)');
        $rq->execute(array($_SESSION['id'], $_GET['id']));
    } else {
        // Gérer le cas où 'id' ou 'id_offre' est manquant
        echo "Une erreur est survenue. Veuillez vérifier les paramètres.";
    }

    // Redirection vers la page Offers.php
    header('location:Offers.php');
    exit(); // Terminer le script après la redirection
?>
