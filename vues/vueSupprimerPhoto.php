<h2>Supprimer une photo d'une plante :</h2>

<?php 

if(empty($noms))	//si il n'y a aucune photo de stocker, c-à-d qu'aucune plante n'a de photo
{
	echo "<p class=error>Suppression impossible : il n'y a actuellement aucune photo dans la base de données</p>";
}
else 	//il y a au moins une plante qui a une photo donc on affiche le premier formulaire
{
	echo"<form method='post' action='#'>";
	echo"<label for='nomPlante'>Nom de la plante : </label>";
	echo"<select name='nomPlante' id='nomPlante' required>";
	foreach($noms as $nom)	//boucle foreach pour lister les plantes qui ont au moins une photo une par une
	{
		if(isset($_POST['SélectionPlante'])&&$nom[0]==$_POST['nomPlante'])	//pour garder la même plante sélectionnée après la soumission du premier formulaire que celle sélectionnée lors de sa soumission 
		{
			if(isset($nom[2]))	//si le nom latin de la plante est défini
			{
				echo "<option value=$nom[0] selected>$nom[1] (nom latin : $nom[2])</option>";	//on affiche le nom latin pour lever l'éventuelle ambiguité car certaines plantes ont le même nom mais un nom latin !=
			}
			else
			{
				echo "<option value=$nom[0] selected>$nom[1]</option>";
			}
		}
		else
		{
			if(isset($nom[2]))	//si le nom latin de la plante est défini
			{
				echo "<option value=$nom[0]>$nom[1] (nom latin : $nom[2])</option>";	//on affiche le nom latin pour lever l'éventuelle ambiguité car certaines plantes ont le même nom mais un nom latin !=
			}
			else
			{
				echo "<option value=$nom[0]>$nom[1]</option>";
			}
		}
	}
	echo "</select> <br/><br/>";
	echo "<input type='submit' name='SélectionPlante' value='Sélectionnez'/>";
	echo "</form>";
}

if(isset($_POST['SélectionPlante']))  //si le premier formulaire a été soumis, alors on peut afficher le deuxième formulaire, celui ppur sélectionner la photo à supprimer
{
	echo "<form method='post' action='#''>";
	echo "<label for='Photo'>Sélectionnez la photo à supprimer : </label>";
	echo "<select name='Photo' id='Photo' required>";
	$i=1;
	foreach($urls as $url)	//boucle foreach pour lister les photos de la plante sélectionnée une par une
	{
		echo "<option value=$url[0]>photo $i</option>";
		$i++;
	}
	echo "</select> <br/> <br/>";
	echo "<input type='submit' name='SélectionPhoto' value='Supprimer'/>";
	echo "</form>";
}

if(isset($_POST['SélectionPhoto']))  //si le formulaire de suppression de la photo est soumis
{
	echo $message; //affichage du code réussite ou erreur
}

?>