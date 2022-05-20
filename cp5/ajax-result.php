<?php
//import
include_once('inc/constants.inc.php');
include_once('class/database.class.php');
$db=new database(HOST,DATA,USER,PASS);

//execute la requete 
if(isset($_GET['lang'])&& !empty($_GET['lang'])){
$sql='SELECT c.Code, c.Name, c.Continent, c.Region,
 c.SurfaceArea, 
 c.IndepYear,
  c.LifeExpectancy 
  FROM country c 
  JOIN countrylanguage l ON c.Code = l.CountryCode WHERE l.Language = ?';
  echo $db->getHtmlTable($sql, array($_GET['lang']));
  }else{
      echo '<div class="alert alert-danger" >
    aucune donnée a afficher
    </div>';
  }
?>