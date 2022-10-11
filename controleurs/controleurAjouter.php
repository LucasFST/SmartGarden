<?php 

$plantes=getPlante($connexion, "Plante");   //récupération de toutes les plantes
$semenciers=getSemencier($connexion, "Semencier");	//récupération de tous les semenciers
$typesSol=getTypeSol($connexion, "Sol");	//récupération de tous les ypes de sol
$versions=getVersion($connexion, "Version");	//récupération de toutes les versions


if(isset($_POST['ValiderAjout'])) // si le formulaire d'ajout est soumis
{ 
	if(vérifAjout($connexion)==true)   //si la vérification de toutes les données saisies et transmises par le formulaire est ok (si il y a des erreurs de saisies, incohérences... alors il y a un affichage des erreurs pour les corriger)
	{
		$nomVariété = mysqli_real_escape_string($connexion, $_POST['nomVariété']); // recuperation de la valeur saisie, que l'on échappe avec msqli pour plus de séurité
		$verification = getVariétéByName($connexion, $nomVariété);   //vérification qu'il n'exite pas déjà une variété avec le même nom
		if($verification == FALSE || count($verification) == 0) // pas de variété avec ce nom, insertion
		{ 
			$insertion1=ajoutVariété($connexion, $nomVariété);   //insertion des infos concernant la table variété
			$idVa=recupidVa($connexion);	//récupération de l'identifiant de la variété concernée
			$insertion2=ajoutProduire($connexion, $idVa);	//insertion des infos concernant la table produire
			$insertion3=ajoutAdapter($connexion,$idVa);	//insertion des infos concernant la table adapter
			$insertion4=ajoutPériodeMEP($connexion,$idVa);	//insertion des infos concernant la table PériodeMEP
			$insertion5=ajoutPériodeR($connexion,$idVa);	//insertion des infos concernant la table PériodeR
			$message = "<p class='success'>La variété $nomVariété a bien été ajoutée !</p>";  //code de réussite pour dire que la variété a bien été ajoutée 
		}
		else 
		{
			$message = "<p class='error'>Une variété existe déjà avec ce nom ($nomVariété) </p>";  //code d'erreur si une variété du même nom existe déjà
		}
	}
	else
	{
		$message=""; //le message est vide car l'un des champs du formulaire a été rempli avec une valeur erronée
	}
}
?>
