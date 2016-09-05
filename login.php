<?
include ('lib/inc/db.inc.php');
if (isset($_POST['submit'])) {
	if (!empty ($_POST['email']) && !empty ($_POST['password'])) {

$sql = "SELECT createddate FROM users WHERE email = '{$_POST['email']}' LIMIT 1";


$result=mysql_query($sql, $link) or die ('Unable to run query:'.mysql_error());

$count = mysql_num_rows($result);

if ($count) {

$row = mysql_fetch_array($result);

$saltedpassword = md5($_POST['password'].$row['createddate']);

$sql = "SELECT * FROM users WHERE email = '{$_POST['email']}' AND password = '$saltedpassword' AND active = '1' LIMIT 1 ";

$result=mysql_query($sql, $link) or die ('Unable to run query:'.mysql_error());
$count = mysql_num_rows($result);

if ($count) {
	$row = mysql_fetch_array($result);
	$_SESSION['logged_in'] = 1;
	$_SESSION['usertypenumber'] = $row['usertypeid'];
	$_SESSION['fname'] = $row['fname'];
	$_SESSION['userid'] = $row['userid'];
	$_SESSION['city'] = $row['city'];
	$_SESSION['state'] = $row['state'];
	$_SESSION['zipcode'] = $row['zipcode'];
	 
	 switch($_SESSION['usertypenumber']){
		case '100' : header('location:user.php');
		break;
		case '200' : header('location:user.php');
		break;
		case '300' : header('location:admin.php');
		break;
	 default : $error = "<p>epic fail</p>";
	 }
	
}else{
	$msg2 = '<p class="sqlerror">Your username and Password are wrong. Please try again.</p>';
}


} else {
	$msg2 = '<p class="sqlerror">Your username and Password are wrong. Please try again.</p>';
}
	

	
} else {
	$msg2 = '<p class="sqlerror">Email and password are required.</p>';
	}
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

<body id="loginpage" class="fullwidth">
<? include('lib/inc/header.inc.php'); ?>    
    
    <div id="container">
    <div id="breadcrumb"><a href="index.php">Home</a>><span class="currentbreadcrumb"> Sign In</span></div>
        <div id="maincontent" class="floatclear">
        <? echo $msg2; ?>
        	<div id="recipelist" class="leftfloat">
            <div id="announcement"><h2>Welcome to Recipetincan.com</h2><p>Sign in to start creating your own recipes and share them with the world.</p></div>
            	<div class="header">
            	  <h1>Sign In</h1>
               	</div>
                <div id="loginform">
                	<div class="innerborder">
                		<form action="login.php" method="post">
                    		<label for="email">Email: </label><input type="text" id="email" name="email" />
                       	 <label for="password">Password: </label><input type ="password" id="password" name="password" />
                       	 <input type="submit" id="submit" name="submit" value="Sign In" class="button" />
                    </form>
                    </div>
                </div>    
            </div> <!-- end recipelist -->
            
            
            </div> <!-- end sidebar -->
            
        </div> <!-- end maincontent -->
    </div> <!-- end container -->
<? include('lib/inc/footer.inc.php');?>


</body>
</html>
