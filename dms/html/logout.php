<?php
session_start();
if(isset($_SESSION["isAdmin"])){
  session_destroy();
}
header("Location: auth-login-basic.php");
 ?>
