<?
include ('lib/inc/db.inc.php');
$msg = $_REQUEST['msg'];

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

<body id="signuppage" class="fullwidth">
<? include('lib/inc/header.inc.php'); ?>
<div id="container">
  <div id="breadcrumb"><a href="index.php">Home </a>><a href="user.php"> My Account</a>><span class="currentbreadcrumb"> Recipe Step One</span></div>
  <div id="maincontent" class="floatclear">
    <div id="recipelist" class="leftfloat">
      <div class="header">
        <h1>Step 1 - Setting up your recipe</h1>
      </div>
      <div id="signupform">
        <div class="innerborder">
          <form action="recipesteptwo.php" method="post">
            <p>How many ingredients will your recipe need?<span class="required">*</span></p>
            <input type="text" id="ingredientnumber" name="ingredientnumber" required   />
            <p>How many steps will your recipe require?<span class="required">*</span></p>
            <input type="text" id="recipestepnumber" name="recipestepnumber" required   />
            <input type="submit" id ="steponesubmit" value="Step Two" class="button" />
            <p>Max = 20 ingredients or steps</p>
            <? echo $msg; ?>
          </form>
      </div>
    </div>
    <!-- end recipelist --> 
    
  </div>
  <!-- end sidebar --> 
  
</div>
<!-- end maincontent -->
</div>
<!-- end container -->
<? include('lib/inc/footer.inc.php');?>
</body>
</html>
