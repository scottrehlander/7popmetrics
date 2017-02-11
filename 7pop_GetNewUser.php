<?
	$DBhost = "db524255376.db.1and1.com";
	$DBuser = "dbo524255376";
	$DBpass = "rcbrcb123";
	$DBName = "db524255376";
	mysql_connect($DBhost,$DBuser,$DBpass) or die("Unable to connect to database");

	if($_GET['sk']=='newUser')
	{	
		mysql_select_db($DBName) or die("Unable to select database $DBName");

		$sqlquery = "INSERT INTO users (userName) VALUES('" . 'newUser' . "')";

		$results = mysql_query($sqlquery);
		
		$sqlquery = "SELECT * FROM users ORDER BY userId desc LIMIT 1";

		$results = mysql_query($sqlquery);
		while($row = mysql_fetch_array( $results )) 
		{
			// Print out the contents of each row
			echo $row['userId'];
		} 		
		
		mysql_close();
	}
?>