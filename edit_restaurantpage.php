<? include ('lib/inc/db.inc.php');
include ('lib/inc/resize-class.php');
$msg = $_REQUEST['msg'];

$restaurantid = $_REQUEST['restaurantid'];

$result = mysql_query("SELECT * FROM restaurants WHERE restaurantid = $restaurantid");
$row = mysql_fetch_array($result);
if ($_SESSION['usertypenumber'] != 300) {
	
	if ($row['active'] == 0 || $row['active'] == 2) {
		header('location:index.php');
	}
	
	if ($_SESSION['logged_in'] == 0 || $row['createdby'] != $_SESSION['userid']) {
		header('location:index.php');
	}
}

						if (isset($_POST['submit'])) {
							extract($_POST);
							$sql = "UPDATE restaurants SET";
							$sql .= " restaurantname = '".mysql_real_escape_string($restaurantname)."',";
							$sql .= " restaurantdescription = '".mysql_real_escape_string($restaurantdescription)."',";
							$sql .= " restaurantcity = '".mysql_real_escape_string($restaurantcity)."',";
							$sql .= " restaurantstate = '".mysql_real_escape_string($restaurantstate)."',";
							$sql .= " restaurantaddress = '".mysql_real_escape_string($restaurantaddress)."',";
							$sql .= " restaurantphone = '".mysql_real_escape_string($restaurantphone)."',";
							$sql .= " restaurantzipcode = '".mysql_real_escape_string($restaurantzipcode)."',";
							$sql .= " categoryid = $restaurantcategory";
							$sql .= " WHERE restaurantid = '$restaurantid' LIMIT 1";
							$result = mysql_query($sql);
							if($result) {
								$msg = "<p class='sqlconfirm'>$restaurantname updated sucessfully</p>";
							} else {
								$msg = "<p class='sqlerror'>There was a problem, please try again</p>";
							} //closes if result
							
								if(!empty($_FILES['photo']['name'])) {
									$sql = "UPDATE restaurantpictures SET filename = '".mysql_real_escape_string($_FILES['photo']['name'])."' WHERE restaurantid = $restaurantid";
									mysql_query($sql);
					
									
	$dirname = $restaurantid;
    $fullpath = "/home/content/39/9219239/html/recipetincan/lib/img/{$dirname}/"; 
    
    if (file_exists($fullpath)) { 
        //$msg .= "The directory {$dirname} exists<br />"; 
    } else { 
        mkdir("/home/content/39/9219239/html/recipetincan/lib/img/{$dirname}/"); 
        //$msg .= "The directory {$dirname} was successfully created.<br />"; 
    }  

if (
($_FILES["photo"]["type"] == "image/gif")
|| ($_FILES["photo"]["type"] == "image/jpeg")
|| ($_FILES["photo"]["type"] == "image/pjpeg")
|| ($_FILES["photo"]["type"] == "image/jpg")
|| ($_FILES["photo"]["type"] == "image/png")
) // Less than 2MB
  {
if ($_FILES["photo"]["size"] < 2000000) {
	
  if ($_FILES["photo"]["error"] > 0) {
    $msg .= "<p class=\"alert\">Error Code: " . $_FILES["photo"]["error"] . "</p>";
    } else {

    if (file_exists($fullpath . $_FILES["photo"]["name"])) {
      $msg .= "<p class=\"alert\">". $_FILES["photo"]["name"] . " already exists.</p>";
      } else {
    move_uploaded_file($_FILES["photo"]["tmp_name"], ($fullpath . $_FILES["photo"]["name"]));
	
	//=================================================================================== Create Thumbnail
	// *** 1) Initialise / load image
	$resizeObj = new resize($fullpath . $_FILES["photo"]["name"]);
if(!resizeObj) { $msg .= "<p class=\"alert\">Didn't create Thumbnail object</p>"; }
	// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
	$resizeObj -> resizeImage(204, 100, 'crop',0);
if(!resizeObj) { $msg .= "<p class=\"alert\">Didn't resize Thumbnail</p>"; }
	// *** 3) Save image
	$resizeObj -> saveImage($fullpath . '175_'.$_FILES["photo"]["name"], 100);
	//=================================================================================== Create Thumbnail
	// *** 1) Initialise / load image
	$resizeObj = new resize($fullpath . $_FILES["photo"]["name"]);
if(!resizeObj) { $msg .= "<p class=\"alert\">Didn't create Thumbnail object</p>"; }
	// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
	$resizeObj -> resizeImage(225, 150, 'auto',0);
if(!resizeObj) { $msg .= "<p class=\"alert\">Didn't resize Thumbnail</p>"; }
	// *** 3) Save image
	$resizeObj -> saveImage($fullpath . '225_'.$_FILES["photo"]["name"], 100);
	//=================================================================================== Create full size
	// *** 1) Initialise / load image
	$resizeObj = new resize($fullpath . $_FILES["photo"]["name"]);
if(!resizeObj) { $msg .= "<p class=\"alert\">Didn't create Full Size object</p>"; }
	// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
	$resizeObj -> resizeImage(400, 175, 'landscape',0);
if(!resizeObj) { $msg .= "<p class=\"alert\">Didn't resize Full Size</p>"; }
	// *** 3) Save image
	$resizeObj -> saveImage($fullpath . '400_'.$_FILES["photo"]["name"], 100);
	//=================================================================================== Create Primary size
	// *** 1) Initialise / load image
	$resizeObj = new resize($fullpath . $_FILES["photo"]["name"]);
if(!resizeObj) { $msg .= "<p class=\"alert\">Didn't create Primary Size object</p>"; }
	// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
	$resizeObj -> resizeImage(680, 380, 'crop',0);
if(!resizeObj) { $msg .= "<p class=\"alert\">Didn't resize Primary Size</p>"; }
	// *** 3) Save image
	$resizeObj -> saveImage($fullpath . '680_'.$_FILES["photo"]["name"], 100);
	//=================================================================================== Change Permissions
	$permissions90 = chmod(($fullpath . '175_'.$_FILES["photo"]["name"]),0755); // MAKE SURE NEW FILE HAS CORRECT PERMISSIONS
	$permissions90 = chmod(($fullpath . '225_'.$_FILES["photo"]["name"]),0755); // MAKE SURE NEW FILE HAS CORRECT PERMISSIONS
	$permissions600 = chmod(($fullpath . '400_'.$_FILES["photo"]["name"]),0755); // MAKE SURE NEW FILE HAS CORRECT PERMISSIONS
	$permissions420 = chmod(($fullpath . '680_'.$_FILES["photo"]["name"]),0755); // MAKE SURE NEW FILE HAS CORRECT PERMISSIONS
		  
	//=================================================================================== Modify Original
	$width = getimagesize($fullpath . $_FILES["photo"]["name"]);
	if($width[0]>1100) {
	// *** 1) Initialise / load image
	$resizeObj = new resize($fullpath . $_FILES["photo"]["name"]);
if(!resizeObj) { $msg .= "<p class=\"alert\">Didn't create Original Size object</p>"; }
	// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
	$resizeObj -> resizeImage(1100, 1100, 'landscape',0);
if(!resizeObj) { $msg .= "<p class=\"alert\">Didn't resize Original Size</p>"; }
	// *** 3) Save image
	$resizeObj -> saveImage($fullpath . $_FILES["photo"]["name"], 100);
	}
	$newwidth = getimagesize($fullpath . $_FILES["photo"]["name"]);
	//=================================================================================== end Modify Original
      } // closes pre-existing file check
    } // closes error check
	
	} else {
  $msg .= "<p class=\"alert\">File Size Too Large. Files must be less than 2MB.</p>";
	}
  } else {
  $msg .= "<p class=\"alert\">Invalid file. Files must be .JPGs, .GIFs, or .PNGs.</p>";
  } // closes invalid file check

									
									
									
									
								} //closes if file upload check
							
							
							
						} //closes update


$sql = "SELECT * FROM restaurants WHERE restaurantid = $restaurantid LIMIT 1";
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
<? echo $msg; ?> 
<script type="text/javascript" src="lib/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script> 
<script type="text/javascript">
tinyMCE.init({
        mode : "textareas",
		theme : "simple"    
});
</script>
<div id="container">
  <div id="breadcrumb"><a href="index.php">Home </a>><a href="restaurants.php"> Restaurants</a>><span class="currentbreadcrumb"> <? echo $restaurantname; ?></span></div>
  <div id="maincontent" class="floatclear">
  <div id="recipelist" class="leftfloat">
  <form action="edit_restaurantpage.php" method="post" enctype="multipart/form-data">
    <div class="header">
      <h1>
        <input name="restaurantname" type="text" id="redipename" class="clear" value="<? echo $restaurantname; ?>" />
      </h1>
    </div>
    <div class="outerbox">
      <div id="mainpicture">
        <div class="innerborder">
          <?
                    	echo"<img src='lib/img";if ($filename != "nopicture.png"){echo"/$restaurantid";}echo"/680_$filename' class='mainpicture' alt='restaurantpicture' />";
					?>
          <input type="file" name="photo" />
        </div>
      </div>
      <div id="ingredients">
        <div class="innerborder">
          <p>Description of your restaurant</p>
          <? 
							if(!empty($restaurantdescription)) {
								echo"<textarea name='restaurantdescription'>$restaurantdescription </textarea>";
							} else {
							echo "<textarea name='restaurantdescription'>No Description has been set. </textarea>";	
							}
						
						 ?>
        </div>
      </div>
      <div class="recipestep">
        <? 
	
						echo "Menu Comming Soon";
					?>
      </div>
    </div>
    </div>
    <!-- end recipelist -->
    
    <div id="sidebar" class="rightfloat">
      <div id="recipeinfo">
        <div id="description">
          <h2>Address</h2>
          <label for="restaurantaddress">Address: </label>
          <input id="restaurantaddress"type='text' name="restaurantaddress" value="<? echo " $restaurantaddress";?>" />
          <label for="restaurantcity">City: </label>
          <input id="restaurantcity"type='text' name="restaurantcity" value="<? echo $restaurantcity;?>" />
          <div>
            <label for="restaurantstate">State:</label>
            <select name="restaurantstate">
              <option value=""  >Select a State</option>
              <option value="AL" <? if ($restaurantstate == "AL") { echo "selected='selected'"; }?> >Alabama</option>
              <option value="AK"<? if ($restaurantstate == "AK") { echo "selected='selected'"; }?>>Alaska</option>
              <option value="AZ"<? if ($restaurantstate == "AZ") { echo "selected='selected'"; }?>>Arizona</option>
              <option value="AR"<? if ($restaurantstate == "AR") { echo "selected='selected'"; }?>>Arkansas</option>
              <option value="CA"<? if ($restaurantstate == "CA") { echo "selected='selected'"; }?>>California</option>
              <option value="CO"<? if ($restaurantstate == "CO") { echo "selected='selected'"; }?>>Colorado</option>
              <option value="CT"<? if ($restaurantstate == "CT") { echo "selected='selected'"; }?>>Connecticut</option>
              <option value="DE"<? if ($restaurantstate == "DE") { echo "selected='selected'"; }?>>Delaware</option>
              <option value="DC"<? if ($restaurantstate == "DC") { echo "selected='selected'"; }?>>District Of Columbia</option>
              <option value="FL"<? if ($restaurantstate == "FL") { echo "selected='selected'"; }?>>Florida</option>
              <option value="GA"<? if ($restaurantstate == "GA") { echo "selected='selected'"; }?>>Georgia</option>
              <option value="HI"<? if ($restaurantstate == "HI") { echo "selected='selected'"; }?>>Hawaii</option>
              <option value="ID"<? if ($restaurantstate == "ID") { echo "selected='selected'"; }?>>Idaho</option>
              <option value="IL"<? if ($restaurantstate == "IL") { echo "selected='selected'"; }?>>Illinois</option>
              <option value="IN"<? if ($restaurantstate == "IN") { echo "selected='selected'"; }?>>Indiana</option>
              <option value="IA"<? if ($restaurantstate == "IA") { echo "selected='selected'"; }?>>Iowa</option>
              <option value="KS"<? if ($restaurantstate == "KS") { echo "selected='selected'"; }?>>Kansas</option>
              <option value="KY"<? if ($restaurantstate == "KY") { echo "selected='selected'"; }?>>Kentucky</option>
              <option value="LA"<? if ($restaurantstate == "LA") { echo "selected='selected'"; }?>>Louisiana</option>
              <option value="ME"<? if ($restaurantstate == "ME") { echo "selected='selected'"; }?>>Maine</option>
              <option value="MD"<? if ($restaurantstate == "MD") { echo "selected='selected'"; }?>>Maryland</option>
              <option value="MA"<? if ($restaurantstate == "MA") { echo "selected='selected'"; }?>>Massachusetts</option>
              <option value="MI"<? if ($restaurantstate == "MI") { echo "selected='selected'"; }?>>Michigan</option>
              <option value="MN"<? if ($restaurantstate == "MN") { echo "selected='selected'"; }?>>Minnesota</option>
              <option value="MS"<? if ($restaurantstate == "MS") { echo "selected='selected'"; }?>>Mississippi</option>
              <option value="MO"<? if ($restaurantstate == "MO") { echo "selected='selected'"; }?>>Missouri</option>
              <option value="MT"<? if ($restaurantstate == "MT") { echo "selected='selected'"; }?>>Montana</option>
              <option value="NE"<? if ($restaurantstate == "NE") { echo "selected='selected'"; }?>>Nebraska</option>
              <option value="NV"<? if ($restaurantstate == "NV") { echo "selected='selected'"; }?>>Nevada</option>
              <option value="NH"<? if ($restaurantstate == "NH") { echo "selected='selected'"; }?>>New Hampshire</option>
              <option value="NJ"<? if ($restaurantstate == "NJ") { echo "selected='selected'"; }?>>New Jersey</option>
              <option value="NM"<? if ($restaurantstate == "NM") { echo "selected='selected'"; }?>>New Mexico</option>
              <option value="NY"<? if ($restaurantstate == "NY") { echo "selected='selected'"; }?>>New York</option>
              <option value="NC"<? if ($restaurantstate == "NC") { echo "selected='selected'"; }?>>North Carolina</option>
              <option value="ND"<? if ($restaurantstate == "ND") { echo "selected='selected'"; }?>>North Dakota</option>
              <option value="OH"<? if ($restaurantstate == "OH") { echo "selected='selected'"; }?>>Ohio</option>
              <option value="OK"<? if ($restaurantstate == "OK") { echo "selected='selected'"; }?>>Oklahoma</option>
              <option value="OR"<? if ($restaurantstate == "OR") { echo "selected='selected'"; }?>>Oregon</option>
              <option value="PA"<? if ($restaurantstate == "PA") { echo "selected='selected'"; }?>>Pennsylvania</option>
              <option value="RI"<? if ($restaurantstate == "RI") { echo "selected='selected'"; }?>>Rhode Island</option>
              <option value="SC"<? if ($restaurantstate == "SC") { echo "selected='selected'"; }?>>South Carolina</option>
              <option value="SD"<? if ($restaurantstate == "SD") { echo "selected='selected'"; }?>>South Dakota</option>
              <option value="TN"<? if ($restaurantstate == "TN") { echo "selected='selected'"; }?>>Tennessee</option>
              <option value="TX"<? if ($restaurantstate == "TX") { echo "selected='selected'"; }?>>Texas</option>
              <option value="UT"<? if ($restaurantstate == "UT") { echo "selected='selected'"; }?>>Utah</option>
              <option value="VT"<? if ($restaurantstate == "VT") { echo "selected='selected'"; }?>>Vermont</option>
              <option value="VA"<? if ($restaurantstate == "VA") { echo "selected='selected'"; }?>>Virginia</option>
              <option value="WA"<? if ($restaurantstate == "WA") { echo "selected='selected'"; }?>>Washington</option>
              <option value="WV"<? if ($restaurantstate == "WV") { echo "selected='selected'"; }?>>West Virginia</option>
              <option value="WI"<? if ($restaurantstate == "WI") { echo "selected='selected'"; }?>>Wisconsin</option>
              <option value="WY"<? if ($restaurantstate == "WY") { echo "selected='selected'"; }?>>Wyoming</option>
            </select>
          </div>
          <div>
            <label for="restaurantzipcode">Zipcode: </label>
            <input id="restaurantzipcode"type='text' name="restaurantzipcode" value="<? echo $restaurantzipcode; ?>" />
          </div>
        </div>
        <div id="category">
          <label for ="restaurantcategory">Category:</label>
          <select name="restaurantcategory" required="required">
            <option value="" >Category of Food</option>
            <?
							$sql = "SELECT * FROM categories ORDER BY category ASC";
							$result = mysql_query($sql);
							$count = mysql_num_rows($result);
							$i=0;
							while ($i < $count) {
								$category = mysql_result($result, $i, "category");
								$recipecategoryid = mysql_result($result, $i, "categoryid");
							echo "<option value='$recipecategoryid'"; if($categoryid == $recipecategoryid) { echo"selected='selected'";} echo">$category</option>";
							$i++;	
							}
							?>
          </select>
        </div>
        <label for="restaurantphone">Phone:</label>
        <input type="text" name="restaurantphone" value="<? echo $restaurantphone; ?>" />
      </div>
    <input type="submit" id="submitrecipe" class="button floatclear" value="Submit Changes" name="submit" />
    </div>
    <!-- end sidebar -->
    
    </div>
    <!-- end maincontent -->
    <input type="hidden" name="restaurantid" value="<? echo $restaurantid;?>" ?>
    
  </form>
</div>
<!-- end container -->
<? include('lib/inc/footer.inc.php');?>
</body>
</html>
