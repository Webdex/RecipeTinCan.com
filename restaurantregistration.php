<?
include ('lib/inc/db.inc.php');
if ($_SESSION['logged_in'] != 1) {
header('location:index.php');
}

//SIGNUP START
 if (isset($_POST['signupsubmit'])) {
	extract($_POST);
 	if(empty($signupfname) || empty($signupstate) || empty($signupphone) || empty($signupzipcode) || empty($signupcity) || empty($signupaddress)) {
	$msg = "<p class='sqlerror'>Please fill in all fields.</p>";
		} else {
		
	 $time = date("Y-m-d");
		
		
		$sql = "INSERT INTO restaurants (restaurantid, restaurantname, categoryid, createddate, createdby, restaurantstate, restaurantcity, restaurantaddress, restaurantphone, restaurantzipcode, active) VALUES (NULL,'".mysql_real_escape_string($signupfname)."', '".mysql_real_escape_string($signupcategory)."', '$time' , '$_SESSION[userid]', '".mysql_real_escape_string($signupstate)."', '".mysql_real_escape_string($signupcity)."', '".mysql_real_escape_string($signupaddress)."', '".mysql_real_escape_string($signupphone)."', '".mysql_real_escape_string($signupzipcode)."', 3)";
	$result = mysql_query($sql, $link);
	$count = mysql_affected_rows();
$restaurantid = mysql_insert_id();	
				if($count == "1") {
	$msg = "<p class='sqlconfirm'>Thank you for registering. Your Restaurant will be reviewed and you will be notified within a week.</p>";
$result2 = mysql_query("INSERT INTO restaurantpictures (restaurantpictureid, restaurantid, filename, createdby, createddate, active) VALUES (NULL, $restaurantid, 'nopicture.png', $_SESSION[userid], '$time', 1 )");
				} else {
	$msg = "<p class='sqlerror'>There was a problem with your registration. Please try again.</p>";
				}
 } //closes field check
	 }//closes submit check

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
<? echo $msg; ?>  
    <div id="container">
    <div id="breadcrumb"><a href="index.php">Home </a>> <a href="user.php">My Account</a> > <span class="currentbreadcrumb"> Restaurant Registration</span></div>
        <div id="maincontent" class="floatclear">
        	<div id="recipelist" class="leftfloat">
            <div id="announcement"><h2>Register your restaurant with Recipetincan.com</h2>
            <p>Register to have your restaurant listed on our site.</p></div>
            	<div class="header">
            	  <h1>Restaurant Registration</h1>
               	</div>
                <div id="signupform">
                	<div class="innerborder">
                	<form action="restaurantregistration.php" method="post">
                    <div id="signupinfo" class="rightfloat">
                    <h3>Why Register?</h3>
                    <ol>
                    	<li>Link recipes with your restaurant to make your restaurant menu.</li>
                    	<li>Have your restaurant seen by hundreds of users in the area.</li>
                    	<li>Have your restaurant rated and commented on by viewers.</li>
                    </ol>

                    </div>
                    	<div id="labels" class="leftfloat">
                        <label for="fname">Name: </label>
                        <label for="fname">Category: </label>
                        <label for="state">State: </label>
                        <label for="city">City: </label>
                        <label for="address">Address: </label>
                        <label for="phone">Phone: </label>
                        <label for="zipcode">Zipcode: </label>
                        </div>
                        
                        <div id="inputs" class="leftfloat">
                        <input type ="text" id="fname" name="signupfname" />
                        <select name="signupcategory">                         	
						<?
							$result = mysql_query("SELECT * FROM categories");
							$count = mysql_num_rows($result);
							$i= 0;
							$link = "link";
							while ($i < $count) {
								$category = mysql_result($result, $i, "category");
								$categoryid2 = mysql_result($result, $i, "categoryid");
								echo "<option value ='$categoryid2'>$category</option>";
								$i++;
							}
							?>
                            </select>
                        
                        <select name="signupstate"> 
                        <option value="" selected="selected">Select a State</option> 
                        <option value="AL">Alabama</option> 
                        <option value="AK">Alaska</option> 
                        <option value="AZ">Arizona</option> 
                        <option value="AR">Arkansas</option> 
                        <option value="CA">California</option> 
                        <option value="CO">Colorado</option> 
                        <option value="CT">Connecticut</option> 
                        <option value="DE">Delaware</option> 
                        <option value="FL">Florida</option> 
                        <option value="GA">Georgia</option> 
                        <option value="HI">Hawaii</option> 
                        <option value="ID">Idaho</option> 
                        <option value="IL">Illinois</option> 
                        <option value="IN">Indiana</option> 
                        <option value="IA">Iowa</option> 
                        <option value="KS">Kansas</option> 
                        <option value="KY">Kentucky</option> 
                        <option value="LA">Louisiana</option> 
                        <option value="ME">Maine</option> 
                        <option value="MD">Maryland</option> 
                        <option value="MA">Massachusetts</option> 
                        <option value="MI">Michigan</option> 
                        <option value="MN">Minnesota</option> 
                        <option value="MS">Mississippi</option> 
                        <option value="MO">Missouri</option> 
                        <option value="MT">Montana</option> 
                        <option value="NE">Nebraska</option> 
                        <option value="NV">Nevada</option> 
                        <option value="NH">New Hampshire</option> 
                        <option value="NJ">New Jersey</option> 
                        <option value="NM">New Mexico</option> 
                        <option value="NY">New York</option> 
                        <option value="NC">North Carolina</option> 
                        <option value="ND">North Dakota</option> 
                        <option value="OH">Ohio</option> 
                        <option value="OK">Oklahoma</option> 
                        <option value="OR">Oregon</option> 
                        <option value="PA">Pennsylvania</option> 
                        <option value="RI">Rhode Island</option> 
                        <option value="SC">South Carolina</option> 
                        <option value="SD">South Dakota</option> 
                        <option value="TN">Tennessee</option> 
                        <option value="TX">Texas</option> 
                        <option value="UT">Utah</option> 
                        <option value="VT">Vermont</option> 
                        <option value="VA">Virginia</option> 
                        <option value="WA">Washington</option> 
                        <option value="WV">West Virginia</option> 
                        <option value="WI">Wisconsin</option> 
                        <option value="WY">Wyoming</option>
                        </select>
                        <input type ="text" id="city" name="signupcity" />
                        <input type ="text" id="address" name="signupaddress" />
                        <input type ="phone" id="Phone" name="signupphone" />
                        <input type ="text" id="zipcode" name="signupzipcode" />
                        
                        <div class="required leftfloat"><p>*All fields required</p></div>
                        <input type="submit" id="submit" value="Register Restaurant" name="signupsubmit" class="button rightfloat" />
                        </div>
                    </form>
                    </div>
                </div>    
            </div> <!-- end recipelist -->
            
            
            </div> <!-- end sidebar -->
            
        </div> <!-- end maincontent -->
    </div> <!-- end container -->
<? include('lib/inc/footer.inc.php');?>


</body>
</html>
