<? include ('lib/inc/db.inc.php');
if($_SESSION['usertypenumber'] != 300 || $_SESSION['usertypenumber'] == 0 ) {
header('location:index.php');
}

$adminrequest = $_REQUEST['adminrequest'];
$action = $_REQUEST['action'];
$id = $_REQUEST['id'];
$reportid = $_REQUEST['reportid'];

if (isset($_POST['addtype'])) {
	extract($_POST);
	$time = date("Y-m-d h:i:s");
	$sql = "INSERT INTO type (typeid, type, createdby, createddate, active)";
	$sql .= "VALUES (NULL, '$typename', '$_SESSION[fname]', '$time', 1);";
	echo $sql;
	$result = mysql_query($sql);
	if ($result) {
		$msg .="<p class=\"sqlconfirm\"> Type has been sucessfully added </p>";
	} else { $msg .="<p class=\"sqlerror\"> There was a problem please try again </p>"; }//closes if the update worked
}//closes if user delete check

if ($adminrequest == "typerestore") {
	$sql = "UPDATE type SET active = 1 WHERE typeid = $id LIMIT 1";
	$result = mysql_query($sql);
	if ($result) {
		$msg .="<p class=\"sqlconfirm\"> Type has been sucessfully restored </p>";
	} else { $msg .="<p class=\"sqlerror\"> There was a problem please try again </p>"; }//closes if the update worked
}//closes if user delete check

if ($adminrequest == "typedelete") {
	$sql = "UPDATE type SET active = 0 WHERE typeid = $id LIMIT 1";
	$result = mysql_query($sql);
	if ($result) {
		$msg .="<p class=\"sqlconfirm\"> Type has been sucessfully disabled </p>";
	} else { $msg .="<p class=\"sqlerror\"> There was a problem please try again </p>"; }//closes if the update worked
}//closes if user delete check




if (isset($_POST['addcategory'])) {
	extract($_POST);
	$time = date("Y-m-d h:i:s");
	$sql = "INSERT INTO categories (categoryid, category, createdby, createddate, active)";
	$sql .= "VALUES (NULL, '$categoryname', '$_SESSION[fname]', '$time', 1);";
	echo $sql;
	$result = mysql_query($sql);
	if ($result) {
		$msg .="<p class=\"sqlconfirm\"> Category has been sucessfully added </p>";
	} else { $msg .="<p class=\"sqlerror\"> There was a problem please try again </p>"; }//closes if the update worked
}//closes if user delete check

if ($adminrequest == "categoryrestore") {
	$sql = "UPDATE categories SET active = 1 WHERE categoryid = $id LIMIT 1";
	$result = mysql_query($sql);
	if ($result) {
		$msg .="<p class=\"sqlconfirm\"> Category has been sucessfully restored </p>";
	} else { $msg .="<p class=\"sqlerror\"> There was a problem please try again </p>"; }//closes if the update worked
}//closes if user delete check

if ($adminrequest == "categorydelete") {
	$sql = "UPDATE categories SET active = 0 WHERE categoryid = $id LIMIT 1";
	$result = mysql_query($sql);
	if ($result) {
		$msg .="<p class=\"sqlconfirm\"> Category has been sucessfully disabled </p>";
	} else { $msg .="<p class=\"sqlerror\"> There was a problem please try again </p>"; }//closes if the update worked
}//closes if user delete check


if ($adminrequest == "users" && $action == "delete") {
	$sql = "UPDATE users SET active = 0 WHERE userid = $id LIMIT 1";
	$result = mysql_query($sql);
	if ($result) {
		$msg .="<p class=\"sqlconfirm\"> User has been sucessfully disabled </p>";
	} else { $msg .="<p class=\"sqlerror\"> There was a problem please try again </p>"; }//closes if the update worked
}//closes if user delete check


if ($adminrequest == "users" && $action == "promote") {
	$sql = "UPDATE users SET usertypeid = 300 WHERE userid = $id LIMIT 1";
	$result = mysql_query($sql);
	if ($result) {
		$msg .="<p class=\"sqlconfirm\"> User has been sucessfully promoted to admin status </p>";
	} else { $msg .="<p class=\"sqlerror\"> There was a problem please try again </p>"; }//closes if the update worked
}//closes if user promote check


if ($adminrequest == "recipes" && $action == "delete") {
	$sql = "UPDATE recipes SET active = 0 WHERE recipeid = $id LIMIT 1";
	$result = mysql_query($sql);
	if ($result) {
		$msg .="<p class=\"sqlconfirm\"> Recipe has been sucessfully disabled </p>";
	} else { $msg .="<p class=\"sqlerror\"> There was a problem please try again </p>"; }//closes if the update worked
}//closes if user delete check

if ($adminrequest == "restaurants" && $action == "delete") {
	$sql = "UPDATE restaurants SET active = 0 WHERE restaurantid = $id LIMIT 1";
	$result = mysql_query($sql);
	if ($result) {
		$msg .="<p class=\"sqlconfirm\"> Restaurant has been sucessfully disabled </p>";
	} else { $msg .="<p class=\"sqlerror\"> There was a problem please try again </p>"; }//closes if the update worked
											if ($SESSION['userid'] != 300) {
											header('Location:user.php');
											}
}//closes if user delete check


if ($adminrequest == "recipereport" && $action == "ignore") {
	$sql = "UPDATE reports SET active = 0, resolvedby = $_SESSION[userid], resolveddate = '$time' WHERE reportid = $reportid LIMIT 1";
	$result = mysql_query($sql);
	echo $sql;
	if ($result) {
		$msg .="<p class=\"sqlconfirm\"> Report has been sucessfully ignored </p>";
	} else { $msg .="<p class=\"sqlerror\"> There was a problem please try again </p>"; }//closes if the update worked
}//closes if alert ignore check

if ($adminrequest == "recipereport" && $action == "delete") {
	$sql = "UPDATE reports SET active = 0, resolvedby = $_SESSION[userid], resolveddate = '$time' WHERE reportid = $reportid LIMIT 1";
	$result = mysql_query($sql);
	
	$sql = "UPDATE recipes SET active = 0 WHERE recipeid = $id";
	$result = mysql_query($sql);
	if ($result) {
		$msg .="<p class=\"sqlconfirm\"> Recipe has been sucessfully deleted </p>";
	} else { $msg .="<p class=\"sqlerror\"> There was a problem please try again </p>"; }//closes if the update worked
}//closes if alert ignore check

if ($adminrequest == "restaurantreport" && $action == "ignore") {
	$sql = "UPDATE reports SET active = 0, resolvedby = $_SESSION[userid], resolveddate = '$time' WHERE reportid = $reportid LIMIT 1";
	$result = mysql_query($sql);
	echo $sql;
	if ($result) {
		$msg .="<p class=\"sqlconfirm\"> Report has been sucessfully ignored </p>";
	} else { $msg .="<p class=\"sqlerror\"> There was a problem please try again </p>"; }//closes if the update worked
}//closes if alert ignore check

if ($adminrequest == "restaurantreport" && $action == "delete") {
	$sql = "UPDATE reports SET active = 0, resolvedby = $_SESSION[userid], resolveddate = '$time' WHERE reportid = $reportid LIMIT 1";
	$result = mysql_query($sql);
	
	$sql = "UPDATE restaurants SET active = 0 WHERE restaurantid = $id";
	$result = mysql_query($sql);
	if ($result) {
		$msg .="<p class=\"sqlconfirm\"> Restaurant has been sucessfully deleted </p>";
	} else { $msg .="<p class=\"sqlerror\"> There was a problem please try again </p>"; }//closes if the update worked
}//closes if alert ignore check


if ($adminrequest == "restaurantrequest" && $action == "deny") {
	$sql = "UPDATE restaurants SET active = 2 WHERE restaurantid = $id LIMIT 1";
	$result = mysql_query($sql);
	echo $sql;
	if ($result) {
		$msg .="<p class=\"sqlconfirm\"> Restaurant has been denied submission </p>";
	} else { $msg .="<p class=\"sqlerror\"> There was a problem please try again </p>"; }//closes if the update worked
}//closes if restaurantrequest ignore check

if ($adminrequest == "restaurantrequest" && $action == "approve") {
	$sql = "UPDATE restaurants SET active = 1 WHERE restaurantid = $id LIMIT 1";	
	$result = mysql_query($sql);
	if ($result) {
		$msg .="<p class=\"sqlconfirm\"> Restaurant has been approved </p>";
	} else { $msg .="<p class=\"sqlerror\"> There was a problem please try again </p>"; }//closes if the update worked
}//closes if restaurantrequest ignore check






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

<body id="adminpage" class="fullwidth">
<? include('lib/inc/header.inc.php'); ?>
<script type="text/javascript" src="lib/js/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.pack"></script> 
<? echo $msg; ?>
<div id="container">
  <div id="breadcrumb"><a href="index.php">Home </a>> <span class="currentbreadcrumb"> My Account</span></div>
  <div id="maincontent" class="floatclear">
    <div class="header">
      <h1>Welcome Admin <? echo $_SESSION['fname'];?> <span class="small">(<a href="user.php">view basic user page</a>)</span></h1>
    </div>
    <div class="outerbox">
      <div class="innerborder">
        <div class="adminbuttonrow">
          <div id="adminrecipebutton" class="adminbox leftbox leftfloat"> <a href="admin_manage.php?adminrequest=recipes" rel="colorbox" class="lightbox"> </a> </div>
          <div id="adminrestaurantbutton" class="adminbox middlebox leftfloat"> <a href="admin_manage.php?adminrequest=restaurants"  rel="colorbox" class="lightbox"> </a> </div>
          <div id="adminusersbutton" class="adminbox rightbox leftfloat"> <a href="admin_manage.php?adminrequest=users" rel="colorbox" class="lightbox"> </a> </div>
        </div>
        <div class="adminbuttonrow">
        <?
							$reports = mysql_num_rows(mysql_query("SELECT * FROM reports WHERE active = 1"));
							$restaurants = mysql_num_rows(mysql_query("SELECT * FROM restaurants WHERE active = 3"));

		?>
          <div id="adminalertbutton" class="adminbox leftbox leftfloat <? if ($reports > 0 || $restaurants > 0) {echo "activealert";}?>"> <a href="admin_manage.php?adminrequest=alerts" rel="colorbox" class="lightbox"> </a> </div>
          
          <div id="adminutilitiesbutton" class="adminbox middlebox leftfloat"> <a href="admin_manage.php?adminrequest=utilities"  rel="colorbox" class="lightbox"> </a> </div>
        </div>
      </div>
    </div>
    <!-- end maincontent --> 
  </div>
</div>
<!-- end container -->
<? include('lib/inc/footer.inc.php');?>
</body>
</html>
