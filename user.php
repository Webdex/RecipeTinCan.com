<? include ('lib/inc/db.inc.php');
if($_SESSION['logged_in'] == 0) {
header("location:index.php");
}
$action = $_REQUEST['action'];
$recipeid = $_REQUEST['recipeid'];
if($_REQUEST['edit'] == "success") {
$msg .= "<p class='sqlconfirm'>Location updated</p>";
}

if ($action == "delete") {
	$sql = "UPDATE recipes SET active = 0 WHERE recipeid = $recipeid LIMIT 1";
	$result = mysql_query($sql);
	if ($result) {
		$msg .="<p class=\"sqlconfirm\"> Recipe has been sucessfully deleted </p>";
	} else { $msg .="<p class=\"sqlerror\"> There was a problem please try again </p>"; }//closes if the update worked
}//closes if user delete check

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>RecipeTinCan</title>
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.9.0/build/reset/reset-min.css" />
<link media="screen" href="lib/js/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="lib/css/styles.css" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

</head>

<body id="userpage">
<? include('lib/inc/header.inc.php'); ?>    
<script type="text/javascript" src="lib/js/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.pack"></script> 
<? echo $msg;?>
    <div id="container">
  <div id="breadcrumb"><a href="index.php">Home </a>> <span class="currentbreadcrumb"> My Account</span></div>
        <div id="maincontent" class="floatclear">
        	<div id="recipelist" class="leftfloat">
            	<div class="header">
            	  <h1>Welcome <? echo $_SESSION['fname'];?></h1>
               	</div>
                
                <div class="section">
                	
                <h2>Share your own recipe in 3 easy steps</h2>
                <div class="outerbox">
                <div class="innerborder">
                    <div id="getstarted">
                    	<a href="recipestepone.php"><div id="getstartedbutton" class="rightfloat"><p>Create</p></div></a>
                        
                        <div id="getstarteddirections" class="leftfloat">
                        	<ol>
                            	<li><h3>Step 1</h3> <p>Select how many ingredients and steps your recipe will need.</p></li>
                                <li><h3>Step 2</h3> <p>Write your recipe.</p></li>
                                <li><h3>Step 3</h3> <p>Review your recipe for any changes.</p></li>
                            </ol>
                        </div>
                        </div>
                    
                    </div>
                    </div>
                </div>
                
                <div class="section">
                	<h2>Your Recipes</h2>
                    <div class="outerbox">
                    
                    <div class="innerborder">
                    <?
					$result = mysql_query("SELECT * FROM recipes JOIN categories ON recipes.categoryid = categories.categoryid JOIN type ON recipes.typeid = type.typeid WHERE recipes.active = 1 AND recipes.createdby = $_SESSION[userid] ORDER BY recipes.recipeid DESC");
$count = mysql_num_rows($result);

					if ($count >= 1) {
					?>
                    <div class="button createrecipe"><a href="recipestepone.php"><p>Create a new recipe</p></a></div>
                    <table>
					                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Rating</th>
                            <th>Edit</th>
                            <!-- <th>Delete</th> -->
                            </tr>
                        </thead>
                    <?
					
					
					$i = 0;
					while($i < $count) {
					$row = mysql_fetch_array($result);
					extract($row);
					$stars = str_repeat('<img src="lib/img/star.png" class="ratingstars" alt="rating star" />',$rating);
					if (empty($rating)) {$stars = "Not Rated";}

					echo "
                        <tbody>
                            <tr>
                            <td class='tabledescription'><a href='recipepage.php?recipeid=$recipeid'>$name</a></td>
                            <td class='tablecategory'>$category</td>
                            <td class='tabletype'>$type</td>
                            <td class='tablename'> $stars </td>
                            <td class='tableview'><div class='button editbutton'><a href='edit_recipepage.php?edit=edit&amp;recipeid=$recipeid'>Edit</a></div></td>
                          <!--  <td class='tableview'><div class='button editbutton'><a href='user.php?action=delete&amp;recipeid=$recipeid'>Delete</a></div></td> -->
                            </tr>
                        </tbody>
					";$i++;
					} 
					
					?>
                                        </table> <? } else { ?>
                                        <div><p>You have no recipes created <div class="button"><a href="recipestepone.php"> Create one now </a></div></p></div> <? } ?>
                    </div>
                    </div>
                </div>
                
            </div> <!-- end recipelist -->
            
            <div id="sidebar" class="rightfloat">
            
            <? 
			$result = mysql_query("SELECT * FROM restaurants JOIN categories ON restaurants.categoryid = categories.categoryid JOIN users ON restaurants.createdby = users.userid JOIN restaurantpictures ON restaurants.restaurantid = restaurantpictures.restaurantid WHERE restaurants.active = 1 AND restaurants.createdby = $_SESSION[userid] ORDER BY restaurants.restaurantid DESC LIMIT 1");
			$row = mysql_fetch_array($result);
			$count = mysql_num_rows($result); if ($count == 0 ) { ?><div class="sidebarsection">
            <h2>Are you a restaurant owner?</h2>
            <div>
            <p>Register your restaurant today and have your restaurant listed</p>
            </div>
            <div class="button">
            <a href="restaurantregistration.php"> Register Your Restaurant </a>
            </div>
            </div>
			<? } else { 
						extract($row);
            echo "<h2>Your Restaurants <span class='small'>[<a href='restaurantregistration.php'>Register</a>]</span></h2>
            <div class='sidebarrestaurant'>
            	<div class='leftfloat'>
                <img src='lib/img"; if ($filename != "nopicture.png"){echo"/$restaurantid";} echo"/175_$filename' alt='$filename'/>
                </div>
                <div class='rightfloat'>
                <p>$restaurantcity</p>
                <p>$restaurantstate, $restaurantzipcode </p>
                </div>
<div class='button floatclear'><a  class='lightbox' href='admin_manage.php?adminrequest=restaurantowner&userid=$_SESSION[userid]'>View Your Restaurants</a></div>            </div>
            ";
             } ?>
			<!-- end section -->
            
            <div class="section">
            	<h2>Your Location <span class='small'>[<a href='signup.php?action=edit'>Change</a>]</span></h2>
                <div class="sidebox">
                    <div class='leftfloat'>
                    <p><? echo $_SESSION['city']; ?> <? echo "$_SESSION[state], $_SESSION[zipcode]"; ?></p>
                    </div>
                </div>
            </div> <!-- END SECTION -->
            
            	<div id="userfavoriateslist" class="sidebarsection">
                	<h2>Your Favorite Recipes</h2>
                    
                    <?
					$sql = "SELECT * FROM recipefavoriates JOIN recipes ON recipefavoriates.recipeid = recipes.recipeid WHERE recipefavoriates.active = 1 AND recipefavoriates.userid = $_SESSION[userid]";
					$result = mysql_query($sql);
					$count = mysql_num_rows($result);
					if($count > 0) {
					$i = 0;
					while($i < $count) {
						$row = mysql_fetch_array($result);
						extract($row);
                        echo "<div class='newrecipebox'><a href='recipepage.php?recipeid=$recipeid'><p class='leftfloat'><span>$name</span></p></a><div class='rightfloat favoritedelete'><a href='#$recipeid'><img src='lib/img/delete.png' alt='delete from favorite'/><a></div><a href='recipepage.php?recipeid=$recipeid'><p class='rightfloat'>view</p></a></div>";
					$i++;
					} } else { echo "You have no favorites"; }
					?>
                    
                </div>
                
            </div> <!-- end sidebar -->
            
        </div> <!-- end maincontent -->
    </div> <!-- end container -->
<? include('lib/inc/footer.inc.php');?>


</body>
</html>
