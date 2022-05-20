<?php
// Imports
include_once('inc/constants.inc.php');
include_once('class/database.class.php');

// Exécute la requête
if (isset($_GET['lang']) && !empty($_GET['lang'])) {
    $sql = 'SELECT c.Code, 
        c.Name, 
        c.continent, 
        c.Region, 
        c.SurfaceArea, 
        c.IndepYear, 
        c.Population, 
        c.LifeExpectancy
        FROM country c
        JOIN countrylanguage l
        ON c.code = l.countrycode
        WHERE l.Language = ?';
    $db = new Database(HOST, DATA, USER, PASS);
    echo $db->getHtmlTable($sql, array($_GET['lang']));
} else {
    echo '<div class="alert alert-danger">Aucune donnée à afficher</div>';
}
