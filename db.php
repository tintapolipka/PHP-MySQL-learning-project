<?php
function db_init(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hirdetesek";

    //Create connection
    $conn = new mysqli($servername,$username,$password,$dbname);

    //Check connection

    if($conn->connect_error){
        die("Connection failed: ".$conn->connect_error);
    };
 return $conn;
}
?>