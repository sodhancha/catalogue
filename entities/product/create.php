<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/dbClass.php';
include_once '../../modals/product.php';

// required to encode json web token
include_once '../../config/core.php';
include_once '../../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../../libs/php-jwt-master/src/ExpiredException.php';
include_once '../../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../../libs/php-jwt-master/src/JWT.php';

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
