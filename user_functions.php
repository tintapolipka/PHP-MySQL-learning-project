<?php
require 'db.php';

function check_user_pass($email,$password,$conn){    
        $user = '';
        $tiskotitott_jelszo = hash('sha256',$password);
        $sql = "SELECT * FROM users WHERE email='".$email."' AND password='".$tiskotitott_jelszo."';";
        $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $user = array($row["id"],$row["firstname"],$row["lastname"]); 
            
        }
    } else {
      return FALSE;
    }
    $conn->close();
  return $user[0];


}

function get_user_info($id){
      $user = '';  
      $conn = db_init();
        
        $sql = "SELECT * FROM users WHERE id='".$id."';";
        $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $user = array($row["id"],$row["firstname"],$row["lastname"],$row["email"]); 
            
        }
    } else {
      die('db error');
    }
    $conn->close();
  return $user;


}


function check_login(){
    if(isset($_POST["email"])&& isset($_POST["password"])){
        $email = $_POST["email"];
        $password = $_POST["password"];
        $conn = db_init();
        $succ = check_user_pass($email, $password, $conn);
                
        if( $succ != FALSE){
           setcookie('current_user', $succ, time() + 300, "/");
           header( "Location: /hirdetesek/login.php");
           exit();
        
        } else { 
          //fail
          echo '<p class="error">Invalid email or password</p>';};
    }

function logout(){
    setcookie('current_user','',time(),"/");
}
    
function is_logged_in(){
  if($_COOKIE['current_user']){
    return TRUE;
  } else {return FALSE;};
};

function login_form(){
   
    echo '<form id="loginmenu" action="login.php" method="post">
        <label >Email</label>
        <input type="email" name="email">
        <label >Password</label>
        <input type="password" name="password">
        <input type="submit" value="Login">
    </form>
    <a href="register.php">Create new registration</a>';
     
}

}

function check_register(){
  if(isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["password2"])){
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $hash = hash('sha256',$password);

    if($password != $password2){
    echo '<p class="error">Password not match!</p>';
    }
    else{
      $conn = db_init();
      $guid = getGUID(); 
      $sql = "INSERT INTO users (id,email,password,firstname,lastname) VALUES ('".$guid."', '" .$email."', '".$hash."', '". $firstname. "', '".$lastname. "' );";
    
      if ($conn->query($sql) == TRUE) {
        setcookie("current_user", $guid, time() + 300, "/");
      } else {
        die('db error');
      }
      $conn->close();
    };
    header("Location: /hirdetesek/login.php");
    exit();
  };
}

function getGUID(){
  if(function_exists('com_create_guid')){
    return com_create_guid();
  } else {
    mt_srand((double)microtime()*10000);
    $charid = strtoupper(md5(uniqid(rand(),true)));
    $hypen = chr(45);
    $uuid = ''
      .substr($charid,0,8).$hypen
      .substr($charid,8,4).$hypen
      .substr($charid,12,4).$hypen
      .substr($charid,16,4).$hypen
      .substr($charid,20,12).$hypen;
    return $uuid;
  }
}

function profile_form(){
   $user_data = get_user_info($_COOKIE["current_user"]); 
  echo '<form id="loginmenu" action="profile.php" method="post">
      <label >Email</label>
      <input type="email" name="email" value="'.$user_data[3].'">
      <label >Vezetéknév</label>
      <input type="text" name="firstname" value="'.$user_data[1].'">
      <label >Utónév</label>
      <input type="text" name="lastname" value="'.$user_data[2].'">

      <input type="submit" value="Profil módosítása">
  </form>';
  
   
}

function check_user_mod(){
  if(isset($_POST["email"]) && isset($_POST["firstname"]) && isset($_POST["lastname"])){
    $id= $_COOKIE["current_user"];
    $email = $_POST["email"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
  
    $conn = db_init();
    $sql = "UPDATE users SET email ='".$email."', firstname='".$firstname."', lastname='".$lastname."' WHERE id='".$id."';";  
  
  if ( $conn->query($sql) === TRUE) {
    header("Location: /hirdetesek/login.php");
    exit();
  } else {
    die('db error');
  }
  $conn->close();
 }
}

?>