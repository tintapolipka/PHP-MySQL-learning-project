<?php 
require 'template.php';
require 'ad_functions.php';
header_load();

// Megint nem működik a require
function is_logged_in(){
    if($_COOKIE["current_user"]!=''){
      return TRUE;
    } else {return FALSE;};
  };

  $isloggedIn = is_logged_in();
// Ezért kell ez bele
if($isloggedIn== FALSE) {
    header('Location: /hirdetesek/login.php');
};

check_item_post();
 ?>
<form id="loginmenu" action="ads_add.php" method="post">
<label>Item name</label>
<input type="name" name="name">
<label>Item description</label>
<input type="text" name="description">
<label>Category</label>
<input type="text" name="category">
<label>Prize</label>
<input type="number" name="price">
<input type="submit" value="End">
</form>

<?php
footer_load();
?>