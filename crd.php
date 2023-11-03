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
                $this->connection=true;
                return true;
            }
        }
    }

    function detail():Bool{
        return $this->connection;
    }

    public function insertData(string $table,array $data){
        if(sizeof($data)>0){
            if($this->tableExistis($table)){
                $allkey = implode(" , ",array_keys($data));
                $allvalue = implode("' , '",array_values($data));
                $sql = "INSERT INTO $table($allkey) VALUES('$allvalue')";
                $isInsert = $this->cnct->query($sql);
                if(!$isInsert){
                    array_push($this->result,"there is some error");
                    return false; 
                }
                $this->result = $data;
                return true;
            }else{
                array_push($this->result,"table is not exist...");
            }
        }else{
            array_push($this->result,"data mest need...");
            return false;
        }
    }

    public function update(string $table, array $param,$where=null){
        if($this->tableExistis($table)){
            $txt = "";
            foreach($param as $key => $val){
                $txt .= " $key = '$val',";
            };
            $mywhere = ($where) ? " WHERE $where" : "";
            $txt = substr($txt,0,strlen($txt)-1);
            $sql = "UPDATE  $table SET ".$txt.$mywhere ;
            $rsl = $this->cnct->query($sql);
            if(!$rsl){
                array_push($this->result,"there is some error");
                return false; 
            }
            array_push($this->result,$this->cnct->affected_rows);
            return true;


        }else{
            array_push($this->result,"table dosnt existis...");
        }
    }




    public function resultAccess(){
        $nesArray = $this->result;
        $this->result = array();
        return $nesArray;
    }

    private function tableExistis($tableName){
        $sql = "SHOW TABLES FROM $this->dbName LIKE '$tableName'";
        $rsl = $this->cnct->query($sql);
        if($rsl->num_rows==1){
            return  true;
        }else{
            array_push($this->result,$tableName."does'nt exist...");
            return false;
        }
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