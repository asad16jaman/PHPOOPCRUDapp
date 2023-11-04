<?php 
require "crd.php";

    $ob = new DataBase();
    // $ob->insertData("abc",["customerName"=>"rohiduzzaman","roll"=>1245]);
    // print_r($ob->resultAccess());
    $ob->getData('mytst','*',"home='Bogura'",null,'userId desc');

    echo "<br>";
    print_r($ob->resultAccess());

?>