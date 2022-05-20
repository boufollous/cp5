<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<title>Document</title>
</head>
<body class="">
<?php
//les import
include_once('inc/constants.inc.php');
include_once('class/database.class.php');
$db = new dataBase(HOST, DATA, USER, PASS);
echo '<h2> les langues</h2>';
$sql = 'SELECT DISTINCT language FROM countrylanguage ORDER BY language';
echo $db->getHtmlSelect('lang', $sql);
?>
<div id="pays" class="mt-3">
<?php
$sql = 'SELECT Code,Name,Continent,Region,SurfaceArea,IndepYear,Population,LifeExpectancy FROM country';
echo $db->getHtmlTable($sql);
?>
</div>



</body>
<script src="./js/ajax.js"></script>
</html>