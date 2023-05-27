<?php

class NormalizeData
{
    public function normalData($dataRalation, $dataMain, $oneToMany)
    {

        $dataRalationGroup = [];
        list($tableRelation, $foreignKey) = array_values(reset($oneToMany));
        foreach ($dataRalation as $dataRalations) {
            $dataRalationGroup[$dataRalations->$foreignKey][] = $dataRalations;
        }

        foreach ($dataMain as $dataMains) {
            $dataMains->product = $dataRalationGroup[$dataMains->id];
        }
        return $dataMain;
    }
}