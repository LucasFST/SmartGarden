<h2>Générer et Afficher une parcelle : </h2>

<form method="post" action="#">	

	<label for="nbRang">Nombre de rangs : </label>
	Min : <input type="number" min="1" name="rangMin" id="nbRang" required placeholder="1" value="1"/> Max : <input type="number" min="1" name="rangMax" id="nbRang" required placeholder="20" value="20"/> <br/>
	
	<label for="pourcentageCulture">Rangs occupés par des cultures (%) : </label>
	<input type="number" name="pourcentageCulture" id="pourcentageCulture" step="0.1" min="0" max="100" required placeholder="50" value="50"/> <br/>
	
	<label for="pourcentageSauvage">Rangs occupés par des plantes indésirables (%) : </label>
	<input type="number" name="pourcentageSauvage" id="pourcentageSauvage" step="0.1" min="0" max="100" required placeholder="50" value="50"/> <br/>
	
	<br/><br/>
	<input type="submit" name="ValiderParcelle" value="Générer et Afficher"/>

</form>

<?php 

echo "<br/>";

if(isset($_POST['ValiderParcelle'])&&$Affichage) //si le formulaire a été soumis et que $Affichage est true (c-à-d si les données du formulaires ont été vérifiées et validées)
{
	echo $message;
	echo "<h2>Affichage de la parcelle générée :</h2>";
	echo "<div class='affichageParcelle'><table class='tableauParcelle'><tr><th> Rang </th><th> Plante </th><th> Variété </th><th> Type de Plante </th></tr>";
	foreach($DonnéesRangsCultivés as $DonnéesRangCultivé)	//boucle foreach pour afficher un à un les rangs cultivés
	{
		echo "<tr><td>$DonnéesRangCultivé[5]</td><td>$DonnéesRangCultivé[1]</td><td>$DonnéesRangCultivé[3]</td><td>$DonnéesRangCultivé[2]</td></tr>";
	}
		foreach($DonnéesRangsSauvages as $DonnéesRangSauvage)	//boucle foreach pour afficher un à un les rangs sauvages
	{
		echo "<tr><td>$DonnéesRangSauvage[1]</td><td>$DonnéesRangSauvage[3]</td><td>Non défini</td><td>$DonnéesRangSauvage[4]</td></tr>";
	}
		foreach($DonnéesRangsLibres as $DonnéeRangsLibre)	//boucle foreach pour afficher un à un les rangs libres
	{
		echo "<tr><td>$DonnéeRangsLibre[1]</td><td> - </td><td> - </td><td> - </td></tr>";
	}
	echo"</table></div>";

}

?>
