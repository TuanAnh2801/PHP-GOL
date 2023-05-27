<?php

class OneToMany
{
    public function oneToMany($category, $oneToMany,$pdo)
    {
        $idCategory = [];
        foreach ($category as $categories) {
            $idCategory[] = $categories->id;
        }
        $idCategory = implode(', ', $idCategory);
        foreach ($oneToMany as $item) {
            $tableRelation = $item['tableRalation'];
            $foreignKey = $item['foreignKey'];
        }
        $sql = "SELECT * FROM $tableRelation WHERE $foreignKey IN ($idCategory)";
        $stmt = $pdo->prepare($sql);
        // thuc thi sql
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }
}