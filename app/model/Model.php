<?php 

namespace App\Model;

use ReflectionClass;

class Model {
    private $pdo;
    protected static $table;
    protected $where;
    protected $orderBy;
    protected $limit;

    public function __construct() {
        try {
            $pdo = new \PDO('mysql:host='.dbConfig()['host'].';dbname='.dbConfig()['dbname'], dbConfig()['nickname'], dbConfig()['password']);
            $this->pdo = $pdo;
        } catch (\Throwable $th) {
            die("Mysql bağlantınız kurulamadı " . $th->getMessage());
        }
    }

    public function where(array $conditions) {
        $class = new self;
        $sqlWhere = [];

        foreach ($conditions as $key => $value) {
            $sqlWhere[] = "$key = $value";
        }

        $sqlWhere = implode(' AND ', $sqlWhere);

        $this->where = $sqlWhere;

        return $this;
    }

    public function orderBy(string $column, string $ordered = 'ASC') {
        $this->orderBy = " ORDER BY $column $ordered";

        return $this;
    }

    public function limit(int|string $limit = 10) {
        $this->limit = " LIMIT $limit";

        return $this;
    }

    public static function table() {
        $class = new self;
        $calledClass = get_called_class();
        $ref = new \ReflectionClass($calledClass);
        $shortRef = strtolower($ref->getShortName())."s";

        $class::$table = $shortRef;

        return $class;
    }

    public function get() {
        $class = new self;
        
        $sql = "SELECT * FROM " . $class::$table . " " . $this->where . " " . $this->orderBy . " " . $this->limit;
        $query = $this->pdo->query($sql);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}