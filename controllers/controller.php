<?php

include '..\\models\\DatabaseManager.php';

function clearData($data){
    return trim(strip_tags($data));
}

$dbManager = new \models\DatabaseManager();

    $errors = array();

    // validate login
    $login = clearData($_POST['login']);
    $loginError = "";

    if(!preg_match("/^[A-Za-z0-9]{5,20}$/", $login)){
        $loginError = "Логин должен быть от 5 до 20 символов. Используйте буквы латинского алфавита и цифры";
    } elseif($dbManager->isLoginUsedAlready($login)){
        $loginError = "Такой логин уже существует";
    }

    $errors += array("login" => $loginError);

    // validate password
    $pass = clearData($_POST['pass']);
    $confirm = clearData($_POST['confirm']);
    $passError = "";

    if(!preg_match("/^[A-Za-z0-9]{5,20}$/", $pass)){
        $passError = "Пароль должен быть от 5 до 20 символов. Используйте буквы латинского алфавита и цифры";
    } elseif($pass !== $confirm){
        $passError = "Пароли должны совпадать";
    }

    $errors += array("password" => $passError);

    //validate phone
    $phone = clearData($_POST['phone']);
    $phoneError = "";


    // ^\+\d\d\s\([\d]{3}\)\s[\d]{3}-[\d]{2}-[\d]{2}$ ready for first format
    // /^\({0,1}[\d]{3}\){0,1}\s[\d]{3}\s[\d]{2}\s[\d]{2}$/ ready for two others format

    if(!preg_match('/^(\+\d\d\s\([\d]{3}\)\s[\d]{3}-[\d]{2}-[\d]{2})'
    . '|(\({0,1}[\d]{3}\){0,1}\s[\d]{3}\s[\d]{2}\s[\d]{2})$/', $phone)){
        $phoneError = "Некорректный номер. Введите номер в формате +38 (093) 937-99-92, 093 937 99 92, (093) 937 99 92";
    }

    $errors += array("phone" => $phoneError);

    //validate invite
    $invite = clearData($_POST['invite']);
    $inviteError = "";

    $isUsed = $dbManager->isInviteUsedAlready($invite);

    if(!preg_match("/^[0-9]{6}$/", $invite)){
       $inviteError = "Введите 6 цифр";
    } elseif($isUsed === 1){
        $inviteError = "Несуществующий инвайт";
    } elseif($isUsed === 2){
        $inviteError = "Инвайт уже занят";
    }

    $errors += array("invite" => $inviteError);

    $result = empty($errors) ? 'success' : 'errors';

    if(empty($errors)){

        $dbManager->insertNewUser($login, $pass, $phone, $_POST["city"], $invite);
    }

    echo json_encode($errors);
