<?php

class Database
{
    private static $pdo;

    /**
     * set connection with database (initialisation of $pdo)
     **/

    private static function setDatabase()
    {
        require_once 'init/identifier.php';

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

    public function getDbInfos($inWhatTable, $whatInfoYouSearch,$secondInfoYouSearch): array
    {
        settype($whatInfoYouSearch, "string");
        settype($secondInfoYouSearch, "string");
        $tableQuery = 'SELECT * FROM `projet_bdd`.'.$inWhatTable.'';
        $stmt = $this->getDatabase()->prepare($tableQuery);
        $stmt->execute();
        $infos = $stmt->fetchAll();

        if ($secondInfoYouSearch === '') {
            foreach ($infos as $info) {
                $tableInfo[] = $info[$whatInfoYouSearch];
            }
        }
        else {
            foreach ($infos as $info) {
                $tableInfo[] = ($info[$whatInfoYouSearch].' '.$info[$secondInfoYouSearch]);
            }
        }
        return $tableInfo;
    }
}
