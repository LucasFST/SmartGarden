<h2> Ajouter la photo d'une plante :</h2>

<form method="post" action="#" enctype="multipart/form-data">
	<label for="nomPlante">Nom de la plante : </label>
	<select name="nomPlante" id="nomPlante" required>
		<?php 
			foreach($plantes as $plante)  //boucle foreach pour lister toutes les plantes une à une 
			{
				if(isset($_POST['AjouterPhoto'])&&$_POST['nomPlante']==$plante[0])  //pour garder la même plante sélectionnée après soumission du formulaire que celle sélectionnée lors de la soumission
				{
					if(isset($plante[2]))	//si le nom latin de la plante est défini
					{
						echo "<option value=$plante[0] selected>$plante[1] (nom latin : $plante[2])</option>";	//on affiche le nom latin pour lever l'éventuelle ambiguité car certaines plantes ont le même nom mais un nom latin !=
					}
					else
					{
						echo "<option value=$plante[0] selected>$plante[1]</option>";
					}
				}
				else
				{
					if(isset($plante[2]))	//si le nom latin de la plante est défini
					{
						echo "<option value=$plante[0]>$plante[1] (nom latin : $plante[2])</option>";	//on affiche le nom latin pour lever l'éventuelle ambiguité car certaines plantes ont le même nom mais un nom latin !=
					}
					else
					{
						echo "<option value=$plante[0]>$plante[1]</option>";
					}
				}
			}
		?>
	</select> <br/>
	<label for="photo">Importer photo : </label>
	<input type="file" id="photo" name="photo" accept=".png, .jpg, .jpeg, .gif, .bmp" required> 
	<br/> <br/> 
    <input type="submit" name="AjouterPhoto" value="Ajouter">
</form>

<br/> <br/>

<p class="légende">Les extensions de fichier acceptées sont ".png", ".jpg", ".jpeg", ".gif" et ".bmp" . <br/> Pour un affichage optimal, privilégiez les photos en format paysage !</p>
	
<br/>

<?php
	if(isset($_POST['AjouterPhoto'])) //si le formulaire d'ajout est soumis
	{
		//on affiche les messages qui sont définis
		if(isset($messageTaille)) echo $messageTaille;
        if(isset($messageUpload)) echo $messageUpload;
        if(isset($messageExtension)) echo $messageExtension;
        if(isset($messageError)) echo $messageError;
        if(isset($messageRéussite)) echo $messageRéussite;
        if(isset($messageErrorName)) echo $messageErrorName;
	}
?>
