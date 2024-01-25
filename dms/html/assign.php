<?php
if(isset($_POST["path"])){

$path=$_POST["path"];

if ($_POST["routedto"]=="Unassigned") {
$routedto="";
}else{
  $routedto=$_POST["routedto"];
}
include '../functions/config.php';

$database->getReference('Files/'.$path.'/routedto')->set($routedto);
echo "success";
}
 ?>
