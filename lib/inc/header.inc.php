<?
							$reports = mysql_num_rows(mysql_query("SELECT * FROM reports WHERE active = 1"));
							$restaurants = mysql_num_rows(mysql_query("SELECT * FROM restaurants WHERE active = 3"));
?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-37625301-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"> </script>

    <script type="text/javascript" src="lib/js/jquery.js"> </script>
    <div id="headbanner"></div>
    <div id="header">
    	<div id="headercontainer">
        	<div id="branding" class="leftfloat">
            	<a href="http://www.recipetincan.com">
                
                 <img src="lib/img/logo.png" alt="recipetincanlogo" />
                
                </a>
            </div>
            <div id="login" class="rightfloat">
        <? if ($_SESSION['logged_in'] == 1) {
        echo "<h3><div class='leftfloat'>Welcome ". $_SESSION['fname'] ."</div> <div class='rightfloat'><a href='logout.php'>Logout</a></div><div class='rightfloat'><a href='logincheck.php' class='userlink'>My Account";
				if ($_SESSION['usertypenumber'] == 300 && $reports > 0 || $restaurants > 0) {
			echo '<img src="lib/img/exclamation5.png" alt="alert icon"/>';
		}

		echo"</a>
		
		</div></h3>";
        } else {
        echo ("				<div class='rightfloat'><p><a href='login.php' class='loginlink'>Sign In</a></p></div>
                <div class='rightfloat'><p><a href='signup.php' class='signuplink'>Create an account</a></p></div>
");
		}
		?>
                
            </div>
        </div>
        <div id="nav">
        	<div id="navcontainer">
            	<ol>
                	<li class="homelink"><a href="http://www.recipetincan.com">Home</a></li>
                	<li class="recipeslink"><a href="category.php?r=all">Recipes</a>
                    	
                        <ol>
                        	<?
							$result = mysql_query("SELECT * FROM categories WHERE active = 1");
							$count = mysql_num_rows($result);
							$i= 0;
							$link = "link";
							while ($i < $count) {
								$category = mysql_result($result, $i, "category");
								$categoryid2 = mysql_result($result, $i, "categoryid");
								echo "<li class='$category$link'><a href='category.php?categoryid=$categoryid2'>$category</a></li>";
								$i++;
							}
							?>
                        	
                        </ol>
                        
                    </li>
                	<li class="restaurantslink"><a href="restaurants.php">Restaurants</a></li>
                	<li class="aboutlink"><a href="about.php">About</a></li>
                </ol>
            </div>
        </div>
    </div> <!-- end header -->
