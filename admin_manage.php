<? include ('lib/inc/db.inc.php');

$adminrequest = $_GET['adminrequest'];


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
    <script type="text/javascript" src="lib/js/jquery.js"> </script>
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.9.0/build/reset/reset-min.css" />
<link rel="stylesheet" type="text/css" href="lib/css/styles.css" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>

<body id="adminmanagepage">


                    <? // utilities admin
					if ($adminrequest == "utilities") { //checks admin request
					echo "<h1>Manage Site Utilities Admin $_SESSION[fname]</h1>"; ?>
                    
                    <div class="sidebox">
                    <h3>Create a new category</h3>
                    	<form action="admin.php" method="post">
                        	<input type="text" value="Category Name" class="clear" name="categoryname" /> 
                            <input type="submit" value="Create" class="button" name="addcategory"  />
                        </form>
                    </div>					
					<? $result = mysql_query("SELECT * FROM categories ORDER BY categoryid");
$count = mysql_num_rows($result);

					if ($count >= 1) { //makes sure at least 1 recipe is found
					?>
                    <table>
					                        <thead>
                        <tr>
                            <th>Category Id</th>
                            <th>Category</th>
                            <th># of Recipes</th>
                            <th>Status</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?
					
					
					$i = 0;
					while($i < $count) {
					$row = mysql_fetch_array($result);
					extract($row);
					$recipenumbersql = mysql_query("SELECT recipeid FROM recipes WHERE categoryid = $categoryid AND recipes.active = 1");
					$recipenumber = mysql_num_rows($recipenumbersql);
					echo "
                            <tr>
                            <td class='tabletype'><a href='recipepage.php?recipeid=$recipeid'>$categoryid</a></td>
                            <td class='tablename'>$category</td>
                            <td class='tabletype'>$recipenumber</td>
                            <td class='tableview'>"; if ($active == "0"){echo"Disabled";} else {echo"Enabled"; }  echo"</td>
                            <td class='tableview'>"; if ($active == "0"){echo"<div class='button editbutton'><a href='admin.php?adminrequest=categoryrestore&id=$categoryid'>Restore</a></div>";} else {echo"<div class='button deletebutton'><a href='admin.php?adminrequest=categorydelete&id=$categoryid'>Disable</a></div>"; }  echo"</td>
                            </tr>
					";$i++;
					}
					
					?>
                        </tbody>
                                        </table> <? } else { ?>
                                        <div><p>There are no categories created </p></div> 
										<? } //closes recipe check ?>
										
										
                    <div class="sidebox">
                    <h3>Create a new type</h3>
                    	<form action="admin.php" method="post">
                        	<input type="text" value="Type Name" class="clear" name="typename" /> 
                            <input type="submit" value="Create" class="button" name="addtype"  />
                        </form>
                    </div>					
					<? $result = mysql_query("SELECT * FROM type ORDER BY typeid");
$count = mysql_num_rows($result);

					if ($count >= 1) { //makes sure at least 1 type is found
					?>
                    <table>
					                        <thead>
                        <tr>
                            <th>Type Id</th>
                            <th>Type</th>
                            <th># of Recipes</th>
                            <th>Status</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?
					
					
					$i = 0;
					while($i < $count) {
					$row = mysql_fetch_array($result);
					extract($row);
					$recipenumbersql = mysql_query("SELECT typeid FROM recipes WHERE typeid = $typeid AND recipes.active = 1");
					$recipenumber = mysql_num_rows($recipenumbersql);
					echo "
                            <tr>
                            <td class='tabletype'><a href='recipepage.php?recipeid=$recipeid'>$typeid</a></td>
                            <td class='tablename'>$type</td>
                            <td class='tabletype'>$recipenumber</td>
                            <td class='tableview'>"; if ($active == "0"){echo"Disabled";} else {echo"Enabled"; }  echo"</td>
                            <td class='tableview'>"; if ($active == "0"){echo"<div class='button editbutton'><a href='admin.php?adminrequest=typerestore&id=$typeid'>Restore</a></div>";} else {echo"<div class='button deletebutton'><a href='admin.php?adminrequest=typedelete&id=$typeid'>Disable</a></div>"; }  echo"</td>
                            </tr>
					";$i++;
					}
					
					?>
                        </tbody>
                                        </table> <? } else { ?>
                                        <div><p>There are no types created </p></div> 
										<? } //closes recipe check
										
										
										
										 }//closes request check ?>


                    <? // recipe admin
					if ($adminrequest == "recipes") { //checks admin request
					echo "<h1>Manage Recipes Admin $_SESSION[fname]</h1>";
					$result = mysql_query("SELECT * FROM recipes JOIN categories ON recipes.categoryid = categories.categoryid JOIN type ON recipes.typeid = type.typeid WHERE recipes.active = 1 ORDER BY recipes.recipeid DESC");
$count = mysql_num_rows($result);

					if ($count >= 1) { //makes sure at least 1 recipe is found
					?>
                    <table>
					                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Rating</th>
                            <th>Featured</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?
					
					
					$i = 0;
					while($i < $count) {
					$row = mysql_fetch_array($result);
					extract($row);
										$stars = str_repeat('<img src="lib/img/star.png" class="ratingstars" alt="rating star" />',$rating);
					if (empty($rating)) {$stars = "Not Rated";}

					echo "
                            <tr>
                            <td class='tablename'><a href='recipepage.php?recipeid=$recipeid'>$name</a></td>
                            <td class='tablecategory'>$category</td>
                            <td class='tabletype'>$type</td>
                            <td class='tablename'> $stars </td>
                            <td class='tabletype'>"; if($featured==1){echo"<div class='deleteslideshow'><a href='#$recipeid'></a></div>";} else {echo"<div class='addslideshow'><a href='#$recipeid'></a></div>";} echo"</td>
                            <td class='tableview'><div class='button editbutton'><a href='edit_recipepage.php?edit=edit&recipeid=$recipeid'>Edit</a></div></td>
                            <td class='tableview'><div class='button deletebutton'><a href=\"admin.php?adminrequest=recipes&id=$recipeid&action=delete\">Delete</a></div></td>
                            </tr>
					";$i++;
					}
					
					?>
                        </tbody>
                                        </table> <? } else { ?>
                                        <div><p>There are no recipes created </p></div> 
										<? } //closes recipe check
										 }//closes request check ?>
                                        
                                        
                    <? //restaurant admin
					if ($adminrequest == "restaurants") { //checks admin request
					echo "<h1>Manage Restaurants Admin $_SESSION[fname]</h1>";
					$result = mysql_query("SELECT * FROM restaurants JOIN categories ON restaurants.categoryid = categories.categoryid JOIN users ON restaurants.createdby = users.userid WHERE restaurants.active = 1");
$count = mysql_num_rows($result);

					if ($count >= 1) { //makes sure at least 1 recipe is found
					?>
                    <table>
					                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Created by</th>
                            <th>Category</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Zip</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?
					
					
					$i = 0;
					while($i < $count) {
					$row = mysql_fetch_array($result);
					extract($row);
					echo "
                            <tr>
                            <td class='tablename'><a href='restaurantpage.php?restaurantid=$restaurantid'>$restaurantname</a></td>
                            <td class='tablecategory'>$fname</td>
                            <td class='tablecategory'>$category</td>
                            <td class='tablename'> $restaurantaddress </td>
                            <td class='tablename'> $restaurantcity </td>
                            <td class='tablename'> $restaurantstate </td>
                            <td class='tablename'> $restaurantzipcode </td>
                            <td class='tableview'><div class='button editbutton'><a href='edit_restaurantpage.php?restaurantid=$restaurantid'>Edit</a></div></td>
                            <td class='tableview'><div class='button deletebutton'><a href=\"admin.php?adminrequest=restaurants&id=$restaurantid&action=delete\">Delete</a></div></td>
                            </tr>
					";$i++;
					}
					
					?>
                        </tbody>
                                        </table> <? } else { ?>
                                        <div><p>There are no restaurants created </p></div> 
										<? } //closes recipe check
										 }//closes request check ?>




                    <? //restaurant owner administration
					if ($adminrequest == "restaurantowner") { //checks admin request
					echo "<h1>Manage Your Restaurants $_SESSION[fname]</h1>";
					$result = mysql_query("SELECT * FROM restaurants JOIN categories ON restaurants.categoryid = categories.categoryid WHERE restaurants.active = 1 AND restaurants.createdby = $_SESSION[userid]");
$count = mysql_num_rows($result);

					if ($count >= 1) { //makes sure at least 1 recipe is found
					?>
                    <table>
					                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Zip</th>
                            <th>Rating</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?
					
					
					$i = 0;
					while($i < $count) {
					$row = mysql_fetch_array($result);
					extract($row);
					echo "
                            <tr>
                            <td class='tablename'><a href='restaurantpage.php?restaurantid=$restaurantid'>$restaurantname</a></td>
                            <td class='tablename'>$category</td>
                            <td class='tablename'> $restaurantaddress </td>
                            <td class='tablename'> $restaurantcity </td>
                            <td class='tablename'> $restaurantstate </td>
                            <td class='tablename'> $restaurantzipcode </td>
                            <td class='tablename'> (Rating) </td>
                            <td class='tableview'><div class='button editbutton'><a href='edit_restaurantpage.php?restaurantid=$restaurantid'>Edit</a></div></td>
                            <td class='tableview'><div class='button deletebutton'><a href=\"admin.php?adminrequest=restaurants&id=$restaurantid&action=delete\">Delete</a></div></td>
                            </tr>
					";$i++;
					}
					
					?>
                        </tbody>
                                        </table> <? } else { ?>
                                        <div><p>There are no restaurants created </p></div> 
										<? } //closes restaurants check
										 }//closes request check ?>

                                        
                                        
                    <? //users admin
					if ($adminrequest == "users") { //checks admin request
					echo "<h1>Manage Users Admin $_SESSION[fname]</h1>";
					$result = mysql_query("SELECT * FROM users JOIN usertype ON users.usertypeid = usertype.usertypenumber WHERE users.active = 1");
$count = mysql_num_rows($result);

					if ($count >= 1) { //makes sure at least 1 recipe is found
					?>
                    <table>
					                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>User Type</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Zip</th>
                            <th>Make Admin</th>
                            <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?
					
					
					$i = 0;
					while($i < $count) {
					$row = mysql_fetch_array($result);
					extract($row);
					$usertypeid = mysql_result($result, $i, "users.usertypeid");
					echo "
                            <tr>
                            <td class='tablename'>$fname $lname</td>
                            <td class='tablename'><a href='mailto:$email'>$email</a></td>
                            <td class='tablename'>$usertype</td>
                            <td class='tablename'>$city</td>
                            <td class='tablename'> $state </td>
                            <td class='tablename'> $zipcode </td>
                            <td class='tableview'>";
							if($usertypeid == 300) {
							echo"<div class=' button offbutton deletebutton'>Promote</div>";
							} 
							else {
							echo"<div class=' button deletebutton'><a href=\"admin.php?adminrequest=users&id=$userid&action=promote\">Promote</a></div>";
							}
							echo"</td>
                            <td class='tableview'><div class='button deletebutton'><a href=\"admin.php?adminrequest=users&id=$userid&action=delete\">Delete</a></div></td>
                            </tr>
					";$i++;
					}
					
					?>
                        </tbody>
                                        </table> <? } else { ?>
                                        <div><p>There are no users created </p></div> 
										<? } //closes recipe check
										 }//closes request check ?>



                    <? //users admin
					if ($adminrequest == "alerts") { //checks admin request
					echo "<h1>Manage Alerts Admin $_SESSION[fname]</h1>";
					$result = mysql_query("SELECT * FROM reports JOIN users ON reports.createdby = users.userid JOIN recipes ON reports.recipeid = recipes.recipeid WHERE reports.active = 1");
$count = mysql_num_rows($result);

					if ($count >= 1) { //makes sure at least 1 is found
					?>
                    <h3>Recipe Alerts</h3>
                    <table>
					                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Report by</th>
                            <th>Email</th>
                            <th>Report Description</th>
                            <th>Ignore</th>
                            <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?
					
					
					$i = 0;
					while($i < $count) {
					$row = mysql_fetch_array($result);
					extract($row);
					echo "
                            <tr>
                            <td class='tablename'><a href='recipepage.php?recipeid=$recipeid'>$name</a></td>
                            <td class='tablename'>$fname</td>
                            <td class='tablename'><a href='mailto:$email'>$email</a></td>
                            <td class='tabledescription'>$description</td>
                            <td class='tableview'><div class='button'><a href=\"admin.php?adminrequest=recipereport&reportid=$reportid&id=$recipeid&action=ignore\">Ignore</a></div></td>
                            <td class='tableview'><div class='button'><a href=\"admin.php?adminrequest=recipereport&reportid=$reportid&id=$recipeid&action=delete\">Delete</a></div></td>
                            </tr>
					";$i++;
					}
					
					?>
                        </tbody>
                                        </table> <? } else { ?>
                                        <div><p>There are no Recipe alerts </p></div> 
										<? } //closes alert check



					$result = mysql_query("SELECT * FROM reports JOIN restaurants ON reports.restaurantid = restaurants.restaurantid JOIN users ON restaurants.createdby = users.userid WHERE reports.active = 1");
$count = mysql_num_rows($result);

					if ($count >= 1) { //makes sure at least 1 is found
					?>
                    <h3>Restaurant Alerts</h3>
                    <table>
					                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Report by</th>
                            <th>Email</th>
                            <th>Report Description</th>
                            <th>Ignore</th>
                            <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?
					
					
					$i = 0;
					while($i < $count) {
					$row = mysql_fetch_array($result);
					extract($row);
					echo "
                            <tr>
                            <td class='tablename'><a href='restaurantpage.php?restaurantid=$restaurantid'>$restaurantname</a></td>
                            <td class='tablename'>$fname</td>
                            <td class='tablename'><a href='mailto:$email'>$email</a></td>
                            <td class='tabledescription'>$description</td>
                            <td class='tableview'><div class='button'><a href=\"admin.php?adminrequest=restaurantreport&reportid=$reportid&id=$restaurantid&action=ignore\">Ignore</a></div></td>
                            <td class='tableview'><div class='button'><a href=\"admin.php?adminrequest=restaurantreport&reportid=$reportid&id=$restaurantid&action=delete\">Delete</a></div></td>
                            </tr>
					";$i++;
					}
					
					?>
                        </tbody>
                                        </table> <? } else { ?>
                                        <div><p>There are no Restaurant alerts </p></div> 
										<? } //closes alert check



					$result = mysql_query("SELECT * FROM restaurants JOIN users ON restaurants.createdby = users.userid WHERE restaurants.active = 3");
$count = mysql_num_rows($result);

					if ($count >= 1) { //makes sure at least 1 is found
					?>
                    <h3>Restaurant Submissionss</h3>
                    <table>
					                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Created by</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City </th>
                            <th>State</th>
                            <th>Address</th>
                            <th>Zipcode</th>
                            <th>Edit</th>
                            <th>Deny</th>
                            <th>Approve</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?
					
					
					$i = 0;
					while($i < $count) {
					$row = mysql_fetch_array($result);
					extract($row);
					echo "
                            <tr>
                            <td class='tablename'><a href='restaurantpage.php?restaurantid=$restaurantid'>$restaurantname</a></td>
                            <td class='tablename'>$fname</td>
                            <td class='tablename'>$<a href='mailto:$email'>email</a></td>
                            <td class='tablename'>$restaurantphone</td>
                            <td class='tablename'>$restaurantcity</td>
                            <td class='tablename'>$restaurantstate</td>
                            <td class='tablename'>$restaurantaddress</td>
                            <td class='tablename'>$restaurantzipcode</td>
                            <td class='tableview'><div class='button editbutton'><a href='edit_restaurantpage.php?restaurantid=$restaurantid'>Edit</a></div></td>
                            <td class='tableview'><div class='button deletebutton'><a href=\"admin.php?adminrequest=restaurantrequest&id=$restaurantid&action=deny\">Deny</a></div></td>
                            <td class='tableview'><div class='button deletebutton'><a href=\"admin.php?adminrequest=restaurantrequest&id=$restaurantid&action=approve\">Approve</a></div></td>
                            </tr>
					";$i++;
					}
					
					?>
                        </tbody>
                                        </table> <? } else { ?>
                                        <div><p>There are no Restaurant submissions </p></div> 
										<? } //closes alert check





										 }//closes request check ?>


                                        
</body>
</html>