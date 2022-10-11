<?php

//FAUSTMANN Lucas
//numéro étudiant : 12020351

	session_start(); // démarre ou reprend une session
    ini_set('display_errors', 1); // affiche les erreurs (au cas où)
    ini_set('display_startup_errors', 1); // affiche les erreurs (au cas où)
    error_reporting(E_ALL); // affiche les erreurs (au cas où)
    require('inc/config-bd.php'); //inclut le fichier config-bd
    require('inc/routes.php');  //inclut le fichier routes
    require('modele/modele.php'); // inclut le fichier modele

    $connexion = getConnexionBD();
    
    
/* 

Intégration des données :

$infosPlantes=getInfoPlantes($connexion);
insertInfoPlantes($connexion, $infosPlantes);
$infosVarietes=getInfoVarietes($connexion);
insertInfoVarietes($connexion, $infosVarietes);

*/
    

            

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Smart Garden</title>
    <!-- lie le style CSS externe  -->
    <link href="css/style.css" rel="stylesheet" media="all" type="text/css">
    <!-- ajoute une image favicon (dans l'onglet du navigateur) -->
    <link rel="shortcut icon" href='img/Smart Garden-4.png' />

<body>
    <?php include('static/header.php'); ?>
    <div id="divCentral">
        <?php include('static/menu.php'); ?>
        <main>
            <?php
            $controleur = 'controleurAccueil'; // par défaut, on charge accueil.php
            $vue = 'vueAccueil'; // par défaut, on charge accueil.php
            if(isset($_GET['page'])) 
            {
                $nomPage = $_GET['page'];
                if(isset($routes[$nomPage])) // si la page existe dans le tableau des routes, on la charge
                { 
                    $controleur = $routes[$nomPage]['controleur'];
                    $vue = $routes[$nomPage]['vue'];
                }
            }
        include('controleurs/' . $controleur . '.php');
        include('vues/' . $vue . '.php'); 
        ?>
        </main>
    </div>
    <?php include('static/footer.php'); ?>
</body>

</html>