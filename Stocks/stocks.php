<?php

function getvalueindex($indexabreviation){

$needle = '<span id='.$indexabreviation.'_l>'; //Going to have to make that relative to the fetch_array
$contents = file_get_contents('http://www.google.com/search?sourceid=chrome&ie=UTF-8&q='. $indexabreviation.'+stock'); //Going to have to make that relative to the fetch_array
$position = strpos($contents, $needle);
$position+=7;
$x = 0;
$certainty = 0;
 while ($x<15){
  $contentletter = $contents[$position];
  $ints = array('1','2','3','4','5','6','7','8','9','0', ",", ".");
  if (in_array($contentletter, $ints)){$indexvalue[$x] = $contentletter;}
  $x++;
  $position++;}
if (isset($indexvalue)){$indexvalue = implode("", $indexvalue);
return $indexvalue;}
}

?>