<?php

require_once '../functions/firebase/vendor/autoload.php';
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Auth;

$firebase = (new Factory)
   ->withServiceAccount(__DIR__ . '/dms-cdrrmo-firebase-adminsdk-dw1wu-c240241e74.json')
   ->withDatabaseUri('https://dms-cdrrmo-default-rtdb.firebaseio.com');
$database=$firebase->createDatabase();
$auth=$firebase->createAuth();
$storage = $firebase->createStorage();


// var_dump($database);
// $storageClient = $storage->getStorageClient();
// $anotherBucket = $storage->getBucket('profiles');

// $user = $auth->getUser($_SESSION['verified_user_id']);
//
//  var_dump($anotherBucket);
 // exit();
 ?>
