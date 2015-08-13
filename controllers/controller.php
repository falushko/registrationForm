<?php

include '..\\models\\DatabaseManager.php';

function clearData($data){
    return trim(strip_tags($data));
}

$dbManager = new \models\DatabaseManager();

    $isValidationPassed = true;
    $errors = array();

    // validate login
    $login = clearData($_POST['login']);
    $loginError = "";

    if(!preg_match("/^[A-Za-z0-9]{5,20}$/", $login)){
        $loginError = "Используте от 5 до 20 латинских символов или цифр";
        $isValidationPassed = false;
    } elseif($dbManager->isLoginUsedAlready($login)){
        $isValidationPassed = false;
        $loginError = "Такой логин уже существует";
    }

    $errors += array("login" => $loginError);

    // validate password
    $pass = clearData($_POST['pass']);
    $confirm = clearData($_POST['confirm']);
    $passError = "";

    if(!preg_match("/^[A-Za-z0-9]{5,20}$/", $pass)){
        $passError = "Используте от 5 до 20 латинских символов или цифр";
        $isValidationPassed = false;
    } elseif($pass !== $confirm){
        $passError = "Пароли должны совпадать";
        $isValidationPassed = false;
    }

    $errors += array("password" => $passError);

    //validate phone
    $phone = clearData($_POST['phone']);
    $phoneError = "";
    // todo clear phone from any symbols except digits

    if(!preg_match('/^(\+\d\d\s\([\d]{3}\)\s[\d]{3}-[\d]{2}-[\d]{2})'
    . '|(\({0,1}[\d]{3}\){0,1}\s[\d]{3}\s[\d]{2}\s[\d]{2})$/', $phone)){
        $phoneError = "Некорректный номер. Введите номер в формате +38 (093) 937-99-92, 093 937 99 92, (093) 937 99 92";
        $isValidationPassed = false;
    }

    $errors += array("phone" => $phoneError);

    //validate invite
    $invite = clearData($_POST['invite']);
    $inviteError = "";

    $isUsed = $dbManager->isInviteUsedAlready($invite);

    if(!preg_match("/^[0-9]{6}$/", $invite)){
       $inviteError = "Введите 6 цифр";
        $isValidationPassed = false;
    } elseif($isUsed === 1){
        $inviteError = "Несуществующий инвайт";
        $isValidationPassed = false;
    } elseif($isUsed === 2){
        $inviteError = "Инвайт уже занят";
        $isValidationPassed = false;
    }

    $errors += array("invite" => $inviteError);

    $result = empty($errors) ? 'success' : 'errors';

    if($isValidationPassed){
        $phone = str_replace('+', '', $phone);
        $phone = str_replace('(', '', $phone);
        $phone = str_replace(')', '', $phone);
        $phone = str_replace(' ', '', $phone);
        $phone = str_replace('-', '', $phone);
        $dbManager->insertNewUser($login, $pass, $phone, $_POST["city"], $invite);
        echo "success";
        exit;
    }

    echo json_encode($errors);

