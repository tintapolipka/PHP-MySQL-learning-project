<?php 
require 'template.php';
require 'user_functions.php';

header_load();
check_register();
?>
    <form id="loginmenu" action="register.php" method="post">
        <label >Email</label>
        <input type="email" name="email">
        <label >Password</label>
        <input type="password" name="password">
        <label >Password again</label>
        <input type="password" name="password2">
        <label >Firstname:</label>
        <input type="text" name="firstname">
        <label >Lastname:</label>
        <input type="text" name="lastname">
        <input type="submit" value="Register">
    </form>
<?php
    footer_load();
?>