<h2>Affichage des données : </h2>

<form method="post" action="#">
	<label for="type">Type de données à afficher : </label>
	<select name="Type" id="type" required>
		<?php
		if(isset($_POST['ValiderAffichage'])&&$_POST['Type']=="TypePlante")  //afin de garder le même champs sélectionné après la soumission du formulaire que celui sélectionné pour l'affichage (ici Types de Plantes)
		{
			echo "<option value='Plante'> Plantes </option>";
			echo "<option value='Variété'> Variétés </option>";
			echo "<option value='TypePlante' selected> Types de Plantes (et sous-types) </option>";
		}
		else
		{
			if(isset($_POST['ValiderAffichage'])&&$_POST['Type']=="Variété")  //afin de garder le même champs sélectionné après la soumission du formulaire que celui sélectionné pour l'affichage (ici Variétés)
			{
				echo "<option value='Plante'> Plantes </option>";
				echo "<option value='Variété' selected> Variétés </option>";
				echo "<option value='TypePlante'> Types de Plantes (et sous-types) </option>";
			}
			else  //sinon c'est Plantes qui est sélectionné par défaut (que ce soit parce qu'on a décidé d'afficher les plantes ou que le formulaire n'a pas encore été soumis une seule fois)
			{
				echo "<option value='Plante'> Plantes </option>";
				echo "<option value='Variété''> Variétés </option>";
				echo "<option value='TypePlante'> Types de Plantes (et sous-types) </option>";
			}
		}
		?>
	</select>
	<br/><br/>
	<input type="submit" name="ValiderAffichage" value="Afficher"/>
</form>
<br/>


<?php 

if(isset($_POST['ValiderAffichage']))  //si le formulaire est soumis 
{
	if(isset($message))
	{
		echo $message;
	}
	else
	{
		$donnéesAffich=$_POST['Type'];  //on récupère le type de données à afficher

		if($donnéesAffich=='TypePlante')  //si on veut afficher les types de plantes
		{
			foreach($types as $type) //boucle foreach pour afficher tout les types de plantes un par un
			{
				echo "<div class='tableau'><table><th>"."Type : ".$type['typeP']."</th>";
				foreach($Soustypes as $Soustype)	//boucle foreach pour afficher éventuellement tout les sous-types (un par un) du type courant
				{
					if($type['typeP']==$Soustype['typeP'])  //on affiche le sous-type ssi son type est le même que le type courant
					{
						echo( "<tr><td>".$Soustype['sous_typeP']."</td></tr>");
					}
				}
				echo "</table></div>";
			} 
		}
		elseif ($donnéesAffich=='Plante') //si on veut afficher les plantes
		{
			foreach($plantes as $plante)  //boucle foreach pour afficher toutes les plantes une à une
			{
				echo "<div class='tableau'><table><th>"."Espèce : ".$plante['nomP']."</th>";
				echo "<tr><td>"."Identifiant : ".$plante['idPl']."</td></tr>";
				if((isset($plante['nomL']))&&$plante['nomL']!="") echo "<tr><td>"."Nom en latin : ".$plante['nomL']."</td></tr>";  //on affiche le nom latin ssi celui-ci est défini et !=""
				if((isset($plante['catégorieP']))&&$plante['catégorieP']!="") echo "<tr><td>"."Catégorie : ".$plante['catégorieP']."</td></tr>";	//on affiche la catégorie ssi celle-ci est définie et !=""
				if((isset($plante['typeP']))&&$plante['typeP']!="") echo "<tr><td>"."Type : ".$plante['typeP']."</td></tr>";	//on affiche le type ssi celui-ci est défini et !=""
				if((isset($plante['sous_typeP']))&&$plante['sous_typeP']!="") echo "<tr><td>"."Sous-type : ".$plante['sous_typeP']."</td></tr>";	//on affiche le sous-type ssi celui-ci est défini et !=""
				echo "</table></div>";
			} 
		}
		elseif($donnéesAffich=='Variété')  //si on veut afficher les variétés
		{
			foreach($varietes as $variete) //boucle foreach pour afficher toutes les variétés une à une
			{
				echo "<div class='tableau'><table><th>"."Variété : ".$variete['nomV']."</th>";
				echo "<tr><td>"."Identifiant Variété : ".$variete['idVa']."</td></tr>";
				if(isset($variete['idPl'])) echo "<tr><td>"."Identifiant de la plante concernée : ".$variete['idPl']."</td></tr>";	//on affiche l'identifiant de la plante concernée ssi celui-ci est défini
				if(isset($variete['année'])) echo "<tr><td>"."Année de mise sur le marché : ".$variete['année']."</td></tr>";	//on affiche l'année de mise sur le marché ssi celle-ci est définie
				if((isset($variete['commentaire']))&&$variete['commentaire']!="") echo "<tr><td>"."Commentaire général : ".$variete['commentaire']."</td></tr>";	//on affiche le commentaire général ssi celui-ci est défini et !=""
				if((isset($variete['précocité']))&&$variete['précocité']!="") echo "<tr><td>"."Commentaire précocité : ".$variete['précocité']."</td></tr>";	//on affiche le commentaire précocité ssi celui-ci est défini et !=""
				if((isset($variete['semis']))&&$variete['semis']!="") echo "<tr><td>"."Commentaire semis : ".$variete['semis']."</td></tr>";	//on affiche le commentaire semis ssi celui-ci est défini et !=""
				if((isset($variete['plantation']))&&$variete['plantation']!="") echo "<tr><td>"."Commentaire plantation : ".$variete['plantation']."</td></tr>";	//on affiche le commentaire plantation ssi celui-ci est défini et !=""
				if((isset($variete['entretien']))&&$variete['entretien']!="") echo "<tr><td>"."Commentaire entretien : ".$variete['entretien']."</td></tr>";	//on affiche le commentaire entretien ssi celui-ci est défini et !=""
				if((isset($variete['récolte']))&&$variete['récolte']!="") echo "<tr><td>"."Commentaire récolte : ".$variete['récolte']."</td></tr>";	//on affiche le commentaire récolte ssi celui-ci est défini et !=""
				if(isset($variete['nbjourslevée'])) echo "<tr><td>"."Nombre de jours de levée : ".$variete['nbjourslevée']."</td></tr>";	//on affiche le nb jours de levée ssi celui-ci est défini
				echo "</table></div>";
			} 
		}
	}
}


?>
	