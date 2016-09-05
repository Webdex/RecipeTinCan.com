<? header("Content-Type: application/xml; charset=ISO-8859-1");
	
  class RSS //give the php code a class
  {
	public function RSS() // make a new function named rss
	{
		require_once ('lib/inc/db.inc.php'); // database connection
	}
	public function GetFeed() // new function inside of rss function
	{
		return $this->getDetails() . $this->getItems();
	}
	private function getDetails() // title of the rss document. can be gotten from database if database has RSS table
	{
			$details = '<?xml version="1.0" encoding="ISO-8859-1" ?>
				<rss version="2.0">
					<channel>
						<title>Recipetincan.com Top 20 Recipes</title>
						<link>http://www.recipetincan.com</link>
						<description>Recipes for you</description>
						<image>
							<title>Recipetincan.com Top 20 Recipes</title>
							<url>http://www.recipetincan.com/lib/img/logo_red.png</url>
							<link>http://www.recipetincan.com</link>
						</image>';
		return $details;
	}
	private function getItems() // gets each rss item
	{
		$itemsTable = "recipes";
		$query = "SELECT * FROM ". $itemsTable ." WHERE active = 1 ORDER BY rating DESC LIMIT 20";
		$result = mysql_query ($query);
		$items = '';
		while($row = mysql_fetch_array($result))
		{
			$items .= '<item>
				<title>'. $row["name"] .'</title>
						<link>http://www.recipetincan.com/recipepage.php?recipeid='. $row['recipeid'] .'</link>
				<description><![CDATA['. $row["text"] .']]></description>
			</item>';
		}
		$items .= '</channel>
				</rss>';
		return $items;
	}
}

  $rss = new RSS(); // runs the rss function
  echo $rss->GetFeed(); //echo the feed to the page
?>
