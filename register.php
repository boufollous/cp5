<?php
// var_dump($_POST);
// Récupération des valeurs saisies et application sécurité
foreach ($_POST as $key => $val) {
    $params[':' . $key] = (isset($_POST[$key]) && !empty($_POST[$key])) ? htmlspecialchars($_POST[$key]) : null;
}

// Crypte mail et mot de passe
$params[':mail'] = md5(md5($params[':mail']) . strlen($params[':mail']));
$params[':pass'] = sha1(md5($params[':mail']) . md5($params[':pass']));
// var_dump($params);

include_once('inc/constants.inc.php');
try {
    // Connexion à la BDD
    $cnn = new PDO('mysql:host=' . HOST . ';port=' . PORT . ';dbname=' . DATA . ';charset=utf8', USER, PASS);
    // Options
    $cnn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $cnn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // Teste si le mail n'existe pas déjà
    $sql = 'SELECT COUNT(*) AS nb FROM users WHERE mail=?'; // paramètre anonyme
    $qry = $cnn->prepare($sql); // prépare la requête
    $qry->execute(array($params[':mail']));
    $row = $qry->fetch();
    var_dump($row);
    if ($row['nb'] == 1) {
        echo '<p>Cette adresse mail existe déjà !';
        echo '<a href="index.php">Retour à l\'accueil</a>';
    } else {
        $sql = 'INSERT INTO users(pseudo, mail, pass) VALUES(:pseudo, :mail, :pass)';
        $qry = $cnn->prepare($sql);
        $qry->execute($params);
        unset($cnn); // déconnexion
        header('location:index.php?m=ccok');
    }
} catch (PDOException $err) {
    $err->getMessage();
}
