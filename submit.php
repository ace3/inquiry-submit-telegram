<?php
session_start();

if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];

} else {
    $cart = array();
    $_SESSION['cart'] = $cart;
}

if (isset($_SESSION['profile'])) {
    $profile = $_SESSION['profile'];

} else {
    $profile = array();
    $_SESSION['profile'] = $profile;
}

require_once('telegram.php');

if(sizeof($profile)==0)
{
$newURL = 'index.php';
header('Location: '.$newURL);
}
if(sizeof($cart)==0)
{
    $newURL = 'index.php';
    header('Location: ' . $newURL);
}

include_once('database.php');

$result = R::getAll('select products.id , products.`code`, products.`name`, category.`name` as category_name , subcategory.`name` as subcategory_name , units.`name` as unit_name  , products.`price` from sma_products products
left join sma_categories category
on products.subcategory_id = category.id
left join sma_categories subcategory
on products.category_id = subcategory.id
left join sma_units units
on products.unit = units.id');

R::close();

$products = array();
foreach ($result as $key => $value) {
    $products_detail = array(
        'id' => $value['id'],
        'category_name' => $value['category_name'],
        'subcategory_name' => $value['subcategory_name'],
        'unit_name' => $value['unit_name'],
        'product_name' => $value['name'],
        'description' => $value['name'],
        'price' => $value['price'],
    );
    $products[] = $products_detail;
}
$separator = PHP_EOL;

$date = date('m/d/Y h:i:s a', time());

$string = '### ORDER BARU ###'.$separator.$separator;
$string .= $date.$separator.$separator;

$counter = 1;
$subtotal = 0;
foreach ($cart as $key => $value) {
    foreach ($products as $k => $v)
    {
        if($value['product_id'] == $v['id'])
        {
            $string .='#'.$counter.$separator;
            $string .=$v['product_name'] .' ['.$v['unit_name'].'] x '.$value['qty'].' '.$v['unit_name'].''.$separator;
            $total = $value['qty']*$v['price'];
            $string .=$value['qty'].' x '.number_format($v['price'],0,',','.').' = '.number_format($total,0,',','.').$separator.$separator;
            $counter++;
            $subtotal = $subtotal+$total;
        }        
    }
}
$string .= 'TOTAL (IDR) = Rp. '.number_format($subtotal,0,',','.').$separator;
$string .= '(TOLONG DICEK KEMBALI DENGAN HARGA TOKO)'.$separator.$separator;
$string .= '### DETAIL PEMESAN ###'.$separator.$separator;
$string .= 'NAMA: '.$profile['name'] . $separator . $separator;
$string .='ALAMAT:'.$separator;
$string .= $profile['address'].$separator.$separator;
$string .= 'EKSPEDISI: ' .$separator. $profile['expedisi'] . $separator . $separator;
$string .= 'HP: ' . $profile['phone'] . $separator . $separator;
$string .= 'EMAIL: ' . $profile['email'] . $separator . $separator;
$string .= '### HARAP FOLLOWUP VIA WA/SMS/TELP/EMAIL ###';

sendMessage($string);

$newURL = 'index.php';
unset($_SESSION['cart']); 
header('Location: '.$newURL);
?>