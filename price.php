<?php

$result = R::getAll('select products.id , products.`code`, products.`name`, category.`name` as category_name , subcategory.`name` as subcategory_name , units.`name` as unit_name  , products.`price` from sma_products products
left join sma_categories category
on products.subcategory_id = category.id
left join sma_categories subcategory
on products.category_id = subcategory.id
left join sma_units units
on products.unit = units.id');


// var_dump($result); 
// die();
R::close();




$products = array();

foreach ($result as $key => $value) {
    $products_detail = array(
        'id' => $value['code'],
        'category_name' => $value['category_name'],
        'subcategory_name' => $value['subcategory_name'],
        'unit_name' => $value['unit_name'],
        'product_name' => $value['name'],
        'description' => $value['name'],
        'price' => $value['price']
    );

    $products[] = $products_detail;
}

//var_dump($products); die();
// for ($i = 1;$i <10 ; $i++)
// {
//     $products_detail = array('id' =>$i,
//         'product_name'=>'Product '.$i,
//                             'description' => 'Description '.$i,
//                             'price' => $i*10000);

//                             $products[] = $products_detail;
// }


//$satuan = array('METER','ROLL','UNIT','BOX');
?>
