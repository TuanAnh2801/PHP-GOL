<?php

class Model
{

    protected $table;

    private $pdo;

    protected $oneToMany = [];

    protected $primaryKey = 'id';

    private $where = [];

    private $select = null;

    private $groupBy = null;

    private $having = null;

    private $orderBy = null;

    private $limit = null;

    private $offset = null;

    private $join = [];

    protected $attribute = [];

    public function __set($name, $value)
    {
        $this->attribute[$name] = $value;
    }

    public function __get($name)
    {
        $this->$name();
    }

    public function __construct()
    {
        $this->pdo = $this->connectPdo();
    }

    public function insert($data): bool|int
    {
        $table = $this->table;
        $columnKey = array_keys($data);
        $columns = implode(', ', $columnKey);

        $tmpPlaceHolder = [];
        $values = [];
        foreach ($data as $value) {
            $tmpPlaceHolder[] = '?';
            $values[] = $value;
        }

        $placeHolderSql = implode(', ', $tmpPlaceHolder);
        $sql = "INSERT INTO $table ($columns) VALUES ($placeHolderSql)";
        // chuan bi sql
        $stmt = $this->pdo->prepare($sql);
        // thuc thi sql
        $dataExcute = $stmt->execute($values);
        if ($dataExcute) {
            $lastInsertId = $this->pdo->lastInsertId();
        }
        if ($lastInsertId) {
            return $lastInsertId;
        }

        return false;
    }


    public function delete()
    {
        $table = $this->table;
        $tmpWhere = [];
        foreach ($this->where as $key => $valueWhere) {
            $keyWhere = 'where_' . $key;
            $tmpWhere[] = $valueWhere['column'] . ' ' . $valueWhere['operator'] . ' :' . $keyWhere;
            $dataExcute[$keyWhere] = $valueWhere['value'];

        }
        $where = implode(' AND ', $tmpWhere);
        $sql = "DELETE FROM $table WHERE ";
        if ($this->where) {
            $sql = $sql . $where;
        }

        $stmt = $this->pdo->prepare($sql);
        // thuc thi sql
        $dataExcute = $stmt->execute($dataExcute);

    }

    public function select($select)
    {
        if ($select) {
            $this->select = $select;
        } else {
            $this->select = "*";
        }

        return $this;
    }

    public function groupBy($groupBy)
    {
        $this->groupBy = $groupBy;
        return $this;
    }


    public function having($having)
    {
        $this->having = $having;
        return $this;
    }

    public function orderBy($orderBy)
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    public function limit($limit, $offset)
    {
        $this->limit = $limit;
        $this->offset = $offset;

        return $this;
    }

    public function join($tableJoin, $condition)
    {
        $this->join[] = [
            'type' => 'INNER',
            'tableJoin' => $tableJoin,
            'condition' => $condition
        ];
        return $this;
    }


    public function get()
    {
        $dataWhere = [];
        // SELECT CustomerName, City, Country FROM Customers;
        $sql = "SELECT ";

        // select
        if ($this->select) {
            $sql = $sql . $this->select . ' FROM ' . $this->table;
        }

        // join INNER JOIN Customers ON Orders.CustomerID=Customers.CustomerID;
        if ($this->join) {
            foreach ($this->join as $valueJoin) {
                $sql = $sql . ' ' . $valueJoin['type'] . ' JOIN ' . $valueJoin['tableJoin'] . ' ON ' . $valueJoin['condition'];
            }
        }

        // where
        if ($this->where) {
            list($where, $dataWhere) = $this->whereAnd();
            $sql = $sql . ' WHERE ' . $where;
        }

        // group by
        if ($this->groupBy) {
            $sql = $sql . ' GROUP BY ' . $this->groupBy;
        }

        // having
        if ($this->having) {
            $sql = $sql . ' HAVING ' . $this->having;
        }

        // order
        if ($this->orderBy) {
            $sql = $sql . ' ORDER BY ' . $this->orderBy;
        }

        // limit
        // LIMIT [offset,] row_count;
        if (is_numeric($this->limit)) {
            if (is_numeric($this->offset)) {
                $sql = $sql . ' LIMIT ' . $this->offset . ', ' . $this->limit;
            } else {
                $sql = $sql . ' LIMIT ' . $this->limit;
            }
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($dataWhere);
//        echo '<pre>';
//        print_r($this->oneToMany);
        // thuc thi sql
        $dataMain = $stmt->fetchAll(PDO::FETCH_OBJ);
        if ($this->oneToMany) {
            foreach ($this->oneToMany as $itemData) {
                $oneToMay = new OneToMany();
                $dataRelation = $oneToMay->oneToMany($dataMain, $itemData, $this->pdo, $this->primaryKey);
                echo '<pre>';
                print_r($dataRelation);
            }
        }


    }

    private function whereAnd()
    {
        $tmpWhere = [];
        $dataWhere = [];
        foreach ($this->where as $key => $valueWhere) {
            $keyWhere = 'where_' . $key;
            $tmpWhere[] = $valueWhere['column'] . ' ' . $valueWhere['operator'] . ' :' . $keyWhere;
            $dataWhere[$keyWhere] = $valueWhere['value'];

        }
        $where = implode(' AND ', $tmpWhere);

        return [$where, $dataWhere];
    }


    public function update($data)
    {
        $table = $this->table;

        $dataExcute = [];
        foreach ($data as $key => $value) {
            $tmpKey[] = $key . ' = :' . $key;
            $dataExcute[$key] = $value;
        }
        $column = implode(', ', $tmpKey);

        $tmpWhere = [];
        foreach ($this->where as $key => $valueWhere) {
            $keyWhere = 'where_' . $key;
            $tmpWhere[] = $valueWhere['column'] . ' ' . $valueWhere['operator'] . ' :' . $keyWhere;
            $dataExcute[$keyWhere] = $valueWhere['value'];

        }

        $where = implode(' AND ', $tmpWhere);
        $sql = "UPDATE $table SET $column WHERE ";

        // check have where
        if ($this->where) {
            $sql = $sql . $where;
        }

        $sql = "UPDATE $table SET $column WHERE $where";
        $stmt = $this->pdo->prepare($sql);
        // thuc thi sql
        $dataExcute = $stmt->execute($dataExcute);

    }

    public function where()
    {

        $numArg = func_num_args();
        $args = func_get_args();

        if ($numArg === 2) {
            $column = $args[0];
            $operator = '=';
            $value = $args[1];
        } elseif ($numArg === 3) {
            $column = $args[0];
            $operator = $args[1];
            $value = $args[2];
        } else {
            $column = null;
            $operator = null;
            $value = null;
        }

        $this->where[] = [
            'column' => $column,
            'operator' => $operator,
            'value' => $value
        ];

        return $this;

    }

    public function connectPdo()
    {
        $host = '127.0.0.1';
        $db = 'laravel';
        $user = 'root';
        $pass = '';
        $port = "3306";
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";

        try {
            return new \PDO($dsn, $user, $pass);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }


    public function save($instanceObj)
    {


        $data = [];
        foreach ($instanceObj->getFilAble() as $value) {
            $method = 'get' . ucfirst($value);
            $data[$value] = $instanceObj->$method();
        }
        $this->attribute = $data;

    }

    public function whereArray($conditionArray)
    {

        if (is_array($conditionArray) && count($conditionArray) === 1) {
            $conditionArray = [$conditionArray];
        }

        foreach ($conditionArray as $itemArray) {

            list($column, $operator, $value) = $itemArray;

            $this->where[] = [
                'column' => $column,
                'operator' => $operator,
                'value' => $value
            ];

        }

        return $this;

    }


    public function test()
    {

        // 3 category -> N -> N + 1 -> 2
        $sqlCategory = "SELECT * FROM category";

        $stmt = $this->pdo->prepare($sqlCategory);
        $stmt->execute();
        // thuc thi sql
        $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
//        echo "<pre>";
//        print_r($categories);
        // lay id chinh de query sang bang phu

        $idCategorys = [];

        foreach ($categories as $categoryItem) {
            $idCategorys[] = $categoryItem->id;
        }

        $idCategorysIn = implode(', ', $idCategorys);


        // query lay data bang phu
        $sqlProducts = "SELECT * FROM products WHERE category_id IN ($idCategorysIn)";
        $stmt = $this->pdo->prepare($sqlProducts);
        $stmt->execute();
        // thuc thi sql
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);
//        echo "<pre>";
//        print_r($products);


        // chuan hoa du lieu
        $productGroup = [];
        foreach ($products as $productItem) {
            $key = $productItem->category_id;
            $productGroup[$key][] = $productItem;


        }
//        echo '<pre>';
//        print_r($productGroup);


        foreach ($categories as $categoryItem) {
            $categoryItem->product = $productGroup[$categoryItem->id];
        }


        echo "<pre>";
        print_r($categories);
        echo "<hr/>";


    }

    public function with($modelRelation)
    {
        foreach ($modelRelation as $modelRelations) {
            $this->$modelRelations();
        }
        return $this;
    }

    public function oneToMany()
    {
        $sqlCategory = "SELECT * FROM category ";
        $tmp = $this->pdo->prepare($sqlCategory);
        $tmp->execute();
        $categories = $tmp->fetchAll(PDO::FETCH_OBJ);

        $keyCategory = [];
        foreach ($categories as $category) {
            $keyCategory[] = $category->id;
        }
        $keyCategory = implode(',', $keyCategory);

        $sqlProduct = "SELECT * FROM products WHERE category_id in($keyCategory)";
        $tmp = $this->pdo->prepare($sqlProduct);
        $tmp->execute();
        $products = $tmp->fetchAll(PDO::FETCH_OBJ);
        $productGroup = [];
        foreach ($products as $product) {
            $keyProduct = $product->category_id;
            $productGroup[$keyProduct] = $product;
        }

        foreach ($categories as $category) {
            $category->product = $productGroup[$category->id];

        }
        echo '<pre>';
        print_r($categories);
    }

    public function beLongTo()
    {
        $sqlProduct = "SELECT * FROM products";
        $tmp = $this->pdo->prepare($sqlProduct);
        $tmp->execute();
        $products = $tmp->fetchAll(PDO::FETCH_OBJ);
        $keyProduct = [];
        foreach ($products as $product) {
            $keyProduct[] = $product->category_id;
        }
        $keyProduct = implode(',', $keyProduct);
        $sqlCategory = "SELECT * FROM category WHERE id in($keyProduct)";
        $tmp = $this->pdo->prepare($sqlCategory);
        $tmp->execute();
        $categories = $tmp->fetchAll(PDO::FETCH_OBJ);
        $categoryGroup = [];
        foreach ($categories as $category) {
            $keyCategory = $category->id;
            $categoryGroup[$keyCategory] = $category;
        }
        foreach ($products as $product) {
            $product->category = $categoryGroup[$product->category_id];
        }
        echo '<pre>';
        print_r($products);
    }

    public function manyToMany()
    {
        $sqlProduct = "SELECT * FROM products";
        $tmp = $this->pdo->prepare($sqlProduct);
        $tmp->execute();
        $products = $tmp->fetchAll(PDO::FETCH_OBJ);
        $keyProduct = [];
        foreach ($products as $product) {
            $keyProduct[] = $product->id;
        }
        $keyProduct = implode(',', $keyProduct);
        $sqltag = "SELECT * FROM tags INNER JOIN product_tag ON tags.id=product_tag.tag_id WHERE product_tag.product_id IN($keyProduct)";
        $tmp = $this->pdo->prepare($sqltag);
        $tmp->execute();
        $tags = $tmp->fetchAll(PDO::FETCH_OBJ);
        $tagGroup = [];
        foreach ($tags as $tag) {
            $keyTag = $tag->product_id;
            $tagGroup[$keyTag][] = $tag;
        }
        foreach ($products as $product) {
            $product->tag = $tagGroup[$product->id] ?? [];
        }
        echo '<pre>';
        print_r($products);
    }

    public function hasMany($className, $poreignKey)
    {
        $classIntance = new $className();
        $tableRelation = $classIntance->table;
        $this->oneToMany[] = [
            'tableRelation' => $tableRelation,
            'poreignKey' => $poreignKey
        ];
        return $this;
    }

}