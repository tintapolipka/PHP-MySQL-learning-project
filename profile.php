<?php 
require 'template.php';
require 'user_functions.php';

function is_logged_in(){
    if($_COOKIE['current_user']){
      return TRUE;
    } else {return FALSE;};
  };

header_load();

$isloggedIn = is_logged_in();

if($isloggedIn== FALSE) {
    header('Location: /hirdetesek/login.php');
    exit();
}

    echo 'Profil módosítása<br>';
    check_user_mod();
    profile_form();
footer_load();
?>