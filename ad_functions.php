<?php
//require 'db.php';
require 'user_functions.php';

function check_item_post(){
    if(isset($_POST["name"])&& isset($_POST["description"])&& isset($_POST["category"])&& isset($_POST["price"])){
        $name = $_POST["name"];
        $description = $_POST["description"];
        $category = $_POST["category"];
        $price = $_POST["price"];
        $userhash= $_COOKIE["current_user"];
        $conn = db_init();
        
        $guid = getGUID(); 
        $sql = "INSERT INTO ads (id,name,description,price,category,owner_id) 
        VALUES ('".$guid."', '" .$name."', '".$description."', '". $price. "', '".$category. "', '".$userhash."' );";
      
        if ($conn->query($sql) == TRUE) {
          
        } else {
          die('db error');
        }
        $conn->close();
        header("Location: /hirdetesek/ads.php");
        exit();
    }
}   

function ad_check_filter(){
  if(isset($_GET["categories"])){
    $category = $_GET["categories"];
    
    if ($category == 'ALL'){
      list_ads();
    } else {
      list_ads_params($category);
    };
    echo 'kategória: '. $category;
  } else {list_ads();};
};

function list_ads(){

  $sql = "SELECT ads.id, ads.name,ads.description, ads.price, ads.category, users.email, users.firstname, users.lastname FROM `ads` INNER JOIN users ON ads.owner_id=users.id;";

  $conn = db_init();
        
  
    $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      
    echo '<table><tr><th>Termék neve</th><th>Termék leírása</th><th>Termék ára</th><th>Eladó neve</th><th>Eladó email címe</th>';
      while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["name"]."</td>";
        echo "<td>".$row["description"]."</td>";
        echo "<td>".$row["price"]."</td>";
        echo "<td>".$row["firstname"]." ".$row["lastname"]. "</td>";            
        echo "<td>".$row["email"]."</td>";
        }

        echo '</table>';
  } else {
      die('db error');
    }
    $conn->close();

}

function list_ads_params($category){
  $sql = "SELECT ads.id, ads.name,ads.description, ads.price, ads.category, users.email, users.firstname, users.lastname FROM `ads` INNER JOIN users ON ads.owner_id=users.id WHERE ads.category = '".$category."';";

  $conn = db_init();
        
  
    $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      
    echo '<table><tr><th>Termék neve</th><th>Termék leírása</th><th>Termék ára</th><th>Eladó neve</th><th>Eladó email címe</th>';
      while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["name"]."</td>";
        echo "<td>".$row["description"]."</td>";
        echo "<td>".$row["price"]."</td>";
        echo "<td>".$row["firstname"]." ".$row["lastname"]. "</td>";            
        echo "<td>".$row["email"]."</td>";
        }

        echo '</table>';
  } else {
      die('db error');
    }
    $conn->close();

}



function get_categories(){
  $sql = "SELECT DISTINCT category FROM ads ORDER BY category ASC;";
  $conn = db_init();
  $result = $conn->query($sql);
  $categories = array();

if ($result->num_rows > 0) {
    
    while($row = $result->fetch_assoc()) {
      
      array_push($categories,$row["category"]);
      }
} else {
    die('db error');
  }
  $conn->close();
return $categories;

}

function print_category_selector(){
  $categories = get_categories();

echo '<form id="loginmenu" method="GET" action="ads.php">';
echo '<select id="categories" name="categories">';
echo '<option value="ALL" selected>Mindegyik</option>';
for($i=0; $i<count($categories);$i++){
  echo '<option value="'.$categories[$i].'">'.$categories[$i].'</option>';
}
echo '</select>';
echo '<input type="submit" value="Szűrés"></form>';
}

?>