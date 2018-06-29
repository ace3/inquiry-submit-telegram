<?php

include_once 'database.php';

$productId = $_POST['product'];
echo '<option value="">Select Variant</option>';

$result = R::getAll("
select variants.id as id, variants.name as variant_name
from sma_product_variants variants
where variants.product_id = " . $productId);

$variants = array();

if ($result) {
    foreach ($result as $key => $value) {
        $variants_detail = array(
            'id' => $value['id'],
            'variant_name' => $value['variant_name'],
        );

        $variants[] = $variants_detail;
    }
}

foreach ($variants as $key => $value) {
    $code = $value['id'];
    $name_value = $value['variant_name'];
    echo "<option value='" . $code . "'>" . $name_value . "</option>";
}

if (!$result) {
    echo "<option value='0' selected >No Variant</option>";
}
