<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/city.php';

$database = new Database();
$db = $database->getConnection();

$user = new City($db);

$data = json_decode(file_get_contents("php://input"), false, 512, JSON_THROW_ON_ERROR);

$id = $_GET['id'];
$name = $_GET['name'];

$user->name = $data->name;
$user->id = $data->id;

if ($user->update()) {

    http_response_code(200);

    echo json_encode(["message" => "Пользователь был обновлён."], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
} else {

    http_response_code(503);

    echo json_encode(["message" => "Невозможно обновить пользователя."], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
}
