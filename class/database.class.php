<?php
/**
 * Mini-framework :
 * Connexion à une base de données MySQL ou MariaDB
 * et exploitation
 */
class Database
{
    // Attributs privés
    private $host;
    private $dbname;
    private $user;
    private $pass;
    protected $cnn; // généré par le constructeur
    private $connected = false; // généré par le constructeur

    // Constructeur
    public function __construct(string $newHost, string $newDbname, string $newUser, string $newPass)
    {
        // Assigne la valeur des paramètres aux attributs 
        $this->setHost($newHost);
        $this->setDbname($newDbname);
        $this->setUser($newUser);
        $this->setPass($newPass);

        // Tente une connexion à la BDD
        try {
            // Connexion
            $this->cnn = new PDO('mysql:host=' . $this->getHost() . ';dbname=' . $this->getDbname() . ';charset=utf8', $this->getUser(), $this->getPass());
            // Options de connexion : erreur + type de renvoi
            $this->cnn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->cnn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->connected = true;
        } catch (PDOException $err) {
            throw new Exception(__CLASS__ . ' : ' . $err->getMessage());
        }
    }

    // Accesseurs/Mutateurs
    public function setHost(string $newHost)
    {
        $this->host = $newHost;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function setDbname(string $newDbname)
    {
        $this->dbname = $newDbname;
    }

    public function getDbname(): string
    {
        return $this->dbname;
    }

    public function setUser(string $newUser)
    {
        $this->user = $newUser;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function setPass(string $newPass)
    {
        $this->pass = $newPass;
    }

    public function getPass(): string
    {
        return $this->pass;
    }

    /**
     * Méthode qui renvoie le résultat d'une requête dont l'instruction est passée en paramètre 
     * @param string $sql - instruction SQL préparée de type SELECT
     * @param array $params - valeurs des paramètres pour la requête préparée
     * @return array
     */
    public function getResult(string $sql, array $params = array()): array
    {
        try {
            // Prépare la requête
            $qry = $this->cnn->prepare($sql);
            $qry->execute($params);
            return $qry->fetchAll();
        } catch (PDOException $err) {
            throw new Exception(__CLASS__ . ' : ' . $err->getMessage());
        }
    }

    public function getJSON(string $sql, array $params = array()): string
    {
        $data = $this->getResult($sql, $params);
        return json_encode($data);
    }

    /**
     * Renvoie sous la forme d'un tableau HTML le résultat d'une requête SQL paramétrée
     * @param string $sql - requête SQL de type SELECT paramétrée
     * @param array $params - tableau contenant les valeurs à associer aux paramètres de la requête SQL (par défaut vide)
     * @return string code HTML correspondant au tableau rempli
     */
    public function getHtmlTable(string $sql, array $params = array()): string
    {
        // Récupère sous la forme d'un tableau associatif le résultat de la requête SQL
        $qry = $this->cnn->prepare($sql);
        $qry->execute($params);

        // En-tête du tableau HTML
        $html = '<table class="table table-striped">';
        $html .= '<thead class="thead-dark"><tr>';
        for ($i = 0; $i < $qry->columnCount(); $i++) {
            $meta = $qry->getColumnMeta($i);
            $html .= '<th>' . $meta['name'] . '</th>';
        }
        $html .= '</tr></thead><tbody>';

        // Parcourt le 1er array
        foreach ($qry->fetchAll() as $row) {
            $html .= '<tr>';
            // Parcourt le 2nd array
            foreach ($row as $key => $val) {
                $html .= '<td>' . $val . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';
        return $html;
    }

    public function getHtmlSelect(string $id, string $sql, array $params = array()): string
    {
        // Prépare et exécute la requête
        $qry = $this->cnn->prepare($sql);
        $qry->execute($params);

        // Récupère le résultat dans un tableau indexé
        $data = $qry->fetchAll(PDO::FETCH_NUM);
        $html = '<select class="form-control" id="' . $id . '">';
        foreach ($data as $val) {
            // Si une seule colonne
            if ($qry->columnCount() === 1) {
                $html .= '<option value="' . $val[0] . '">' . $val[0] . '</option>';
            } else {
                $html .= '<option value="' . $val[0] . '">' . $val[1] . '</option>';
            }
        }
        $html .= '</select>';
        return $html;
    }
}
