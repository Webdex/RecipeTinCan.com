<? include ('lib/inc/db.inc.php');

$adminrequest = $_GET['adminrequest'];
$recipeid = $_REQUEST['recipeid'];
$restaurantid = $_REQUEST['restaurantid'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.9.0/build/reset/reset-min.css" />
<link rel="stylesheet" type="text/css" href="lib/css/styles.css" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"> </script>
    <script type="text/javascript" src="lib/js/jquery.js"> </script>
<script type="text/javascript" src="lib/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
</head>

<body>
<div id="reportpage">
<h1>Why report this <? if (!empty($recipeid)) {?>recipe? <? } else { ?>restaurant? <? } ?></h1>
<form id="reportform" action="<? if (!empty($recipeid)) {echo"recipepage.php";} if (!empty($restaurantid)) { echo"restaurantpage.php";} ?>" method="post"> 
<textarea name="reportdescription" required="required"></textarea>
<div><input type="submit" name="report" class="button" value="Submit Report"/></div>
<input type="hidden" name="recipeid" value="<? echo $recipeid; ?>" />
<input type="hidden" name="restaurantid" value="<? echo $restaurantid; ?>" />
</form>
</div>
</body>
</html>