<?php class HtmlParser{
	
	function getElementAndXPath($tagid, $tagname,$tagtype,$htmlContent){
		
		$dom = new DOMDocument();
        @$dom->loadHTML($htmlContent);
        $xpath = new DOMXPath($dom);
        $query = '//'.$tagname.'[@'.$tagtype.'="'.$tagid.'"]';
        $element = $xpath->query($query)->item(0);
		
		$result = (object) array(
        'xpath' => $xpath,
        'element' => $element,
		'dom' => $dom
        );
		
		
		return $result;
	}
	
	function getElementInsideElement($tagname,$tagtype,$tagvalue,$xpath,$element){
		    
			$querySpan = './/'.$tagname.'[contains(@'.$tagtype.', "'.$tagvalue.'")]';
            $spanElement = $xpath->query($querySpan, $element)->item(0);
			
			return $spanElement;
	}
	
}