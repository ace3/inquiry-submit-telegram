<?php

$products = array();

for ($i = 1;$i <10 ; $i++)
{
    $products_detail = array('id' =>$i,
        'product_name'=>'Product '.$i,
                            'description' => 'Description '.$i,
                            'price' => $i*10000);

                            $products[] = $products_detail;
}


$satuan = array('METER','ROLL','UNIT','BOX');
?>
