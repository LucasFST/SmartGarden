<?php 
	$plantes=getPlante($connexion, "Plante");  // récupérer toutes les plantes

	if(isset($_POST['AfficherPhoto']))  //si le formulaire d'affichage est soumis
	{
		$idPl=$_POST['nomPlante'];  //récupération de l'identifiant de la plante sélectionnée
		$tabURL=récupURL($connexion, $idPl);  //récupération des liens vers les photos concernant la plante passée en paramètre
	}
	
?>

