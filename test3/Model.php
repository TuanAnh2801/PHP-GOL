<?php

class Model{
    private $pdo;
    private $select;
    protected $table;
    private $data;
    private $limit;
    private $offset;
    private $dataTable;
    private $condition;
    private $keyPr;
    private $column;
    private $primaryKeyColumn;
    public function __construct()
    {
        $this->connectDB();
        $this->pr();
    }
    public function pr(){

        $sql  = "SHOW KEYS FROM $this->table WHERE Key_name = 'PRIMARY'" ;


            $tmp = $this->pdo->prepare($sql);
            $tmp->execute();
       $row = $tmp->fetch(PDO::FETCH_ASSOC);
            $primaryKeyColumn = $row["Column_name"];

           return $this->primaryKeyColumn =$primaryKeyColumn;

    }
    public function find($keyPr,$column){
        $this->keyPr = $keyPr;
        $this->column = $column;

        if (!is_array( $this->keyPr)) {
            $sql = " SELECT $this->column FROM $this->table WHERE  $this->primaryKeyColumn = $this->keyPr";
            echo $sql;
            $tmp = $this->pdo->prepare($sql);
            $tmp->execute();
            $product = $tmp->fetchAll(PDO::FETCH_ASSOC);
            echo '<pre>';
            print_r($product);
        }
        else{

            $keyWhere = '';
        foreach ($this->keyPr as $value){
            $sql = " SELECT $this->column FROM $this->table WHERE  $this->primaryKeyColumn = $value";
            $tmp = $this->pdo->prepare($sql);
            $tmp->execute();
            $product = $tmp->fetchAll(PDO::FETCH_ASSOC);
            echo '<pre>';
            print_r($product);
        }

        }
    }

    public function insert($data){
        $this->data = $data;
        $keyAr = array_keys( $this->data );
        $keyData = implode(' , ',$keyAr);
        $keyValue = array_map(function ($item){
            return ':'.$item;
        },$keyAr);

        $keyValue = implode(' , ',$keyValue);
        $sql = " INSERT INTO  $this->table ($keyData ) VALUES ($keyValue)";

        $tmp  = $this->pdo->prepare($sql);
        $tmp->execute($this->data);
    }
    public function limit($limit,$offset){
     $this->limit  =  $limit;
     $this->offset = $offset;
     return $this;
    }
    public function join($dataTable,$condition){
        $this->join[] = [
            'join' => ' INNER',
            'table'=> $dataTable,
            'condition' => $condition
        ];

        return $this;
    }
    public function select($select){
       if ($select){
           $this->select = $select;
       }
      else
       $this->select = '*';

       return $this;
    }
    public function get(){
        $sql = ' SELECT ';
        $value_where= [];
        if ($this->select){
            $sql .=  $this->select . ' FROM '. $this->table;
        }
//        if ($this->where){
//            list($key_where , $value_where) = $this->whereAnd();
//            $sql .= ' WHERE ' . $key_where;
//
//        }
        if (is_numeric($this->limit)){
            if (is_numeric($this->offset)){
                $sql .= ' LIMIT ' . $this->offset . ','.$this->limit;
            }
            else
                $sql .=  ' LIMIT ' . $this->offset ;

        }

//        if ($this->join){
//            foreach ($this->join as $valueJoin){
//                $sql .= $valueJoin['join'] . ' JOIN ' . $valueJoin['table'] . ' ON ' . $valueJoin['condition'];
//            }
//        }

        $tmp = $this->pdo->prepare($sql);
        $tmp->execute($value_where);
        $product = $tmp->fetch(PDO::FETCH_ASSOC);
        echo $sql;
        echo '<pre>';
        print_r($product);

    }
    public function whereAnd(){
        $key_where = [];
        $value_where = [];
            foreach ($this->where as $key => $value){
                $where = ':where_'.$key;
                $key_where[] = $value['column'] . $value['operation'] . $where;
                $value_where[$where] = $value['value'];
            }
        $key_where = implode(' AND ',$key_where);

            return [$key_where , $value_where];

    }
    public function where(){
        $numAr = func_num_args();
        $vulAr = func_get_args();
        if ($numAr === 2){
            $column = $vulAr[0];
            $operation = ' =';
            $value = $vulAr[1];
        }
        elseif ($numAr === 3){
            $column = $vulAr[0];
            $operation = $vulAr[1];
            $value = $vulAr[2];
        }
        else{
            $column = null;
            $operation = null;
            $value = null;
        }
        $this->where[] = [
            'column' =>$column,
            'operation'=>$operation,
            'value' => $value
        ];
        return $this;
        }
public function test(){
        $sqlCategory = "SELECT * FROM category";
        $tmp = $this->pdo->prepare($sqlCategory);
        $tmp->execute();
        $category = $tmp->fetchAll(PDO::FETCH_OBJ);

        $idCategory = [];
        foreach ($category as $categories){
            $idCategory[] = $categories->id;
        }

    $idCategory = implode(',',$idCategory);
    $sqlProduct = "SELECT * FROM products WHERE category_id IN($idCategory)";
    $stmp = $this->pdo->prepare($sqlProduct);
    $stmp->execute();
    $product  = $stmp->fetchAll(PDO::FETCH_OBJ);
    $keyProduct = [];
    foreach ($product as $products){
        $key = $products->category_id;
        $keyProduct[$key][]= $products;
    }

    foreach ($category as $categories){
        $categories->product = $keyProduct[$categories->id];
    }
    echo '<pre>';
    print_r($category);
}

    public function connectDB(){
        $host = '127.0.0.1';
        $db   = 'gol_php';
        $user = 'root';
        $pass = '';
        $port = "3306";
        $charset = 'utf8mb4';


        $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
        try {
            $this->pdo = new \PDO($dsn, $user, $pass);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}