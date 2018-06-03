<?php 
session_start();

if(isset($_SESSION['cart']))
{
    $cart = $_SESSION['cart'];
    
}
else {
    $cart = array();
    $_SESSION['cart'] = $cart;
}

if(isset($_SESSION['profile']))
{
    $profile = $_SESSION['profile'];
    
}
else {
    $profile = array();
    $_SESSION['profile'] = $profile;
}

?>