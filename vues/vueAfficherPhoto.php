<h2> Afficher l'album photos d'une plante :</h2>
 <form method="post" action="#">
    <label for="nomPlante">Nom de la plante : </label>
	<select name="nomPlante" id="nomPlante" required>
		<?php 
			foreach($plantes as $plante)  //boucle foreach pour lister toutes les plantes
			{
				if(isset($_POST['AfficherPhoto'])&&$_POST['nomPlante']==$plante[0])  //pour garder la même plante sélectionnée après soumission du formulaire que celle sélectionnée lors de la soumission
				{
					if(isset($plante[2])) 	//si le nom latin de la plante est défini
					{
						echo "<option value=$plante[0] selected>$plante[1] (nom latin : $plante[2])</option>";  //on affiche le nom latin pour lever l'éventuelle ambiguité car certaines plantes ont le même nom mais un nom latin !=
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
	</select> <br/> <br/>
	<input type="submit" name="AfficherPhoto" value="Afficher">
</form>


<?php 
	if(isset($_POST['AfficherPhoto']))  //si le formulaire a été soumis
	{
		if(!empty($tabURL))	//si la plante sélectionnée possède bien des photos
		{
			echo "<div class='slider-scroll'>";
			$i=1;
			foreach($tabURL as $photo)	//boucle foreach pour lister toutes les photos une à une
			{
				echo "<img id='slide-scroll$i' src=$photo[0] alt>";
				$i++;
			}
			echo "</div>";
			echo "<ul class='ancre'>";
			$i=1;
			foreach($tabURL as $photo)	//boucle foreach pour définir une ancre pour chaque photo
			{
				echo "<li><a href='#slide-scroll$i'>$i</a></li>";
				$i++;
			}
			echo "</ul>";
		}
		else  	//la plante sélectionnée ne possède pas de photo -> affichage du code erreur
		{
			echo "<p class='error'>L'album photo de cette plante est vide ! Ajoutez une photo de cette plante ! </p>";
		}
	}
?>



