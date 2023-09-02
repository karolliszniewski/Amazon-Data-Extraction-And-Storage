<html>
<body>
<link rel="stylesheet" href="inc/css/style.css?2" />

<?php
// Order is important!
//require_once 'inc/showErrors.php';
// cut strings 
require_once 'inc/class/StringManipulator.php';
// get the dom like selenium
require_once 'inc/class/HtmlParser.php';
// price
require_once 'inc/class/DecodePrice.php';
// delivery , minimum order
require_once 'inc/class/OutOfStock.php';
// variations
require_once 'inc/class/Variations.php';
// title
require_once 'inc/class/Title.php';
// category
require_once 'inc/class/Category.php';

$id = $_POST['id'];
$asin = $_POST['asin'];
$htmlContent = "";

if (isset($_FILES['html']['tmp_name']) && !empty($_FILES['html']['tmp_name'])) {
    $htmlContent = file_get_contents($_FILES['html']['tmp_name']);
}





// price
$DecodePrice = new DecodePrice();
$priceRow_0 = $DecodePrice->findPriceBasic($htmlContent,'newAccordionRow_0','div','id');
$priceRow_1 = $DecodePrice->findPriceBasic($htmlContent,'newAccordionRow_1','div','id');
$priceRow_2 = $DecodePrice->findPriceBasic($htmlContent,'newAccordionRow_2','div','id');
$priceDesktop = $DecodePrice->findPriceBasic($htmlContent,'gsod_singleOfferDisplay_Desktop','div','id');
$priceDesktop_feature = $DecodePrice->findPriceBasic($htmlContent,'gsod_singleOfferDisplay_Desktop_feature_div','div','id');
$priceSubscription = $DecodePrice->findPriceSubscription($htmlContent,'snsAccordionRowMiddle','div','id');

// delivery and minimum quantity
$outOfStock = new OutOfStock();
$delivery = $outOfStock->delivery($htmlContent,'div','deliveryBlockMessage');
$quantity = $outOfStock->munimumOrder($htmlContent,'quantityRelocate_feature_div','div','id');
// for new items dont show low quantity in stock
$lowStock = $outOfStock->lowStock($htmlContent,'availabilityInsideBuyBox_feature_div','div','id');

// dropdown , variations asins
$variations = new Variations();
$variations1 = $variations->type1($htmlContent,'a-unordered-list a-nostyle a-button-list a-declarative a-button-toggle-group a-horizontal a-spacing-top-micro swatches swatchesSquare imageSwatches','ul','class');

// Title
$title = new Title();
$productTitle = $title->title($htmlContent,'productTitle','span','id');

//Category
$category = new Category();
$categoryWidget = $category->category($htmlContent,'showing-breadcrumbs_csm_instrumentation_wrapper','div','cel_widget_id');


// validate data: lowest price found or 0 if not found
$prices = array($priceRow_0->price, $priceRow_1->price, $priceRow_2->price, $priceDesktop->price, $priceDesktop_feature->price, $priceSubscription->price);

$filteredPrices = array_filter($prices, function ($price) {
    return $price > 0;
});

if (!empty($filteredPrices)) {
    $priceStatus = min($filteredPrices);
} else {
    $priceStatus = 0;
}

if($priceStatus > 0){
	$stockStatus = 1;
}else{
	
	$stockStatus = 0;
}

?>

    <div class="container">
      <div class="table">
        <div class="data-row">Price</div>
        <div class="data-row">newAccordionRow_0</div>
        <div class="data-row <?php if($priceRow_0->price > 0){echo 'green';} ?>"><?php echo $priceRow_0->price.'asin:'.$priceRow_0->asin; ?></div>
		
		<div class="data-row">Price</div>
        <div class="data-row">newAccordionRow_1</div>
        <div class="data-row <?php if($priceRow_1->price > 0){echo 'green';} ?>"><?php echo $priceRow_1->price; ?></div>

        <div class="data-row ">Price</div>
        <div class="data-row">newAccordionRow_2</div>
        <div class="data-row <?php if($priceRow_2->price > 0){echo 'green';} ?>"><?php echo $priceRow_2->price; ?></div>
		
				<div class="data-row">Price</div>
        <div class="data-row">gsod_singleOfferDisplay_Desktop</div>
        <div class="data-row <?php if($priceDesktop->price > 0){echo 'green';} ?>"><?php echo $priceDesktop->price.'asin:'.$priceRow_0->asin; ?></div>
		
		<div class="data-row">Price</div>
        <div class="data-row">gsod_singleOfferDisplay_Desktop_feature_div</div>
        <div class="data-row <?php if($priceDesktop_feature->price > 0){echo 'green';} ?>"><?php echo $priceDesktop_feature->price.'asin:'.$priceRow_0->asin; ?></div>
		
		<div class="data-row">Price Subscription</div>
        <div class="data-row">snsAccordionRowMiddle</div>
        <div class="data-row <?php if($priceSubscription->price > 0){echo 'green';} ?>"><?php echo $priceSubscription->price; ?></div>
				<div class="data-row">Delivery</div>
        <div class="data-row">deliveryBlockMessage</div>
        <div class="data-row <?php if($delivery > 0){echo 'green';} ?>"><?php echo $delivery; ?></div>
		
		
			  		<div class="data-row">Minimum Order Quantity</div>
        <div class="data-row">quantityRelocate_feature_div</div>
        <div class="data-row <?php if($quantity > 0){echo 'green';} ?>"><?php echo $quantity; ?></div>
		
					  		<div class="data-row">Final Price</div>
        <div class="data-row">// validate data:</div>
        <div class="data-row <?php if($priceStatus > 0){echo 'green';} ?>"><?php echo $priceStatus; ?></div>
		
							  		<div class="data-row">Stock Status</div>
        <div class="data-row">// validate data:</div>
        <div class="data-row <?php if($stockStatus > 0){echo 'green';} ?>"><?php echo $stockStatus; ?></div>
		
  		<div class="data-row">All Items</div>
        <div class="data-row">a-unordered-list...</div>
	  <textarea class="allitems" cols="10" rows="5"><?php print_r($variations1) ?></textarea>
	  
	  
	  							  		<div class="data-row">Title</div>
        <div class="data-row">productTitle</div>
       <input class="allitems"  value=" <?php echo $productTitle; ?>">
	   
	   	  	  							  		<div class="data-row">Category</div>
        <div class="data-row">cel_widget_id</div>
       <input class="allitems"  value=" <?php echo $categoryWidget; ?>">

	   	  	  							  		<div class="data-row">Low Stock</div>
        <div class="data-row">htmlText</div>
       <input class="allitems"  value=" <?php if($lowStock == true){echo 'Low';}else{echo 'In Stock';} ?>">


	   
		<!-- end table -->
      </div>
	  


	  <!-- end container -->
    </div>


<?php














echo '<hr><br /><br /><br />';
echo $htmlContent;
?>


<form action="upload.php" method="post" enctype="multipart/form-data">
ids: <input id="ids" type="text" name="id"><br>
asin: <input id="asin" type="text" name="asin"><br>
html: <input id="html" type="file" name="html"><br>

<input id="submit" type="submit">
</form>

</body>
</html>