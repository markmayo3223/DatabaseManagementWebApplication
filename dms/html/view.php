<?php
$url=$_GET["url"];

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    header('Content-disposition: inline');
    header('Content-type: application/msword'); // not sure if this is the correct MIME type
    readfile($url);
    exit;
     ?>
    <iframe src="<?php echo 'http://docs.google.com/gview?url='.$url.'&embedded=true'; ?>" width="100%" height="100%"></iframe>
  </body>
</html>
