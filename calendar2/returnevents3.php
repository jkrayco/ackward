<?php
           //connect to the database
           
           //query that retrieves all the events
            $json = array();
     // requête qui récupère les événements
     $requete = "SELECT * FROM event ORDER BY id";
     
     // connexion à la base de données
     try {
     $bdd = new PDO('mysql:host=localhost;dbname=ackward', 'root', 'root');
     } catch(Exception $e) {
     exit('Impossible de se connecter à la base de données.');
     }
     // exécution de la requête
     $resultat = $bdd->query($requete) or die(print_r($bdd->errorInfo()));
     
     // envoi du résultat au success
     echo json_encode($resultat->fetchAll(PDO::FETCH_ASSOC));

           

?>