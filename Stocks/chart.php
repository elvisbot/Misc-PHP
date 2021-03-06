<?php

// Start Session and Security
session_start();

// Connect to Database

// OMMITTED
	
// Set Variables
$index = (int) htmlspecialchars($_GET['id']);
$result = mysql_query("SELECT * FROM sdata WHERE indexid=$index ORDER BY value DESC LIMIT 0,1") or die(mysql_error());
$row = mysql_fetch_array($result);
$max = (int) $row['value'] + 1;
$result2 = mysql_query("SELECT * FROM sdata WHERE indexid=$index ORDER BY value LIMIT 0,1") or die(mysql_error());
$row2 = mysql_fetch_array($result2);
$min = (int) $row2['value'] - 1;
if ( $min >= 0 )
	{
	$min = 0;
	}

// Chart Data
include 'charts.php';

$chart[ 'axis_category' ] = array ( 'size'=>8, 'color'=>"ffffff", 'alpha'=>50, 'font'=>"arial", 'bold'=>true, 'skip'=>22 ,'orientation'=>"horizontal" ); 
$chart[ 'axis_ticks' ] = array ( 'value_ticks'=>true, 'category_ticks'=>true, 'major_thickness'=>2, 'minor_thickness'=>1, 'minor_count'=>1, 'major_color'=>"000000", 'minor_color'=>"222222" ,'position'=>"outside" );
$chart[ 'axis_value' ] = array (  'min'=>$min, 'max'=>$max, 'font'=>"arial", 'bold'=>true, 'size'=>10, 'color'=>"ffffff", 'alpha'=>50, 'steps'=>6, 'prefix'=>"", 'suffix'=>"", 'decimals'=>0, 'separator'=>"", 'show_min'=>true );
$chart[ 'chart_border' ] = array ( 'color'=>"000000", 'top_thickness'=>2, 'bottom_thickness'=>2, 'left_thickness'=>2, 'right_thickness'=>2 );

// Personal Injection
$counter = 0;
$chart [ 'chart_data' ][ 0 ][ 0 ] = '';
$result = mysql_query("SELECT * FROM sdata WHERE indexid=$index ORDER BY id") or die(mysql_error());
while($row = mysql_fetch_array($result))
	{
	$counter++;
	$time = $row['what_time'];
	$chart [ 'chart_data' ][ 0 ][ $counter ] = $time;
	}
$counter2 = 0;
$counter3 = 0;
$chart [ 'chart_data' ][ 1 ][ $counter2 ] = 'Today';
$chart [ 'chart_data' ][ 2 ][ $counter3 ] = 'Yesterday';
$result2 = mysql_query("SELECT * FROM sdata WHERE indexid=$index ORDER BY id DESC") or die(mysql_error());
while($row2 = mysql_fetch_array($result2))
	{
	$timelimit = 60*60*24;
	$timelimit2 = 60*60*24*2;
	$etime = strototime($row['what_time']);
	$atime = time() - $timelimit;
	$atime2 = time() - $timelimit2;
	if ($etime > $atime)
		{
		$counter2++;
		$value = $row2['value'];
		$chart [ 'chart_data' ][ 1 ][ $counter2 ] = $value;
		}
	if ($etime < $atime AND $etime > $atime2)
		{
		$counter3++;
		$value = $row2['value'];
		$chart [ 'chart_data' ][ 2 ][ $counter3 ] = $value;
		}
	}

// Continuation
$chart[ 'chart_grid_h' ] = array ( 'alpha'=>10, 'color'=>"000000", 'thickness'=>1, 'type'=>"solid" );
$chart[ 'chart_grid_v' ] = array ( 'alpha'=>10, 'color'=>"000000", 'thickness'=>1, 'type'=>"solid" );
$chart[ 'chart_pref' ] = array ( 'line_thickness'=>2, 'point_shape'=>"none", 'fill_shape'=>false );
$chart[ 'chart_rect' ] = array ( 'x'=>40, 'y'=>25, 'width'=>335, 'height'=>200, 'positive_color'=>"000000", 'positive_alpha'=>30, 'negative_color'=>"ff0000",  'negative_alpha'=>10 );
$chart[ 'chart_type' ] = "Line";
$chart[ 'chart_value' ] = array ( 'prefix'=>"", 'suffix'=>"", 'decimals'=>2, 'separator'=>"", 'position'=>"cursor", 'hide_zero'=>true, 'as_percentage'=>false, 'font'=>"arial", 'bold'=>true, 'size'=>12, 'color'=>"ffffff", 'alpha'=>75 );

$chart[ 'draw' ] = array ( array ( 'type'=>"text", 'color'=>"ffffff", 'alpha'=>15, 'font'=>"arial", 'rotation'=>-90, 'bold'=>true, 'size'=>50, 'x'=>-10, 'y'=>348, 'width'=>300, 'height'=>150, 'text'=>"", 'h_align'=>"center", 'v_align'=>"top" ),
                           array ( 'type'=>"text", 'color'=>"000000", 'alpha'=>15, 'font'=>"arial", 'rotation'=>0, 'bold'=>true, 'size'=>60, 'x'=>0, 'y'=>0, 'width'=>320, 'height'=>300, 'text'=>"output", 'h_align'=>"left", 'v_align'=>"bottom" ) );

$chart[ 'legend_rect' ] = array ( 'x'=>-100, 'y'=>-100, 'width'=>10, 'height'=>10, 'margin'=>10 ); 

$chart[ 'series_color' ] = array ( "77bb11", "cc5511" ); 

SendChartData ( $chart );

?>
