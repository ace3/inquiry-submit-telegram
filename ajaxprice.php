<?php 

include_once 'database.php';


$qty = 0;
$productId = $_POST['product_id'];
$qty = $_POST['qty'];

$result = R::getAll("select products.price from sma_products products
where products.id = " . $productId);

$eachprice = 0;
foreach ($result as $key => $value) {
    $eachprice = $value['price'];
}

R::close();

$subtotal_price = $eachprice*$qty;

$subtotal_price = number_format($subtotal_price,0,",",".");

echo '<h4>Example <span class="label label-default">Subtotal Price: '.$subtotal_price.'</span></h4>';
?>





