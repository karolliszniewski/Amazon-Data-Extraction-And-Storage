<?php


class DecodePrice extends StringManipulator{
	
	function __construct(){
		$this->htmlParser = new HtmlParser();
	}
		
    function findPriceBasic($htmlContent,$tagid,$tagname,$tagtype) {
					$notFound = (object) array(
									'price' => 0,
									'asin' => 'none',
									);
		$result = 	$this->htmlParser->getElementAndXPath($tagid,$tagname,$tagtype,$htmlContent);
		$xpath = $result->xpath;
		$element = $result->element;
        
		// Check if a valid price element is found, return the price or 0 if not found
        if ($element) {
			
			$spanElement = $this->htmlParser->getElementInsideElement('span','class','a-offscreen',$xpath,$element);
            $cleanedText = preg_replace('/[^0-9.]/', '', $spanElement->textContent);
			$result = (object) array(
									'price' => $cleanedText,
									'asin' => $asin,
									);
									

			
			if(strlen($cleanedText)>=8){
				return $notFound;
			}

            return $result;
        } else {
            return $notFound;
        }
    }
	
	// subscription price
	
	    function findPriceSubscription($htmlContent,$tagid,$tagname,$tagtype) {
						$notFound = (object) array(
									'price' => 0,
									'asin' => 'none',
									);
		$result = 	$this->htmlParser->getElementAndXPath($tagid,$tagname,$tagtype,$htmlContent);
		$xpath = $result->xpath;
		$element = $result->element;
		$dom = $result->dom;

        // Jesli element zostal znaleziony, wyswietl jego kod HTML
        if ($element) {
            $querySpan = './/span[contains(@id, "sns-base-price")]';
            $spanElement = $xpath->query($querySpan, $element)->item(0);
			$elementHtml = $dom->saveHTML($spanElement);
			$asin = $this->cutFromTo('data-csa-c-asin="','"',$elementHtml);
			$elementHtml =	$this->cutFromTo('>','<',$elementHtml);

            $cleanedText = preg_replace('/[^0-9.]/', '', $elementHtml);
						$result = (object) array(
									'price' => $cleanedText,
									'asin' => $asin,
									);
									

            return $result;
        } else {
            return $notFound;
        }
    }
	
}