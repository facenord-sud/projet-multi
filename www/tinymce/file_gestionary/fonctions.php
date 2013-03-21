<?php

function genLst($adr) {
	//Ce tableau contiendra la liste des fichiers
	$tab = array();

	//Si le dossier est bien ouvert (opendir() retourne un pointeur sur un dossier. Il est affecté à $dossier. Faire un if permet de vérifier que le dossier a bien été ouvert.
	if ($dossier = opendir($adr)) {
		//Pour chacun des fichiers du dossier ( = Tant qu'il y en a, on récupère les fichiers un par un )
		while ($fichier = readdir($dossier)) {
			//Si ce n'est pas un dossier
			//Si ce n'est pas un dossier
			if ($fichier != "." && $fichier != "..") {
				//Extension du fichier
				$extension = explode(".", $fichier);
				$extension = $extension[count($extension)-1]; //Le dernier élément est l'extension

				//Taille du fichier en ko
				$octets = filesize($adr . "/" . $fichier);
				$taille = $octets / 1024;
				$taille = round($taille, 2);

				//On ajoute le nom du fichier, son extension et sa taille dans le tableau $tab
				$tab[] = array("nom" => $fichier, "extension" => $extension, "taille" => $taille);
			}
		}

		//On libère les ressources utilisées pour l'ouverture du dossier
		closedir($dossier);

		//On retourne $tab qui contient la liste des noms des fichiers
		return $tab;
	}
}

function renFic($adr, $nom, $nouvNom) {
	//ok est un booléen qui permettra de savoir si l'opération s'est bien déroulée.
	$ok = false;

	//On vérifie que les paramètres contiennent quelque chose
	if($adr != "" && $nom != "" && $nouvNom != "") {
		//Les chemins de notre fichier avant et après avoir été renommé
		$ancienNom = $adr . "/" . $nom;
		$nouveauNom = $adr . "/" . $nouvNom;

		//On vérifie que le fichier existe bien et qu'il n'existe pas déjà de fichier avec le nouveau nom
		if(file_exists($ancienNom) && !file_exists($nouveauNom)) {
			//Puis on le renomme
			$ok = rename($ancienNom, $nouveauNom);
		}
	}
	//On retourne le booléen
	return $ok;
}

function supFic($adr, $nom) {
	//ok est un booléen qui permettra de savoir si l'opération s'est bien déroulée.
	$ok = false;

	//On vérifie que les paramètres contiennent quelque chose
	if($adr != "" && $nom != "") {
		//Le chemin de notre fichier
		$nom = $adr . "/" . $nom;

		//On vérifie que le fichier existe bien et qu'il n'existe pas déjà de fichier avec le nouveau nom
		if(file_exists($nom)) {
			//Puis on le renomme
			$ok = unlink($nom);
		}
	}
	//On retourne le booléen
	return $ok;
}

function envFic($adr, $nomChamp) {
	//ok est un booléen qui permettra de savoir si l'opération s'est bien déroulée.
	$ok = false;
	$origine = $_FILES[$nomChamp]['tmp_name'];
	$destination = $adr . "/" . $_FILES[$nomChamp]['name'];
	if(move_uploaded_file($origine, $destination)) {
		$ok = true;
	}

	return $ok;
}

?>
