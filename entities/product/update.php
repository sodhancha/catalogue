<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/dbClass.php';
include_once '../../modals/product.php';

$database = new dbClass();
$db       = $database->getConnection();
$product  = new Product($db);
$data     = json_decode(file_get_contents("php://input"));

// set ID property of product to be edited
$product->id = $data->id;

// set product property values
$product->name        = $data->name;
$product->price       = $data->price;
$product->description = $data->description;
$product->quantity    = $data->quantity;

// update the product
if ($product->update())
{
    http_response_code(200);
    echo json_encode([ "message" => "Product was updated." ]);
}
else
{
    http_response_code(503);
    echo json_encode([ "message" => "Unable to update product." ]);
}