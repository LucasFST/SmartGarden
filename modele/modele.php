<?php 

// connexion à la BD, retourne un lien de connexion
function getConnexionBD() {
	$connexion = mysqli_connect(SERVEUR, UTILISATRICE, MOTDEPASSE, BDD);
	if (mysqli_connect_errno()) {
	    printf("Échec de la connexion : %s\n", mysqli_connect_error());
	    exit();
	}
	return $connexion;
}

// déconnexion de la BD
function deconnectBD($connexion) {
	mysqli_close($connexion);
}

// récupérer les données pour la table Plante
function getInfoPlantes($connexion) 
{
	$requete = "SELECT DISTINCT nomEspèce, nomEspèceLatin, type, sousType FROM dataset.DonneesFournies;";
	$res = mysqli_query($connexion, $requete);
	$infosPlantes=mysqli_fetch_all($res, MYSQLI_NUM);
	return $infosPlantes;
}

// insérer les données de la table Plante
function insertInfoPlantes($connexion, $infosPlantes)
{
	foreach ($infosPlantes as $infosPlante) 
	{
		$nomP=mysqli_real_escape_string($connexion, $infosPlante[0]);  
		$nomL=mysqli_real_escape_string($connexion, $infosPlante[1]);
		$typeP=mysqli_real_escape_string($connexion, $infosPlante[2]);
		$sous_typeP=mysqli_real_escape_string($connexion, $infosPlante[3]);
		$requete = "INSERT INTO Plante(nomP, nomL, typeP, sous_typeP)  VALUES ('$nomP', '$nomL', '$typeP', '$sous_typeP');";
		$res = mysqli_query($connexion, $requete);
	}
}

// récupérer les données pour la table Variété
function getInfoVarietes($connexion) 
{
	$requete = "SELECT codeVariété, commentaire, labelPrécocité, YEAR(STR_TO_DATE(annéeEnregistrement+',01,01','%Y,%c,%d')) as annéeEnregistrement, idPl  FROM dataset.DonneesFournies INNER JOIN Plante on (nomP=nomEspèce AND nomL=nomEspèceLatin);";  //je fait la jointure également sur le nom Latin car je considère que deux plantes ayant le même nom d'espèce mais pas le même nom latin sont deux plantes différentes (cf distinct dans getInfoPlantes)
	$res = mysqli_query($connexion, $requete);
	$infosVarietes=mysqli_fetch_all($res, MYSQLI_NUM);
	return $infosVarietes;
}


// insérer les données de la table Variété
function insertInfoVarietes($connexion, $infosVarietes)
{
	foreach ($infosVarietes as $infosVariete) 
	{
		$nom=mysqli_real_escape_string($connexion, $infosVariete[0]);
		$commentaire=mysqli_real_escape_string($connexion, $infosVariete[1]);
		$précocité=mysqli_real_escape_string($connexion, $infosVariete[2]);
		$requete = "INSERT INTO Variété(nomV, commentaire, précocité, année, idPl)  VALUES ('$nom', '$commentaire', '$précocité', $infosVariete[3], $infosVariete[4]);";
		$res = mysqli_query($connexion, $requete);
	}
}

// récupérer toutes les instances d'une table
function getInstances($connexion, $nomTable) 
{
	$requete = "SELECT * FROM $nomTable";
	$res = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $instances;
}

// récupérer les types de plantes dans l'ordre alphabétique
function getTypes($connexion, $table) 
{
	$requete = "SELECT DISTINCT typeP FROM $table ORDER BY typeP;";
	$res = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $instances;
}


// récupérer les sous-types dans l'ordre alphabétique (des types et après des sous-types)
function getSousTypes($connexion, $table) 
{
	$requete = "SELECT DISTINCT typeP, sous_typeP FROM $table ORDER BY typeP, sous_typeP;";
	$res = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $instances;
}


// récupérer le nombre d'instances d'une table $nomTable
function countInstances($connexion, $nomTable) {
	$requete = "SELECT COUNT(*) AS nb FROM $nomTable";
	$res = mysqli_query($connexion, $requete);
	if($res != FALSE) 
	{
		$row = mysqli_fetch_assoc($res);
		return $row['nb'];
	}
	return -1;  // valeur négative si erreur de requête (ex, $nomTable contient une valeur qui n'est pas une table)
}

// récupérer le nombre de types de plantes différents 
function countTypes($connexion, $nomTable) {
	$requete = "SELECT COUNT(DISTINCT typeP) AS nb FROM $nomTable";
	$res = mysqli_query($connexion, $requete);
	if($res != FALSE) {
		$row = mysqli_fetch_assoc($res);
		return $row['nb'];
	}
	return -1;  // valeur négative si erreur de requête (ex, $nomTable contient une valeur qui n'est pas une table)
}

//récupérer les 3 parcelles avec le plus de rangs
function getTOP3Parcelle($connexion)
{
	$req = "SELECT idPa, count(*) as nbrang FROM Rang GROUP BY idPa ORDER BY nbrang DESC LIMIT 3;";
	$res = mysqli_query($connexion, $req);
	return mysqli_fetch_all($res, MYSQLI_NUM);
}

//récupérer les 3 plantes avec le plus de variétés
function getTOP3Variété($connexion)
{
	$req = "SELECT nomP, count(*) as nbvariété FROM Variété NATURAL JOIN Plante GROUP BY idPl ORDER BY nbvariété DESC LIMIT 3;";
	$res = mysqli_query($connexion, $req);
	return mysqli_fetch_all($res, MYSQLI_NUM);
}

// récupérer les infos des plantes et trier le résultat dans l'ordre alphabétique des noms des plantes
function getPlante($connexion, $nomTable) 
{
	$requete = "SELECT * FROM $nomTable ORDER BY nomP;";
	$res = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_all($res, MYSQLI_NUM);
	return $instances;
}

// récupérer les infos des semenciers et trier le résultat dans l'ordre alphabétique des noms des semenciers
function getSemencier($connexion, $nomTable) 
{
	$requete = "SELECT * FROM $nomTable ORDER BY nomS;";
	$res = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_all($res, MYSQLI_NUM);
	return $instances;
}

// récupérer les infos des types de sol et trier le résultat dans l'ordre alphabétique des types
function getTypeSol($connexion, $nomTable) 
{
	$requete = "SELECT * FROM $nomTable ORDER BY typeS;";
	$res = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_all($res, MYSQLI_NUM);
	return $instances;
}

// récupérer les infos des versions et trier le résultat dans l'ordre alphabétique des types de version
function getVersion($connexion, $nomTable) 
{
	$requete = "SELECT * FROM $nomTable ORDER BY typeVe;";
	$res = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_all($res, MYSQLI_NUM);
	return $instances;
}

// récupérer toutes les infos des instances de la table variété où le nom de la variété est le même que celui passé en paramètre
function getVariétéByName($connexion, $nomVariété) 
{
	$nomVariété = mysqli_real_escape_string($connexion, $nomVariété); // au cas où $nomVariété provient d'un formulaire
	$requete = "SELECT * FROM Variété WHERE nomV = '". $nomVariété . "'";
	$res = mysqli_query($connexion, $requete);
	$varietes = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $varietes;
}


//Insérer Variété dans la base de données
function ajoutVariété($connexion, $nomVariété)
{
	$idPl=$_POST['nomPlante'];	//récupération de l'identifiant de la plante concernée
	$requete="INSERT INTO Variété(nomV,idPl) VALUES ('$nomVariété', $idPl);";  //insertion de la variété (seulement de son nom et de l'identifiant de la plante concernée)
	$res=mysqli_query($connexion,$requete);
	
	if(isset($_POST['général'])&&$_POST['général']!="")   //si le champs correspondant au commentaire général est défini et qu'il ne consiste pas qu'à une chaîne de caractères vide alors on l'insère (en faisant une update de notre tuple)
	{
		$général=mysqli_real_escape_string($connexion, $_POST['général']);
		$requete="UPDATE Variété SET commentaire='$général' WHERE nomV = '". $nomVariété . "'";
		$res=mysqli_query($connexion, $requete);
	}
	if(isset($_POST['précocité'])&&$_POST['précocité']!="")	//si le champs correspondant au commentaire précocité est défini et qu'il ne consiste pas qu'à une chaîne de caractères vide alors on l'insère (en faisant une update de notre tuple)
	{
		$précocité=mysqli_real_escape_string($connexion, $_POST['précocité']);
		$requete="UPDATE Variété SET précocité='$précocité' WHERE nomV = '". $nomVariété . "'";
		$res=mysqli_query($connexion, $requete);
	}
	if(isset($_POST['semis'])&&$_POST['semis']!="")	//si le champs correspondant au commentaire semis est défini et qu'il ne consiste pas qu'à une chaîne de caractères vide alors on l'insère (en faisant une update de notre tuple)
	{
		$semis=mysqli_real_escape_string($connexion, $_POST['semis']);
		$requete="UPDATE Variété SET semis='$semis' WHERE nomV = '". $nomVariété . "'";
		$res=mysqli_query($connexion, $requete);
	}
	if(isset($_POST['plantation'])&&$_POST['plantation']!="")	//si le champs correspondant au commentaire plantation est défini et qu'il ne consiste pas qu'à une chaîne de caractères vide alors on l'insère (en faisant une update de notre tuple)
	{
		$plantation=mysqli_real_escape_string($connexion, $_POST['plantation']);
		$requete="UPDATE Variété SET plantation='$plantation'WHERE nomV = '". $nomVariété . "'";
		$res=mysqli_query($connexion, $requete);
	}
	if(isset($_POST['entretien'])&&$_POST['entretien']!="")	//si le champs correspondant au commentaire entretien est défini et qu'il ne consiste pas qu'à une chaîne de caractères vide alors on l'insère (en faisant une update de notre tuple)
	{
		$entretien=mysqli_real_escape_string($connexion, $_POST['entretien']);
		$requete="UPDATE Variété SET entretien='$entretien'WHERE nomV = '". $nomVariété . "'";
		$res=mysqli_query($connexion, $requete);
	}
	if(isset($_POST['récolte'])&&$_POST['récolte']!="")	//si le champs correspondant au commentaire récolte est défini et qu'il ne consiste pas qu'à une chaîne de caractères vide alors on l'insère (en faisant une update de notre tuple)
	{
		$récolte=mysqli_real_escape_string($connexion, $_POST['récolte']);
		$requete="UPDATE Variété SET récolte='$récolte' WHERE nomV = '". $nomVariété . "'";
		$res=mysqli_query($connexion, $requete); 
	}
	if(isset($_POST['année']))	//si le champs année est défini alors on insère l'année saisie (en faisant une update de notre tuple)
	{
		$année=$_POST['année'];
		$requete="UPDATE Variété SET année=$année WHERE nomV = '". $nomVariété . "'";
		$res=mysqli_query($connexion, $requete);
	}
	if(isset($_POST['nbjours']))	//si le champs nbjours est défini alors on insère le nb de jours saisi (en faisant une update de notre tuple)
	{
		$nbjours=$_POST['nbjours'];
		$requete="UPDATE Variété SET nbjourslevée=$nbjours WHERE nomV = '". $nomVariété . "'";
		$res=mysqli_query($connexion, $requete);
	}
}

//Récupérer l'identifiant de la variété (idVa) venant d'être ajoutée, c-à-d l'idVa le plus élevé
function recupidVa($connexion)
{
	$requete = "SELECT max(idVa) FROM Variété;";
	$res = mysqli_query($connexion, $requete);
	$idVa= mysqli_fetch_row($res);
	return $idVa[0];
}

//Insérer dans la table produire suite à l'ajout d'une variété
function ajoutProduire($connexion, $idVa)
{	
	if(isset($_POST['version'])&&isset($_POST['semencier'])&&($_POST['semencier']!="NDef")&&($_POST['version']!="NDef")) //on ajoute que si les champs versions et semencier sont définis tout les deux et que leur valeur est != 'NDef'
	{
		$version=$_POST['version'];
		$semencier=$_POST['semencier'];
		$requete = "INSERT INTO Produire VALUES ($idVa, $version, $semencier);";
		$res = mysqli_query($connexion, $requete);
	}
}

//Insérer dans la table adapter suite à l'ajout d'une variété
function ajoutAdapter($connexion, $idVa)
{
	if(isset($_POST['typeSol']))  //si le champs typeSol est défini (donc au moins un type de sol sélectionné) alors on insère
	{
		foreach($_POST['typeSol'] as $type)  //boucle foreach pour insérer dans la table Adapter chaque type de sol qui a été sélectionné ($_POST['typeSol'] peut contenir soit un soit plusieurs types de sol)
		{
			$requete = "INSERT INTO Adapter VALUES ($type, $idVa, 'bon');";  //comme le formulaire évoque les sols adaptés, on choisit de mettre le niveau d'adaptation à 'bon' dans la base de données
			$res = mysqli_query($connexion, $requete);
		}
	}
}

////Insérer dans la table PériodeMEP suite à l'ajout d'une variété
function ajoutPériodeMEP($connexion, $idVa)
{
	if(isset($_POST['debMEP'])&&isset($_POST['finMEP']))  //on insère que si les champs debMEP et finMEP sont tout les deux définis (c-à-d qu'on insère que si notre période est bien définie = début ET fin)
	{
		$debMEP=$_POST['debMEP'];
		$finMEP=$_POST['finMEP'];
		$requete = "INSERT INTO PériodeMEP VALUES ($idVa, '$debMEP', '$finMEP');";
		$res = mysqli_query($connexion, $requete);
	}
}

//Insérer dans la table PériodeR suite à l'ajout d'une variété
function ajoutPériodeR($connexion, $idVa)
{
	if(isset($_POST['debRec'])&&isset($_POST['finRec']))	//on insère que si les champs debRec et finRec sont tout les deux définis (c-à-d qu'on insère que si notre période est bien définie = début ET fin)
	{
		$debRec=$_POST['debRec'];
		$finRec=$_POST['finRec'];
		$requete = "INSERT INTO PériodeR VALUES ($idVa, '$debRec', '$finRec');";
		$res = mysqli_query($connexion, $requete);
	}
}


//Véririfier le champs nbjours du formulaire d'ajout de variété
function vérifnbjours($connexion)
{
	if(empty($_POST['nbjours'])) return true;  //si le champs nbjours est vide on retourne true car l'ajout de la variété peut avoir lieu
	if(isset($_POST['nbjours'])&&$_POST['nbjours']<=0)  //si le champs nbjours est défini et <=0 on affiche un message d'erreur et on retourne false car l'ajout de la variété ne peut pas avoir lieu
	{
		echo "<p class='error'> Erreur : le nombre de jours de levée ne peut être négatif ou égal à 0</p>";
		return false;
	}
	else  //sinon le champs nbjours est bien défini avec une bonne valeur donc on retourne true
	{
		return true;
	}
}

//Véririfier le champs année du formulaire d'ajout de variété
function vérifannée($connexion)
{
	if(empty($_POST['année'])) return true; //si le champs année est vide on retourne true car l'ajout de la variété peut avoir lieu
	if(isset($_POST['année'])&&($_POST['année']<1800||$_POST['année']>2100)) //si le champs année est défini et <1800 ou >2100 on affiche un message d'erreur et retourne false car l'ajout de la variété ne peut pas avoir lieu
	{
		echo "<p class='error'> Erreur : l'année de mise sur le marché est incorrecte (elle doit être comprise entre 1800 et 2100)</p>";
		return false;
	}
	else 	//sinon le champs année est bien défini avec une bonne valeur donc on retourne true
	{
		return true;
	}
}

//Véririfier le champs MEP du formulaire d'ajout de variété
function vérifMEP($connexion)
{
	if(empty($_POST['debMEP']) xor empty($_POST['finMEP']))	//si seulement un des deux champs est vide on affiche un message d'erreur car l'ajout de variété ne peut pas avoir lieu et on retourne false
	{
		echo "<p class='error'> Erreur : une seule date est définie pour la mise en place (veuillez en saisir soit aucune soit deux)</p>";
		return false;
	}
	if(isset($_POST['debMEP'])&&isset($_POST['finMEP'])&&$_POST['debMEP']>$_POST['finMEP'])	//si les deux champs sont définis mais que la date de fin est plus récente que celle de début on affiche un message d'erreur car l'ajout de variété ne peut pas avoir lieu et on retourne false
	{
		echo "<p class='error'> Erreur : la date de début de mise en place doit être plus récente que celle de fin</p>";
		return false;
	}
	else 	//sinon les deux champs sont soit tout les deux vides soit bien définis avec de bonnes valeurs donc on retourne true
	{
		return true;
	}
}

//Véririfier le champs Récolte du formulaire d'ajout de variété
function vérifRec($connexion)
{
	if(empty($_POST['debRec']) xor empty($_POST['finRec']))  //si seulement un des deux champs est vide on affiche un message d'erreur car l'ajout de variété ne peut pas avoir lieu et on retourne false
	{
		echo "<p class='error'> Erreur : une seule date est définie pour la récolte (veuillez en saisir soit aucune soit deux)</p>";
		return false;
	}
	if(isset($_POST['debRec'])&&isset($_POST['finRec'])&&$_POST['debRec']>$_POST['finRec']) //si les deux champs sont définis mais que la date de fin est plus récente que celle de début on affiche un message d'erreur car l'ajout de variété ne peut pas avoir lieu et on retourne false
	{
		echo "<p class='error'> Erreur : la date de début de récolte doit être plus récente que celle de fin</p>";
		return false;
	}
	else //sinon les deux champs sont soit tout les deux vides soit bien définis avec de bonnes valeurs donc on retourne true
	{
		return true;
	}
}

//Vérifier que le nom de la variété saisi dans le formulaire d'ajout est bien défini (pas seulement que des espaces)
function vérifnomV($connexion)
{
	if(empty(str_replace(" ","", $_POST['nomVariété'])))  //si le nom saisi n'est composé que d'espaces
	{
		echo "<p class='error'> Erreur : le nom de la variété est incorrect (il n'y a que des espaces) ! </p>";
		return false;
	}
	else
	{
		return isset($_POST['nomVariété']);
	}
}

//Vérifier que le champs semencier et le champs version sont soit tout les deux pas définis soit tout les deux définis 
function vérifProduire($connexion)
{
	if(($_POST['semencier']!="NDef")&&($_POST['version']!="NDef")) //si tout les deux définis
	{
		return true;
	}
	if(($_POST['semencier']=="NDef")&&($_POST['version']=="NDef"))  //si tout les deux pas définis (valeur == 'NDef')
	{
		return true;
	}
	else  //sinon l'un est défini et pas l'autre donc impossible de remplir la table produire après la soumission du formulaire donc on retourne false avec un message d'erreur
	{
		echo "<p class='error'> Erreur : le semencier ainsi que la version doivent être tout les deux soit définis, soit non définis (en même temps) </p>";
		return false;
	}
}

//Véririfier le formumaire d'ajout d'une variété dans son ensemble
function vérifAjout($connexion)
{
	$vérif1=vérifnomV($connexion); //vérif du nom
	$vérif2=vérifannée($connexion); //vérif de l'année
	$vérif3=vérifMEP($connexion); //vérif de la période de MEP
	$vérif4=vérifRec($connexion); //vérif de la période de Rec
	$vérif5=vérifnbjours($connexion); //vérif du nbjours
	$vérif6=vérifProduire($connexion); //vérif des infos pour remplir la table produire
	return($vérif1&&$vérif2&&$vérif3&&$vérif4&&$vérif5&&$vérif6); //retourne true ssi toutes les vérifications sont true
}

// Générer une nouvelle Parcelle
function générerParcelle($connexion)
{
	$requete = "INSERT INTO `Parcelle` (`idPa`, `coordP`, `dimP`, `idJ`) VALUES (NULL, NULL, NULL, NULL); ";
	$res = mysqli_query($connexion, $requete);
}

//Récupérer l'identifiant de la parcelle que l'on vient de créer (l'idPa le plus grand)
function recupidPa($connexion)
{
	$requete = "SELECT max(idPa) FROM Parcelle;";
	$res = mysqli_query($connexion, $requete);
	$idPa= mysqli_fetch_row($res);
	return $idPa[0];
}

//Générer un rang d'une parcelle passée en paramètre avec aussi le numéro du rang
function générerRang($connexion, $idPa, $i)
{
	$requete = "INSERT INTO Rang (idPa, numR) VALUES ($idPa, $i)";
	$res = mysqli_query($connexion, $requete);	
}

//Récupérer les identifiants (idVa) des variétés
function recupVariété($connexion)
{
	$requete="SELECT idVa from Variété;";
	$res=mysqli_query($connexion, $requete);
	$Variétés=mysqli_fetch_all($res, MYSQLI_NUM);
	return $Variétés;
}

//Récupérer les identifiants (idMEP) des mises en place
function recupMEP($connexion)
{
	$requete="SELECT idMEP from MiseEnPlace ;";
	$res=mysqli_query($connexion, $requete);
	$MisesEnPlace=mysqli_fetch_all($res, MYSQLI_NUM);
	return $MisesEnPlace;
}

//Remplir la table cultiver avec en paramètre l'identifiant de la parcelle et le numéro du rang
function remplirCultiver($connexion, $idPa, $i)
{
	$date=date("Y-m-d");  //récupération de la date courante
	$Variétés=recupVariété($connexion);	//récupération des identifiants des variétés
	$MisesEnPlace=recupMEP($connexion);	//récupération des identifiants des mises en place
	$maxVa=count($Variétés); //récupération du nombre total de variétés
	$maxMEP=count($MisesEnPlace);  //récupération du nombre total de mises en place
	$arrayVa=array();  //création d'un tableau pour les idVa
	$arrayMEP=array();  //création d'un tableau pour les idMEP
	foreach($Variétés as $Variété)
	{
		$arrayVa[]=$Variété[0];	//remplissage du tableau avec les identifiants des variétés
	}
	foreach($MisesEnPlace as $MiseEnPlace)
	{
		$arrayMEP[]=$MiseEnPlace[0];	//remplissage du tableau avec les identifiants des mises en place
	}
	$idVa=$arrayVa[rand(0,$maxVa-1)];	//choisit aléatoirement un identifiant de variété
	$idMEP=$arrayMEP[rand(0,$maxMEP-1)];	//choisit aléatoirement un identifiant de mise en place
	$requete = "INSERT INTO Cultiver VALUES($idPa, $i, $idVa, $idMEP, '$date','$date');";
	$res = mysqli_query($connexion,$requete);
}

//Récupérer les identifiants (idPl) des plantes sauvages
function recupPlanteSauvage($connexion)
{
	$requete="SELECT idPl from Plante where typeP like '%Mauvaises herbes%' ;";
	$res=mysqli_query($connexion, $requete);
	$PlantesSauvages=mysqli_fetch_all($res, MYSQLI_NUM);
	return $PlantesSauvages;
}

//Remplir table couvrir avec en paramètre l'identifiant de la parcelle et le numéro du rang
function remplirCouvrir($connexion, $idPa, $i)
{
	$date=date("Y-m-d");  //récupération de la date courante
	$PlantesSauvages=recupPlanteSauvage($connexion);  //récupération des identifiants des plantes sauvages
	$max=count($PlantesSauvages);  //récupération du nombre total de plantes sauvages
	$array=array();  //création d'un tableau
	foreach($PlantesSauvages as $PlantesSauvage)
	{
		$array[]=$PlantesSauvage[0];  //remplissage du tableau avec les identifiants des plantes sauvages
	}
	$idPl=$array[rand(0,$max-1)];  //choisit aléatoirement un identifiant de plante sauvage
	$requete = "INSERT INTO Couvrir VALUES($idPa, $i, $idPl,'$date','$date');";
	$res = mysqli_query($connexion,$requete);
}

//Vérifier dans l'ensemble le formulaire de génération parcelle
function vérifGénérerParcelle($connexion)
{
	if($_POST['rangMin']>$_POST['rangMax'])  //si le rang min saisi est plus grand que le rang max saisi alors affichage code erreur et $bool1 false
	{
		echo "<p class='error'> Erreur :  Le nombre de rangs minimum doit être inférieur ou égal au nombre de rangs maximum ! </p> ";
		$bool1=false;	
	}
	else //sinon rang min <= rang max donc $bool1 true
	{
		$bool1=true;
	}

	if($_POST['pourcentageCulture']+$_POST['pourcentageSauvage']>100) //si la somme des deux % >100 aors affichage code erreur et $bool2 false
	{
		echo "<p class='error'> Erreur :  Le pourcentage global des rangs occupés ne peut dépasser les 100% ! </p> ";
		$bool2=false;
	}
	else //sinon la somme <=100% donc $bool2 true
	{
		$bool2=true;
	}
	return ($bool1&&$bool2);
}

//Récupérer toutes les données nécessaires pour l'affichage des rangsCultivés
function récupDonnéesRangCultivé($connexion, $idPa)
{
	$requete = "SELECT idPl, nomP, typeP, nomV,idPa, numR, idVa FROM Plante NATURAL JOIN (SELECT idVa, nomV, idPl,idPa, numR FROM Variété NATURAL JOIN (SELECT idPa, numR, idVa FROM Rang NATURAL JOIN Cultiver WHERE idPa=$idPa) as t1) as t2;";  //le but des jointures est dans l'ordre de récup l'idVa pour ensuite récup l'idPl pour ensuite avoir accès aux infos de la plante
	$res = mysqli_query($connexion, $requete);
	return mysqli_fetch_all($res, MYSQLI_NUM);
}


//Récupérer toutes les données nécessaires pour l'affichage des rangsSauvages
function récupDonnéesRangSauvage($connexion, $idPa)
{
	$requete = "SELECT idPa, numR, idPl, nomP, typeP FROM Plante NATURAL JOIN (SELECT idPa, numR, idPl FROM Rang NATURAL JOIN Couvrir WHERE idPa=$idPa) as t1;";  //le but des jointures est dans l'ordre de récup l'idPl pour ensuite avoir accès aux de la plante
	$res = mysqli_query($connexion, $requete);
	return mysqli_fetch_all($res, MYSQLI_NUM);
}

//Récupérer toutes les données nécessaires pour l'affichage des rangsLibres
function récupDonnéesRangLibre($connexion, $idPa, $nbRangsSauvage,$nbRangsCulture)
{
	$requete = "SELECT idPa, numR FROM Rang WHERE (idPa=$idPa AND numR>$nbRangsSauvage+$nbRangsCulture);"; //dans mon choix de conception les rangs libres sont les derniers rangs de la parcelle générée donc leur numR>$nbRangsSauvage+$nbRangsCulture
	$res = mysqli_query($connexion, $requete);
	return mysqli_fetch_all($res, MYSQLI_NUM);
}

//Remplir la table photo suite à l'ajout d'une photo d'une plante
function remplirPhoto($connexion, $idPl, $url)
{
	$requete = "INSERT INTO Photo (idPl, url) VALUES ($idPl, '$url');";
    $res = mysqli_query($connexion, $requete);
}

//Récupérer les liens des photos de la plante à afficher
function récupURL($connexion, $idPl)
{
	$requete = "SELECT url FROM Photo WHERE idPl=$idPl;";
	$res=mysqli_query($connexion, $requete);
	return mysqli_fetch_all($res, MYSQLI_NUM);
}

// récupérer toutes les infos des instances de la table photo où le chemin d'accès à la photo est le même que celui passé en paramètre
function getPhotoByName($connexion, $url) 
{
	$url = mysqli_real_escape_string($connexion, $url);
	$requete = "SELECT * FROM Photo WHERE url = '". $url . "'";
	$res = mysqli_query($connexion, $requete);
	$urls = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $urls;
}

//Récupérer le nom des plantes (et leur identifiant) qui ont des photos
function récupNom($connexion)
{
	$requete = "SELECT DISTINCT idPl, nomP, nomL from Photo NATURAL JOIN Plante ORDER BY nomP;";
	$res = mysqli_query($connexion, $requete);
	return mysqli_fetch_all($res, MYSQLI_NUM);
}

//Supprimer l'instance de la classe Photo comportant l'url en paramètre
function suppURL($connexion, $url)
{
	$requete = "DELETE FROM Photo WHERE url='$url';";
	$res=mysqli_query($connexion, $requete);
	return $res;
}

?>



