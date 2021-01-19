<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control_allow_headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/db.php';
include_once '../objects/category.php';
$database = new Db();
$db = $database->getConnection();
$category = new Category($db);
$data = json_decode(file_get_contents("php://input"));
if(!empty($data->name) and !empty($data->description)){
    $category->name = $data->name;
    $category->description = $data->description;
    $category->created = date('Y-m-d H:i:s');
    if($category->create()){
        http_response_code(201);
        echo json_encode(array("message"=>"Category created."));
    }else{
        http_response_code(503);
        echo json_encode(array("message"=>"Unable to create Category"));
    }
}else{
    http_response_code(400);
    echo json_encode(array("message"=>"Unable to create Category. Data is incomplete."));
}
