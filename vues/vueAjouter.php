<h2>Ajout d'une variété :</h2>

<?php 
	$datecourante=date('Y-m-d'); //récupération de la date courante 
	$annéecourante=date("Y");  //récupération de l'année courante
?> 

<form method="post" action="#">
	
	<label for="nomVariété">Nom de la variété : </label>
	<input type="text" name="nomVariété" id="nomVariété" placeholder="Nouvelle Variété" required /> <span>*</span><br/>
	
	<label for="nomPlante">Nom de la plante : </label>
	<select name="nomPlante" id="nomPlante" required>
		<?php 
			foreach($plantes as $plante)	//boucle foreach pour lister toutes les plantes une à une
			{
				if(isset($_POST['ValiderAjout'])&&$_POST['nomPlante']==$plante[0])  //pour garder la même plante sélectionnée après soumission du formulaire que celle sélectionnée lors de la soumission
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
	</select> <span>*</span><br/>
	
	<label for="semencier">Nom du semencier : </label>
	<select name="semencier" id="semencier"> 
		<option value=NDef>-Non Défini-</option> 					
		<?php 
			foreach($semenciers as $semencier)	//boucle foreach pour lister tous les semenciers un à un
			{
				echo "<option value=$semencier[0]>$semencier[1]</option>";
			}
		?>
	</select> <br/>
	
	<label for="version">Version de la variété : </label>
	<select name="version" id="version">
		<option value=NDef>-Non Défini-</option>
		<?php 
			foreach($versions as $version)	//boucle foreach pour lister toutes les versions une à une
			{
				echo "<option value=$version[0]>$version[1]</option>";
			}
		?>
	</select> <br/>
	
	<label for="typeSol">Types de sols adaptés : </label>
	<select name="typeSol[]" id="typeSol" multiple>
		<?php 
			foreach($typesSol as $typeSol)	//boucle foreach pour lister tous les types de sol un à un
			{
				echo "<option value=$typeSol[0]>$typeSol[1]</option>";
			}
		?>
	</select> <br/>
	
	<label for="année">Année de mise sur la marché : </label>
	<input type="number" name="année" id="année" min="1800" max="2100" placeholder=<?php echo "$annéecourante" ?>  value=<?php echo "$annéecourante" ?> /> <br/>
	
	<label for="MEP">Période de mise en place : </label>
	De  <input type="date" name="debMEP" id="MEP" value=<?php echo "$datecourante" ?> /> À <input type="date" name="finMEP" id="MEP" min="$_POST['debMEP']" value=<?php echo "$datecourante" ?> /> <br/>
	
	<label for="Rec">Période de récolte : </label>
	De <input type="date" name="debRec" id="debRec" value=<?php echo "$datecourante" ?> /> À <input type="date" name="finRec" id="Rec" min="$_POST['debRec']" value=<?php echo "$datecourante" ?> /> <br/> 
	
	<label for="nbjours" id="nbjours">Nombre de jours de levée : </label>
	<input type="number" name="nbjours"id="nbjours" min="1" placeholder="30" value="30"/> <br/> 
	
	<label for="précocité">Commentaire précocité : </label> 
	<textarea name="précocité" id="précocité" maxlength="50" rows=1 cols=50 placeholder="Exemples : précoce, tardive"></textarea> <br/>
	
	<label for="semis">Commentaire semis : </label> 
	<textarea name="semis" id="semis" maxlength="50" rows=1 cols=50 placeholder="Exemple : en ligne, en poquets"></textarea> <br/>
	
	<label for="plantation">Commentaire plantation : </label> 
	<textarea name="plantation" id="plantation" maxlength="50" rows=1 cols=50 placeholder="Exemple : planter à 20cm sous le sol"></textarea> <br/>
	
	<label for="entretien">Commentaire entretien : </label> 
	<textarea name="entretien" id="entretien" maxlength="50" rows=1 cols=50 placeholder="Exemple : arroser deux fois par jour"></textarea> <br/>
	
	<label for="général">Commentaire général : </label> 
	<textarea name="général" id="général" maxlength="100" rows=1 cols=50 placeholder="Autre(s) caractéristique(s)"></textarea> <br/>
	
	<br/><br/>
	<input type="submit" name="ValiderAjout" value="Ajouter"/>
	
</form>
<br/>

<span><p class="légende">* : champs obligatoires</p></span>

<br/>


<?php 
if(isset($_POST['ValiderAjout'])) 
{
	echo $message;//affichage du code réussite ou erreur
}
?>  

<br/>

