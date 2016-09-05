<?php 
include ('lib/inc/db.inc.php');

$action = $_REQUEST['action'];
$recipeid = $_REQUEST['recipeid'];

if ($action == "add") {
	$sql = "UPDATE recipes SET featured = 1 WHERE recipeid = $recipeid LIMIT 1";
	$result = mysql_query($sql);
}
if ($action == "delete") {
	$sql = "UPDATE recipes SET featured = 0 WHERE recipeid = $recipeid LIMIT 1";
	$result = mysql_query($sql);
}



$sql = "SELECT * FROM recipes JOIN recipepictures ON recipes.recipeid = recipepictures.recipeid WHERE recipes.featured = 1 AND recipes.active = 1";
$result = mysql_query($sql);
$count = mysql_num_rows($result);


 $file= fopen("slideshow.xml", "w");

 $_xml ="<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\r\n";

 $_xml .="<SLIDESHOW SPEED=\"4\">\r\n";

 for ($i = 0; $i < $count; $i++) {
$row = mysql_fetch_array($result);
extract($row);
	 $_xml .="<IMAGE URL=\"http://www.recipetincan.com/lib/img/".$recipeid."/680_". $filename ."\" TITLE=\"".$name. "\" />\r\n";
}

 $_xml .="</SLIDESHOW>";

 fwrite($file, $_xml);

 fclose($file);

 echo "XML has been written.  <a href=\"slideshow.xml\">View the XML.</a>";
?>
