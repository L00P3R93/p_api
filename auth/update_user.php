<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include '../config/core.php';
include '../config/db.php';
include '../objects/user.php';
require '../vendor/autoload.php';
use \Firebase\JWT\JWT;

$database = new Db();
$db = $database->getConnection();
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));
$jwt = isset($data->jwt) ? $data->jwt : "";

if($jwt){
    try{
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        $user->firstname = $data->firstname;
        $user->lastname = $data->lastname;
        $user->email = $data->email;
        $user->password = $data->password;
        $user->id = $decoded->data->id;
        if($user->update()){
            $token = array(
                "iat"=>$issued_at,
                "exp"=>$expiration_time,
                "iss"=>$issuer,
                "data"=>array(
                    "id"=>$user->id,
                    "firstname"=>$user->firstname,
                    "lastname"=>$user->lastname,
                    "email"=>$user->email
                )
            );
            $jwt = JWT::encode($token, $key);
            http_response_code(200);
            echo json_encode(array("message"=>"User updated.", "jwt"=>$jwt));
        }else{
            http_response_code(401);
            echo json_encode(array("message"=>"Unable to Update user"));
        }
    }catch (Exception $e){
        http_response_code(401);
        echo json_encode(array("message"=>"Access Denied.", "error"=>$e->getMessage()));
    }
}else{
    http_response_code(401);
    echo json_encode(array("message"=>"Access Denied."));
}
