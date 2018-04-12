<?php
echo 'process the request';
$newURL = 'index.php';
unset($_SESSION['cart']); 
header('Location: '.$newURL);
?>