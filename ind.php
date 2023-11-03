<?php 
require "crd.php";

    $ob = new DataBase();
    // $ob->insertData("abc",["customerName"=>"rohiduzzaman","roll"=>1245]);
    // print_r($ob->resultAccess());
    $ob->update("abc",["roll"=>4330],"     roll= '1001'");
    print_r($ob->resultAccess())

 


?>