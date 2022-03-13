<?php

$pathParent = dirname(__FILE__);
include $pathParent . "/credentials/credentials.php";

header('Content-Type: text/html; charset=utf-8');

?>
<!DOCTYPE html>
<link rel="stylesheet" href="style/upload.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<h1 style="text-align:center;">Upload</h1>

<?php

//taille max de 8 Mo
$tailleMaxFichier = 8 * 1024 * 1024;
$cheminDest = $pathParent . "\uploadFiles";
?>

    <div class="divClass">
        <div class="divContainer">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $tailleMaxFichier;?>">
                <label>Votre fichier: </label>
                <input type="file" name="nomFichier"><br>
                <label>Nouveau nom du fichier: </label><input type="text" name="nouveauNomFichier" placeholder="Nom d'origine si vide"><br><br>
                <input type="submit" value="Envoyer">
            </form>
        </div>
    </div>

    </br>

    <?php
    //si un fichier est bien envoyé via le formulaire
    if(isset($_FILES["nomFichier"])){
        //si aucune erreur n'est présente lors de l'upload du fichier
        if ($_FILES["nomFichier"]["error"] == 0) {
            //si l'input du nouveau nom est vide, garde le nom d'origine du fichier
            if($_POST["nouveauNomFichier"] == null){
                //permet d'obtenir l'extension
                $array = explode('.', $_FILES['nomFichier']['name']);
                $extension = end($array);
                //nom du fichier seul
                $nomFichier = basename($_FILES["nomFichier"]["name"], "." . $extension);
            
            //sinon, attribue le nouveau nom entré au fichier
            }else{
                $array = explode('.', $_FILES['nomFichier']['name']);
                $extension = end($array);
                
                $nomFichier = $_POST["nouveauNomFichier"];
                
            }
            //upload le fichier dans un dossier "/uploadFiles"
            move_uploaded_file($_FILES["nomFichier"]["tmp_name"], $cheminDest . "\\" . $nomFichier . "." . $extension);
            try {
                //connexion a la BDD
                $mysqlClient = new PDO($dbname, $login, $password);
                //ajoute des antislash devant tout les caractères spéciaux de l'url
                $cheminDest = addcslashes($cheminDest, "\\");
                //insertion des données dans la BDD
                $sqlQuery = "INSERT INTO uploadfilesdata(nom_fichier, extension_fichier, chemin_fichier) VALUES ('$nomFichier', '$extension', '".$cheminDest."')";
                $result = $mysqlClient->prepare($sqlQuery);
                $result->execute();
            } catch(PDOException $e) {
                die('Erreur de connexion à la BDD. Erreur n°' . $e->getCode() . ':' . $e->getMessage());
            }
            //affiche un message d'upload réussi
            ?>
            <p style="text-align:center;">Upload du fichier <strong>'<?php echo $nomFichier; ?>'</strong> réussit.</p><?php
        //sinon, affiche un message d'erreur
        }else{?>
            <p style="text-align:center;">Une erreur est survenue. Veuillez réessayer.</p><?php
        }

    }
    
    ?>