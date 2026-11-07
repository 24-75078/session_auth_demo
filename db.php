<?php
$host="localhost";
$username = "root";
$password="";
$db_name="auth_demo";

$conn= new mysqli($host, $username,$password, $db_name);

if ($conn){
//echo "Connnected!";
} else {
    //echo ("Connection Failed:".$conn->connect_error);
}
?>