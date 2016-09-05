<? include ('lib/inc/db.inc.php');
$recipeid = $_REQUEST['recipeid'];
$sql = "UPDATE recipefavoriates SET active = 0 WHERE userid = $_SESSION[userid] AND recipeid = $recipeid";
$result = mysql_query($sql);
?>