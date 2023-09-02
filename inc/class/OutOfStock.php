<?php



class OutOfStock extends StringManipulator{
		
			function __construct(){
		$this->htmlParser = new HtmlParser();
	}
	
	function delivery($htmlContent,$tagname,$tagid){
		$dom = new DOMDocument();
        @$dom->loadHTML($htmlContent);
        $xpath = new DOMXPath($dom);

        $query = '//'.$tagname.'[@id="'.$tagid.'"]';
        $element = $xpath->query($query)->item(0);
		
		if($element){
			
			$elementHtml = $dom->saveHTML($element);
			$delivery = $this->cutFromTo('data-csa-c-delivery-price="','"',$elementHtml);
			$delivery = preg_replace('/[^0-9.]/', '', $delivery);
			if($delivery > 0)
			{
			return $delivery;
			}
			else{
				return 0;
			}
			
			
		}else{
		
		return 0;
		}
	}
	
	
	function munimumOrder($htmlContent,$tagid,$tagname,$tagtype){
		
		$result = 	$this->htmlParser->getElementAndXPath($tagid,$tagname,$tagtype,$htmlContent);
		$xpath = $result->xpath;
		$element = $result->element;
		$dom = $result->dom;
		if($element){
		$elementHtml = $dom->saveHTML($element);
	
		$quantity = $this->cutFromTo(' (Minimum order quantity)" value="','"',$elementHtml);
		$quantity = preg_replace('/[^0-9]/', '', $quantity);
		echo "<br>|$quantity|<br>";
			$quantity = $quantity + 1;
			$quantity = $quantity - 1;
		if(strlen($quantity)<=3){
			if($quantity == 0){
				$quantity = 1;
			}
			return $quantity;
		}
		else{
			return 1;
		}
	
		}else{
			return 1;
		}
		return 1;
	}
	
	function lowStock($htmlContent,$tagid,$tagname,$tagtype){
		
		$result = 	$this->htmlParser->getElementAndXPath($tagid,$tagname,$tagtype,$htmlContent);
		$xpath = $result->xpath;
		$element = $result->element;
		$dom = $result->dom;
		if($element){
			
			$elementText = $element->textContent;
					for($i =1;$i<=15;$i++){
			if(strpos($elementText, "Only $i left in stock") >=1){
				return true;
			}
			
		}
		return false;
		}
		else{
			return false;
		}
		
		
	}
	
}