<?php
class OneToMany{
    public function oneToMany($dataMain,$itemData, $pdo,$primaryKey){
        $idGroup = [];
        foreach ($dataMain as $dataMains){
            $idGroup[]= $dataMains->$primaryKey;
        }
        $idGroup = implode(',',$idGroup);

        list($tableRelation, $foreignKey) = array_values($itemData);
//        echo '<pre>';
//        print_r($tableRelation);
        $sqlRalation = "SELECT * FROM $tableRelation WHERE $foreignKey IN ($idGroup)";
        $tmp = $pdo->prepare($sqlRalation);
        $tmp->execute();
        $data = $tmp->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }
}