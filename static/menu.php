<!-- menu -->
<nav>
	<h1>Menu :</h1>
	<ul>
		<li><a href="index.php">Accueil</a></li>
		<li><a href="index.php?page=afficher">Afficher les variétés / les plantes / les types de plantes</a></li>
		<li><a href="index.php?page=ajouter">Ajouter une variété</a></li>
		<li><a href="index.php?page=parcelle">Généner / Afficher une parcelle</a></li>
		<li><a href="index.php?page=ajouterPhoto">Ajouter la photo d'une plante</a></li>
		<li><a href="index.php?page=afficherPhoto">Afficher l'album photos d'une plante</a></li>
		<li><a href="index.php?page=supprimerPhoto">Supprimer la photo d'une plante</a></li>
	</ul>
	
	<div class="stat">
		<h1>Statistiques :</h1>
		<ul>
		<li>
			<?php
				$nb = countInstances($connexion, "Plante");  //récupération du nb d'instances de la table plante
				if($nb <= 0)
					$statPlante = "Aucune plante n'a été trouvée dans la base de données ! Ajoutez-en !";
				else
					$statPlante = "Actuellement $nb plantes dans la base.";
			?>
			<p><?= $statPlante ?></p>
		</li>
		<li>
			<?php
				$nb = countInstances($connexion, "Variété");  //récupération du nb d'instances de la table variété
				if($nb <= 0)
					$statVariété = "Aucune variété n'a été trouvée dans la base de données ! Ajoutez-en !";
				else
					$statVariété = "Actuellement $nb variétés dans la base.";
			?>
			<p><?= $statVariété ?></p>
		</li>
		<li>
			<?php
				$nb = countTypes($connexion, "Plante");  //récupération du nb de types de plantes
				if($nb <= 0)
					$statType = "Aucune type de plante n'a été trouvée dans la base de données ! Ajoutez-en !";
				else
					$statType = "Actuellement $nb types de plantes dans la base.";
			?>
			<p><?= $statType ?></p>
		</li>
		<li>
			<?php
				echo "<p> Top 3 des plantes avec le plus de variétés : </p>";
				$tab=getTOP3Variété($connexion);  //récupération du top3 des plantes avec le plus de variétés
				echo "<ol>";
				foreach ($tab as $plante) 
				{
					echo "<li> $plante[0] : $plante[1] variétés différentes ";
				}
				echo "</ol>";
			?>
		</li>
		<li>
			<?php
				echo "<p> Top 3 des parcelles avec le plus de rangs : </p>";
				$tab=getTOP3Parcelle($connexion);  //récupération du top3 des parcelles avec le plus de rangs
				echo "<ol>";
				foreach ($tab as $parcelle) 
				{
					echo "<li> Parcelle $parcelle[0] : $parcelle[1] rangs ";
				}
				echo "</ol>";
			?>
		</li>
	</ul>
	</div>
</nav>

