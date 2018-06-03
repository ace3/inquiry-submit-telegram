<?php 

include_once 'database.php';


$categoryId = $_POST['category'];
echo "<option value="">Select Product</option>";

$result = R::getAll("select products.id , products.`code`, products.`name`, category.`name` as category_name ,category.`id` as category_id,  subcategory.`name` as subcategory_name , units.`name` as unit_name  , products.`price` from sma_products products
left join sma_categories category
on products.subcategory_id = category.id
left join sma_categories subcategory
on products.category_id = subcategory.id
left join sma_units units
on products.unit = units.id
where products.category_id = ".$categoryId);

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

foreach ($products as $key => $value) {
$code = $value['id'];
$name_value = $value['product_name'];
    echo "<option value='" . $code . "'>". $name_value . "</option>";

}

?>