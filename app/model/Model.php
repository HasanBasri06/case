<?php 

namespace App\Model;

use ReflectionClass;

class Model {
    private $pdo;
    protected static $table = [];
    protected $where;
    protected $orderBy;
    protected $limit;
    protected $get = [];
    protected $getWith = [];
    protected $with = '';

    public function __construct() {
        try {
            $pdo = new \PDO('mysql:host='.dbConfig()['host'].';dbname='.dbConfig()['dbname'], dbConfig()['nickname'], dbConfig()['password']);
            $this->pdo = $pdo;
        } catch (\Throwable $th) {
            die("Mysql bağlantınız kurulamadı " . $th->getMessage());
        }
    }

    public function where(mixed $key, mixed $value) {
        $sqlWhere = [];

        $sqlWhere = [$key => $value];
        dd($sqlWhere);die;

        
        $sqlWhere = implode(' AND ', $sqlWhere);
        $this->where = ' WHERE ' . $sqlWhere;


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

        $class::$table[] = $ref->getNamespaceName();
        $class::$table[] = $shortRef;

        return $class;
    }

    public function execute($type = 'single') {
        $class = new self;
        
        $sql = "SELECT * FROM " . $class::$table[1] . " " . $this->where . " " . $this->orderBy . " " . $this->limit;
        $query = $this->pdo->query($sql);
        $query->execute();

        if ($type == 'single') {
            return $this->get = $query->fetch(\PDO::FETCH_ASSOC);
        }

        return $this->get = $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function with(string $name) {
        $this->with = $name;

        return $this;
    }

    public function withParameter() {
        $class = new self;
        $getter = $this->get;
        $collect = [];
        $className = ucfirst(rtrim($class::$table[1], 's'));
        $model = $class::$table[0]."\\".$className;
        $method = $this->with;

        try {
            $relatedClass = (new $model)->$method();
        } catch (\Throwable $th) {
            die($className . " sınıfında " . $method." ilişkisi bulunamadı");
        }

        $ref = new ReflectionClass($relatedClass);
        $tableName = strtolower($ref->getShortName()."s");

        foreach ($getter as $data) {
            $QRY = "SELECT * FROM " . $tableName . " WHERE id" . " = " . $data[$method."_id"];
            $prepare = $this->pdo->query($QRY);
            $prepare->execute();

            $collect[] = ["data" => $data, $method => [$prepare->fetchAll(\PDO::FETCH_ASSOC)]];
        }

        $this->get = $collect;
    }

    public function first() {
        return $this->execute('single');
    }

    public function get() {
        $this->execute('multiple');

        if ($this->with !== '') {
            $this->withParameter();
        }

        return $this->get;    
    }

    public function exist() {
        return count($this->execute('multiple')) > 0 ? true : false;
    }
}