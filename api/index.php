<?php

header('Access-Control-Allow-Origin: http://localhost:3000');
header('Content-Type: application/json');

$baseDir = __DIR__; // Get the current directory of the script.

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['endpoint'] === 'products') {
    $productsFile = $baseDir . '/products.json';
    if (!file_exists($productsFile) || filesize($productsFile) <= 0) exit;

    $data = file_get_contents($productsFile);
    $dataArray = json_decode($data, true);
    $response = $dataArray;

    if (isset($_GET['limit'])) {
        $limit = $_GET['limit'];

        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            $response = array_slice($dataArray, ($page - 1) * $limit, $limit);
        } else {
            $response = array_slice($dataArray, 0, $limit);
        }
    }

    echo json_encode($response);
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['endpoint'] === 'categories') {
    $categoriesFile = $baseDir . '/categories.json';
    if (!file_exists($categoriesFile) || filesize($categoriesFile) <= 0) exit;

    $data = file_get_contents($categoriesFile);

    $dataArray = json_decode($data, true);
    $response = $dataArray;
    echo json_encode($response);
} else {
    $response = array('error' => 'Invalid endpoint');
    echo json_encode($response);
}
