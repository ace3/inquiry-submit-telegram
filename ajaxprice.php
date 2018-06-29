<?php
include_once 'database.php';

$qty = 0;
$productId = $_POST['product_id'];
$qty = $_POST['qty'];
$variant = $_POST['variant'];

$result = R::getAll("select products.price from sma_products products
where products.id = " . $productId);
$eachprice = 0;
foreach ($result as $key => $value) {
    $eachprice = $value['price'];
}

$variant_extra_cost = R::getAll("
select variants.id as id, variants.name as variant_name,variants.price, variants.cost
from sma_product_variants variants
where variants.id = " . $variant);

$variant_cost = 0;

$variant_price = 0;
foreach ($variant_extra_cost as $key => $value) {
    $variant_price = $value['price'];
    $variant_cost = $value['cost'];
}

R::close();

$eachprice_total = $eachprice + $variant_price + $variant_cost;

$subtotal_price = $eachprice_total * $qty;
$subtotal_price = number_format($subtotal_price, 0, ",", ".");
echo '<h4><span class="label label-default">Subtotal: Rp. ' . $subtotal_price . ' (' . $qty . ' x Rp. ' . number_format($eachprice, 0, ",", ".") . ')</span></h4>';
if ($variant_cost != 0) {
    echo '<h6><span class="label label-default">Variant Cost: Rp. ' . number_format($variant_cost, 0, ",", ".") . ' </span></h6>';
}
if ($variant_price != 0) {
    echo '<h6><span class="label label-default">Variant Price: Rp. ' . number_format($variant_price, 0, ",", ".") . ' </span></h6>';
}
