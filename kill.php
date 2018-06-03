<?php if(isset($_GET['kill']))
{
    session_start();
    //check if cart already initialized
    if(isset($_SESSION['cart']))
    {
        $cart = $_SESSION['cart'];
    }
    else {
        $cart = array();
        $_SESSION['cart'] = $cart;
    }

    $index = $_GET['kill'];
    unset($cart[$index]);
    $_SESSION['cart'] = $cart;
}
$newURL = 'index.php';
header('Location: '.$newURL);
?>