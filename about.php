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
	$_SESSION['usertypeid'] = $row['usertypeid'];
	$_SESSION['fname'] = $row['fname'];
	 
	 switch($_SESSION['usertypeid']){
	 case '100' : header('location:admin.php');
	 break;
	 case'1' : header('location:user.php');
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
  <div id="breadcrumb"><a href="index.php">Home</a>><span class="currentbreadcrumb"> About</span></div>
  <div id="maincontent" class="floatclear"> <? echo $msg2; ?>
    <div id="recipelist" class="leftfloat">
      <div class="header">
        <h1>Welcome to Recipetincan.com</h1>
      </div>
      <div id="abouttext">
        <p>Recipetincan.com is a food site made for you by you. Here you can upload recipes of your very own and share them with the world. <br />
          <br />
          Recipetincan.com is also a great place to find restaurants in your area. You can also view, rate, and save recipes to your favorites list.</p>
      </div>
    </div>
    <!-- end recipelist -->   
</div>
<!-- end maincontent -->
</div>
<!-- end container -->
<? include('lib/inc/footer.inc.php');?>
</body>
</html>
