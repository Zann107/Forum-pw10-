<?php
  session_start();
  setcookie('mail', time() + 365*24*3600, null, null, false, true); /*parametre true = htppOnly activé pour que cookie inaccesible en jS par navigateur*/
?>


<form action="users.php" method="post" enctype="multipart/form-data"> <!-- action= cible la page de traitement des infos enctype = envoi fichier-->
  Name : <input type="text" name="name">
  Message : <input type="text" name="message">
  Mot de passe : <input type="text" name="pwd">
  pseudo : <input type="text" name="pseudo">
  <input type="checkbox" name="case" id="case" /> <label for="case">Ma case à cocher</label><!--label = nom case coche aussi-->
</br>img profil : <input type="file" name="img"/>
  <input type="submit" value="Valider" />
</form>
