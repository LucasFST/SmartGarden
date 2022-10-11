<?php 
$noms=récupNom($connexion);  //récupération des nom des plantes qui ont des photos
if(isset($_POST['SélectionPlante'])) //si le formulaire de sélection du  nom de la plante est soumis
	{
		$idPl=$_POST['nomPlante'];   //récupération de l'identifiant de la plante sélectionnée
		$urls=récupURL($connexion, $idPl);  //récupération de tous les liens des photos de la plante sélectionnée
	}
if(isset($_POST['SélectionPhoto']))  //si le formulaire de suppression de la photo est soumis
{
	$lien = $_POST['Photo'];  //récupération du lien de la photo à supprimer
	if(unlink($lien))   //teste si la suppression de la photo a été un succès
	{
		$message = "<p class='success'>La photo a bien été supprimée ! </p>";   //si c'est un succès on affichera le code de réussite 
		suppURL($connexion, $_POST['Photo']);  //Supprimer l'instance de la classe Photo comportant le lien de la photo que l'on a supprimée
		unset($_POST['SélectionPlante']);  //On 'vide' la variable $_POST['SélectionPlante'] pour dire que le premier formulaire n'est pas soumis et ainsi ne pas afficher le deuxième (celui de sélection de la photo)
		$noms=récupNom($connexion);  //On re-récupére les noms des plnates qui ont des photos afin d'éventuellement mettre à jour la liste suite à la suppression;
	}
	else
	{
		$message = "<p class='error'>La photo est introuvable ! La suppression n'a pas pu être effectuée... </p>";  //si la suppression n'a pas pu être effectuée on affichera le code erreur
	}
}
?>