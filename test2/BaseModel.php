<?php
class BaseModel{
protected $table;
private $pdo;
public function __construct($table)
{
    $this->table = $table;
    $this->connectData();
}

public function create($dataTable){
    $table = $this->table;
    $nameData = array_keys($dataTable) ;
    $key = implode(',',$nameData);
    $value = array_map(function ($item){
        return ':' .$item;
    },$nameData);
   $valueData= implode(',',$value);
    $sql = "INSERT INTO $table($key) VALUES ($valueData)";
    $sql_insert = $this->pdo->prepare($sql);
    $sql_insert->execute($dataTable);

}
public function connectData(){
    $host = '127.0.0.1';
    $db   = 'php0922e2_crud';
    $user = 'root';
    $pass = '';
    $port = "3306";
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
    try {
        $this->pdo = new \PDO($dsn, $user, $pass);
        var_dump('thanh cong');
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}
}