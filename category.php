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

$categoryid = $_REQUEST['categoryid'];
$r = $_REQUEST['r'];

$search = $_REQUEST['search'];
			
$searchname = $_REQUEST['searchname'];
			  
$searchrateing = $_REQUEST['searchrateing'];
			  
$searchtype = $_REQUEST['searchtype'];
			  
$searchuploadedby = $_REQUEST['searchuploadedby'];



if (!empty($categoryid)) {
$categorysearch = " AND recipes.categoryid = $categoryid";
}


$sql = "SELECT * FROM categories WHERE active = '1' AND categoryid = '$categoryid' LIMIT 1";

$result=mysql_query($sql, $link) or die ('Unable to run query:'.mysql_error());
$row = mysql_fetch_array($result);
$categoryname = $row['category'];

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
  <div id="breadcrumb"><a href="index.php">Home </a>> <span class="currentbreadcrumb"><? if (!empty($categoryid)) {
echo $categoryname; } else { echo "All Recipes"; } ?></span></div>
  <div id="maincontent" class="floatclear">
      <div class="header">
        <h1><? echo $categoryname ?></h1>
      </div>
    <div id="recipelist" class="leftfloat">
      <div class="outerbox">
        <div class="innerborder">
          <div id="searcharea">
            <form action="category.php?categoryid=<? echo $categoryid; ?>&amp;r=<? echo $r; ?>" method="post">
              <input class="clear" name ="searchname" type="text" value="Name" />
              <select name="searchrateing">
              	<option>Rating</option>
              	<option value="5">5 Stars</option>
              	<option value="4">4 Stars</option>
              	<option value="3">3 Stars</option>
              	<option value="2">2 Stars</option>
              	<option value="1">1 Stars</option>
              </select>
              <select name="searchtype">
              	<option>Type</option>
                
              <?
			  			  
			  	$sql = "SELECT * FROM type WHERE active = 1";
				$result = mysql_query($sql);
				$count = mysql_num_rows($result);
				$i = 0; 
				while($i < $count) {
					$typeid = mysql_result($result, $i, "typeid");
					$type = mysql_result($result, $i, "type");
              	echo "<option value='$typeid'>$type</option>";
				$i++;
				}

			  ?>
              </select>
              <input class="clear" name="searchuploadedby" type="text" value="Uploaded by" />
              <input id="searchsubmit" type="submit" class="button" name="search" value="Search" />
            </form>
          </div>
        </div>
        
        <? 
			
			  extract($_POST);
			  
		if ($search == "Search") {
			
			  if ($searchname != "Name") {
			  $searchquery .= "AND recipes.name LIKE '%$searchname%' ";
			  }
			  if ($searchrateing != "Rating") {
			  $searchquery .= "AND recipes.rating = '$searchrateing' ";
			  }
			  if ($searchtype != "Type") {
			  $searchquery .= "AND recipes.typeid = $searchtype ";
			  }
			  if ($searchuploadedby != "Uploaded by") {
			  $searchquery .= "AND users.fname LIKE '$searchuploadedby' OR users.lname LIKE '$searchuploadedby' ";
			  }
		}
		
			if (!empty($categoryid)) {
				$sql = "SELECT * FROM recipes JOIN recipepictures ON recipes.recipeid=recipepictures.recipeid JOIN categories ON recipes.categoryid = categories.categoryid JOIN users ON recipes.createdby = users.userid JOIN type ON recipes.typeid = type.typeid  WHERE recipes.categoryid = $categoryid AND recipes.active = 1 $searchquery LIMIT $offset , $rowsPerPage";
			} else {
				$sql = "SELECT * FROM recipes JOIN recipepictures ON recipes.recipeid=recipepictures.recipeid JOIN categories ON recipes.categoryid = categories.categoryid JOIN users ON recipes.createdby = users.userid JOIN type ON recipes.typeid = type.typeid WHERE recipes.active = 1 $searchquery LIMIT $offset , $rowsPerPage";
			}
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
					  echo '<img src="lib/img/star.png" class="ratingstars rightfloat" alt="rating star" /> ';
			 } }else {
				 echo"<span class='rightfloat'>Not Rated</span>";
			 }
			  
			 echo stripslashes("</p></div>
            <div class='picture leftfloat'> <a href='recipepage.php?recipeid=$recipeid&amp;categoryid=$categoryid'><img src='lib/img/$recipeid/175_$filename' alt='$name' /></a> </div>
            <div class='info rightfloat'>
              <div class='description'>
                $text
              </div>
              <div class='category'> Preptime: $preptime : Cooktime: $cooktime  <div class='rightfloat'>$category : $type</div></div>
            </div>
          </div>
        </div>");
		$i++;
		}
		?>
        
		<?
if ($r == "all") {
	$categoryid = "";
}

				$sql = "SELECT * FROM recipes JOIN recipepictures ON recipes.recipeid=recipepictures.recipeid JOIN users ON recipes.createdby = users.userid WHERE recipes.active = 1  $categorysearch $searchquery";

		$result = mysql_query($sql);
		$count = mysql_num_rows($result);		
		$totalPages = ceil($count / $rowsPerPage);
		
			if($currentPage > 1) {
			
			/* echo '<div class="leftfloat nextprev toppagenavprev"><div class="innerborder"><a href="category.php?page=' . ($currentPage-1) . '&categoryid=' . ($categoryid) . '">Previous Page</a></div></div>'; */
			echo '<div class="leftfloat nextprev"><div class="innerborder"><a href="category.php?page='.($currentPage-1).'&amp;categoryid='.($categoryid).'&amp;search='.($search).'&amp;searchrateing='.($searchrateing).'&amp;searchtype='.($searchtype).'&amp;searchuploadedby='.($searchuploadedby).'&amp;searchname='.($searchname).'&amp;r='.($r). '">Previous Page</a></div></div>';
			
			}
			
			if($currentPage < $totalPages) {
			
			/*echo '<div class="rightfloat nextprev toppagenavnext"><div class="innerborder"><a href="category.php?page=' . ($currentPage+1) . '&categoryid=' . ($categoryid) . '">Next Page</a></div></div>'; */
			echo '<div class="rightfloat nextprev"><div class="innerborder"><a href="category.php?page='.($currentPage+1).'&amp;categoryid='.($categoryid).'&amp;search='.($search).'&amp;searchrateing='.($searchrateing).'&amp;searchtype='.($searchtype).'&amp;searchuploadedby='.($searchuploadedby).'&amp;searchname='.($searchname).'&amp;r='.($r). '">Next Page</a></div></div>';
			
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
        <div class="header">
          <h1> Top 10 <? echo $categoryname; ?> Recipes </h1>
<? $result = mysql_query("SELECT * FROM recipes WHERE active = 1 $categorysearch ORDER BY rating DESC LIMIT 10");
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
		  ?>        <div class="viewmore"></div>
      </div>
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
