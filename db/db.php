<?php

class Database {

    private static $bdd = null;

    public static function getBdd() {
        if (is_null(self::$bdd)) {
            self::$bdd = new PDO("mysql:host=" . Bootstrap::$params['db']['host'] . ";dbname=" . Bootstrap::$params['db']['database'], Bootstrap::$params['db']['username'], Bootstrap::$params['db']['password']);
        }
        return self::$bdd;
    }

}

?>