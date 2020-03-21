<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of testfunc
 *
 * @author skliz
 */
include("../utility/Library.php");
include("../config/connector.php");

$object = new Library();
$connection = new Connector();
$connection->doConnection();

$password = $object->doEncryption("password");

echo  $password;

$query = "insert into servicelogin (username,password) values ('skliz','$password') ";

$result = mysql_query($query) or die(mysql_error());


print_r($_FILES['image']);

echo date('Y-m-d');

echo "<br/>";

echo date('H:m:s');

?>