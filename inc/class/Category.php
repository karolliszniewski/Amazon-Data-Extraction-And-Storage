<?php 
// i copied this class from https://github.com/nicolas-grekas/Patchwork-UTF8/blob/master/src/Patchwork/Utf8.php
require_once 'Utf8.php';

class Category extends \Patchwork\Utf8{
				function __construct(){
		$this->htmlParser = new HtmlParser();
	}
	
	function category($htmlContent,$tagid,$tagname,$tagtype){
		$result = 	$this->htmlParser->getElementAndXPath($tagid,$tagname,$tagtype,$htmlContent);
		$element = $result->element;
		if($element){
			$elementText = $element->textContent;
			$elementText = $this::toAscii($elementText);
$elementText = preg_replace("/\n|\r/", "", $elementText);
$elementText = preg_replace("/\s{2,}/", "", $elementText);
$elementText = preg_replace("/›/", ">", $elementText);		
$elementText = preg_replace("/&/", "", $elementText);	
$elementText = preg_replace("/'/", "", $elementText);	

			return $elementText;
		}else{
			return 0;}
	}
	
	
}
