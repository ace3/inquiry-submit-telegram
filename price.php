<?php

$cat = R::getAll('select id , name from sma_categories where id in(select distinct category_id from sma_products)');

$categories = array();

foreach ($cat as $key => $value) {
    $category = array(
        'id'=>$value['id'],
        'name'=>$value['name']
    );
    $categories[] = $category;
}

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
        'price' => $value['price']
    );

    $products[] = $products_detail;
}

?>
