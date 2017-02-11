<?
	$DBhost = "db524255376.db.1and1.com";
	$DBuser = "dbo524255376";
	$DBpass = "rcbrcb123";
	$DBName = "db524255376";
	mysql_connect($DBhost,$DBuser,$DBpass) or die("Unable to connect to database");

	if($_GET['sk']=='track')
	{	
		mysql_select_db($DBName) or die("Unable to select database $DBName");
		
		if($_GET['uid'] != "")
			$uid = $_GET['uid'];
		else
			$uid = '-1';
			
		if($_GET['timesOpened'])
			$timesOpened = $_GET['timesOpened'];
		else
			$timesOpened = -1;
			
		if($_GET['gameName'])
			$gameName = $_GET['gameName'];
		else
			$gameName = '';
		
		$sqlquery = "INSERT INTO metrics (info, userId, timesOpened, gameName) VALUES('" . $_GET['info'] . "', " . $uid . ", " . $timesOpened . ", '" . $gameName . "')";

		$results = mysql_query($sqlquery);
		
		echo($sqlquery . " was run");

		mysql_close();
	}
	else if($_GET['sk']=='pigsinablanket')
	{
		mysql_select_db($DBName) or die("Unable to select database $DBName");
		
		$payload = $_GET['payload'];
		$eventType = $_GET['type'];
		
		$sqlquery = "INSERT INTO eventLog (eventType, eventPayload) VALUES('" . $eventType . "', '" . $payload . "')";

		$results = mysql_query($sqlquery);
		
		mysql_close();
	}	
	else
	{
		if($_GET['viewit'])
		{
			if($_GET['viewit'] == 1)
			{
				mysql_select_db($DBName) or die("Unable to select database $DBName");

				$sqlquery = "SELECT * FROM metrics ORDER BY id desc";

				$results = mysql_query($sqlquery);

				echo "<table border='1'>";
				echo "<tr> <th>metric id</th> <th>datetime</th> <th>game name</td> <th>times opened</th> <th>user id</th> </tr>";
				// keeps getting the next row until there are no more to get
				while($row = mysql_fetch_array( $results )) {
					// Print out the contents of each row into a table
					echo "<tr><td>"; 
					echo $row['id'];
					echo "</td><td>"; 
					echo $row['datetime'];
					echo "</td><td>"; 
					echo $row['gameName'];
					echo "</td><td>"; 
					echo $row['timesOpened'];
					echo "</td><td>"; 
					echo $row['userId'];
					echo "</td></tr>"; 
				} 

				echo "</table>";
				mysql_close();	
			}
			else
			{
				mysql_select_db($DBName) or die("Unable to select database $DBName");

				$sqlquery = "SELECT * FROM metrics ORDER BY id desc";

				$results = mysql_query($sqlquery);

				
				// Create an array of phone types that are actually the same
				$phoneTypeLookup = array();
				
				// Arrive
				$phoneTypeLookup['HTC T7575'] = 'HTC Arrive';
				
				// Pro
				$phoneTypeLookup['HTC 7 Pro T7576'] = 'HTC 7 Pro';
				
				// Lumia 800
				$phoneTypeLookup['NOKIA Nokia 800'] = 'NOKIA Lumia 800';
				$phoneTypeLookup['NOKIA Nokia 800C'] = 'NOKIA Lumia 800';
				
				// Lumia 710
				$phoneTypeLookup['NOKIA Nokia 710'] = 'NOKIA Lumia 710';
				
				// HD7
				$phoneTypeLookup['HTC HD7 T9292'] = 'HTC HD7';
				
				// Radar
				$phoneTypeLookup['HTC Radar C110e'] = 'HTC Radar 4G';
				
				// Mozart
				$phoneTypeLookup['HTC 7 Mozart T8698'] = 'HTC 7 Mozart';
				$phoneTypeLookup['HTC T8697'] = 'HTC 7 Mozart';
				
				// Focus Flash
				$phoneTypeLookup['SAMSUNG SGH-i677'] = 'Samsung Focus Flash';
				
				// Focus				
				$phoneTypeLookup['SAMSUNG SGH-I917'] = 'Samsung Focus';
				$phoneTypeLookup['SAMSUNG SGH-i917.'] = 'Samsung Focus';
				$phoneTypeLookup['SAMSUNG SGH-i917'] = 'Samsung Focus';
				$phoneTypeLookup['SAMSUNG SGH-i917R'] = 'Samsung Focus';
				
				// Focus S
				$phoneTypeLookup['SAMSUNG SGH-i937'] = 'Samsung Focus S';
				
				// Jil Sander
				$phoneTypeLookup['LG LG-E906'] = 'LG Jil Sander';
				
				// Titan
				$phoneTypeLookup['HTC PI39100'] = 'HTC Titan 4G';
				$phoneTypeLookup['HTC TITAN X310e'] = 'HTC Titan 4G';
								
				// Trophy
				$phoneTypeLookup['HTC mwp6985'] = 'HTC 7 Trophy';
								
				// Omnia W
				$phoneTypeLookup['SAMSUNG GT-I8350'] = 'SAMSUNG Omnia W';
				
				// Optimus
				$phoneTypeLookup['LG LG-E900'] = 'Samsung Optimus';
				$phoneTypeLookup['LG LG-E900h'] = 'Samsung Optimus';
				
				// Surround
				$phoneTypeLookup['HTC T8788'] = 'HTC Surround 7';

				// Quantum
				$phoneTypeLookup['LG LG-C900'] = 'LG Quantum';
				
								
				$phonesArray = array();
				while($row = mysql_fetch_array($results))
				{
					$samePhoneTypeName = $row['info'];
					if(array_key_exists($row['info'], $phoneTypeLookup))
						$samePhoneTypeName = $phoneTypeLookup[$row['info']];
						
					if(!array_key_exists($samePhoneTypeName, $phonesArray))
						$phonesArray[$samePhoneTypeName] = 0;
					
					$phonesArray[$samePhoneTypeName]++;
				}
								
				echo "<table border='1'>";
				echo "<tr> <th>Phone Type</th> <th>Occurances</th> </tr>";
				// keeps getting the next row until there are no more to get
				while( $element = each( $phonesArray ) )
				{
					// Print out the contents of each row into a table
					echo "<tr><td>"; 
					echo $element['key'];
					echo "</td><td>"; 
					echo $element['value'];
					echo "</td></tr>"; 
				} 
				
				echo "</table>";
				mysql_close();
			}
		}
	}
?>