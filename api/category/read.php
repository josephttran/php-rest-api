<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

// Instantiate category object
$cat = new Category($db);

// Category read query
$result = $cat->read();

// Get row count
$num = $result->rowCount();

// Check if any Category
if ($num > 0) {
  $cat_arr = array();
  $cat_arr['data'] = array();

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $cat_item = array(
      'id' => $id,
      'name' => $name,
    );

    array_push($cat_arr['data'], $cat_item);
  }

  // Return to JSON and output
  echo json_encode($cat_arr);
} else {
  // No posts
  echo json_encode(
    array('message' => 'No Category Found')
  );
}