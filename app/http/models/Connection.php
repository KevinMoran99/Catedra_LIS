<?php
namespace Http\Models;
use \PDO;
use \PDOException;
class Connection{ 
    private static $connection = null;
    private static $statement = null;
    private static $id = null;
    private static $error = null;

    
    //conectar a la base 
    private static function connect(){
        $server="localhost";
        $user = "root";
        $pass="";
        $database="stoam";
        try{
            self::$connection = new PDO("mysql:host=$server; dbname=$database; charset=utf8",$user,$pass);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $ex){
            print($ex->getCode());
        }
    }

    //desconectar de la base
    private static function disconnect(){
        self::$error = self::$statement->errorInfo();
        self::$connection = null;
    }

    public static function select($query, $values){
        self::connect();
        self::$statement = self::$connection->prepare($query);
        self::$statement->execute($values);
        self::disconnect();
        return self::$statement->fetchAll();
    }

    public static function selectOne($query, $values){
        self::connect();
        self::$statement = self::$connection->prepare($query);
        self::$statement->execute($values);
        self::disconnect();
        return self::$statement->fetch();
    }

    public static function insertOrUpdate($query, $values){
        try {
            self::connect();
            self::$statement = self::$connection->prepare($query);
            $state = self::$statement->execute($values);
            self::$id = self::$connection->lastInsertId();
            self::disconnect();
            return $state;
        }
        catch (PDOException $error) {
            return $error->errorInfo[1];
        }
    }

    public static function getLastRowId(){
        return self::$id;
    }

    public static function getException(){
        if(self::$error[0] == "00000"){
            return false;
        }else{
            return self::$error[1];
        }
    }


    
}
