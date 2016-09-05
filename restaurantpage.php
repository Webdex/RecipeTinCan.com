<? include ('lib/inc/db.inc.php');
$msg = $_REQUEST['msg'];

$restaurantid = $_REQUEST['restaurantid'];
$action = $_REQUEST['action'];
$sql = "SELECT * FROM restaurants WHERE restaurantid = $restaurantid AND active = 1 LIMIT 1";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
extract($row);

$sql = "SELECT * FROM restaurantpictures WHERE restaurantid = $restaurantid LIMIT 1";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
extract($row);

						$result = mysql_query("SELECT * FROM categories WHERE categoryid=$categoryid LIMIT 1");
						$row = mysql_fetch_array($result);
						$categoryname = $row['category'];
						
if(isset($_POST['report'])) {
	extract($_POST);
	 $time = date("Y-m-d");
	$sql = "INSERT INTO reports";
	$sql .= " (reportid, restaurantid, description, createdby, createddate, active)";
	$sql .= " VALUES (NULL, $restaurantid, '".mysql_real_escape_string($reportdescription)."', $_SESSION[userid], '$time', 1);";
	$result = mysql_query($sql);
	if ($result) {
		$msg = "<p class='sqlconfirm'>Your report has been submitted for admin review</p>";
	} else {
		$msg = "<p class='sqlerror'>There was an error, please try again.</p>";
	}
}//closes if report

if (isset($_POST['submitcomment'])) { //comment post
	extract($_POST);
		if (strlen($comment) > 150) {
				$msg .= "<p class='sqlerror'>Your comment is too long. Please shorten it</p>";
		} else {
		$time = date("Y-m-d");
		$sql ="INSERT INTO restaurantcomments";
		$sql .=" (commentid, restaurantid, comment, createdby, createddate, active)";
		$sql .=" VALUES (NULL, $restaurantid, '". mysql_real_escape_string($comment) ."', $_SESSION[userid], '$time', 1)";
		$result = mysql_query($sql);
		$count = mysql_affected_rows();
			if($count == 1) {
				$msg .= "<p class='sqlconfirm'>Comment Posted Sucessfully</p>";
			} else {
				$msg .= "<p class='sqlerror'>There was problem, please try again</p>";
			}
		}
}//closes if comment

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>RecipeTinCan</title>
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.9.0/build/reset/reset-min.css" />
<link rel="stylesheet" type="text/css" href="lib/css/styles.css" />
<link media="screen" href="lib/js/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.css" type="text/css" rel="stylesheet">
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>

<body id="categorypage">
<? include('lib/inc/header.inc.php'); ?>  
<script type="text/javascript" src="lib/js/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.pack"></script>
<script type="text/javascript" src="lib/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
        mode : "textareas",
		theme : "simple"    
});
</script>
<? echo $msg;?>
    <div id="container">
    <div id="breadcrumb"><a href="index.php">Home </a>> <a href="restaurants.php"> Restaurants</a>><span class="currentbreadcrumb"> <? echo $restaurantname; ?></span></div>
        
        <div id="maincontent" class="floatclear">
        	<div id="recipelist" class="leftfloat">
            	<div class="header">
            	  <h1><? echo $restaurantname; ?></h1>
                </div>
                <div class="outerbox"> 
                	<div id="mainpicture">
                     <div class="innerborder">               
						<?
                    	echo"<a href ='lib/img/$restaurantid/$filename' class='lightbox'><img src='lib/img";if ($filename != "nopicture.png"){echo"/$restaurantid";}echo"/680_$filename' class='mainpicture' alt='restaurantpicture' /></a>";
						
						
					?>
<div id="recipeoptions">
<div id="reportbutton" class="rightfloat"><a href="report.php?restaurantid=<? echo $restaurantid;?>" class="lightbox">Flag</a></div>  
</div>
                 </div>
                    </div>
                    
                    <div id="ingredients">
                    <div class="innerborder"> 
                        <? 
							if(!empty($restaurantdescription)) {
								echo stripslashes("$restaurantdescription");
							} else {
							echo "<p>No Description has been set.</p>";	
							}
						
						 ?>
                    </div>
                    </div>
                    
                    <div class="recipestep">
                    
                    <? 
	
						echo "Menu Coming Soon";
					?>
					</div>
                
                
                
                
                
                </div>
            </div> <!-- end recipelist -->
            
            <div id="sidebar" class="rightfloat">

                <div id="recipeinfo">
                <div id="description">
                    <h2>Address</h2>
                	<p><? echo " $restaurantaddress <br /> $restaurantcity, $restaurantstate $restaurantzipcode";?></p>
                </div>
                	<div id="type">
                    	<p><? 
						echo "Phone: $restaurantphone";
						?>
                        </p>
                    </div>
                	<div id="category">
                    	<p><? 
						echo "Category: $categoryname";?></p>
                    </div>
                </div>
                
                <div>
                        <div id="commentform">
                    <div class="header"><h3>Comments</h3></div>
          <? if ($_SESSION['logged_in'] != 1) { ?>
          <p id="commentlogin"><a href="login.php">Sign In</a> to post a comment</p>
          <? } else {?>
          <form action="restaurantpage.php" method="post">
            <textarea name="comment"> Write your comment here</textarea>
            <input id="submit" type="submit" class="button" name="submitcomment" Value="Comment" />
            <input type="hidden" name="restaurantid" value="<? echo $restaurantid; ?>" />
          </form>
      <? }//closes if logged in ?>
                        </div>
                    
        <?
		$sql = "SELECT * FROM restaurantcomments JOIN users ON restaurantcomments.createdby = users.userid WHERE restaurantcomments.restaurantid = $restaurantid LIMIT 10";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
		for ($i =0; $i < $count; $i++) {
			$row = mysql_fetch_array($result);
			extract($row);
			$createddate = mysql_result($result, $i, "restaurantcomments.createddate");
        echo stripslashes("<div class=\"comment\">
                 <h3>$fname - <span class=\"small\">$createddate</span></h3>
          <span class=\"bigquote\">\"</span>$comment<span class=\"bigquote\">\"</span>
        </div>");
		}
		if ($count == 0) {
			echo "<p>No Comments. Be the first to write one.</p>";
		}
		?>
                </div>
                

            </div> <!-- end sidebar -->
            
        </div> <!-- end maincontent -->
    </div> <!-- end container -->
<? include('lib/inc/footer.inc.php');?>


</body>
</html>
