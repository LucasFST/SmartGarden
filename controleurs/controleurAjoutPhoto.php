<?php 

$plantes=getPlante($connexion, "Plante");  //récupération de toutes les plantes

if(isset($_POST['AjouterPhoto'])) //si le formulaire d'ajout est soumis
{

	$dossier = 'imagesPlantes/'; // dossier où sera déplacé la nouvelle image
    $tmp_file = $_FILES['photo']['tmp_name'];  //récupération du nom temporaire

    $taille_max = 1048576;   //défintion de la taille max autorisée pour le fichier
    $taille_fichier = filesize($tmp_file);  //récupération de la taille du fichier transmis
    if ($taille_fichier > $taille_max)
    {
      $messageTaille = "<p class='error'>Vous avez dépassé la taille de fichier autorisée ! </p>";  //code d'erreur si la taille du fichier est supérieure à celle autorisée
    }
    else
    {
	   if( !is_uploaded_file($tmp_file) )  //vérification que le fichier a bien été téléchargé par HTTP POST (ici par la négation)
        {
            $messageUpload = "<p class='error'>Le fichier est introuvable ! </p>";   //code d'erreur si le fichier n'a pas été téléchargé
        }
 
        $type_file = $_FILES['photo']['type'];   // récupération de l'extension du fichier
 
        if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') && !strstr($type_file, 'png') )   // on vérifie maintenant l'extension
        {
            $messageExtension = "<p class='error'>L'extension du fichier n'est pas acceptée ! </p>";  //code d'erreur si l'extension du fichier ne fait pas parti de celles autorisées (les propositions de ci-dessus)
        }
 
        // on copie le fichier dans le dossier de destination
        $name_file = $_FILES['photo']['name'];  //récupération du nom original de la photo
        $name_file=str_replace(' ', '_',$name_file); //pour enlever les éventuels espaces du nom original de la photo
    
        $URL = $dossier . $name_file;  //on compose l'url (le chemin) entier vers la photo (dossier+nom)
        $URL = mysqli_real_escape_string($connexion, $URL); //on l'échappe par sécurité via la fonction mysqli

        $verification = getPhotoByName($connexion, $URL); //on teste s'il n'existe pas déjà une photo avec le même chemin stocké dans la base de données
        if($verification == FALSE || count($verification) == 0) // pas de photo avec le même lien, insertion
        {
            if( !move_uploaded_file($tmp_file, $URL))  //vérification que la fichier a bien été téléchargé dans le dossier souhaité (ici par la négation)
            {
                $messageError = "<p class='error'>Impossible d'insérer l'image' ! </p>";  //code d'erreur si ce n'est pas le cas
            }
            else
            {
                $messageRéussite = "<p class='success'>La photo a bien été uploadée ! </p>";  //code de réussite si c'est la cas
                $idPl=$_POST['nomPlante'];   //récupération de l'identifiant de la plante concernée par cette photo
                remplirPhoto($connexion, $idPl,$URL);   //insertion dans la base de données du nouveau tuple de l'instance photo
            }
        }
        else
        {
             $messageErrorName = "<p class='error'>Il existe déjà une photo du même nom : veuillez saisir un nouveau nom pour votre photo ! </p>";  //code d'erreur s'il existe déjà une photo avec le même chemin stocké dans la base de données
        }
    }

}



?>