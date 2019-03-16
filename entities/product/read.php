<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/dbClass.php';
include_once '../../modals/product.php';

//database and product objects
$database = new dbClass();
$db       = $database->getConnection();
$product  = new Product($db);

$prods = $product->read();
$num   = $prods->rowCount();

if ($num > 0)
{
    $products_arr            = [];
    $products_arr["records"] = [];

    while ($row = $prods->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);

        $product_item = [
            "id"          => $id,
            "name"        => $name,
            "description" => html_entity_decode($description),
            "price"       => $price,
            "quantity"    => $quantity,
        ];

        array_push($products_arr["records"], $product_item);
    }

    http_response_code(200);
    echo json_encode($products_arr);
}
else
{
    http_response_code(404);
    echo json_encode([ "message" => "No products found." ]);
}