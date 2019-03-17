<?php
include('common_header.php');

use \Firebase\JWT\JWT;

$database = new dbClass();
$db       = $database->getConnection();
$product  = new Product($db);
$data     = json_decode(file_get_contents("php://input"));
$jwt      = isset($data->jwt) ? $data->jwt : "";

if($jwt){
    // if decode succeed, show user details
    try {
        // decode jwt
        $decoded = JWT::decode($jwt, $key, array('HS256'));

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
    }catch (Exception $e){

        // set response code
        http_response_code(401);

        // show error message
        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }
}