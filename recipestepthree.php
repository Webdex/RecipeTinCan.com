<? include ('lib/inc/db.inc.php');
include ('lib/inc/resize-class.php');
$msg = $_REQUEST['msg'];


	extract($_POST);
	
	/*
	if (
		empty($recipename) ||
		empty($recipecategory) ||
		empty($recipedesc) ||
		empty($recipeingredient0) ||
		empty($recipestepheader0) ||
		empty($recipestep0) ||
		empty($recipetype) ||
		empty($_FILES["photo"]["name"]))
		 {
			$msg="<p class='sqlerror'>Plese fill in all fields</p>";
			$required = "class='required'";
			header('location:recipesteptwo.php');  

			} else {
	   */
	
	
	
	
	$recipename = stripslashes($recipename);
	$recipecategory = stripslashes($recipecategory);
	$recipedesc = stripslashes($recipedesc);
	$recipecooktime = preg_replace("/[^0-9]/","", $recipecooktime);
	$filename = $_FILES["photo"]["name"];
	if (empty($filename)) { $filename = "norecipephoto.png";}
	 $time = date("Y-m-d h:i:s");	  

    $fullpath = "/home/content/39/9219239/html/recipetincan/lib/img/temp/"; 
    
    if (file_exists($fullpath)) { 
        //$msg .= "The directory {$dirname} exists<br />"; 
    } else { 
        mkdir("/home/content/39/9219239/html/recipetincan/lib/img/temp/"); 
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
	$permissions420 = chmod(($fullpath . '680_'.$_FILES["photo"]["name"]),0755); // MAKE SURE NEW FILE HAS CORRECT PERMISSIONS
	if(!$permissions || !$permissions90) { $msg .= "<p class=\"alert\">Permissions failed to update.</p>"; } else { $msg .= "<p class=\"alert\">File has successfully uploaded.</p>"; }
	
      } // closes pre-existing file check
    } // closes error check
	
	} else {
  $msg .= "<p class=\"alert\">File Size Too Large. Files must be less than 2MB.</p>";
	}
  } else {
  $msg .= "<p class=\"alert\">Invalid file. Files must be .JPGs, .GIFs, or .PNGs.</p>";
  } // closes invalid file check
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

<script type="text/javascript">
function submitform()
{
  document.backbuttonform.submit();
}
</script>

</head>

<body id="categorypage">
<? include('lib/inc/header.inc.php'); ?>    
    
    <div id="container">
    <div id="breadcrumb"><a href="index.php">Home </a>><a href="user.php"> My Account</a>><a href="recipestepone.php">Recipe Step One</a>><a href="javascript: submitform()">Recipe Step Two</a>><span class="currentbreadcrumb"> Recipe Step Three</span></div>
        
        <div id="maincontent" class="floatclear">
        	<div id="recipelist" class="leftfloat">
            	<div class="header">
            	  <h1><? echo $recipename; ?></h1>
                </div>
                <div class="outerbox"> 
                	<div id="mainpicture">
                     <div class="innerborder">               

                    	<img src="lib/img/temp/680_<? echo $filename;?>" class="mainpicture" alt="recipepicture" />
                    </div>
                    </div>
                    
                    <div id="ingredients">
                    <div class="innerborder"> 
                    	<h2>Ingredients</h2>
                        <ul><? 
							$i = 0;
							while($i < $ingredientnumber) {
								
							echo "<li class='leftfloat ingredient'>${'recipeingredient'.$i}</li> ";
							$i++;
							}
						
						
						 ?></ul>
                    </div>
                    </div>
                    
                    <div class="recipestep">
                    
                    <? 
					$i=0;
						while($i < $recipestepnumber) {
                    	echo "<h2>${'recipestepheader'.$i}</h2>
                        ${'recipestep'.$i}";
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
                	<p><? echo $recipedesc;?></p>
                </div>
                
                	<div id="category">
                    	<p><? 
						$result = mysql_query("SELECT * FROM categories WHERE categoryid=$recipecategory LIMIT 1");
						$row = mysql_fetch_array($result);
						$category = $row['category'];
						echo "Category: $category";?></p>
                    </div>
                	<div id="type">
                    	<p><? 
						$result = mysql_query("SELECT * FROM type WHERE typeid=$recipetype LIMIT 1");
						$row = mysql_fetch_array($result);
						$type = $row['type'];
						echo "Type: $type";?></p>
                    </div>
                    <div id="preptime">
                    	<p><? echo "Preptime: $preptime"; ?></p>
                    </div>
                    <div id="cooktime">
                    	<p><? echo "Cooktime: $cooktime"; ?></p>
                    </div>
                </div>
                
        <form action="recipesubmit.php" method="post" enctype="multipart/form-data">
        	<input type="hidden" name="recipecategory" value="<? echo $recipecategory; ?>" />
        	<input type="hidden" name="recipename" value="<? echo $recipename; ?>" />
        	<input type="hidden" name="recipedesc" value="<? echo $recipedesc; ?>" />
        	<input type="hidden" name="ingredientnumber" value="<? echo $ingredientnumber; ?>" />
        	<input type="hidden" name="recipestepnumber" value="<? echo $recipestepnumber; ?>" />
        	<input type="hidden" name="recipetype" value="<? echo $recipetype; ?>" />
            <input type="hidden" name="filename" value="<? echo $filename; ?>" />
        	<input type="hidden" name="preptime" value="<? echo $preptime; ?>" />
        	<input type="hidden" name="cooktime" value="<? echo $cooktime; ?>" />
            <?
			$i=0;
			while($i < $ingredientnumber) {
        	echo "<input type='hidden' name='recipeingredient$i' value='${'recipeingredient'.$i} ' />";
			$i++;
				}
			$i=0;
			while($i < $ingredientnumber) {
        	echo "<input type='hidden' name='recipestepheader$i' value='${'recipestepheader'.$i}' />";
        	echo "<input type='hidden' name='recipestep$i' value='${'recipestep'.$i}' />";
			$i++;
				}
			?>
                    <input type="submit" id="submitrecipe" class="button floatclear" name="confirm" value="Confirm Recipe" />
        </form>
<div class="centered"><p>Or</p></div>


       <form action="recipesteptwo.php?edit=edit" method="post" name="backbuttonform" enctype="multipart/form-data">
            <input type="hidden" name="recipecategory" value="<? echo $recipecategory; ?>" />
        	<input type="hidden" name="recipename" value="<? echo $recipename; ?>" />
        	<input type="hidden" name="recipedesc" value="<? echo $recipedesc; ?>" />
        	<input type="hidden" name="ingredientnumber" value="<? echo $ingredientnumber; ?>" />
        	<input type="hidden" name="recipestepnumber" value="<? echo $recipestepnumber; ?>" />
            <input type="hidden" name="filename" value="<? echo $filename; ?>" />
        	<input type="hidden" name="recipetype" value="<? echo $recipetype; ?>" />
        	<input type="hidden" name="preptime" value="<? echo $preptime; ?>" />
        	<input type="hidden" name="cooktime" value="<? echo $cooktime; ?>" />
            <?
			$i=0;
			while($i < $ingredientnumber) {
        	echo "<input type='hidden' name='recipeingredient$i' value='${'recipeingredient'.$i}' />";
			$i++;
				}
			$i=0;
			while($i < $recipestepnumber) {
        	echo "<input type='hidden' name='recipestepheader$i' value='${'recipestepheader'.$i}' />";
        	echo "<input type='hidden' name='recipestep$i' value='${'recipestep'.$i}' />";
			$i++;
				}
			?>

       <input type="submit" id ="backtoedit" class="button" value="Go Back to Editing" name="edit"/>
       </form>

            </div> <!-- end sidebar -->
            
        </div> <!-- end maincontent -->

    </div> <!-- end container -->
<? include('lib/inc/footer.inc.php');?>


</body>
</html>
<? /* } //closes required check */ ?>
