<?
include ('lib/inc/db.inc.php');
 switch ($_SESSION['usertypenumber']) {
		case '100' : header('location:user.php');
		break;
		case '200' : header('location:user.php');
		break;
		case '300' : header('location:admin.php');
		break;
		default : header('location:index.php');
	
 }

?>