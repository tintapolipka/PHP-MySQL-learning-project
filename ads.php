<?php 
require 'template.php';
require 'ad_functions.php';
header_load();
    echo 'Hírdetések<br>';
    print_category_selector();
    ad_check_filter();
footer_load();
?>