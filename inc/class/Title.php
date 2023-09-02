<?php
// i copied this class from https://github.com/nicolas-grekas/Patchwork-UTF8/blob/master/src/Patchwork/Utf8.php
require_once 'Utf8.php';

class Title extends \Patchwork\Utf8{
				function __construct(){
		$this->htmlParser = new HtmlParser();
	}
	
	function title($htmlContent,$tagid,$tagname,$tagtype){
		$result = 	$this->htmlParser->getElementAndXPath($tagid,$tagname,$tagtype,$htmlContent);
		$element = $result->element;
		if($element){
			$elementText = $element->textContent;
			$elementText = mb_convert_encoding($elementText, "UTF-8");
			$elementText = $this::toAscii($elementText);
			$elementText = preg_replace("/'/", "", $elementText);	
			$elementText = preg_replace("/\?/", "", $elementText);	
			$elementText = str_replace('\\', '', $elementText);
			$elementText = preg_replace('/^\s+/', '', $elementText); 
			$elementText = preg_replace('/\s+$/', '', $elementText);

			return $elementText;
		}
		else{
		return 0;
		}
	}
	
}