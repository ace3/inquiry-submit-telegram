<?php
session_start();
$cart = $_SESSION['cart'];
if(isset($_POST))
{
    $product_id = $_POST['product'];
    $qty = $_POST['qty'];
    $notes = $_POST['notes'];
    $cart_item = array('product_id'=>$product_id,
    'qty'=>$qty,
        'notes' => $notes
    );
    $cart[] = $cart_item;
}
$_SESSION['cart'] = $cart;
$newURL = 'index.php';
header('Location: '.$newURL);
?>