<?php 

class DataBase{
   private $serverName = "localhost";
   private $username = "root";
   private $password = "";
   private $dbName = "asad";

   private $cnct;
   private $connection = false;
   private $result = [];
    
    function __construct(){
        if($this->connection==false){
            $this->cnct = new mysqli($this->serverName,$this->username,$this->password,$this->dbName);
            if($this->cnct->connect_error){
                array_push($this->result,$this->cnct->connect_error);
                return false;
            }else{
                echo "connection hoice...";
                $this->connection=true;
                return true;
            }
        }

    }

    function detail():Bool{
        return $this->connection;
    }




    function __destruct(){
        if($this->connection){
            $this->cnct->close();
            $this->connection = false;
            return true;
        }else{
            return true;
        }
    }



}




?>