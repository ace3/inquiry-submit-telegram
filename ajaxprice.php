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

echo '<h4><span class="label label-default">Subtotal: Rp. '.$subtotal_price.' ('.$qty.' x Rp. '.number_format($eachprice,0,",",".").')</span></h4>';
?>





