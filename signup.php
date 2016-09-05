<?
include ('lib/inc/db.inc.php');
$action = $_REQUEST['action'];


//SIGNUP START
 if (isset($_POST['signupsubmit'])) {
	extract($_POST);
	
require_once('lib/inc/recaptchalib.php');
  $privatekey = "6Lcsz9gSAAAAAC6EjWUk8IXd1OvGG5VUnaIg2Jmu";
  $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    $msg .= "<p class='sqlerror'>Varification code was entered incorectly. Please try again</p>";
  } else {
    // Your code here to handle a successful verification
	
	
 	if($signupfname == "First Name" || $signuplname == "Last Name" || $signuppassword == "Password" || $signupemail == "Email") {
	$msg = "<p class='sqlerror'>Please fill in all fields.</p>";
		} else {
			
$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(!preg_match($email_exp,$signupemail)) {
    $msg .= '<p class="sqlerror">The Email Address you entered does not appear to be valid.</p>';
  }
    $string_exp = "/^[A-Za-z .'-]+$/";
  if(!preg_match($string_exp,$signupfname)) {
    $msg .= '<p class="sqlerror">The First Name you entered does not appear to be valid.</p>';
  }
  if(!preg_match($string_exp,$signuplname)) {
    $msg .= '<p class="sqlerror">The Last Name you entered does not appear to be valid.</p>';
  }
  if(!preg_match($string_exp,$signupcity)) {
    $msg .= '<p class="sqlerror">The City you entered does not appear to be valid.</p>';
  }
      $num_exp = "/^[0-9 .'-]+$/";
  if(!preg_match($num_exp,$signupzipcode) || strlen($signupzipcode) != 5 ) {
    $msg .= '<p class="sqlerror">The zipcode you entered does not appear to be valid.</p>';
  }
  	if(!empty($msg)) {
		$msg .= "";
	} else {

				
		
		$sql = "SELECT * FROM users WHERE email = '$signupemail' AND active = 1";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);		
			if ($count > 0) {
				$msg = "<p class='sqlerror'>That Email is already registered with us.</p>";
			} else {
		
		
		
		
	 $time = date("Y-m-d h:i:s");
	 
	 $saltedpassword = md5($signuppassword.$time);
	 
		$sql = "INSERT INTO users (userid, email, password, fname, lname, createddate, createdby, usertypeid, state, city, zipcode, active) VALUES (NULL, '".mysql_real_escape_string($signupemail)."','".mysql_real_escape_string($saltedpassword)."','".mysql_real_escape_string($signupfname)."','".mysql_real_escape_string($signuplname)."', '$time' , 'System', 100, '".mysql_real_escape_string($signupstate)."', '".mysql_real_escape_string($signupcity)."', '".mysql_real_escape_string($signupzipcode)."', 1)";
	
	$result = mysql_query($sql, $link);
	$count = mysql_affected_rows();
				if($count == "1") {
	$sql = "SELECT * FROM users WHERE email = '$signupemail' AND active = '1' LIMIT 1 ";
	$result=mysql_query($sql, $link) or die ('Unable to run query:'.mysql_error());
	$row = mysql_fetch_array($result);
	$_SESSION['logged_in'] = 1;
	$_SESSION['usertypenumber'] = $row['usertypeid'];
	$_SESSION['fname'] = $row['fname'];
	$_SESSION['userid'] = $row['userid'];
	$_SESSION['city'] = $row['city'];
	$_SESSION['state'] = $row['state'];
	$_SESSION['zipcode'] = $row['zipcode'];
	header('location:user.php');	
				} else {
	$msg = "<p class='sqlerror'>There was a problem with your registration. Please try again.</p>";
				}
			} //closes validation
}//closes duplicate check
 } //closes field check
	 }//closes submit check
  }// closes recaptcha check
  
  
  if (isset($_POST['update'])) { //if edit
	  extract($_POST);
	  $sql = "UPDATE users SET";
	  $sql .= " city = '". mysql_real_escape_string($city) ."',";
	  $sql .= " state = '". mysql_real_escape_string($state) ."',";
	  $sql .= " zipcode = '". mysql_real_escape_string($zipcode) ."'";
	  $sql .= " WHERE userid = $_SESSION[userid]";
	  $sql .= " LIMIT 1";
	  $result = mysql_query($sql);
	  	if ($result) {
			$row = mysql_fetch_array(mysql_query("SELECT `city`, `zipcode`, `state` FROM users WHERE userid = $_SESSION[userid] LIMIT 1"));
			$_SESSION['city'] = $row['city'];
			$_SESSION['state'] = $row['state'];
			$_SESSION['zipcode'] = $row['zipcode'];
			header("Location:user.php?edit=success");
		} else {
			$msg .= "<p class='sqlerror'>There was a problem. Please try again</p>";
			$action = "edit";
		}
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
<script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'clean'
 };
 </script>
</head>

<body id="signuppage" class="fullwidth">
<? include('lib/inc/header.inc.php'); ?>    
    <? echo $msg; ?>
    <? echo $action; ?>
    <div id="container">
    <?			 if ($action == "edit") { ?>
    <div id="breadcrumb"><a href="index.php">Home </a>> <a href="user.php">My Account </a>> <span class="currentbreadcrumb">Edit Location</span></div>
    <? } else { ?>
    <div id="breadcrumb"><a href="index.php">Home </a>> <span class="currentbreadcrumb">Sign Up</span></div>
        <? }?><div id="maincontent" class="floatclear">
        	<div id="recipelist" class="leftfloat">
            <?
			 if ($action == "edit") { ?>
            	<div class="header fullwidth">
                    <h1>Edit Location</h1>
               	</div>
                
                <div id="signupform">
                	<div class="innerborder">
                	<form action="signup.php" method="post">
                    <div id="signupinfo" class="rightfloat">
                    <p>Provide us with accurate location info to quickly view restaurants in your area.</p>
					</div>
                    	<div id="labels" class="leftfloat">
<label for="city">City: </label>          
<label for="state">State: </label>
<label for="zipcode">Zipcode: </label>
              </div>
                        <div id="inputs" class="leftfloat">
                                                <input type ="text" id="city" name="city" value="<? echo $_SESSION['city']; ?>" />
                                                <select name="state">
                          <option value="">Select a State</option>
                          <option value="AL" <? if($_SESSION['state'] == "AL") {?> selected="selected"<? }?>>Alabama</option>
                          <option value="AK"<? if($_SESSION['state'] == "AK") {?> selected="selected"<? }?>>Alaska</option>
                          <option value="AZ"<? if($_SESSION['state'] == "AZ") {?> selected="selected"<? }?>>Arizona</option>
                          <option value="AR"<? if($_SESSION['state'] == "AR") {?> selected="selected"<? }?>>Arkansas</option>
                          <option value="CA"<? if($_SESSION['state'] == "CA") {?> selected="selected"<? }?>>California</option>
                          <option value="CO"<? if($_SESSION['state'] == "CO") {?> selected="selected"<? }?>>Colorado</option>
                          <option value="CT"<? if($_SESSION['state'] == "CT") {?> selected="selected"<? }?>>Connecticut</option>
                          <option value="DE"<? if($_SESSION['state'] == "DE") {?> selected="selected"<? }?>>Delaware</option>
                          <option value="DC"<? if($_SESSION['state'] == "DC") {?> selected="selected"<? }?>>District Of Columbia</option>
                          <option value="FL"<? if($_SESSION['state'] == "FL") {?> selected="selected"<? }?>>Florida</option>
                          <option value="GA"<? if($_SESSION['state'] == "GA") {?> selected="selected"<? }?>>Georgia</option>
                          <option value="HI"<? if($_SESSION['state'] == "HI") {?> selected="selected"<? }?>>Hawaii</option>
                          <option value="ID"<? if($_SESSION['state'] == "ID") {?> selected="selected"<? }?>>Idaho</option>
                          <option value="IL"<? if($_SESSION['state'] == "IL") {?> selected="selected"<? }?>>Illinois</option>
                          <option value="IN"<? if($_SESSION['state'] == "IN") {?> selected="selected"<? }?>>Indiana</option>
                          <option value="IA"<? if($_SESSION['state'] == "IA") {?> selected="selected"<? }?>>Iowa</option>
                          <option value="KS"<? if($_SESSION['state'] == "KS") {?> selected="selected"<? }?>>Kansas</option>
                          <option value="KY"<? if($_SESSION['state'] == "KY") {?> selected="selected"<? }?>>Kentucky</option>
                          <option value="LA"<? if($_SESSION['state'] == "LA") {?> selected="selected"<? }?>>Louisiana</option>
                          <option value="ME"<? if($_SESSION['state'] == "ME") {?> selected="selected"<? }?>>Maine</option>
                          <option value="MD"<? if($_SESSION['state'] == "MD") {?> selected="selected"<? }?>>Maryland</option>
                          <option value="MA"<? if($_SESSION['state'] == "MA") {?> selected="selected"<? }?>>Massachusetts</option>
                          <option value="MI"<? if($_SESSION['state'] == "MI") {?> selected="selected"<? }?>>Michigan</option>
                          <option value="MN"<? if($_SESSION['state'] == "MN") {?> selected="selected"<? }?>>Minnesota</option>
                          <option value="MS"<? if($_SESSION['state'] == "MS") {?> selected="selected"<? }?>>Mississippi</option>
                          <option value="MO"<? if($_SESSION['state'] == "MO") {?> selected="selected"<? }?>>Missouri</option>
                          <option value="MT"<? if($_SESSION['state'] == "MT") {?> selected="selected"<? }?>>Montana</option>
                          <option value="NE"<? if($_SESSION['state'] == "NE") {?> selected="selected"<? }?>>Nebraska</option>
                          <option value="NV"<? if($_SESSION['state'] == "NV") {?> selected="selected"<? }?>>Nevada</option>
                          <option value="NH"<? if($_SESSION['state'] == "NH") {?> selected="selected"<? }?>>New Hampshire</option>
                          <option value="NJ"<? if($_SESSION['state'] == "NJ") {?> selected="selected"<? }?>>New Jersey</option>
                          <option value="NM"<? if($_SESSION['state'] == "NM") {?> selected="selected"<? }?>>New Mexico</option>
                          <option value="NY"<? if($_SESSION['state'] == "NY") {?> selected="selected"<? }?>>New York</option>
                          <option value="NC"<? if($_SESSION['state'] == "NC") {?> selected="selected"<? }?>>North Carolina</option>
                          <option value="ND"<? if($_SESSION['state'] == "ND") {?> selected="selected"<? }?>>North Dakota</option>
                          <option value="OH"<? if($_SESSION['state'] == "OH") {?> selected="selected"<? }?>>Ohio</option>
                          <option value="OK"<? if($_SESSION['state'] == "OK") {?> selected="selected"<? }?>>Oklahoma</option>
                          <option value="OR"<? if($_SESSION['state'] == "OR") {?> selected="selected"<? }?>>Oregon</option>
                          <option value="PA"<? if($_SESSION['state'] == "PA") {?> selected="selected"<? }?>>Pennsylvania</option>
                          <option value="RI"<? if($_SESSION['state'] == "RI") {?> selected="selected"<? }?>>Rhode Island</option>
                          <option value="SC"<? if($_SESSION['state'] == "SC") {?> selected="selected"<? }?>>South Carolina</option>
                          <option value="SD"<? if($_SESSION['state'] == "SD") {?> selected="selected"<? }?>>South Dakota</option>
                          <option value="TN"<? if($_SESSION['state'] == "TN") {?> selected="selected"<? }?>>Tennessee</option>
                          <option value="TX"<? if($_SESSION['state'] == "TX") {?> selected="selected"<? }?>>Texas</option>
                          <option value="UT"<? if($_SESSION['state'] == "UT") {?> selected="selected"<? }?>>Utah</option>
                          <option value="VT"<? if($_SESSION['state'] == "VT") {?> selected="selected"<? }?>>Vermont</option>
                          <option value="VA"<? if($_SESSION['state'] == "VA") {?> selected="selected"<? }?>>Virginia</option>
                          <option value="WA"<? if($_SESSION['state'] == "WA") {?> selected="selected"<? }?>>Washington</option>
                          <option value="WV"<? if($_SESSION['state'] == "WV") {?> selected="selected"<? }?>>West Virginia</option>
                          <option value="WI"<? if($_SESSION['state'] == "WI") {?> selected="selected"<? }?>>Wisconsin</option>
                          <option value="WY"<? if($_SESSION['state'] == "WY") {?> selected="selected"<? }?>>Wyoming</option>
                        </select>
                        <input type ="text" id="zipcode" name="zipcode"  value="<? echo $_SESSION['zipcode']; ?>"/>
                        <input type="submit" id="submit" value="Update" name="update" class="button rightfloat" />
                        </div>
                    </form>
                    </div>
                </div>  
			 <? } ?>
            <?  if ($count == "1") { ?>
            
            	<div class="outerbox">
                	<div class="innerborder">
                    	<p class="centered">Thank you for registering! You may now <a href="login.php">sign in</a>.</p>
                    </div>
                </div>
            <? } else if($action != "edit") {?>
            <div id="announcement"><h2>Welcome to Recipetincan.com</h2>
                <p>Sign up to start creating your own recipes and share them with the world.</p>
            </div>
            	<div class="header">
            	  <h1>Sign Up</h1>
               	</div>
                <div id="signupform">
                	<div class="innerborder">
                	<form action="signup.php" method="post">
                    <div id="signupinfo" class="rightfloat">
                    <h3>Why signup?</h3>
                    <ol>
                    	<li>Create and share your recipes with the world.</li>
                    	<li>View and save your favoriate recipes to view at any time.</li>
                    	<li>Be able to rate recipes and comment on recipes you like.</li>
                    </ol>
                            
<? 
 require_once('lib/inc/recaptchalib.php');
  $publickey = "6Lcsz9gSAAAAAHUk532bNBFmwZt6MKkVj1hQZ72l"; // you got this from the signup page
  echo recaptcha_get_html($publickey);?>
                    </div>
                    	<div id="labels" class="leftfloat">
                        <label for="fname">First Name: </label>
                        <label for="lname">Last Name: </label>
                        <label for="email">Email: </label>
                        <label for="password">Password: </label>
                        <label for="city">City: </label>
                        <label for="state">State: </label>
                        <label for="zipcode">Zipcode: </label>
                        </div>
                        
                        <div id="inputs" class="leftfloat">
                        <input type ="text" id="fname" name="signupfname" value="<? echo $signupfname; ?>" />
                        <input type ="text" id="lname" name="signuplname" value="<? echo $signuplname; ?>"/>
                        <input type="text" id="email" name="signupemail" value="<? echo $signupemail; ?>"/>
                        <input type ="password" id="password" name="signuppassword"/>
                        <input type ="text" id="city" name="signupcity" value="<? echo $signupcity; ?>" />
                        <select name="signupstate">
                          <option value="">Select a State</option>
                          <option value="AL" <? if($signupstate == "AL") {?> selected="selected"<? }?>>Alabama</option>
                          <option value="AK"<? if($signupstate == "AK") {?> selected="selected"<? }?>>Alaska</option>
                          <option value="AZ"<? if($signupstate == "AZ") {?> selected="selected"<? }?>>Arizona</option>
                          <option value="AR"<? if($signupstate == "AR") {?> selected="selected"<? }?>>Arkansas</option>
                          <option value="CA"<? if($signupstate == "CA") {?> selected="selected"<? }?>>California</option>
                          <option value="CO"<? if($signupstate == "CO") {?> selected="selected"<? }?>>Colorado</option>
                          <option value="CT"<? if($signupstate == "CT") {?> selected="selected"<? }?>>Connecticut</option>
                          <option value="DE"<? if($signupstate == "DE") {?> selected="selected"<? }?>>Delaware</option>
                          <option value="DC"<? if($signupstate == "DC") {?> selected="selected"<? }?>>District Of Columbia</option>
                          <option value="FL"<? if($signupstate == "FL") {?> selected="selected"<? }?>>Florida</option>
                          <option value="GA"<? if($signupstate == "GA") {?> selected="selected"<? }?>>Georgia</option>
                          <option value="HI"<? if($signupstate == "HI") {?> selected="selected"<? }?>>Hawaii</option>
                          <option value="ID"<? if($signupstate == "ID") {?> selected="selected"<? }?>>Idaho</option>
                          <option value="IL"<? if($signupstate == "IL") {?> selected="selected"<? }?>>Illinois</option>
                          <option value="IN"<? if($signupstate == "IN") {?> selected="selected"<? }?>>Indiana</option>
                          <option value="IA"<? if($signupstate == "IA") {?> selected="selected"<? }?>>Iowa</option>
                          <option value="KS"<? if($signupstate == "KS") {?> selected="selected"<? }?>>Kansas</option>
                          <option value="KY"<? if($signupstate == "KY") {?> selected="selected"<? }?>>Kentucky</option>
                          <option value="LA"<? if($signupstate == "LA") {?> selected="selected"<? }?>>Louisiana</option>
                          <option value="ME"<? if($signupstate == "ME") {?> selected="selected"<? }?>>Maine</option>
                          <option value="MD"<? if($signupstate == "MD") {?> selected="selected"<? }?>>Maryland</option>
                          <option value="MA"<? if($signupstate == "MA") {?> selected="selected"<? }?>>Massachusetts</option>
                          <option value="MI"<? if($signupstate == "MI") {?> selected="selected"<? }?>>Michigan</option>
                          <option value="MN"<? if($signupstate == "MN") {?> selected="selected"<? }?>>Minnesota</option>
                          <option value="MS"<? if($signupstate == "MS") {?> selected="selected"<? }?>>Mississippi</option>
                          <option value="MO"<? if($signupstate == "MO") {?> selected="selected"<? }?>>Missouri</option>
                          <option value="MT"<? if($signupstate == "MT") {?> selected="selected"<? }?>>Montana</option>
                          <option value="NE"<? if($signupstate == "NE") {?> selected="selected"<? }?>>Nebraska</option>
                          <option value="NV"<? if($signupstate == "NV") {?> selected="selected"<? }?>>Nevada</option>
                          <option value="NH"<? if($signupstate == "NH") {?> selected="selected"<? }?>>New Hampshire</option>
                          <option value="NJ"<? if($signupstate == "NJ") {?> selected="selected"<? }?>>New Jersey</option>
                          <option value="NM"<? if($signupstate == "NM") {?> selected="selected"<? }?>>New Mexico</option>
                          <option value="NY"<? if($signupstate == "NY") {?> selected="selected"<? }?>>New York</option>
                          <option value="NC"<? if($signupstate == "NC") {?> selected="selected"<? }?>>North Carolina</option>
                          <option value="ND"<? if($signupstate == "ND") {?> selected="selected"<? }?>>North Dakota</option>
                          <option value="OH"<? if($signupstate == "OH") {?> selected="selected"<? }?>>Ohio</option>
                          <option value="OK"<? if($signupstate == "OK") {?> selected="selected"<? }?>>Oklahoma</option>
                          <option value="OR"<? if($signupstate == "OR") {?> selected="selected"<? }?>>Oregon</option>
                          <option value="PA"<? if($signupstate == "PA") {?> selected="selected"<? }?>>Pennsylvania</option>
                          <option value="RI"<? if($signupstate == "RI") {?> selected="selected"<? }?>>Rhode Island</option>
                          <option value="SC"<? if($signupstate == "SC") {?> selected="selected"<? }?>>South Carolina</option>
                          <option value="SD"<? if($signupstate == "SD") {?> selected="selected"<? }?>>South Dakota</option>
                          <option value="TN"<? if($signupstate == "TN") {?> selected="selected"<? }?>>Tennessee</option>
                          <option value="TX"<? if($signupstate == "TX") {?> selected="selected"<? }?>>Texas</option>
                          <option value="UT"<? if($signupstate == "UT") {?> selected="selected"<? }?>>Utah</option>
                          <option value="VT"<? if($signupstate == "VT") {?> selected="selected"<? }?>>Vermont</option>
                          <option value="VA"<? if($signupstate == "VA") {?> selected="selected"<? }?>>Virginia</option>
                          <option value="WA"<? if($signupstate == "WA") {?> selected="selected"<? }?>>Washington</option>
                          <option value="WV"<? if($signupstate == "WV") {?> selected="selected"<? }?>>West Virginia</option>
                          <option value="WI"<? if($signupstate == "WI") {?> selected="selected"<? }?>>Wisconsin</option>
                          <option value="WY"<? if($signupstate == "WY") {?> selected="selected"<? }?>>Wyoming</option>
                        </select>
<input type ="text" id="zipcode" name="signupzipcode"  value="<? echo $signupzipcode; ?>"/>
                        <div class="required leftfloat"><p>*All fields required</p></div>
                        <input type="submit" id="submit" value="Sign Up" name="signupsubmit" class="button rightfloat" />
                        </div>
                    </form>
                    </div>
                </div>  
                <? } //closes thank you confirmation if?>  
            </div> <!-- end recipelist -->
            
            
            </div> <!-- end sidebar -->
            
        </div> <!-- end maincontent -->
    </div> <!-- end container -->
<? include('lib/inc/footer.inc.php');?>


</body>
</html>
