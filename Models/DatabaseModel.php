<?php

class Database
{
    private static $pdo;

    /**
     * set connection with database (initialisation of $pdo)
     **/

    private static function setDatabase()
    {
        require_once '../init/identifier.php';

        self::$pdo = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8", $username, $password);
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function getDatabase(): object
    {
        if (self::$pdo === null) {
            self::setDatabase();
        }
        return self::$pdo;
    }

    public function getTableInfos($inWhatTable): array
    {
        $tableQuery = 'SELECT * FROM `projet_bdd`.' . $inWhatTable;
        $stmt = $this->getDatabase()->prepare($tableQuery);
        $stmt->execute();
        return $stmt->fetchAll();


    }

    public function getPreciseInfo($inWhatTable, $whatInfoYouSearch, $attribute, $conditionToCheck): array
    {
        $whatInfoYouSearch = (string)$whatInfoYouSearch;
        $tableQuery = "SELECT * FROM `projet_bdd` . " . $inWhatTable . ' WHERE '.$attribute.' = :conditionToCheck';
        $stmt = $this->getDatabase()->prepare($tableQuery);

        $stmt->bindParam('conditionToCheck', $conditionToCheck);

        $stmt->execute();
        $datas = $stmt->fetchAll();
        foreach ($datas as $userdata) {
            $data[] = $userdata[$whatInfoYouSearch];
        }
        return $data;
    }
}