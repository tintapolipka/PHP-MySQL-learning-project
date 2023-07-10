<?php 
require 'template.php';
require 'user_functions.php';
header_load();
check_login();

if(isset($_COOKIE["current_user"])){
    $id = $_COOKIE["current_user"];
    $user_data = get_user_info($id);
    echo '<h1> Welcome, '.$user_data[1] .' '.$user_data[2].'!</h1>';
    echo '<a href="logout.php"> Logout </a>';
}
else {login_form();};

?>


<?php

footer_load();
?>