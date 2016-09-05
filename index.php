<? include ('lib/inc/db.inc.php');
include('lib/inc/ip2locationlite.class.php');
 
//Load the class
$ipLite = new ip2location_lite;
$ipLite->setKey('88daa8068b2c1135b1cb2134a7594024c0b18f5f3824dc1ada71dd1146678c42');
 
//Get errors and locations
$locations = $ipLite->getCity($_SERVER['REMOTE_ADDR']);
$errors = $ipLite->getError();
if($_SESSION['logged_in'] == 1) {
$locations['cityName'] = $_SESSION['city'];
$locations['regionName'] = $_SESSION['state'];
$locations['zipCode'] = $_SESSION['zipcode'];
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>RecipeTinCan</title>
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.9.0/build/reset/reset-min.css" />
<link rel="stylesheet" type="text/css" href="lib/css/styles.css" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>

<body id="home">
<? include('lib/inc/header.inc.php'); ?>
<div id="container">
  <div id="headsection">
    <div class="header">
      <h1>Featured Recipes</h1>
    </div>
    <div id="banner" class="leftfloat">
      <div class="outerbox">
        <div class="innerborder">
        
<object data="slideshow.swf" type="application/x-shockwave-flash" width="640" height="250">
    <param name="movie" value="slideshow.swf">
 
    <!-- If flash is not installed -->
    <p>You need Adobe Flash Player to view this content</p>
</object>        
        </div>
      </div>
    </div>
    
    <div class="rightfloat">
    <div id="headadvertisment" class="rightfloat">
      <p>advertisement</p>
        <img src="lib/img/advertisment.jpg" class="advertisment" alt="advertisment" />
    </div>
       <div id="socialmedia" class="rightfloat floatclear">
       <p>Social Media</p>
       <a href="rss.php"><img src="lib/img/rss.png" alt="rss feed" /></a>
       <img src="lib/img/facebook.png" alt="Facebook" />
       <img src="lib/img/socialmedia.png" alt="Twitter" />
       </div>
    </div>
    
  </div>
  <div id="maincontent" class="floatclear">
    <div class="header">
      <h1> Popular Recipes </h1>
    </div>
    <div id="recipelist" class="leftfloat">
      <?
				$sql = "SELECT * FROM recipes JOIN recipepictures ON recipes.recipeid=recipepictures.recipeid JOIN categories ON recipes.categoryid = categories.categoryid JOIN users ON recipes.createdby = users.userid JOIN type ON recipes.typeid = type.typeid  WHERE recipes.active = 1 $searchquery ORDER BY recipes.rating DESC LIMIT 5";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
		$i = 0;
		if ($count == 0) {echo'<p>No Recipes Found</p>'; }
		while ($i < $count) {
					$row = mysql_fetch_array($result);
					extract($row);
					$createddate = mysql_result($result, $i, "recipes.createddate");
					
$sql2 = "SELECT * FROM reciperating WHERE recipeid = $recipeid"; // start rating get
$result2 = mysql_query($sql2);
$votes = mysql_num_rows($result2);
$i2 = 0;
$total ="";
while($i2 < $votes) {
	$total += mysql_result($result2, $i2,'reciperating'); //add up totals
	$i2++;
}
if($votes > 1) {
$rating = round($total / $votes); //find adverage
}
        echo "<div class='infoblocksearch'>
          <div class='innerborder'>
            <div class='title'>
              <p><a href='recipepage.php?recipeid=$recipeid&amp;categoryid=$categoryid'>$name</a> - by $fname <span>uploaded $createddate</span><span class='rightfloat small'>($votes votes)</span>";
			 if ($votes > 0) { 
			 for ($i3=1; $i3 <= $rating; $i3++) {
					  echo '<img src="lib/img/star.png" class="ratingstars rightfloat" alt="rating star" />';
			 } }else {
				 echo"<span class='rightfloat'>Not Rated</span>";
			 }
			  
			 echo" </p></div>
            <div class='picture leftfloat'> <a href='recipepage.php?recipeid=$recipeid&amp;categoryid=$categoryid'><img src='lib/img/$recipeid/175_$filename' alt='$name' /></a> </div>
            <div class='info rightfloat'>
              <div class='description'>
                ".stripslashes($text)."
              </div>
              <div class='category'> Preptime: $preptime : Cooktime: $cooktime  <div class='rightfloat'>$category : $type</div></div>
            </div>
          </div>
        </div>";
		$i++;
		}
?>
    </div>
    <!-- end recipelist -->
<?
 $result = mysql_query("SELECT * FROM restaurants JOIN restaurantpictures ON restaurants.restaurantid=restaurantpictures.restaurantid JOIN categories ON restaurants.categoryid=categories.categoryid JOIN users ON restaurants.createdby = users.userid WHERE restaurants.active = 1 AND restaurantcity = '$locations[cityName]'");
		$count = mysql_num_rows($result);
?>    
    <div id="sidebar" class="rightfloat">
      <div id="sidebarrestaurants" class="sidebarsection">
      <? if ($count == 0) {?>
        <div class="header">
          <h1>Popular Restaurants</h1>
        </div>
      <? } else {?>
        <div class="header">
          <h1> Restaurants Near You </h1>
        </div>
        <div class="location">
          <span class="small"><? echo "$locations[cityName] $locations[regionName] $locations[zipCode]";  ?></span>
        </div>
        <? }?>
        
<?
		if ($count == 0) {
$result = mysql_query("SELECT * FROM restaurants JOIN restaurantpictures ON restaurants.restaurantid=restaurantpictures.restaurantid JOIN categories ON restaurants.categoryid=categories.categoryid JOIN users ON restaurants.createdby = users.userid WHERE restaurants.active = 1");		}
		$count = mysql_num_rows($result);
		$range2 = rand (0, $count - 1);
		mysql_data_seek($result, $range2);
		$row = mysql_fetch_array($result);
		extract($row);
?>        
        
        <div class="sidebaradvertisment">
          <div class="sidebaradvertismenthead">
            <h2><a href="restaurantpage.php?restaurantid=<? echo $restaurantid?>"><? echo $restaurantname; ?></a></h2>
          </div>
          <div class="sidebaradvertismentimage "> <a href="restaurantpage.php?restaurantid=<? echo $restaurantid?>"> <? echo"<img src='lib/img"; if ($filename != "nopicture.png"){echo"/$restaurantid"; } echo"/225_$filename' class='mainpicture' alt='restaurantpicture' />"; ?></a> </div>
          <div class="sidebaradvertismentinfo ">
            <? 
			if (strlen($restaurantdescription) > 120){
  			$restaurantdescription = substr($restaurantdescription, 0, 120) . '...';
			}
			echo stripslashes($restaurantdescription);
			?>
          </div>
        </div>
        <div class="viewmore"></div>
      </div>
      <div id="sidebarnewrecipes" class="sidebarsection">
        <div class="header">
          <h1> Newest Recipes </h1>
        </div>
        <? $result = mysql_query("SELECT * FROM recipes WHERE active = 1 ORDER BY recipeid DESC LIMIT 10");
		$count = mysql_num_rows($result);
		for($i=0; $i < $count; $i++ ) {
			$row = mysql_fetch_array($result);
			extract($row);
			echo"        <div class='newrecipebox'> <a href='recipepage.php?recipeid=$recipeid&amp;categoryid=$categoryid'>
          <p class='leftfloat'><span>$name</span>
          <p class='rightfloat'>view</p>
          </a> </div>
";
		}
		  ?>
        <div class="viewmore"></div>
      </div>
    </div>
    <!-- end sidebar --> 
    
  </div>
  <!-- end maincontent --> 
</div>
<!-- end container -->
<? include('lib/inc/footer.inc.php');?>
</body>
</html>
