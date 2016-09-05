<?php
include('lib/inc/ip2locationlite.class.php');
 
//Load the class
$ipLite = new ip2location_lite;
$ipLite->setKey('88daa8068b2c1135b1cb2134a7594024c0b18f5f3824dc1ada71dd1146678c42');
 
//Get errors and locations
$locations = $ipLite->getCity($_SERVER['REMOTE_ADDR']);
$errors = $ipLite->getError();
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?
//Getting the result
echo "<p>\n";
echo "<strong>First result</strong><br />\n";
if (!empty($locations) && is_array($locations)) {
  foreach ($locations as $field => $val) {
    echo $field . ' : ' . $val . "<br />\n";
  }
}
echo "</p>\n";
 
//Show errors
echo "<p>\n";
echo "<strong>Dump of all errors</strong><br />\n";
if (!empty($errors) && is_array($errors)) {
  foreach ($errors as $error) {
    echo var_dump($error) . "<br /><br />\n";
  }
} else {
  echo "No errors" . "<br />\n";
}
echo "</p>\n"; 
echo $locations['cityName'];
?>
</body>
</html>