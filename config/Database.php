<?php
namespace Config;

use MongoDB\Driver\Manager;
use MongoDB\Driver\Exception\Exception;

class Database
{
    public static function getConnection()
    {
        try {
            // Utilise le nom du service Docker "mongodb"
            $mongo = new Manager("mongodb://mongodb:27017");
            var_dump($mongo);
            //$mongo = new \MongoDB\Driver\Manager("mongodb://mongodb:27017");
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        return $mongo;
    }
}