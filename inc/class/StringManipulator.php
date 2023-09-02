<?php 

class StringManipulator{
	
		// from(but without defined string) -> to first after
function cutFromTo($startString,$endString,$sourceCode)
{
	$from = strpos($sourceCode,$startString);
	$result = substr($sourceCode,$from + strlen($startString));
	$to = strpos($result,$endString);
	$result = substr($result,0,$to);
	
return $result;	
}

// from(but without defined string) -> and everything after
function cutFrom($startString,$sourceCode)
{
	$from = strpos($sourceCode,$startString);
	$result = substr($sourceCode,$from + strlen($startString));
return $result;	
}
}

