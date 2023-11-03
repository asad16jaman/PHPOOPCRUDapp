<?php 
require "crd.php";

    $ob = new DataBase();

    $ob->insertData("abc",["customerName"=>"rohiduzzaman","roll"=>1245]);
    print_r($ob->resultAccess());

 


?>