<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authroization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$cat = new Category($db);

$data = json_decode(file_get_contents('php://input'));

$cat->id = $data->id;
$cat->name = $data->name;
$cat->created_at = $data->created_at;

if ($cat->update()) {
  echo json_encode(array('message' => 'Category updated'));
} else {
  echo json_encode(array('message' => 'Category not updated'));
}