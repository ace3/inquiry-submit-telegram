<?php

session_start();
$cart = $_SESSION['cart'];
if(isset($_POST))
{
    $product_id = $_POST['product'];
    $qty = $_POST['qty'];
    
    $cart_item = array('product_id'=>$product_id,
    'qty'=>$qty
    );
    $cart[] = $cart_item;
}
$_SESSION['cart'] = $cart;

$newURL = 'index.php';
header('Location: '.$newURL);
?>