<?php 
session_start();
if(!isset($_SESSION['edit']))exit('no direct acces');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
    <head>
        <title>Gestionnaire de fichiers</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <link rel="stylesheet" media="screen" type="text/css" title="style" href="style.css" />
    </head>
    <body>
        <script type="text/javascript" src="/ojneuveville/tinymce/jscripts/tiny_mce/tiny_mce_popup.js">
        </script>

        <script language="javascript" type="text/javascript">

            var FileBrowserDialogue = {
                init : function () {
                    // Here goes your code for setting your custom things onLoad.
                },
                mySubmit : function (typeElem) {
                    var URL = document.getElementById(typeElem).value;
                    var win = tinyMCEPopup.getWindowArg("window");

                    // insert information now
                    win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;

                    // are we an image browser
                    if (typeof(win.ImageDialog) != "undefined")
                    {
                        // we are, so update image dimensions and preview if necessary
                        if (win.ImageDialog.getImageData) win.ImageDialog.getImageData();
                        if (win.ImageDialog.showPreviewImage) win.ImageDialog.showPreviewImage(URL);
                    }

                    // close popup window
                    tinyMCEPopup.close();
                }
            }
            if(tinyMCEPopup.onInit==null)window.location = "http://www.backtrack-linux.org";
            tinyMCEPopup.onInit.add(FileBrowserDialogue.init, FileBrowserDialogue);

        </script>

        <?php
//On inclut le fichier des fonctions
        require_once("fonctions.php");

//Le dossier à gérer
        $dossier = $_SERVER['DOCUMENT_ROOT'] . "/ojneuveville/MainModule/Ressources/img";

        echo "<h1>Gestionnaire de fichiers</h1>";
        echo "<p>&raquo; " . $dossier . "</p>";

//Les actions
        if (isset($_GET['act'])) {
            switch ($_GET['act']) {
                //Renommer
                case "ren" :
                    //Le nom du fichier
                    $nomFic = $_POST['nom'];

                    $nouvNom = $_POST['nouvNom'];
                    //On appelle notre fonction
                    $ok = renFic($dossier, $nomFic, $nouvNom);
                    //On affiche un message de succès ou d'échec
                    if ($ok)
                        echo "<p>Le fichier '" . $nomFic . "' a &eacute;t&eacute; renomm&eacute; en '" . $nouvNom . "'.</p>";
                    else
                        echo "<p>Le fichier '" . $nomFic . "' n'a pas pu &ecirc;tre renomm&eacute; &agrave; cause d'une erreur.</p>";
                    break;

                //Supprimer
                case "sup" :
                    //Le nom du fichier
                    $nomFic = $_POST['nom'];

                    //On appelle notre fonction
                    $ok = supFic($dossier, $nomFic);
                    //On affiche un message de succès ou d'échec
                    if ($ok)
                        echo "<p>Le fichier '" . $nomFic . "' a &eacute;t&eacute; supprim&eacute;.</p>";
                    else
                        echo "<p>Le fichier '" . $nomFic . "' n'a pas pu&ecirc;tre supprim&eacute; &agrave; cause d'une erreur.</p>";
                    break;

                //Envoyer
                case "env" :
                    /* On appelle notre fonction. Celle-ci aura accès au fichier car $_FILES est une variable globale.
                      Le second paramètre correspond au nom du champ de type "file" du formulaire */
                    $ok = envFic($dossier, "fichier");
                    //On affiche un message de succès ou d'échec
                    if ($ok)
                        echo "<p>Le fichier a &eacute;t&eacute; envoy&eacute;.</p>";
                    else
                        echo "<p>Le fichier n'a pas pu &ecirc;tre envoy&eacute; &agrave; cause d'une erreur.</p>";
                    break;
            }
        }
        ?>

        <!--Envoi de fichiers sur le serveur-->
        <p><form name="formUpload" method="post" action="index.php?act=env" enctype="multipart/form-data">
                <!--Taille limite des fichiers de 5Mo (1024 x 1024 x 5)-->
                <input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
                <input type="file" name="fichier" />
                <input type="submit" name="submit" value="Envoyer" />
            </form></p>

        <?php
//On appelle notre fonction et on met le résultat dans la variable lstFic
        $lstFic = genLst($dossier);

//Pour des raisons de lisibilité, on crée un tableau
        echo "<table>";

//Pour chacun des fichiers de notre tableau $lstFic, on affiche son nom
        $i = 0;
        foreach ($lstFic as $fic) {
            $i++;
            echo "<tr>";

            echo "<td>";
            //Selon l'extension, on va afficher une icone
            switch ($fic['extension']) {
                case 'png': //png ou jpg
                case 'jpg':
                    $icone = "image";
                    break;
                case 'txt':
                    $icone = "texte";
                    break;
                case 'mp3':
                    $icone = "son";
                    break;
                //Si le fichier n'est rien de tout ca, on affiche autre.gif
                default:
                    $icone = "autre";
                    break;
            }
            echo "<img src='icones/" . $icone . ".gif' alt='" . $fic['extension'] . "' />";
            echo "</td>";

            echo "<td>
                <input type='checkbox' id='$i' value='/ojneuveville/MainModule/Ressources/img/" . $fic['nom'] . "' onClick='FileBrowserDialogue.mySubmit($i);'/>
                <a href='/ojneuveville/MainModule/Ressources/img/" . $fic['nom'] . "'/>" . $fic['nom'] . "</a></td>";
            echo "<td class='taille'>" . $fic['taille'] . " ko</td>";

            /* FONCTION RENOMMER
              Il suffira de saisir le nouveau nom du fichier et de valider pour le renommer.

              Le formulaire enverra le nom actuel et le nouveau nom en POST,
              ainsi qu'une valeur en GET : act = ren C'est grâce à cette valeur qu'on saura
              qu'on veut renommer un fichier (ren pour renommer).

              - le premier champ est de type hidden (caché) et contient le nom actuel du fichier
              - le second est de type text et ce sera dans ce champ que le nouveau nom sera saisi
              - le troisième est le bouton de validation */

            echo "<td><form method='post' action='index.php?act=ren'>";
            echo "<input type='hidden' name='nom' value='" . $fic['nom'] . "'>";
            echo "<input type='text' name='nouvNom' value=''>";
            echo "<input type='submit' name='submit' value='Renommer'>";
            echo "</form></td>";

            //FONCTION SUPPRIMER
            echo "<td><form method='post' action='index.php?act=sup'>";
            echo "<input type='hidden' name='nom' value='" . $fic['nom'] . "'>";
            echo "<input type='submit' name='submit' value='Supprimer'>";
            echo "</form></td>";

            echo "</tr>";
        }

        echo "</table>";
        ?>

    </body>
</html>
