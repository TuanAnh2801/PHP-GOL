<?php

class Model
{
    protected $table;
    private $pdo;
    private $where = [];
    private $select = null;
    private $groupBy = null;
    private $having = null;
    private $orderBy = null;
    private $limit = null;
    private $offset = null;
    private $join = [];
    private $name;
    protected $attribute = [];
    private $conditionArr = [];

    public function __set($name, $price)
    {
        $this->attribute[$name] = $price;
    }

    public function __construct()
    {
        $this->connectData();
    }


    public function delete()
    {
        $table = $this->table;
        $namWhere = [];
        $valueData = [];
        foreach ($this->where as $key => $valueWhere) {
            $keyName = ':where_' . $key;
            $namWhere[] = $valueWhere['column'] . ' = ' . $keyName;

            $valueData[$keyName] = $valueWhere['value'];
        }
        $namWhere = implode(' AND ', $namWhere);

        $sql = "DELETE FROM $table WHERE ";
        if ($this->where) {
            $sql = $sql . $namWhere;


        }
        $tmp = $this->pdo->prepare($sql);

        $tmp->execute($valueData);
    }

    public function select($select)
    {
        if ($select) {
            $this->select = $select;
        } else {
            $this->select = '*';
        }
        return $this;

    }

    public function groupBy($groupBy)
    {
        if ($groupBy) {
            $this->groupBy = $groupBy;
        }
        return $this;

    }

    public function having($having)
    {
        if ($having) {
            $this->having = $having;
        }
        return $this;

    }

    public function orderBy($orderBy)
    {
        if ($orderBy) {
            $this->orderBy = $orderBy;
        }
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
            'type' => ' INNER',
            'tableJoin' => $tableJoin,
            'condition' => $condition
        ];
        return $this;

    }

    public function get()
    {

        $valueData = [];
        $sql = "SELECT ";
        if ($this->select) {
            $sql .= $this->select . ' FROM ' . $this->table;
        }
        if ($this->join) {
            foreach ($this->join as $valueJoin) {
                $sql .= $valueJoin['type'] . ' JOIN ' . $valueJoin['tableJoin'] . ' ON ' . $valueJoin['condition'];
            }

        }
        if ($this->where) {
            list($namWhere, $valueData) = $this->whereAnd();
            $sql .= ' WHERE ' . $namWhere;

        }
        if ($this->groupBy) {

            $sql .= ' GROUP BY ' . $this->groupBy;


        }
        if ($this->having) {

            $sql .= ' HAVING ' . $this->having;


        }
        if ($this->orderBy) {

            $sql .= ' ORDER BY ' . $this->orderBy;


        }
        if (is_numeric($this->limit)) {
            if (is_numeric($this->offset)) {
                $sql .= ' LIMIT ' . $this->offset . ', ' . $this->limit;
            } else {
                $sql .= ' LIMIT ' . $this->limit;

            }
        }
        echo $sql;
        $tmp = $this->pdo->prepare($sql);

        $tmp->execute($valueData);


        $product = $tmp->fetchAll(PDO::FETCH_ASSOC);
        echo '<pre>';
        print_r($product);

    }

    private function whereAnd()
    {
        $namWhere = [];
        $valueData = [];
        foreach ($this->where as $key => $valueWhere) {
            $keyName = ':where_' . $key;
            $namWhere[] = $valueWhere['column'] . $valueWhere['operator'] . $keyName;

            $valueData[$keyName] = $valueWhere['value'];

        }

        $namWhere = implode(' AND ', $namWhere);
        return [$namWhere, $valueData];

    }

    public function update($data)
    {
        $name = [];
        $namWhere = [];
        $valueData = [];
        $table = $this->table;
        foreach ($data as $key => $value) {
            $name[] = $key . ' = :' . $key;
            $valueData[$key] = $value;

        }
        $columns = implode(', ', $name);

        foreach ($this->where as $key => $valueWhere) {
            $keyName = ':where_' . $key;
            $namWhere[] = $valueWhere['column'] . ' = ' . $keyName;

            $valueData[$keyName] = $valueWhere['value'];
        }

        $namWhere = implode(' AND ', $namWhere);

        $sql = "UPDATE $table SET $columns WHERE ";
        if ($this->where) {
            $sql = $sql . $namWhere;
        }
        $tmp = $this->pdo->prepare($sql);

        $tmp->execute($valueData);

    }

    public function where()
    {
        $numArg = func_num_args();
        $args = func_get_args();
        if ($numArg === 2) {
            $columns = $args[0];
            $operator = '=';
            $value = $args[1];
        } elseif ($numArg === 3) {
            $columns = $args[0];
            $operator = $args[1];
            $value = $args[2];
        } else {
            $columns = null;
            $operator = null;
            $value = null;
        }
        $this->where[] = [
            'column' => $columns,
            'operator' => $operator,
            'value' => $value
        ];

        return $this;
    }

    public function save($product_model)
    {
        $data = [];
        foreach ($product_model->getFilable() as $value) {
            $method = 'get' . ucfirst($value);
            $data[$value] = $product_model->$method();
        }
        $this->attribute = $data;
        $this->insert($this->attribute);
    }

    public function insert($data)
    {
//        1. Xem output thư viện
//        2. Xem input cần đưa vào
        $table = $this->table;

        $columnKey = array_keys($data);
        $columns = implode(', ', $columnKey);
//        $why = str_replace('')
//        $playHolderSql = array_map(function ($item) {
//            return ':' . $item;
//        }, $columnKey);
//        $playHolderSql = implode(", ", $playHolderSql);
//        $sql = "INSERT INTO $table ($columns) VALUES (?,?,?)" ;
        $key = [];
        $value = [];
        foreach ($data as $values) {
            $key[] = '?';
            $value[] = $values;
        }
        $playHolderSql = implode(',', $key);
        $sql = "INSERT INTO $table ($columns) VALUES ($playHolderSql)";
        $tmp = $this->pdo->prepare($sql);
        $tmp->execute($value);
    }

    public function whereArray($conditionArr)
    {
        if (is_array($conditionArr) && count($conditionArr) ===1){
            $conditionArr = [$conditionArr];
        }
        foreach ($conditionArr as $itemArr) {
            list($columns, $operator, $value) = $itemArr;

            $this->where[] = [
                'column' => $columns,
                'operator' => $operator,
                'value' => $value
            ];
        }
        return $this;
    }

    public function connectData()
    {
        $host = '127.0.0.1';
        $db = 'gol_php';
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