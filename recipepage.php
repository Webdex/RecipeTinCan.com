<? include ('lib/inc/db.inc.php');
$msg = $_REQUEST['msg'];

$recipeid = $_REQUEST['recipeid'];
$action = $_REQUEST['action'];
$rating = $_REQUEST['rating'];


$sql = "SELECT * FROM reciperating WHERE recipeid = $recipeid"; // start rating get
$result = mysql_query($sql);
$votes = mysql_num_rows($result);
$row = mysql_fetch_array($result);
$i = 0;
$total ="";
while($i < $votes) {
	$total += mysql_result($result, $i,'reciperating'); //add up totals
	$i++;
}
if ($votes > 0) { //check if any votes exist
$rating = round($total / $votes); //find adverage
//end rating get
}

// get recipe information
$sql = "SELECT * FROM recipes JOIN users ON recipes.createdby = users.userid WHERE recipeid = $recipeid LIMIT 1";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
extract($row);

$sql = "SELECT * FROM recipepictures WHERE recipeid = $recipeid LIMIT 1";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
extract($row);

$result = mysql_query("SELECT * FROM categories WHERE categoryid=$categoryid LIMIT 1");
$row = mysql_fetch_array($result);
$categoryname = $row['category'];
// end get recipe information

//check if user has voted on this recipe
$sql = "SELECT * FROM reciperating WHERE recipeid = $recipeid AND ratedby = $_SESSION[userid]";
$result = mysql_query($sql);
if ($result) {
$userhasvoted = mysql_num_rows($result);
}
//end check if user has voted

if ($action == "favoriate") {
	 $result = mysql_query("SELECT * FROM recipefavoriates WHERE userid = $_SESSION[userid] AND recipeid = $recipeid AND active = 1"); //check if it is already favoriated by this user
	 $count = mysql_num_rows($result);
	 if($count == 0) { //if feturns false, confinue
	$sql ="INSERT INTO recipefavoriates";
	$sql .=" (recipefavoriateid, userid, recipeid, active)";
	$sql .="  VALUES (NULL, $_SESSION[userid], $recipeid, 1);";
	$result = mysql_query($sql);
	if($result) {
		$msg = "<p class='sqlconfirm'>$name has been added to your favorites</p>";
	} else {
		$msg = "<p class='sqlerror'>There was an error, please try again</p>";

	}
	 }// closes if favoriated check
}//closes if favoriate


if (isset($_POST['submitcomment'])) { //comment post
	extract($_POST);
		if (strlen($comment) > 150) {
				$msg .= "<p class='sqlerror'>Your comment is too long. Please shorten it</p>";
		} else {
		$time = date("Y-m-d");
		$sql ="INSERT INTO recipecomments";
		$sql .=" (commentid, recipeid, comment, createdby, createddate, active)";
		$sql .=" VALUES (NULL, $recipeid, '". mysql_real_escape_string($comment) ."', $_SESSION[userid], '$time', 1)";
		$result = mysql_query($sql);
		$count = mysql_affected_rows();
			if($count == 1) {
				$msg .= "<p class='sqlconfirm'>Comment Posted Sucessfully</p>";
			} else {
				$msg .= "<p class='sqlerror'>There was problem, please try again</p>";
			}
		}
}//closes if comment

if(isset($_POST['report'])) {
	extract($_POST);
	 $time = date("Y-m-d");
	$sql = "INSERT INTO reports";
	$sql .= " (reportid, recipeid, description, createdby, createddate, active)";
	$sql .= " VALUES (NULL, $recipeid, '".mysql_real_escape_string($reportdescription)."', $_SESSION[userid], '$time', 1);";
	$result = mysql_query($sql);
	if ($result) {
		$msg = "<p class='sqlconfirm'>Your report has been submitted for admin review</p>";
	} else {
		$msg = "<p class='sqlerror'>There was an error, please try again.</p>";
	}
}//closes if report
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><? echo $name;?> - Recipetincan</title>
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.9.0/build/reset/reset-min.css" />
<link rel="stylesheet" type="text/css" href="lib/css/styles.css" />
<link media="screen" href="lib/js/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.css" type="text/css" rel="stylesheet">
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>

<body id="recipepage">
<? include('lib/inc/header.inc.php'); ?>
<script type="text/javascript">
var recipeid = <?php echo json_encode($_GET[recipeid]); ?>; 
</script> 
<script type="text/javascript" src="lib/js/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.pack"></script> 
<script type="text/javascript" src="lib/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script> 
<script type="text/javascript">
$(document).ready(function() {
tinyMCE.init({
        mode : "textareas",
		theme : "simple"    
});
$('#reciperating').rating('rating.php', {maxvalue:5});
});

</script> 
<script type="text/javascript" src="lib/js/rating.js"></script> 
<? echo $msg; ?>
<div id="container">
  <div id="breadcrumb"><a href="index.php">Home </a>> <a href="category.php?categoryid=<? echo $categoryid?>"> <? echo $categoryname; ?></a>><span class="currentbreadcrumb"> <? echo $name; ?></span></div>
  <div id="maincontent" class="floatclear">
    <div id="recipelist" class="leftfloat">
      <div class="header">
        <h1><? echo "$fname's $name"; ?>
          <? 
				  $i=0;
				  while($i < $rating) {
					  echo '<img src="lib/img/star.png" class="ratingstars" alt="rating star" />';
					  $i++;
				  }
				  $outof = 5;
				  $outof = $outof - $rating;
				  
				  $blankstars = str_repeat('<img src="lib/img/star2.png" class="ratingstars" alt="blank rating star" />',$outof);
				  echo $blankstars;
                  
                   ?>
        </h1>
      </div>
      <div class="outerbox">
        <div id="mainpicture">
          <div class="innerborder">
            <?
						if (!empty($filename)) {
                    	echo"<a href ='lib/img/$recipeid/$filename' class='lightbox'><img src='lib/img/$recipeid/680_$filename' class='mainpicture' alt='recipepicture' /></a>";} else {
						echo"<img src='lib/img/noimage.png' class='mainpicture' alt='recipepicture' />";	
						}
						?>
            <div id="recipeoptions">
<? if($_SESSION['logged_in'] != 1) { ?>                     
              <div id="favoriatebutton" class="leftfloat"><img src="lib/img/package_favourite.png" alt="Favorite icon" /><a href="login.php">Sign in to Favorite</a></div>
              <? } ?>
              <? if($_SESSION['logged_in'] == 1) {
				  $result = mysql_query("SELECT * FROM recipefavoriates WHERE userid = $_SESSION[userid] AND recipeid = $recipeid AND active = 1");
				  $count = mysql_num_rows($result);
				  
						if ($count > 0) {
					   ?>
              <div id="favoriatebutton" class="leftfloat"><img src="lib/img/package_favourite.png" alt="favorites icon" />Favorited</div>
					   <? } else { ?>
              <div id="favoriatebutton" class="leftfloat"><a href="recipepage.php?action=favoriate&recipeid=<? echo $recipeid?>"><img src="lib/img/package_favourite.png"  alt="Favorite icon"/>Add to Favorites</a></div>
					 <? } } ?>
                     
              <div id="printbutton" class="leftfloat"><img src="lib/img/printer.png" alt="print button"/><a href="printpage.php?rid=<? echo $recipeid;?>" target="_blank">Print</a></div>
              <div id="facebookbutton" class="leftfloat">Share:<div class="rightfloat"><a href="http://www.facebook.com/sharer.php?u=http://www.recipetincan.com/recipepage.php?recipeid=<? echo $recipeid; ?>
&amp;t=Recipetincan-<? echo"'". preg_replace('/ /','%20',$name) ."'"; ?>" target="_blank"><img src="lib/img/facebook.png" alt="Facebook share" /></a></div></div>
<? if($_SESSION['logged_in'] == 1) { ?>                     
              <div id="reportbutton" class="rightfloat"><a href="report.php?recipeid=<? echo $recipeid;?>" class="lightbox">Flag</a></div>
              <? 
			  if ($userhasvoted > 0) {
			  ?>
              <div id ="reciperating_thankyou" style="display:block;" class="rating leftfloat">
              Thank you for your vote
              </div>
              <? } else {?>
              <div id ="reciperating_thankyou" class="rating leftfloat">
              Thank you for your vote
              </div>
              <div id ="reciperating" class="rating leftfloat">
                <p class="leftfloat">Rate:</p>
              </div>
              <? } //closes if user has voted 
			  } else { ?>
            	<div class="leftfloat">
                <a href="login.php">Sign In</a> to rate this recipe
                </div>
                <? }//closes if logged in ?>
            </div>
            
 
            
            <!-- end Recipe Options --> 
          </div>
        </div>
        <div id="ingredients">
          <div class="innerborder">
            <h2>Ingredients</h2>
            <ul>
              <?
						$sql = "SELECT * FROM recipeingredients WHERE recipeid=$recipeid";
						$result = mysql_query($sql);
						$count = mysql_num_rows($result);
							$i = 0;
							while($i < $count) {
							$ingredient = mysql_result($result, $i, "ingredient");	
							echo stripslashes("<li class='leftfloat ingredient'>$ingredient</li> ");
							$i++;
							}
						
						
						 ?>
            </ul>
          </div>
        </div>
        <div class="recipestep">
          <? 
						$sql = "SELECT * FROM recipesteps WHERE recipeid=$recipeid ORDER BY stepnumber";
						$result = mysql_query($sql);
						$count = mysql_num_rows($result);
						$i=0;
						while($i < $count) {
							$recipestepheader = mysql_result($result, $i, "recipestepheader");
							$recipestep = mysql_result($result, $i, "recipestepdescription");	
                    	echo stripslashes("<h2>$recipestepheader</h2>
                        $recipestep");
						$i++;
						}
					?>
        </div>
      </div>
    </div>
    <!-- end recipelist -->
    
    <div id="sidebar" class="rightfloat">
    
    <?
						$row = mysql_fetch_array(mysql_query("SELECT createdby FROM recipes WHERE recipeid = $recipeid"));
						$createdby = $row['createdby'];
	 if( $createdby == $_SESSION['userid']) { ?>
        <div class="optionbox">
        <p>This is your recipe <? echo $fname;?> </p>
        <div class="button"> <a href="edit_recipepage.php?edit=edit&amp;recipeid=<? echo $recipeid; ?>">Edit</a> </div>
        
        <p class="centered">Or</p>
        <div class="button deletebutton"> <a href="user.php?action=delete&amp;recipeid=<? echo $recipeid; ?>">Delete</a> </div>
        </div> 
	<? } ?>
      <div id="recipeinfo">
        <div id="description">
          <h2>Recipe Description</h2>
          <? echo $text;?>
        </div>
        <div id="category">
          <p>
            <? 
						echo "Category: $categoryname";?>
          </p>
        </div>
        <div id="type">
          <p>
            <? 
						$result = mysql_query("SELECT * FROM type WHERE typeid=$typeid LIMIT 1");
						$row = mysql_fetch_array($result);
						$type = $row['type'];
						echo "Type: $type";?>
          </p>
        </div>
        
                    <div id="preptime">
                    	<p><? echo "Preptime: $preptime"; ?></p>
                    </div>
                    <div id="cooktime">
                    	<p><? echo "Cooktime: $cooktime"; ?></p>
                    </div>
      </div>
      <div>
        <div id="commentform">
          <div class="header">
            <h3>Comments</h3>
          </div>
          <? if ($_SESSION['logged_in'] != 1) { ?>
          <p id="commentlogin"><a href="login.php">Sign In</a> to post a comment</p>
          <? } else {?>
          <form action="recipepage.php" method="post">
            <textarea name="comment"> Write your comment here</textarea>
            <input id="submit" type="submit" class="button" name="submitcomment" Value="Comment" />
            <input type="hidden" name="recipeid" value="<? echo $recipeid; ?>" />
          </form>
      <? }//closes if logged in ?>
        </div>
        <?
		$sql = "SELECT * FROM recipecomments JOIN users ON recipecomments.createdby = users.userid WHERE recipecomments.recipeid = $recipeid LIMIT 10";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
		for ($i =0; $i < $count; $i++) {
			$row = mysql_fetch_array($result);
			extract($row);
			$createddate = mysql_result($result, $i, "recipecomments.createddate");
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
    </div>
    <!-- end sidebar --> 
    
  </div>
  <!-- end maincontent --> 
</div>
<!-- end container -->
<? include('lib/inc/footer.inc.php');?>
</body>
</html>
