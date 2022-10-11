<?php 

if(isset($_POST['ValiderParcelle'])) //si le formulaire de génération de parcelle est soumis
{
	if(vérifGénérerParcelle($connexion)==true)  //si la vérification des données saisies et envoyées par le formulaire est ok (si c'est  pas le cas alors il y a un affichage des erreurs pour les corriger)
	{
		if($_POST['rangMin']==$_POST['rangMax'])  //si le rang min saisi est identique au rang max saisi
		{
			$nbRangs=$_POST['rangMin'];  //le nombre de rangs total à générer est dinc fixe et est égal au deux
		}
		else
		{
			$nbRangs=rand($_POST['rangMin'], $_POST['rangMax']);  //sinon le nombre de rang total à générer est choisi aléatoirement entre le rang min saisi et le rang max saisi
		}
		$nbRangsCulture=floor($_POST['pourcentageCulture']*$nbRangs/100);  //on détermine le nb de rangs cultivés et on l'arrondit à l'entier inférieur avec la fonction floor
		$nbRangsSauvage=floor($_POST['pourcentageSauvage']*$nbRangs/100);	//on détermine le nb de rangs sauvages et on l'arrondit à l'entier inférieur
		$nbRangsLibre=$nbRangs-($nbRangsSauvage+$nbRangsCulture);  //on détermine le nb de rangs libres 
		générerParcelle($connexion);   //on génére une nouvelle parcelle
		$idPa=recupidPa($connexion);  //on récupère son identifiant
		for($i=1;$i<=$nbRangs;$i++)   //boucle for pour générer les rangs de la nouvelle parcelle
		{
			générerRang($connexion, $idPa, $i);  //on générer les rangs  
		}
		for($i=1;$i<=$nbRangsCulture;$i++)  //boucle for pour remplir la table cultiver, c-à-d "créer" les rangs cultivés
		{
			remplirCultiver($connexion, $idPa, $i);
		}
		for($i=$nbRangsCulture+1;$i<=($nbRangsCulture+$nbRangsSauvage);$i++)   //boucle for pour remplir la table couvrir c-à-d "créer" les rangs sauvages
		{
			remplirCouvrir($connexion, $idPa, $i);
		}
		//a noter que pour les rangs libres on n'a rien à faire à part les générer (ce qui est fait dans la première boucle for)

		$message= "<div class='success'>
				La parcelle a bien été générée ! <br/> 
				Elle est composé d'un total de $nbRangs rangs : 
				<ul> 
					<li>$nbRangsCulture rangs occupés par des cultures </li>
					<li>$nbRangsSauvage rangs occupés par des plantes indésirables</li>
					<li>$nbRangsLibre rangs libres (sans végétation)</li>
				</ul>
				</div>";
		//message pour l'affichage du code de réussite de la génération de la parcelle avec ses détails
		$Affichage=true;  //on met la variable $Affichage à true pour dire que l'on peut afficher la parcelle
		$DonnéesRangsCultivés=récupDonnéesRangCultivé($connexion, $idPa);	//récupération des données nécessaires à l'affichage des rangs cultivés
		$DonnéesRangsSauvages=récupDonnéesRangSauvage($connexion, $idPa);	//récupération des données nécessaires à l'affichage des rangs sauvages
		$DonnéesRangsLibres=récupDonnéesRangLibre($connexion, $idPa, $nbRangsSauvage, $nbRangsCulture);	//récupération des données nécessaires à l'affichage des rangs libres
	}
	else
	{
		$Affichage=false;	//on met la variable $Affichage à false pour dire qu'il ne faut pas faire l'affichage de la parcelle car la vérifiaction n'est pas ok
	}
	
}
?>
