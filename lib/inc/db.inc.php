<? 
//Connect To Database
$hostname='recipetincan.db.9219239.hostedresource.com';
$username='recipetincan';
$password='Gu*t3f4n';
$dbname='recipetincan';
$usertable='your_tablename';
$yourfield = 'your_field';

$link = mysql_connect($hostname,$username, $password) or die ('Unable to connect to database!'. mysql_error());
mysql_select_db($dbname);

session_start();
//end connect
?>