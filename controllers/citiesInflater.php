<?php

include '..\\models\\DatabaseManager.php';

function clearData($data){
    return trim(strip_tags($data));
}

$dbManager = new \models\DatabaseManager();
$country = clearData($_POST['country']);
$countries = $dbManager->getCities($country);
$result = array();

for($i = 0; $i < count($countries); $i++){
    $result[$i] = $countries[$i]['city_name'];
}

echo json_encode($result);