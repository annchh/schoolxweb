<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


include_once '../config/database.php';
include_once '../models/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$page = $_GET['page']??1;
$kol = 3;
$art = ($page*$kol)-$kol;

$stmt = $user->get($kol, $art);
$num = $stmt->rowCount();

if ($num > 0) {

    $user_arr = array();
    $user_arr["items"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        // извлекаем строку
        extract($row, 1);

        $user_item = array(
            "id" => $id,
            "name" => $name,
            "city_id" => $city_id,
        );

        $user_arr["items"][] = $user_item;
    }

    http_response_code(200);

    echo json_encode($user_arr, JSON_THROW_ON_ERROR);

} else {
    http_response_code(404);

    echo json_encode(["message" => "Пользователи не найдены."], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
}