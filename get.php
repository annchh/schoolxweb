<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


include_once '../config/database.php';
include_once '../models/city.php';

$database = new Database();
$db = $database->getConnection();

$city = new City($db);

$page = $_GET['page']??1;
$kol = 3;
$art = ($page*$kol)-$kol;

$stmt = $city->get($kol, $art);
$num = $stmt->rowCount();

if ($num > 0) {

    $city_arr = array();
    $city_arr["items"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        // извлекаем строку
        extract($row, EXTR_OVERWRITE);

        $city_item = array(
            "id" => $id,
            "name" => $name,

        );

        $city_arr["items"][] = $city_item;
    }

    http_response_code(200);

    echo json_encode($city_arr, JSON_THROW_ON_ERROR);

} else {
    http_response_code(404);

    echo json_encode(["message" => "Пользователь не найдены"], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
}
