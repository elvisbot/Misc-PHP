<?php
// ********** This file and all of its containing script is property of James Hamet **********

$time = (int) date(H);
$time2 = (int) date(i);

if (($time > 9 OR ($time > 8 AND $time2 >=30)) AND ($time < 16 OR ($time == 16 AND $time2 == 0)))
	{
	// Start Session and Security
	session_start();

	// Connect to Database
	
	// OMMITEED

	// Add Variables
	$result = mysql_query("SELECT * FROM sdata WHERE id=indexid ORDER BY id") or die(mysql_error());  
	while($row = mysql_fetch_array($result))
		{
		$index = $row['indexname'];
		$source = file_get_contents("http://www.smartmoney.com/quote/".$index);
		$pattern = '#<span smsym="'.$index.'" smfield="price">(.+)<\/span>#';
		if (preg_match($pattern, $source, $array))
			{
			$value = trim((strip_tags($array[0])), '&nbsp;');
			$result2 = mysql_query("SELECT * FROM sdata WHERE indexname='$index' ORDER BY what_time LIMIT 0,1") or die(mysql_error());  
			$row2 = mysql_fetch_array( $result2 );
			$realid = $row2['indexid'];
			mysql_query("INSERT INTO sdata (indexid, indexname, value, what_time) VALUES('$realid','$index','$value', NOW())") or die(mysql_error());
			}
		}
	}

?>
