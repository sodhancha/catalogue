<?php
include('jwt_headers.php');

use \Firebase\JWT\JWT;

$data = json_decode(file_get_contents("php://input"));
$jwt  = isset($data->jwt) ? $data->jwt : "";

// if jwt is not empty
if($jwt){
    // if decode succeed, show user details
    try {
        // decode jwt
        $decoded = JWT::decode($jwt, $key, array('HS256'));

        // set response code
        http_response_code(200);

        // show user details
        echo json_encode(array(
            "message" => "Access granted.",
            "data" => $decoded->data
        ));
    }
    // if decode fails, it means jwt is invalid
    catch (Exception $e){

        // set response code
        http_response_code(401);

        // tell the user access denied  & show error message
        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }
}
else
{
    http_response_code(401);
    echo json_encode(array("message" => "Access denied."));
}