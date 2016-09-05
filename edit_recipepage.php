<? include ('lib/inc/db.inc.php');
include ('lib/inc/resize-class.php');
$recipeid = $_REQUEST['recipeid'];
$edit = $_REQUEST['edit'];
$sql = "SELECT * FROM recipeingredients WHERE recipeid = $recipeid";
$numcheck = mysql_query($sql);
$ingredientnumber = mysql_num_rows($numcheck);


$sql = "SELECT * FROM recipesteps WHERE recipeid = $recipeid ORDER BY stepnumber";
$numcheck = mysql_query($sql);
$recipestepnumber = mysql_num_rows($numcheck);

if (isset($_POST['submit'])) { 
extract($_POST);

$result = mysql_query("SELECT * FROM recipeingredients WHERE recipeid=$recipeid");
$i = 0;
while($i < $ingredientnumber) {
$recipeingredientid = mysql_result($result, $i, "recipeingredientid");	
$sql = "UPDATE recipeingredients SET ingredient = '".mysql_real_escape_string(${'ingredient'.$i})."' WHERE recipeid = $recipeid AND recipeingredientid = $recipeingredientid   LIMIT 1";
$result2=mysql_query($sql);
$i++;
}//closes while


$result = mysql_query("SELECT * FROM recipesteps WHERE recipeid=$recipeid");
$i = 0;
while($i < $recipestepnumber) {
$recipestepid = mysql_result($result, $i, "recipestepid");	
$sql = "UPDATE recipesteps SET recipestepheader = '".mysql_real_escape_string(${'recipestepheader'.$i})."', recipestepdescription = '".mysql_real_escape_string(${'recipestep'.$i})."'  WHERE recipeid = $recipeid AND recipestepid = $recipestepid   LIMIT 1";
$result2=mysql_query($sql);
$i++;
}//closes while

$sql = "UPDATE recipes SET";
$sql .= " name = \"$recipename\",";
$sql .= " text = \"$recipedesc\",";
$sql .= " categoryid = $recipecategory,";
$sql .= " typeid = $recipetype,";
$sql .= " preptime = '$preptime',";
$sql .= " cooktime = '$cooktime'";
$sql .= " WHERE recipeid = $recipeid LIMIT 1";
$result = mysql_query($sql);
if ($result) {
$msg .= "<p class='sqlconfirm'>Sucessfully Updated</p>";
} else {
$msg .= "<p class='sqlerror'>A problem occured, please try again</p>";
}

								if(!empty($_FILES['photo']['name'])) {
									$sql = "UPDATE recipepictures SET filename = '".mysql_real_escape_string($_FILES['photo']['name'])."' WHERE recipeid = $recipeid";
									mysql_query($sql);
					
									
	$dirname = $recipeid;
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
      unlink($fullpath . $_FILES["photo"]["name"]);
      unlink($fullpath . '175_'.$_FILES["photo"]["name"]);
      unlink($fullpath . '225_'.$_FILES["photo"]["name"]);
      unlink($fullpath . '400_'.$_FILES["photo"]["name"]);
      unlink($fullpath . '680_'.$_FILES["photo"]["name"]);
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
	/*if(!$permissions || !$permissions90) { $msg .= "<p class=\"alert\">Permissions failed to update.</p>"; } else { $msg .= "<p class=\"alert\">File has successfully uploaded.</p>"; }	*/
		  
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


}//closes if upload check
$result = mysql_query("SELECT * FROM recipepictures WHERE recipeid = $recipeid");
$row = mysql_fetch_array($result);
extract($row);
$result= mysql_query("SELECT * FROM recipes WHERE recipeid=$recipeid");
$row = mysql_fetch_array($result);
extract($row);

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
<script type="text/javascript" src="lib/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
        mode : "textareas",
		theme : "simple"    
});
</script>
<? echo $msg;?>
<form id="recipesubmitform" action="edit_recipepage.php" method="post" enctype="multipart/form-data">    <div id="container">
    <div id="breadcrumb">
      <a href="index.php">Home </a>><a href="logincheck.php"> My Account</a>><span class="currentbreadcrumb"> Edit Recipe</span></div>
        
        <div id="maincontent" class="floatclear">
        <div class="header"><h1> Edit your recipe</h1></div>
        	<div id="recipelist" class="leftfloat">
            	<div class="header">
                
            	  <h1><label for="recipename"></label><input class="clear" type="text" id="recipename" value="<? if(isset($edit)) {echo $name;} else {?> Recipe Name <? } ?>" name="recipename" required/></h1>
                </div>
                <div class="outerbox"> 
                	<div id="mainpicture">
                     <div class="innerborder">               

                    	<? if (empty($filename)) {?><img src="lib/img/tempimage.png" class="mainpicture" alt="recipepicture" /> <? } else {?> <img class="mainpicture" alt="recipepicture" src="lib/img/<? echo "$recipeid/680_$filename" ?>"> <? }?>
                        <input type="file" id="photo" name="photo" />
                    </div>
                    </div>
                    
                    <div id="ingredients">
                    <div class="innerborder"> 
                    	<h2>Ingredients</h2>
                        
						<? 
						$sql = "SELECT * FROM recipeingredients WHERE recipeid=$recipeid";
						$result = mysql_query($sql);
						$count = mysql_num_rows($result);
							$i = 0;
							while($i < $count) {
							$ingredient = mysql_result($result, $i, "ingredient");	
							echo "<input type='text' value='$ingredient' name='ingredient$i' /> ";
							$i++;
							}
						
						
						 ?>
                        
                        
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
                    	echo "<h2><input type='text' name='recipestepheader$i' value='$recipestepheader' /></h2>
                        <p><textarea name='recipestep$i'>$recipestep</textarea></p>";
						$i++;
						}
                       ?> 
                        
                    </div>
                
                
                
                
                
                </div>
            </div> <!-- end recipelist -->
            
            <div id="sidebar" class="rightfloat">

                <div id="recipeinfo">
                <div id="description">
                <h2>Recipe Description</h2>
                	<p><label for="recipedesc" ></label><textarea id="recipedesc" name="recipedesc" required><? if(isset($edit)) {echo $text;} else {?>Write a short description of your recipe here.<? } ?></textarea></p>
                </div>
                
                	<div id="category">
                    	<select name="recipecategory" required="required">
                        <option value="" >Category of Food</option>
                        	<?
							$sql = "SELECT * FROM categories WHERE active = 1 ORDER BY category ASC";
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
                	<div id="type">
                    	<select name="recipetype" required="required">
                        <option value="">Type of Food</option>
                        	<?
							$sql = "SELECT * FROM type WHERE active = 1 ORDER BY type ASC";
							$result = mysql_query($sql);
							$count = mysql_num_rows($result);
							$i=0;
							while ($i < $count) {
								$type = mysql_result($result, $i, "type");
								$recipetypeid = mysql_result($result, $i, "typeid");
							echo "<option value='$recipetypeid'"; if($typeid == $recipetypeid) { echo"selected='selected'";} echo">$type</option>";
							$i++;	
							}
							?>
                        	
                        </select>
                    </div>
                    
                    <div id="preptime">
                    	<select name="preptime" required="required">
                        	<option value="" <? if(!isset($preptime)) { ?> selected="selected" <? }?>>Prep time</option>
                        	<option value="N/A" <? if($preptime == "N/A") {?> selected="selected"<? } ?> >N/A</option>
                        	<option value="5 Min"<? if($preptime == "5 Min") {?> selected="selected"<? } ?>>5 Min</option>
                        	<option value="10 Min"<? if($preptime == "10 Min") {?> selected="selected"<? } ?>>10 Min</option>
                        	<option value="15 Min"<? if($preptime == "15 Min") {?> selected="selected"<? } ?>>15 Min</option>
                        	<option value="30 Min"<? if($preptime == "30 Min") {?> selected="selected"<? } ?>>30 Min</option>
                        	<option value="45 Min"<? if($preptime == "45 Min") {?> selected="selected"<? } ?>>45 Min</option>
                        	<option value="1 Hour"<? if($preptime == "1 Hour") {?> selected="selected"<? } ?>>1 Hour</option>
                        	<option value="1 Hour 15 Min"<? if($preptime == "1 Hour 15 Min") {?> selected="selected"<? } ?>>1 Hour 15 Min</option>
                        	<option value="1 Hour 30 Min"<? if($preptime == "1 Hour 30 Min") {?> selected="selected"<? } ?>>1 Hour 30 Min</option>
                        	<option value="1 Hour 45 Min"<? if($preptime == "1 Hour 45 Min") {?> selected="selected"<? } ?>>1 Hour 45 Min</option>
                        	<option value="2 Hours"<? if($preptime == "2 Hours") {?> selected="selected"<? } ?>>2 Hours</option>
                        	<option value="2 Hours 15 Min"<? if($preptime == "2 Hours 15 Min") {?> selected="selected"<? } ?>>2 Hours 15 Min</option>
                        	<option value="2 Hours 30 Min"<? if($preptime == "2 Hours 30 Min") {?> selected="selected"<? } ?>>2 Hours 30 Min</option>
                        	<option value="2 Hours 45 Min"<? if($preptime == "2 Hours 45 Min") {?> selected="selected"<? } ?>>2 Hours 45 Min</option>
                        	<option value="3 Hours+" <? if($preptime == "3 Hours+") {?> selected="selected"<? } ?>>3 Hours+</option>
                        </select>
                    </div>
                    
                    <div id="cooktime">
                    	<select name="cooktime" required="required">
                        	<option value="" <? if(!isset($cooktime)) { ?> selected="selected" <? }?>>Cook time</option>
                        	<option value="N/A" <? if($cooktime == "N/A") {?> selected="selected"<? } ?> >N/A</option>
                        	<option value="5 Min"<? if($cooktime == "5 Min") {?> selected="selected"<? } ?>>5 Min</option>
                        	<option value="10 Min"<? if($cooktime == "10 Min") {?> selected="selected"<? } ?>>10 Min</option>
                        	<option value="15 Min"<? if($cooktime == "15 Min") {?> selected="selected"<? } ?>>15 Min</option>
                        	<option value="30 Min"<? if($cooktime == "30 Min") {?> selected="selected"<? } ?>>30 Min</option>
                        	<option value="45 Min"<? if($cooktime == "45 Min") {?> selected="selected"<? } ?>>45 Min</option>
                        	<option value="1 Hour"<? if($cooktime == "1 Hour") {?> selected="selected"<? } ?>>1 Hour</option>
                        	<option value="1 Hour 15 Min"<? if($cooktime == "1 Hour 15 Min") {?> selected="selected"<? } ?>>1 Hour 15 Min</option>
                        	<option value="1 Hour 30 Min"<? if($cooktime == "1 Hour 30 Min") {?> selected="selected"<? } ?>>1 Hour 30 Min</option>
                        	<option value="1 Hour 45 Min"<? if($cooktime == "1 Hour 45 Min") {?> selected="selected"<? } ?>>1 Hour 45 Min</option>
                        	<option value="2 Hours"<? if($cooktime == "2 Hours") {?> selected="selected"<? } ?>>2 Hours</option>
                        	<option value="2 Hours 15 Min"<? if($cooktime == "2 Hours 15 Min") {?> selected="selected"<? } ?>>2 Hours 15 Min</option>
                        	<option value="2 Hours 30 Min"<? if($cooktime == "2 Hours 30 Min") {?> selected="selected"<? } ?>>2 Hours 30 Min</option>
                        	<option value="2 Hours 45 Min"<? if($cooktime == "2 Hours 45 Min") {?> selected="selected"<? } ?>>2 Hours 45 Min</option>
                        	<option value="3 Hours+" <? if($cooktime == "3 Hours+") {?> selected="selected"<? } ?>>3 Hours+</option>
                        </select>
                    </div>
                    
                </div>
                
 <input type="submit" id="submitrecipe" class="button floatclear" value="Submit Changes" name="submit" />
 <div class="button"><a href="recipepage.php?recipeid=<? echo $recipeid;?>">View Recipe</a></div>
 
             </div> <!-- end sidebar -->
        </div> <!-- end maincontent -->
                   
<input type="hidden" name="edit" value="edit"/>
<input type="hidden" name="recipeid" value="<? echo $recipeid;?>"/>
    </div> <!-- end container -->
    </form>
<? include('lib/inc/footer.inc.php');?>


</body>
</html>
