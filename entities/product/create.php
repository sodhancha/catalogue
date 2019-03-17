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

        if ( ! empty($data->name) && ! empty($data->price) && ! empty($data->description) && ! empty($data->quantity))
        {
            $product->name        = $data->name;
            $product->price       = $data->price;
            $product->description = $data->description;
            $product->quantity    = $data->quantity;
            $product->created     = date('Y-m-d H:i:s');

            if ($product->create())
            {
                http_response_code(201);
                echo json_encode([ "message" => "Product was created." ]);
            }
            else
            {
                http_response_code(503);
                echo json_encode([ "message" => "Unable to create product." ]);
            }
        }
        else
        {
            http_response_code(400);
            echo json_encode([ "message" => "Unable to create product. Data is incomplete." ]);
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
