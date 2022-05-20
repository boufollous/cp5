<?php

include_once('../class/database.class.php');

class Model extends dataBase {
    // attribus privé de la classe 

    private $db=null;
    private $table='';

    // contructeur
    public function __construct(string $newHost,string $newDbname,string $newUser,string $newPass,string $newTable ){
        $this->setTable($newTable);
        $this->db=new dataBase($newHost,$newDbname,$newUser,$newPass);
        
    }

    // axxesseur/mutateur pour table 

    public function setTable(string $newTable){
        $this->table=$newTable;
    }



    public function getTable():string{
        return $this->table;
    }
 /**
* renvois toute les lignes de la table
*/
public function readAll(): array{
    $sql = 'SELECT * FROM ' . $this->getTable();
    return $this->db->getResults($sql);
    }


       
    // methode ajoute une ligne dans la nouvelle table

    public function create(array $data) :bool{
        try {
        //remplit le tableux de paramettre pour la reqeut
        foreach ($data as $key => $value) {
        $params[':'.$key]=htmlspecialchars($value);
        // prepare et execute la reqeut
        $sql = 'INSERT INTO ' . $this->getTable() . '('.implode(',', array_keys($data)).')VALUES('.implode(',', array_keys($params)).')';
        echo $sql;
        }
        $qry=$this->db->cnn->prepare($sql);
        return $qry->execute($params);
        } catch (PDOException $err) {
        throw new Exception(__CLASS__ . ' : ' . $err->getMessage());
        }
        }
        
    /**
    * renvois un seul ligne de la table
    * @param string - $pk - column cles primare
    * @param string - $id - valeur de la cles primare
    * @return array
    * 
    */
    public function read(string $pk, string $id ): array{
    $sql = 'SELECT * FROM ' . $this->getTable() .' WHERE ' . $pk . '=?';
    $params = array($id);
    return $this->db->getResults($sql, $params);
    }
 
    

/**
 * modifie la table via la ligne et la valeur(l array  ) passé en parametre 
 * @ param array $data -tableau associatif contenant les données a remplacé dans la table
 * @param string $pk- clé primaire de la table
 * @param string $id -valeur de la clé primaire 
 * return bool renvoie true si 
 */
    public function updat(array $data, string $pk, string $id) :bool{
    //remplir le tableux de pram
    try {
    foreach ($data as $key => $value) {
    $params[':'.$key] = htmlspecialchars($value);
    $assign[] = $key . '=:'. $key;
    }
    $params[':id'] = $id;
    //prepare e execute (SQL)
    $sql = 'UPDATE ' . $this->getTable() . ' SET ' . implode(',', $assign) . ' WHERE ' . $pk .'=:id';
    $qry=$this->db->cnn->prepare($sql);
return $qry->execute($params);
} catch (PDOException $err) {
throw new Exception(__CLASS__ . ' : ' . $err->getMessage());
}
}
/**
 * suprime dans la table la ligne dont la ligne parametre 
 */
    public function delete(string $pk, string $id ) :bool{
        try{
            $sql='DELETE FROM '.$this->getTable().' WHERE ' .$pk.'=?';
            $params=array($id);
            $qry=$this->db->cnn->prepare($sql);
            return $qry->execute($params);
        }catch (PDOException $err) {
            throw new Exception(__CLASS__ . ' : ' . $err->getMessage());
            }
     
    }
    
}
?>