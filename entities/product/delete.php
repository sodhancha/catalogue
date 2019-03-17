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

        // set product id to be deleted
        $product->id = $data->id;

        // delete the product
        if($product->delete())
        {
            http_response_code(200);
            echo json_encode(array("message" => "Product was deleted."));
        }
        else
        {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to delete product."));
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