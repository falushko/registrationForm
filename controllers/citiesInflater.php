<?php

// fills cities selector with cities, corresponding to selected country

include '..\\models\\DatabaseManager.php';

function clearData($data){
    return trim(strip_tags($data));
}

$dbManager = new \models\DatabaseManager();
$country = clearData($_POST['country']);
$cities = $dbManager->getCities($country);
$result = array();

echo json_encode($cities);