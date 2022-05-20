<?php
//mini frameWord 
//conextion a une base de donne mysql ou mariadb
class dataBase{
//attribute
private $host;
private $dbname;
private $user;
private $pass;
//generer par le construucture
protected $cnn;
private $connected=false;

//construecteur
public function __construct(string $newHost, string $newDbname, string $newUser, string $newPass){
$this->setHost($newHost);
$this->setDbname($newDbname);
$this->setUser($newUser);
$this->setPass($newPass);
try{
//connextion
$this->cnn = new PDO('mysql:host='.$this->getHost().";dbname=".$this->getDbname().";charset=utf8",
$this->getUser(), $this->getPass());
$this->cnn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$this->connected = true;
}catch(PDOException $err){
throw new Exception(__CLASS__ . ' : '. $err->getMessage());
}
}
//accesseur/mutateur(changeur de l'etat de l'attribute)
public function setHost(string $newHost){
$this->host=$newHost;
}
public function getHost(): string{
return $this->host;
}

public function setDbname(string $newDbname){
$this->dbname=$newDbname;
}
public function getDbname(): string{
return $this->dbname;
}

public function setUser(string $newUser){
$this->user = $newUser;
}
public function getUser(): string{
return $this->user;
}

public function setPass(string $newPass){
$this->pass = $newPass;
}
public function getPass(): string{
return $this->pass;
}
/**
* Renvoie l'ecart en annees entre deux date passer an parametre
* @param string $sql - instruction SQL preparer de type SELECT
* @param array $params - valeurs des parametre de lma reqeut
* @return array
* */
public function getResults(string $sql, array $params=array()) :array{
try{
//prepare requet
$qry = $this->cnn->prepare($sql);
$qry->execute($params);
return $qry->fetchAll();
}catch(PDOException $err){
throw new Exception(__CLASS__ . ' : '. $err->getMessage());
}
}
public function getJSON(string $sql, array $params=array()) :string{
$data = $this->getResults($sql, $params);
return json_encode($data);
}

/**
* renvoie sous la forme d'un tableux html le resultat d'une reqeut sql parametrer
* @param $sql - reqeut SQL de type SELECT parametrer
* @param array $params - tableux content les valeurs assoucier de la requet SQL (par defaut vide)
* @return string code HTML correspendant au tableux rempli
*/
public function getHtmlTable(string $sql, array $params=array()) :string{
//recupere sous la forme d'un tableux associatife le resultat de la reqeut SQL
// $data = $this->getResults($sql, $params);
// //var_dump($data);

$qry =$this->cnn->prepare($sql);
$qry->execute($params);
// entete du tbleau html
$html='<table class="table table-striped">';
$html.='<thead><tr>';
for($i=0;$i<$qry->columnCount(); $i++){
    $meta=$qry->getColumnMeta($i);
    $html.='<th>'.$meta['name'].'</th>';

}
$html.='</tr></thead><tbody>';



//parcourir le 1er array
foreach($qry->fetchAll() as $row){
    $html .='<tr>';
    // parcourt le second array
    foreach ($row as $key =>$val){
        $html .='<td>'.$val.'</td>';
    }
    $html.='</tr>';


}
$html.="</tbody></table>";
return $html;
}


public function getHtmlSelect(string $id ,string $sql, array $params=array()) :string{
    //prepare et execute de la reqeut
    $qry = $this->cnn->prepare($sql);
    $qry->execute($params);
    //recupere le resultat dans un tableux indexer
    $data = $qry->fetchAll(PDO::FETCH_NUM);
    $html = '<select class"form-control" id="'.$id.'">';
    foreach ($data as $value) {
    //si une seul column
    if ($qry->columnCount() === 1) {
    $html .= '<option value="'.$value[0].'">'.$value[0].'</option>';
    }else{
    $html .= '<option value="'.$value[0].'">'.$value[1].'</option>';
    }
    }
    $html.= '<select/>';
    return $html; 
    }
}    
?>