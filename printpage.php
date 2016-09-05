<? include ('lib/inc/db.inc.php');
$recipeid = $_REQUEST['rid'];

$sql = "SELECT * FROM recipes JOIN users ON recipes.createdby = users.userid WHERE recipes.recipeid = $recipeid LIMIT 1";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
extract($row);
?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.9.0/build/reset/reset-min.css" />
<title><? echo $name;?> - Recipetincan</title>
<style>
h1 {
font-size:28px;
font-weight:bold;	
}

h2 {
	font-size:24px;
	font-weight:bold;
	margin:10px 0 0 0;
}
#printpage {
width:1000px;
padding:50px 100px 50px 100px;
font-size:22px;	
line-height:25px;
}

.leftfloat {
float:left;
width:370px;
margin:30px 30px 0 0;	
}

li {
line-height:25px;
margin:20px 0 0px 0;
list-style:disc;	
}

div {
}
</style>


</head>

<body id="printpage">
<div><h1><? echo $name; ?></h1></div>
<div>From: http://www.recipetincan.com/recipepage.php?recipeid=<? echo $recipeid; ?></div> 
<div>By:<? echo "$fname $lname"; ?></div>  
<div class="leftfloat">
<h2>Ingredients</h2>
<?
						$sql = "SELECT * FROM recipeingredients WHERE recipeid=$recipeid";
						$result = mysql_query($sql);
						$count = mysql_num_rows($result);
							$i = 0;
							while($i < $count) {
							$ingredient = mysql_result($result, $i, "ingredient");	
							echo "<li>$ingredient</li> ";
							$i++;
							}
?>
</div>

<div class="leftfloat">
<? 
						$sql = "SELECT * FROM recipesteps WHERE recipeid=$recipeid ORDER BY stepnumber";
						$result = mysql_query($sql);
						$count = mysql_num_rows($result);
						$i=0;
						while($i < $count) {
							$recipestepheader = mysql_result($result, $i, "recipestepheader");
							$recipestep = mysql_result($result, $i, "recipestepdescription");	
                    	echo "<h2>$recipestepheader</h2>
                        $recipestep";
						$i++;
						}
					?>
</div>

</body>
</html>