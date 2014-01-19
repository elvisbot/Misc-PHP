<?php
// ********** This file and all of its containing script is property of James Hamet **********

// Start Session and Security
session_start();

// Connect to Database

// OMMITTED

// Insert New Data
if (isset($_POST['index']))
	{
	$index = htmlspecialchars($_POST['index']);
	$result = mysql_query("SELECT * FROM sdata WHERE indexname='$index'") or die(mysql_error());
	if (!mysql_num_rows($result))
		{
		$source = file_get_contents("http://www.smartmoney.com/quote/".$index);
		$pattern = '#<span smsym="'.$index.'" smfield="price">(.+)<\/span>#';

		if (preg_match($pattern, $source, $array))
			{
			$value = trim((strip_tags($array[0])), '&nbsp;');
			mysql_query("INSERT INTO sdata (indexname, value, what_time) VALUES('$index','$value', NOW())") or die(mysql_error());
			$result = mysql_query("SELECT * FROM sdata WHERE indexname='$index'") or die(mysql_error());  
			$row = mysql_fetch_array( $result );
			$realid = $row['id'];
			mysql_query("UPDATE sdata SET indexid=id WHERE id='$realid'") or die(mysql_error());  
			}
		else
			{
			?><script type="text/javascript">
			alert("An error has occured.");
			history.back();			
			</script><?php
			}
		}
	else
		{
		?><script type="text/javascript">
		alert("Index already being tracked.");
		history.back();		 // Make it redirect to the entered index	
		</script><?php
		}
	}

// ********** START **********
echo'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-ca">
<head><title>Stock</title>
<meta name="description" content="Welcome to my Stock Tracker" />
<meta name="keywords" content="" lang="en" />
<meta name="language" content="en" />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta http-equiv="content-style-type" content="text/css" />

</head>';

echo'<center><b>Welcome to my Stock Tracker</b></center><br />';

echo'<table align="center"><tr><td>Indexes</td><td>Values</td>';
if (isset($_GET['id']))
	{
	echo'<td>Evolution over Time</td>';
	}
echo'</tr><tr><td width="80px">';

// Show Data
$result = mysql_query("SELECT * FROM sdata WHERE id=indexid ORDER BY id") or die(mysql_error());  
while($row = mysql_fetch_array($result))
	{
	$which = $row['id'];
	$result2 = mysql_query("SELECT * FROM sdata WHERE indexid='$which' ORDER BY id LIMIT 0,1") or die(mysql_error()); 
	$row2 = mysql_fetch_array($result2);
	echo '<a href="index.php?id=' . $row2['id'] . '">' . $row2['indexname'] .'</a><br />';
	}
echo'</td><td width="80px">';
$result = mysql_query("SELECT * FROM sdata WHERE id=indexid ORDER BY id") or die(mysql_error());
while($row = mysql_fetch_array($result))
	{
	$which = $row['id'];
	$result2 = mysql_query("SELECT * FROM sdata WHERE indexid='$which' ORDER BY id DESC LIMIT 0,1") or die(mysql_error()); 
	$row2 = mysql_fetch_array($result2);
	echo $row2['value'] . '<br />';
	}
if (isset($_GET['id']))
	{
	echo'</td><td><div id="myChart">';
	include "charts.php";
	$link = 'sample.php?id=' . (int) htmlspecialchars($_GET['id']);
	echo InsertChart ( "charts.swf", "charts_library", $link, 400, 250 );
	echo'</div>';
	}
echo'</td></tr></table>';

// Add New Form
echo'<form action="/index.php" method="post">
	<center><br /><table cellspacing="10"><tr><td>
	<b>Index:</b></td><td><input type="text" name="index" size="30"/></td><td>
	<center><input type="submit" value="Add"></center></td></tr></table></center>
	</form>';

?>
