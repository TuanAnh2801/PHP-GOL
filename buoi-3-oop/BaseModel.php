<?php

class BaseModel
{
    protected $table;
    private $pdo;
    public function __construct($table)
    {
        $this->table = $table;
        $this->connectDatabase();
    }

    public function create($dataCreate)
    {

        $table = $this->table;
        $key = array_keys($dataCreate);
        $colums = implode(",", $key);
        $keyMap = array_map(function ($item){
            return ":" .$item;
        },$key);

        $valueColumn = implode(",",$keyMap);

        $sql = "INSERT INTO $table($colums) VALUES ($valueColumn)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($dataCreate);


    }

    public function connectDatabase()
    {
        $host = '127.0.0.1';
        $db = 'php0922e2_crud';
        $user = 'root';
        $pass = '';
        $port = "3306";
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
        try {
            $this->pdo = new \PDO($dsn, $user, $pass);
            var_dump('connect success');
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }


}
