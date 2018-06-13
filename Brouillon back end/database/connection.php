<?php
echo 'connection à ma base de données';
$user = 'root';
$password = 'simplonco';
$dbname = 'Forum';
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


/*pour plus de securite au lieu de faire $reponse = $bdd->query('SELECT .... FROM .... WHERE ....n=\'' . $_GET['....'] . '\''); car GET utilisateur peut modifier et récup des donness*/

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


 /*POUR ENREGISTRER MSGE DANS BDD*/
$pseudo = $bdd->prepare('INSERT INTO user (pseudo) VALUES(?)');
$pseudo->execute(array( $_POST['pseudo']));
$pseudo->closeCursor();
header('Location: new.php');/* redirige vers page*/

/* ex : mot de passe*/
// Hachage du mot de passe
$pass_hache = password_hash($_POST['pass'], PASSWORD_DEFAULT);

// Insertion
$req = $bdd->prepare('INSERT INTO membres(pseudo, pass, email, date_inscription) VALUES(:pseudo, :pass, :email, CURDATE())');
$req->execute(array(
    'pseudo' => $pseudo,
    'pass' => $pass_hache,
    'email' => $email));
// sur le formulaire de connexion
//  Récupération de l'utilisateur et de son pass hashé
$req = $bdd->prepare('SELECT id, pass FROM membres WHERE pseudo = :pseudo');
$req->execute(array(
    'pseudo' => $pseudo));
$resultat = $req->fetch();

// Comparaison du pass envoyé via le formulaire avec la base
$isPasswordCorrect = password_verify($_POST['pass'], $resultat['pass']);

if (!$resultat)
{
    echo 'Mauvais identifiant ou mot de passe !';
}
else
{
    if ($isPasswordCorrect) {
        session_start();
        $_SESSION['id'] = $resultat['id'];
        $_SESSION['pseudo'] = $pseudo;
        echo 'Vous êtes connecté !';
    }
    else {
        echo 'Mauvais identifiant ou mot de passe !';
    }
}
/* affiche connecté sur tte les pages du site*/
if (isset($_SESSION['id']) AND isset($_SESSION['pseudo']))
{
    echo 'Bonjour ' . $_SESSION['pseudo'];
}
//grace au cookies connexion auto (il faut psd et id en cookie)

// Suppression des variables de session et de la session pour pv se deconnecter sans attendre le timeout qui deconnecte auto
$_SESSION = array();
session_destroy();

// Suppression des cookies de connexion automatique
setcookie('login', '');
setcookie('pass_hache', '');
?>
