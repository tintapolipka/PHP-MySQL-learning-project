<?php 
require 'template.php';
require 'user_functions.php';
// EZ NEMTOM MIÉRT VOLT
function logout(){
    setcookie('current_user','',time(),"/");
}
//BETETTEM IDE BIZTOS, AMI BIZTOS
logout();
header( "Location: /hirdetesek/login.php");
exit();
?>