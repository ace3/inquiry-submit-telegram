<?php 
//if (session_status() == PHP_SESSION_NONE) {
    session_start();
//}

//check if cart already initialized
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


//assign cart to session;
?>