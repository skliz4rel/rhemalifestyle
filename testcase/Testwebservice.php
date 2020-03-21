<?php
include("Obj.php");
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 * 
 */

$a = new Obj();

$array = array();
$array[0] = $a;
//$array[1] = $a;

echo  json_encode($array);

?>
