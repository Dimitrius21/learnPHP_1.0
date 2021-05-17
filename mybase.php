<?php
class myBase {
    static private $nameDB;
    static private  function createDB() {
        $conf=include('conf.php');
        $str="mysql:host=$conf[host];dbname=$conf[name]";
        self::$nameDB=new PDO($str,$conf['user'], $conf['password']) or die('error conection');        
    }
    static public  function getDB(){
        if (!empty(self::$nameDB)) {
            return self::$nameDB; }    
        self::createDB();
        return self::$nameDB;
    }
}