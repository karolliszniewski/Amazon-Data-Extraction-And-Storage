<?php


class Variations extends StringManipulator{
				function __construct(){
		$this->htmlParser = new HtmlParser();
	}
	
	function type1($htmlContent,$tagid,$tagname,$tagtype){
		$result = 	$this->htmlParser->getElementAndXPath($tagid,$tagname,$tagtype,$htmlContent);
		$xpath = $result->xpath;
		$element = $result->element;
		$dom = $result->dom;
		define('START_POINT','data-csa-c-item-id="');
		define('END_POINT','"');
		$asins = Array();
		if($element){
			$elementHtml = $dom->saveHTML($element);
			$howmany = substr_count($elementHtml,START_POINT);
			
			for($i=0;$i<$howmany;$i++){
				$asins[$i] = $this->cutFromTo(START_POINT,END_POINT,$elementHtml);
				$elementHtml = $this->cutFrom(START_POINT,$elementHtml);
				
			}
			
		}
		return $asins;
		
	}
	
	
	
	
}
