<?php
echo 'connection à ma base de données';
$user = 'root';
$password = 'simplonco';
$dbname = 'forum';
$host = 'localhost';
$port = 3306;

try {
  $bdd = new PDO('mysql:host=localhost;dbname=forum;charset=utf8', 'root', 'simplonco', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));/*precise l'erreur*/
  /* PDO permet acceder bdd*/
}
catch (Exception $e) /*exception permet d attraper l erreur qui afficherai  mot de passe s'affiche*/
{
        die('Erreur : ' . $e->getMessage()); /*ou $error = $e->getCode().' '.$e->getMessage(); suivie de include $appRoot.'Page que l'on vzut afficherp';*/
}



$reponse = $bdd->query('SELECT * FROM salon'); /*rajouter or die(print_r($bdd->errorInfo())); Pour localiser erreur (ne marche pas)*/
while($donnees = $reponse->fetch()){ /* selectionne une ligne du tableau et while fait que l'execution se repete jusqu'à qu'il n'y ait plus de données à recuperer et renvoi faux à while et la bouclle s'arrete*/

echo $donnees['id_salon'].'</br>';
}
$reponse->closeCursor(); /*indique fin de traitement de la requete*/

/* preparation de requete permet choisir ce que l'on veut utiliser*/

/*pour plus de securite au lieu de faire $reponse = $bdd->query('SELECT .... FROM .... WHERE ....n=\'' . $_GET['....'] . '\''); car GET utilisateur peut modifier et récup des donness*/
$req = $bdd->prepare('SELECT id_salon, name_salon FROM salon WHERE  id_salon <= 4'); /*prepare la requete "?" = marqueur mais possibilié de les nommer syntaxe ":nom" ex :id*/
$req->execute(array( $_GET['id_salon'])); /*execute en indiquant ce que l'on veut à la place des '?'*//* Si utilise ":nom" on ecrit array('id' => $_GET['id_salon']) et pas besoin d'ecrire dans l'ordre dans ce cas*/
echo '<ul>';
while ($donnees = $req->fetch()){
  echo '<li>'. $donnees['id_salon'] . $donnees['name_salon'];
}
$req->closeCursor();
/*modif bdd utilise exec() (pour modif)*/
/*ex: $bdd->exec('INSERT INTO jeux_video(nom, possesseur, console, prix, nbre_joueurs_max, commentaires) VALUES(\'Battlefield 1942\', \'Patrick\', \'PC\', 45, 50, \'2nde guerre mondiale\')');*/
/*Si selction variable $req = $bdd->prepare('INSERT INTO jeux_video(nom, possesseur, console, prix, nbre_joueurs_max, commentaires) VALUES(:nom, :possesseur, :console, :prix, :nbre_joueurs_max, :commentaires)');
$req->execute(array(*/
/* pour afficher ce qui a ete modif mettre la requete dans une variable (ex: $f = $bdd->exec ....puis echo $f)*/

try {
  $bdd = new PDO('mysql:host=localhost;dbname=forum;charset=utf8', 'root', 'simplonco', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));/*precise l'erreur*/
  /* PDO permet acceder bdd*/
}
catch (Exception $e) /*exception permet d attraper l erreur qui afficherai  mot de passe s'affiche*/
{
        die('Erreur : ' . $e->getMessage()); /*ou $error = $e->getCode().' '.$e->getMessage(); suivie de include $appRoot.'Page que l'on vzut afficherp';*/
}
 /*POUR ENREGISTRER MSGE DANS BDD*/
$msg = $bdd->prepare('INSERT INTO message (pseudo, contenu) VALUES(?,?)');
$msg->execute(array($_POST['message'], $_POST['pseudo']));
$msg->closeCursor();
header('Location: new.php');/* redirige vers page*/
?>
