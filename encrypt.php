<?php
// ********** This file and all of its containing script is property of James Hamet **********

// Operation Tools
function crypter($str)
	{
    $str = eregi_replace(" +", " ", $str);
    $array = explode(" ", $str);
	// Sentence Structure
    for($i = 0; $i < count($array); $i++)
		{
		// Special Conditions
		$parr = rand(0,2);
		if ($parr == 0 AND $array[$i] != '_')
			{
			echo "(";
			}
		else if ($parr == 1 AND $array[$i] != '_')
			{
			echo "*";
			}
		// Letter Recognition
		$reverse = strrev( $array[$i] );
		$lastletter = $reverse[0];
		$normal = strrev( $reverse );
		$firstletter = $normal[0];
		$neworder = $lastletter . $array[$i];
		$array[$i] = substr_replace($neworder ,"",-1);
		// Word Structure
		for ($newi = 0, $j = strlen($array[$i]); $newi < $j; $newi++) 
			{
			$varr = $array[$i][$newi];
			if ($parr == 0)
				{
				switch ($varr) 
					{
					
					case "r" OR "s":
						switch ($varr)
							{
							case "r":
								$varr = "s";
								break;
							case "s":
								$varr = "r";
								break;
							}
						
					case "n" OR "p":
						switch ($varr)
							{
							case "n":
								$varr = "p";
								break;
							case "p":
								$varr = "n";
								break;
							}
					}
				}
			else if ($parr == 1)
				{
				switch ($varr) 
					{
					
					case "g" OR "h":
						switch ($varr)
							{
							case "g":
								$varr = "h";
								break;
							case "h":
								$varr = "g";
								break;
							}
						
					case "v" OR "s":
						switch ($varr)
							{
							case "s":
								$varr = "v";
								break;
							case "v":
								$varr = "s";
								break;
							}
							
					case "i" OR "a":
						switch ($varr)
							{
							case "u":
								$varr = "a";
								break;
							case "a":
								$varr = "u";
								break;
							}
					}
				}
				switch ($varr) 
					{
					
					case "e" OR "i":
						switch ($varr)
							{
							case "e":
								$varr = "i";
								break;
							case "i":
								$varr = "e";
								break;
							}
						
					case "t" OR "y":
						switch ($varr)
							{
							case "t":
								$varr = "y";
								break;
							case "y":
								$varr = "t";
								break;
							}
					}	
			if (isset($rem) AND $varr == $rem)
				{
				echo '?';
				}
			else 
				{
				$rem = $varr;
				echo $varr;
				}
			}
		$vowels = array('a', 'e', 'i', 'o', 'u');
		$topalph = array('b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm');
		if (in_array($firstletter, $vowels))
			{
			echo'e';
			if (!in_array($lastletter, $vowels))
				{
				echo'r';
				}
			}
		else if (in_array($firstletter, $topalph))
			{
			echo'a';
			if (!in_array($lastletter, $topalph))
				{
				echo'r';
				}
			}
		else if (!in_array($firstletter, $vowels) AND !in_array($firstletter, $topalph) AND !in_array($lastletter, $vowels) AND !in_array($lastletter, $topalph) )
			{
			echo'o';
			}
		else
			{
			echo'or';
			}
		if ($parr == 0 AND $array[$i] != '_')
			{
			echo ")";
			}
		else if ($parr == 1 AND $array[$i] != '_')
			{
			echo "*";
			}
		if (isset($array[($i+1)]))
			{
			echo '_';
			unset($rem);
			}
		}
	}
	
function decrypter($str)
	{
	$str = eregi_replace("_+", "_", $str);
    $array = explode("_", $str);
	// Sentence Structure
    for($i = 0; $i < count($array); $i++)
		{
		
		$vowels = array('a', 'e', 'i', 'o', 'u');
		$topalph = array('b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm');
		$botalph = array('n', 'p', 'q', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z');
		
		// Special Condition Recognition
		$scan = $array[$i];
		$result = $scan[0];
		switch ($result) 
					{
					case "(":
						$trans = substr_replace($scan ,"",-1);
						$trans = strrev( $trans );
						$trans = substr_replace($trans ,"",-1);
						$array[$i] = strrev( $trans );
						$result = 1;
						break;
					case "*":
						$trans = substr_replace($scan ,"",-1);
						$trans = strrev( $trans );
						$trans = substr_replace($trans ,"",-1);
						$array[$i] = strrev( $trans );
						$result = 2;
						break;
					}
		
		// Letter Recognition
		$normal = $array[$i];
		$lastletter = $normal[0];
		$reverse = strrev( $normal );
		$reorder = substr_replace($reverse ,"",-1);
		$normal = strrev( $reorder );
		$firstletter = $normal[0];
		
		if ($firstletter == '?')
			{
			$firstletter = $lastletter;
			}
		
		if ((in_array($firstletter, $vowels) AND in_array($lastletter, $vowels)) OR (in_array($firstletter, $topalph) AND in_array($lastletter, $topalph)) OR (in_array($firstletter, $botalph) AND in_array($lastletter, $botalph)))
			{
			$array[$i] = substr_replace($normal ,"",-1);
			}
		else
			{
			$array[$i] = substr_replace($normal ,"",-2);
			}
		$array[$i] = $array[$i] . $lastletter;

		// Word Structure
		for ($newi = 0, $j = strlen($array[$i]); $newi < $j; $newi++) 
			{
			$parr = 3;
			$varr = $array[$i][$newi];
			if ($result == 1)
				{
				$parr = 0;
				}
			else if ($result == 2)
				{
				$parr = 1;
				}
			else
				{
				$parr = 3;
				}
			if ($varr == '?')
				{
				if (isset($array[$i][($newi - 1)]))
					{
					$varr = $array[$i][($newi - 1)];
					}
				else
					{
					$length = strlen($array[$i]);
					$varr = $array[$i][($length - 1)];
					}
				}
			if ($parr == 0)
				{
				switch ($varr) 
					{
					
					case "r" OR "s":
						switch ($varr)
							{
							case "r":
								$varr = "s";
								break;
							case "s":
								$varr = "r";
								break;
							}
						
					case "n" OR "p":
						switch ($varr)
							{
							case "p":
								$varr = "n";
								break;
							case "n":
								$varr = "p";
								break;
							}
					}
				}
			else if ($parr == 1)
				{
				switch ($varr) 
					{
					
					case "g" OR "h":
						switch ($varr)
							{
							case "g":
								$varr = "h";
								break;
							case "h":
								$varr = "g";
								break;
							}
						
					case "v" OR "s":
						switch ($varr)
							{
							case "v":
								$varr = "s";
								break;
							case "s":
								$varr = "v";
								break;
							}
							
					case "u" OR "a":
						switch ($varr)
							{
							case "u":
								$varr = "a";
								break;
							case "a":
								$varr = "u";
								break;
							}
					}
				}
				switch ($varr) 
					{
					
					case "e" OR "i":
						switch ($varr)
							{
							case "e":
								$varr = "i";
								break;
							case "i":
								$varr = "e";
								break;
							}
						
					case "t" OR "y":
						switch ($varr)
							{
							case "t":
								$varr = "y";
								break;
							case "y":
								$varr = "t";
								break;
							}
					}	
			if ($varr != '?')
				{
				echo $varr;
				}
			}
		echo ' ';
		}
	}
 
// Main Page Begin
echo'<title>Ysicrio Converter</title>';
echo'<center><b>Ysicrio Converter</b></center><br /><br />';

echo'<center><table><tr><td>';
	echo'<form name="encrypt" action="#" method="post">
		 <p>Message: </td><td> <input type="text" name="entry" size="16" />
		 <a href="javascript:document.encrypt.submit()">Encrypt</a></p></form>';
	echo'</tr><tr><td>';
	echo'<form name="decrypt" action="#" method="post">
		 <p>Message: </td><td> <input type="text" name="entry2" size="16" />
		 <a href="javascript:document.decrypt.submit()">Decrypt</a></p></form>';
	echo'</td></tr></table></center>';
	
// Transductions
if (isset($_POST['entry']))
	{
	$value = htmlspecialchars(strtolower($_POST['entry']));
	echo'<table width="90%"><tr><td>'.$value . '</td></tr><tr><td>';
	crypter($value);
	echo'</td></tr></table>';
	}
else if (isset($_POST['entry2']))
	{
	$value = htmlspecialchars(strtolower($_POST['entry2']));
	echo'<table width="90%"><tr><td>'.$value . '</td></tr><tr><td>';
	decrypter($value);
	echo'</td></tr></table>';
	}

?>