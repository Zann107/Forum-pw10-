
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
/*cela permet de valider ou nom une adresse ou un num (bonne ecriture ceux ci) cf openclassroom expression reguliere*/
if (isset($_POST['mail'])) /*isset permet de verifier si la variable existe avant de l'executer (=securite) */
{
  $_POST['mail'] = htmlspecialchars($_POST['mail']);

  if (preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $_POST['mail'])) {
$_POST['mail'] = preg_replace('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', '<a href="$0">$0</a>', $_POST['mail']);
    echo 'L\'adresse : ' .$_POST['mail']. ' est bonne.<br/>';
  }
  else {
    echo 'L\'adresse : '.$_POST['mail'].' n\'est pas bonnne.<br/>';
  }
}

/*remplacement du contenu avec preg_replace*/
if (isset($_POST['msg'])) {
  $_POST['msg'] = htmlspecialchars($_POST['msg']);
  /*utilisation du bbcode (b bold i italique remplace strong et em)*/
 $_POST['msg'] = preg_replace('#\[b\](.+)\[/b\]#isU', '<strong>$1</strong>', $_POST['msg']);/*s= pour que le point marche mem s'il y a des retours à ligne U= selectionne ouverture et fermeture de [b] et pas premiere ouverture et derniere ouverture*/
$_POST['msg'] = preg_replace('#\[i\](.+)\[/i\]#isU', '<em>$1</em>', $_POST['msg']);
$_POST['msg'] = preg_replace('#\[color=(red|green|blue|yellow|purple|olive)\](.+)\[/color\]#isU', '<span style="color:$1">$2</span>', $_POST['msg']);
 /*convertir les adresse en lien cliquable*/
 $_POST['msg'] = preg_replace('#http://[a-z0-9._/?+&=;-]+#i', '<a href="$0">$0</a>', $_POST['msg']);
echo nl2br($_POST['msg']);/*normalement execute les br*/
}

echo htmlspecialchars($_POST['pseudo']);
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
