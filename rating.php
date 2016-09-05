<?  include ('lib/inc/db.inc.php');
$rating = $_POST['rating'];
$recipeid = $_POST['recipeid'];

$sql = "INSERT INTO reciperating";
$sql .= "(reciperatingid, reciperating, recipeid, ratedby)";
$sql .= "VALUES (NULL, $rating, $recipeid, $_SESSION[userid]);";
mysql_query($sql);

$sql = "SELECT * FROM reciperating WHERE recipeid = $recipeid"; // start rating get
$result = mysql_query($sql);
$votes = mysql_num_rows($result);
$row = mysql_fetch_array($result);
$i = 0;
$total ="";
while($i < $votes) {
	$total += mysql_result($result, $i,'reciperating'); //add up totals
	$i++;
}
if ($votes > 0) { //check if any votes exist
$rating = round($total / $votes); //find adverage
//end rating get
}
$sql = "UPDATE recipes";
$sql .= " SET rating = $rating";
$sql .= " WHERE recipeid = $recipeid LIMIT 1";
mysql_query($sql);

?>
