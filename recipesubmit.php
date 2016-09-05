<? include ('lib/inc/db.inc.php');
include ('lib/inc/resize-class.php');

		if (isset($_POST['confirm'])) {
		extract($_POST);
	
	$recipename = stripslashes($recipename);
	$recipecategory = stripslashes($recipecategory);
	$recipedesc = stripslashes($recipedesc);
	$recipecooktime = preg_replace("/[^0-9]/","", $recipecooktime);
	$filename = $filename;
	 $time = date("Y-m-d h:i:s");

$sql = "INSERT INTO recipes (recipeid, name, text, createdby, createddate, featured, categoryid, typeid, preptime, cooktime, active) VALUES (NULL, '".mysql_real_escape_string($recipename)."', '".mysql_real_escape_string($recipedesc)."', '".mysql_real_escape_string($_SESSION['userid'])."', '".mysql_real_escape_string($time)."', 0, '".mysql_real_escape_string($recipecategory)."', '".mysql_real_escape_string($recipetype)."', '".mysql_real_escape_string($preptime)."', '".mysql_real_escape_string($cooktime)."', 1);";

$result=mysql_query($sql, $link) or die ('Unable to run query:'.mysql_error());

$sql = "SELECT * FROM recipes ORDER BY recipeid DESC LIMIT 1";
$result=mysql_query($sql, $link) or die ('Unable to run query:'.mysql_error());
$recipeid = mysql_result($result,$i,"recipeid");

$i=0;
while($i < $recipestepnumber) {
$sql = "INSERT INTO recipesteps (recipestepid, recipeid, stepnumber, recipestepheader, recipestepdescription, active) VALUES (NULL, $recipeid, '".mysql_real_escape_string($i)."', '".mysql_real_escape_string(${'recipestepheader'.$i})."', '".mysql_real_escape_string(${'recipestep'.$i})."', 1);";
$result=mysql_query($sql, $link) or die ('Unable to run query:'.mysql_error());
$i++;
}


$i=0;
while($i < $ingredientnumber) {
$sql = "INSERT INTO recipeingredients (recipeingredientid, recipeid, ingredient, createdby, active) VALUES (NULL, $recipeid, '".mysql_real_escape_string(${'recipeingredient'.$i})."', '".mysql_real_escape_string($_SESSION['fname'])."', 1);";
$result=mysql_query($sql, $link) or die ('Unable to run query:'.mysql_error());
$i++;
}

$sql ="INSERT INTO recipepictures (recipepictureid, recipeid, filename, createdby, createddate, active) VALUES (NULL, $recipeid, '".mysql_real_escape_string($filename)."', '".mysql_real_escape_string($_SESSION['fname'])."', '".mysql_real_escape_string($time)."', 1);";

$result=mysql_query($sql, $link) or die ('Unable to run query:'.mysql_error());




	$dirname = $recipeid;
	$temppath = "lib/img/temp/";
    $fullpath = "/home/content/39/9219239/html/recipetincan/lib/img/{$dirname}/"; 
	
	    if (file_exists($fullpath)) { 
        //$msg .= "The directory {$dirname} exists<br />"; 
    } else { 
        mkdir("/home/content/39/9219239/html/recipetincan/lib/img/{$dirname}/"); 
        //$msg .= "The directory {$dirname} was successfully created.<br />"; 
    }  
	
	copy($temppath.$filename,$fullpath.$filename);

    
	
	//=================================================================================== Create Thumbnail
	// *** 1) Initialise / load image
	$resizeObj = new resize($temppath . "680_$filename");
if(!resizeObj) { $msg .= "<p class=\"alert\">Didn't create Thumbnail object</p>"; }
	// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
	$resizeObj -> resizeImage(204, 100, 'crop',0);
if(!resizeObj) { $msg .= "<p class=\"alert\">Didn't resize Thumbnail</p>"; }
	// *** 3) Save image
	$resizeObj -> saveImage($fullpath . '175_'.$filename, 100);
	//=================================================================================== Create Thumbnail
	// *** 1) Initialise / load image
	$resizeObj = new resize($temppath . "680_$filename");
if(!resizeObj) { $msg .= "<p class=\"alert\">Didn't create Thumbnail object</p>"; }
	// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
	$resizeObj -> resizeImage(225, 150, 'auto',0);
if(!resizeObj) { $msg .= "<p class=\"alert\">Didn't resize Thumbnail</p>"; }
	// *** 3) Save image
	$resizeObj -> saveImage($fullpath . '225_'.$filename, 100);
	//=================================================================================== Create full size
	// *** 1) Initialise / load image
	$resizeObj = new resize($temppath . "680_$filename");
if(!resizeObj) { $msg .= "<p class=\"alert\">Didn't create Full Size object</p>"; }
	// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
	$resizeObj -> resizeImage(400, 175, 'landscape',0);
if(!resizeObj) { $msg .= "<p class=\"alert\">Didn't resize Full Size</p>"; }
	// *** 3) Save image
	$resizeObj -> saveImage($fullpath . '400_'.$filename, 100);
	//=================================================================================== Create Primary size
	// *** 1) Initialise / load image
	$resizeObj = new resize($temppath . "680_$filename");
if(!resizeObj) { $msg .= "<p class=\"alert\">Didn't create Primary Size object</p>"; }
	// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
	$resizeObj -> resizeImage(680, 380, 'crop',0);
if(!resizeObj) { $msg .= "<p class=\"alert\">Didn't resize Primary Size</p>"; }
	// *** 3) Save image
	$resizeObj -> saveImage($fullpath . '680_'.$filename, 100);
	//=================================================================================== Change Permissions
	$permissions90 = chmod(($fullpath . '175_'.$filename),0755); // MAKE SURE NEW FILE HAS CORRECT PERMISSIONS
	$permissions90 = chmod(($fullpath . '225_'.$filename),0755); // MAKE SURE NEW FILE HAS CORRECT PERMISSIONS
	$permissions600 = chmod(($fullpath . '400_'.$filename),0755); // MAKE SURE NEW FILE HAS CORRECT PERMISSIONS
	$permissions420 = chmod(($fullpath . '680_'.$filename),0755); // MAKE SURE NEW FILE HAS CORRECT PERMISSIONS
	if(!$permissions || !$permissions90) { $msg .= "<p class=\"alert\">Permissions failed to update.</p>"; } else { $msg .= "<p class=\"alert\">File has successfully uploaded.</p>"; }
	
		  
	//=================================================================================== Modify Original
	$width = getimagesize($temppath . $filename);
	if($width[0]>1100) {
	// *** 1) Initialise / load image
	$resizeObj = new resize($temppath . $filename);
if(!resizeObj) { $msg .= "<p class=\"alert\">Didn't create Original Size object</p>"; }
	// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
	$resizeObj -> resizeImage(1100, 1100, 'landscape',0);
if(!resizeObj) { $msg .= "<p class=\"alert\">Didn't resize Original Size</p>"; }
	// *** 3) Save image
	$resizeObj -> saveImage($fullpath . $filename, 100);
	}
	$newwidth = getimagesize($fullpath . $filename);
	//=================================================================================== end Modify Original
		if ($filename != "norecipephoto.png") {
		unlink("lib/img/temp/$filename");
		unlink("lib/img/temp/680_$filename");
		}
	} else {
			header('location:index.php');  
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
        <div id="maincontent" class="floatclear">
        <? echo $msg2; ?>
        	<div id="recipelist" class="leftfloat">
            <div id="conformbox">
            <div class="outerbox">
            <div class="innerborder">
            <div id="announcement"><h2>Finished!</h2><p>Your recipe has been created sucessfully.</p></div>
            	<div class="header">
            	  <h1><div class="button"><a href="recipepage.php?recipeid=<? echo $recipeid;?>">View Your Recipe</a></div></h1>
               	</div>
                </div>
                </div> 
                </div> 
                </div>  
            </div> <!-- end recipelist -->
            
            
            </div> <!-- end sidebar -->
            
        </div> <!-- end maincontent -->
    </div> <!-- end container -->
<? include('lib/inc/footer.inc.php');?>


</body>
</html>
