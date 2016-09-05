<? include ('lib/inc/db.inc.php');
$ingredientnumber = $_POST['ingredientnumber'];
$recipestepnumber = $_POST['recipestepnumber'];
$msg = $_REQUEST['msg'];
$edit = $_REQUEST['edit'];
$action = $_REQUEST['action'];
extract($_POST);

if ($recipestepnumber > 20 || $ingredientnumber > 20) {
	$msg="<p class='sqlerror'> Please put less than 20 ingredients or recipe steps</p>";
	header("location:recipestepone.php?msg=$msg"); 
		if ($recipestepnumber == "0" || $ingredientnumber == "0") {
			$msg="<p class='sqlerror'>Please put more than 1 ingredients and recipe step</p>";
			header('location:recipestepone.php');  
		}
} else {

if ($action == "addingredient") {
$ingredientnumber = $ingredientnumber+1;
}
if ($action == "removeingredient") {
$ingredientnumber = $ingredientnumber-1;
}
if ($action == "addstep") {
$recipestepnumber = $recipestepnumber+1;
}
if ($action == "removestep") {
$recipestepnumber = $recipestepnumber-1;
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

<body id="categorypage">
<? include('lib/inc/header.inc.php'); ?>   
<script type="text/javascript" src="lib/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
        mode : "textareas",
		theme : "simple"    
});
function addingredient()
{
    document.recipesubmit.action = "recipesteptwo.php?action=addingredient&edit=edit"

    document.recipesubmit.submit();             // Submit the page

    return true;
}

function removeingredient()
{
    document.recipesubmit.action = "recipesteptwo.php?action=removeingredient&edit=edit"

    document.recipesubmit.submit();             // Submit the page

    return true;
}
function addstep()
{
    document.recipesubmit.action = "recipesteptwo.php?action=addstep&edit=edit"

    document.recipesubmit.submit();             // Submit the page

    return true;
}

function removestep()
{
    document.recipesubmit.action = "recipesteptwo.php?action=removestep&edit=edit"

    document.recipesubmit.submit();             // Submit the page

    return true;
}
</script>

<form id="recipesubmitform" action="recipestepthree.php" method="post" enctype="multipart/form-data" name="recipesubmit">    <div id="container">
    <div id="breadcrumb">
      <a href="index.php">Home </a>><a href="user.php"> My Account</a>><a href="recipestepone.php">Recipe Step One</a>><span class="currentbreadcrumb"> Recipe Step Two</span></div>
        
        <div id="maincontent" class="floatclear">
        <div class="header"><h1> Step 2 - Write your recipe</h1></div>
        	<div id="recipelist" class="leftfloat">
            	<div class="header">
                
            	  <h1><label for="recipename"></label><input class="clear" type="text" id="recipename" value="<? if(isset($edit)) {echo $recipename;} else {?> Recipe Name <? } ?>" name="recipename" required/></h1>
                </div>
                <div class="outerbox"> 
                	<div id="mainpicture">
                     <div class="innerborder">               

                    	<img src=lib/img/tempimage.png class="mainpicture" alt="recipepicture" />
                        <input type="file" id="photo" name="photo" />
                    </div>
                    </div>
                    
                    <div id="ingredients">
                    <div class="innerborder"> 
                    	<h2>Ingredients</h2>
                        
                        <? 
						
						$iingredientnumber = 0;
						while( $iingredientnumber < $ingredientnumber ){
						echo"<label for='recipeingredient$iingredientnumber'></label><input type='text' class='clear' id='recipeingredient$iingredientnumber' value='";if(isset($edit)) { echo"${'recipeingredient'.$iingredientnumber}";} else { echo"Ingredient"; } echo"' name='recipeingredient$iingredientnumber' class='recipeingredient' required='required'/>";
						$iingredientnumber++;
						} 
					
						?>
                        <div>
                            <div id="addingredient"><a href="javascript: addingredient()">Add an Ingredient</a></div>
                            <div id="removeingrdient"><a href="javascript: removeingredient()">Remove an Ingredient</a></div>
                            </div>
                    </div>                    
                    </div> <!-- close ingredients -->
                    
                    <div class="recipestep">

                            <div id="addstep"><a href="javascript: addstep()">Add a Step</a></div>
                            <div id="removestep"><a href="javascript: removestep()">Remove a Step</a></div>

                    <? $irecipestepnumber = 0;
					while( $irecipestepnumber < $recipestepnumber ){
                    	echo"<h2><input class='clear' type='text' id='recipestepheader$irecipestepnumber' value='";if(isset($edit)) { echo"${'recipestepheader'.$irecipestepnumber}";} else { echo"Write your Step Header"; } echo"' name='recipestepheader$irecipestepnumber'/></h2>
                        <p><label for='recipestep$irecipestepnumber'></label><textarea id='recipestep$irecipestepnumber' name='recipestep$irecipestepnumber'>"; if(isset($edit)) { echo"${'recipestep'.$irecipestepnumber}";} else { echo"Write the details of your step here."; } echo"</textarea></p>";
					$irecipestepnumber++;
					}
                       ?> 
                        
                    </div>
                
                
                
                
                
                </div>
            </div> <!-- end recipelist -->
            
            <div id="sidebar" class="rightfloat">

                <div id="recipeinfo">
                <div id="description">
                <h2>Recipe Description</h2>
                	<p><label for="recipedesc" ></label><textarea id="recipedesc" name="recipedesc" required><? if(isset($edit)) {echo $recipedesc;} else {?>Write a short description of your recipe here.<? } ?></textarea></p>
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
								$categoryid = mysql_result($result, $i, "categoryid");
							echo "<option value='$categoryid'"; if($categoryid == $recipecategory) { echo"selected='selected'";} echo">$category</option>";
							$i++;	
							}
							?>
                        	
                        </select>
                        <span class="required">*</span>
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
								$typeid = mysql_result($result, $i, "typeid");
							echo "<option value='$typeid'"; if($typeid == $recipetype) { echo"selected='selected'";} echo">$type</option>";
							$i++;	
							}
							?>
                        	
                        </select>
                        <span class="required">*</span>
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
                        <span class="required">*</span>
                    </div>
                    
                    <div id="cooktime">
                    	<select name="cooktime" required="required">
                        	<option value="" <? if(!isset($cooktime)) { ?> selected="selected" <? }?>>Cook time</option>
                        	<option value="N/A" <? if($cooktime == "N/A") {?> selected="selected"<? } ?> >N/A</option>
                        	<option value="5 Min"<? if($cooktime == "N/A") {?> selected="selected"<? } ?>>5 Min</option>
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
                        <span class="required">*</span>
                    </div>
                    
                </div>
                <input type="submit" id="submitrecipe" class="button floatclear" value="Step Three" />
                <p class="required">* required</p>

            </div> <!-- end sidebar -->
            
        </div> <!-- end maincontent -->
                    

    </div> <!-- end container -->
    <input type="hidden" value="<? echo $ingredientnumber ?>" name="ingredientnumber"/>
    <input type="hidden" value=" <? echo $recipestepnumber ?>" name="recipestepnumber"/>
    </form>
<? include('lib/inc/footer.inc.php');?>


</body>
</html>
<? } ?>
