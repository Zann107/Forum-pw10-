
<?php
  session_start();
  setcookie('mail', time() + 365*24*3600, null, null, false, true); /*parametre true = htppOnly activé pour que cookie inaccesible en jS par navigateur*/
  include($appRoot.'/controllers/users.php');
?>

<h3>Les utilisateurs sont :</h3>

<div>
  <?php


  echo htmlspecialchars($_POST['name']); /* evite que du code soit executé + possibilite d'utiliser fonction strip_tags pour ne pas afficher les balises*/
/*langaage pcre pour regex (expression regulière)*/
/*cela permet de valider ou nom une adresse ou un num (bonne ecriture ceux ci)*//*cf openclassroom expression reguliere*/
if (isset($_POST['mail']))
{
  $_POST['mail'] = htmlspecialchars($_POST['mail']);

  if (preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $_POST['mail'])) {

    echo 'L\'adresse :<br/>' .$_POST['mail']. ' est bonne.';
  }
  else {
    echo 'L\'adresse :<br/>'.$_POST['mail'].' n\'est pas bonnne.';
  }
}


echo htmlspecialchars($_POST['pseudo']);
echo htmlspecialchars($_POST['message']);
echo $_COOKIE['mail'];
  echo $_POST['case'];/*affiche on si cohé*/
if (isset($_FILES['img']) /*(isset verifie)*/AND $_FILES['img']['error'] == 0)/*s'il y a erreur*/
{
  if ($_FILES['img']['size'] <= 8000000)/*=8Mo*/
        {
          $infosfichier = pathinfo($_FILES['img']['name']);
          $extension_upload = $infosfichier['extension']; /*variable qui contiendra autre variable*/
          $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                if (in_array($extension_upload, $extensions_autorisees)) /*in_array = fonvtion*/
                {
                  // On peut valider le fichier et le stocker définitivement
                        move_uploaded_file($_FILES['img']['tmp_name'], '/etc/apache2/uploads/' . basename($_FILES['img']['name']));
                        echo "L'envoi a bien été effectué !";
                }
        }
}
    foreach ($users as $user) {
      echo "- ".$user['name']."<br />";
    }

  ?>
</div>
<!-- <!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Codes d'accès au serveur central de la NASA</title>
    </head>
    <body>

       <?php
  //  if (isset($_POST['mot_de_passe']) AND $_POST['mot_de_passe'] ==  "kangourou") // Si le mot de passe est bon
    {
    // On affiche les codes
    ?>
        <h1>Voici les codes d'accès :</h1>
        <p><strong>CRD5-GTFT-CK65-JOPM-V29N-24G1-HH28-LLFV</strong></p>

        <p>
        Cette page est réservée au personnel de la NASA. N'oubliez pas de la visiter régulièrement car les codes d'accès sont changés toutes les semaines.<br />
        La NASA vous remercie de votre visite.
        </p>
        <?php
    }
  //  else // Sinon, on affiche un message d'erreur
    {
  //      echo '<p>Mot de passe incorrect</p>';
    }
    ?>


    </body>
</html> -->
