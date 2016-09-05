<? include('lib/inc/db.inc.php');
	$_SESSION['logged_in'] = 0;
	unset($_SESSION['usertypenumber']);
	unset($_SESSION['fname']);
	unset($_SESSION['userid']);
	unset($_SESSION['city']);
	unset($_SESSION['state']);
	unset($_SESSION['zipcode']);
header('location: http://www.recipetincan.com');
?>