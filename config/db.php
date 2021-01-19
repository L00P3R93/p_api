<?php
class Db{
    private $_HOST = "localhost";
    private $_DB = "api";
    private $_USER = "root";
    private $_PASS = "";
    public $conn;

    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=".$this->_HOST.";dbname=".$this->_DB,$this->_USER,$this->_PASS);
            $this->conn->exec("set names utf8");
        }catch(PDOException $e){
            echo "Oops!Something went wrong: ".$e->getMessage();
        }
        return $this->conn;
    }
}
