<?php 

class DataBase{
   private $serverName = "localhost";
   private $username = "root";
   private $password = "";
   private $dbName = "asad";

   private $cnct;
   private $connection = false;
   private $result = [];
    
   //constructor function is for build up connection
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

    //this is cheker function to is connection is on or not
    function isOpenDatabase():Bool{
        return $this->connection;
    }

    //it is for insert data/row in table
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

    //this function is use for update table data with or without condition
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

    //this function is use for delete table data with or without condition
    public function delete(string $table, $where=null){
        if($this->tableExistis($table)){
            $ww = ($where)? "WHERE $where" : "";
            $sql = "DELETE FROM $table ".$ww;
            if($this->cnct->query($sql)){
                array_push($this->result,"successfully deleted...");
                return true; 
            }else{
                array_push($this->result,"there is some error");
                return false; 
            }

        }else{
            array_push($this->result,"table dosnt existis...");
        }
    }

    //getting data with pure sql by the help of this function 
    public function sql(string $qry){
        $allrow = $this->cnct->query($qry);
        if($allrow){
            $this->result = $allrow->fetch_all(MYSQLI_ASSOC);
            return true;
        }else{
            array_push($this->result,"there is some error");
            return false; 
        }
    }

    //with the help of this function bellow we can get data by passing valid parameter..
    public function getData(string $table,$row="*",$where=null,$groupBy=null,$orderBy=null){

        if($this->tableExistis($table)){
            $sql = "SELECT $row FROM $table ";
            $wh = ($where) ? " WHERE $where " : "";
            $sql .= $wh;
            $grp = ($groupBy) ? " GROUP BY $groupBy " : "";
            $sql .= $grp;            
            $ord = ($orderBy) ? " ORDER BY $orderBy " : "";
            $sql .= $ord;

            $rsl = $this->cnct->query($sql);
            if($rsl){
                $this->result = $rsl->fetch_all(MYSQLI_ASSOC);
                return true;
            }else{
            array_push($this->result,"there is some error");
            return false; 
            }
        }
    }

    //we can see result with this function call/invoc
    public function resultAccess(){
        $nesArray = $this->result;
        $this->result = array();
        return $nesArray;
    }

    //it is cheaker function that table is existis or not
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

    //close connection if it open with this function
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