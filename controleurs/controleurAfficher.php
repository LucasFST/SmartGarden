<?php 
if(isset($_POST['ValiderAffichage']))  //si le formulaire est soumis
{
	$donnéesAffich=$_POST['Type'];  //récupération du type de données à afficher

// recupération des variétés
	if($donnéesAffich=='Variété')
	{
		$varietes = getInstances($connexion, "Variété");
		if($varietes == null || count($varietes) == 0)   //teste s'il existe au moins une variété
		{
			$message = "<p class='error'> Aucune variété n'a été trouvée dans la base de données ! </p>";
		}
	}

// récupération des plantes
	if($donnéesAffich=='Plante')
	{
		$plantes = getInstances($connexion, "Plante");
		if($plantes == null || count($plantes) == 0) 	//teste s'il existe au moins une plante
		{
			$message = "<p class='error'> Aucune plante n'a été trouvée dans la base de données ! </p>";
		}
	}

//récupération des types de plantes (et éventuellement sous types)
	if($donnéesAffich=='TypePlante')
	{
		$types = getTypes($connexion, "Plante");
		$Soustypes = getSousTypes($connexion, "Plante");
		if($types == null || count($types) == 0) 	//teste s'il existe au moins un type de plantes
		{
			$message = "<p class='error'> Aucun type de plantes n'a été trouvé dans la base de données ! </p>";
		}

	}
}


?>
