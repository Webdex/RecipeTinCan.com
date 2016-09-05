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

$rowsPerPage = 5;

$currentPage = ((isset($_GET['page']) && $_GET['page'] > 0) ? (int)$_GET['page'] : 1);

$offset = ($currentPage-1)*$rowsPerPage;

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

<body id="categorypage">
<? include('lib/inc/header.inc.php'); ?>

<div id="container">
  <div id="breadcrumb"><a href="index.php">Home </a>> <span class="currentbreadcrumb"> Restaurants </span></div>
  <div id="maincontent" class="floatclear">
    <div id="recipelist" class="leftfloat">
      <div class="header">
        <h1><? echo $categoryname ?></h1>
      </div>
      <div class="outerbox">
        <div class="innerborder">
          <div id="searcharea">
            <form action="restaurants.php" method="post">
            <input type="hidden" name="searching" value="1" />
              <input class="clear" name ="searchname" type="text" value="Name" />
              <input class="clear" name ="searchaddress" type="text" value="Address" />


<select name="searchstate">
                          <option value="State" selected="selected">State</option>
                          <option value="AL">Alabama</option>
                          <option value="AK">Alaska</option>
                          <option value="AZ">Arizona</option>
                          <option value="AR">Arkansas</option>
                          <option value="CA">California</option>
                          <option value="CO">Colorado</option>
                          <option value="CT">Connecticut</option>
                          <option value="DE">Delaware</option>
                          <option value="DC">District Of Columbia</option>
                          <option value="FL">Florida</option>
                          <option value="GA">Georgia</option>
                          <option value="HI">Hawaii</option>
                          <option value="ID">Idaho</option>
                          <option value="IL">Illinois</option>
                          <option value="IN">Indiana</option>
                          <option value="IA">Iowa</option>
                          <option value="KS">Kansas</option>
                          <option value="KY">Kentucky</option>
                          <option value="LA">Louisiana</option>
                          <option value="ME">Maine</option>
                          <option value="MD">Maryland</option>
                          <option value="MA">Massachusetts</option>
                          <option value="MI">Michigan</option>
                          <option value="MN">Minnesota</option>
                          <option value="MS">Mississippi</option>
                          <option value="MO">Missouri</option>
                          <option value="MT">Montana</option>
                          <option value="NE">Nebraska</option>
                          <option value="NV">Nevada</option>
                          <option value="NH">New Hampshire</option>
                          <option value="NJ">New Jersey</option>
                          <option value="NM">New Mexico</option>
                          <option value="NY">New York</option>
                          <option value="NC">North Carolina</option>
                          <option value="ND">North Dakota</option>
                          <option value="OH">Ohio</option>
                          <option value="OK">Oklahoma</option>
                          <option value="OR">Oregon</option>
                          <option value="PA">Pennsylvania</option>
                          <option value="RI">Rhode Island</option>
                          <option value="SC">South Carolina</option>
                          <option value="SD">South Dakota</option>
                          <option value="TN">Tennessee</option>
                          <option value="TX">Texas</option>
                          <option value="UT">Utah</option>
                          <option value="VT">Vermont</option>
                          <option value="VA">Virginia</option>
                          <option value="WA">Washington</option>
                          <option value="WV">West Virginia</option>
                          <option value="WI">Wisconsin</option>
                          <option value="WY">Wyoming</option>
                        </select>              <input class="clear" name="searchcity" type="text" value="City or Zip" />
              <input id="searchsubmit" type="submit" class="button" name="search" value="Search" />
            </form>
          </div>
        </div>
        
        <? 
			
			  $searchquery = $_REQUEST['searchquery'];
			  extract($_POST);
			  
		if ($search == "Search") {
			
			  if ($searchname != "Name") {
			  $searchquery .= "AND restaurants.restaurantname LIKE '%$searchname%' ";
			  }
			  if ($searchaddress != "Address") {
			  $searchquery .= "AND restaurants.restaurantaddress = '$searchaddress' ";
			  }
			  if ($searchstate != "State") {
			  $searchquery .= "AND restaurants.restaurantstate = '$searchstate' ";
			  }
			  if ($searchcity != "City or Zip") {
			  $searchquery .= "AND restaurants.restaurantcity = '$searchcity' OR restaurants.restaurantzipcode LIKE '$searchcity'  ";
			  }
		}
		
		

				$sql = "SELECT * FROM restaurants JOIN restaurantpictures ON restaurants.restaurantid=restaurantpictures.restaurantid JOIN categories ON restaurants.categoryid=categories.categoryid JOIN users ON restaurants.createdby = users.userid WHERE restaurants.active = 1 AND restaurants.restaurantcity = '$locations[cityName]' $searchquery LIMIT $offset , $rowsPerPage";		
		if ($searching == 0) {
				$sql .= " UNION ALL SELECT * FROM restaurants JOIN restaurantpictures ON restaurants.restaurantid=restaurantpictures.restaurantid JOIN categories ON restaurants.categoryid=categories.categoryid JOIN users ON restaurants.createdby = users.userid WHERE restaurants.active = 1 $searchquery LIMIT $offset , $rowsPerPage"; }
				
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
		$i = 0;
		while ($i < $count) {
					$row = mysql_fetch_array($result);
					extract($row);
			$name = mysql_result($result, $i, "restaurantname");
			$createdby = mysql_result($result, $i, "createdby");
			$createddate = mysql_result($result, $i, "createddate");
			$restaurantid = mysql_result($result, $i, "restaurantid");
			$filename = mysql_result($result, $i, "filename");
			$text = mysql_result($result, $i, "restaurantdescription");
        echo "<div class='infoblocksearch'>
          <div class='innerborder'>
            <div class='title'>
              <p><a href='restaurantpage.php?restaurantid=$restaurantid&amp;categoryid=$categoryid'>$name</a> <span>uploaded $createddate</span></p>
            </div>
            <div class='picture leftfloat'> <a href='restaurantpage.php?restaurantid=$restaurantid&amp;categoryid=$categoryid'>
			
				
			<img src='lib/img";if ($filename != "nopicture.png"){echo"/$restaurantid";}echo"/175_$filename' alt='$name' />
			
			</a> </div>
            <div class='info rightfloat'>
              <div class='description'>
                ";if(!empty($text)){echo" ".stripslashes($text)."";} else {echo"<p>No description set</p>";}echo"
              </div>
              <div class='category'> $restaurantaddress - $restaurantcity $restaurantstate, $restaurantzipcode</div>
            </div>
          </div>
        </div>";
		$i++;
		}
		if ($count == 0) {
			echo "No restaurants found";
		}
		?>
        
		<?


		$totalPages = ceil($count / $rowsPerPage);
			if($currentPage > 1) {
			
			echo '<div class="leftfloat nextprev toppagenavprev"><div class="innerborder"><a href="category.php?page=' . ($currentPage-1) . '&categoryid=' . ($categoryid) . '">Previous Page</a></div></div>';
			echo '<div class="leftfloat nextprev"><div class="innerborder"><a href="category.php?page=' . ($currentPage-1) . '&categoryid=' . ($categoryid) . '">Previous Page</a></div></div>';
			
			}
			
			if($currentPage < $totalPages) {
			
			echo '<div class="rightfloat nextprev toppagenavnext"><div class="innerborder"><a href="category.php?page=' . ($currentPage+1) . '&categoryid=' . ($categoryid) . '">Next Page</a></div></div>';
			echo '<div class="rightfloat nextprev"><div class="innerborder"><a href="category.php?page=' . ($currentPage+1) . '&categoryid=' . ($categoryid) . '">Next Page</a></div></div>';
			
			}
		?>    
	  </div>
    </div>
    <!-- end recipelist -->
    
    <div id="sidebar" class="rightfloat">
      <div id="sidebarrestaurants" class="sidebarsection">
        <div class="sidebaradvertisment">
          <p>advertisement</p>
          <img src="lib/img/advertisment.jpg" class="advertisment" alt="advertisment" /> </div>
        <div class="viewmore"></div>
      </div>
      <div id="sidebarnewrecipes" class="sidebarsection">
        
<? $result = mysql_query("SELECT * FROM restaurants WHERE active = 1 AND restaurantcity = '$locations[cityName]' LIMIT 10");
		$count = mysql_num_rows($result);
		if($count == 0) {
$result = mysql_query("SELECT * FROM restaurants WHERE active = 1 LIMIT 10");
		$count = mysql_num_rows($result);
		echo"<div class='header'><h1>Restaurants</h1></div>";
		}else {echo"<div class='header'><h1>Restaurants Near You</h1></div> 
					        <div class=\"location\"><span class=\"small\">$locations[cityName] $locations[regionName] $locations[zipCode]</span></div>
        

		";
		
		}
		
		?>
	<?	for($i=0; $i < $count; $i++ ) {
			$row = mysql_fetch_array($result);
			extract($row);
			echo"        <div class='newrecipebox'> <a href='restaurantpage.php?restaurantid=$restaurantid'>
          <p class='leftfloat'><span>$restaurantname</span>
          <p class='rightfloat'>view</p>
          </a> </div>
";
		}
		?>        <div class="viewmore"></div>
      </div>
      <div class="viewmore"></div>
  </div>
  <!-- end sidebar --> 
  
</div>
<!-- end maincontent -->
</div>
<!-- end container -->
<? include('lib/inc/footer.inc.php');?>
</body>
</html>
