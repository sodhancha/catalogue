<?php
include('common_header.php');

use \Firebase\JWT\JWT;

//database and product objects
$database = new dbClass();
$db       = $database->getConnection();
$product  = new Product($db);
$data     = json_decode(file_get_contents("php://input"));
$jwt      = isset($data->jwt) ? $data->jwt : "";

if ($jwt)
{
    // if decode succeed, show user details
    try
    {
        // decode jwt
        $decoded = JWT::decode($jwt, $key, [ 'HS256' ]);

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
    } catch (Exception $e)
    {

        // set response code
        http_response_code(401);

        // show error message
        echo json_encode([
            "message" => "Access denied.",
            "error"   => $e->getMessage()
        ]);
    }
}