<?php
/**
 * Created by PhpStorm.
 * User: Владимир
 * Date: 01.08.2015
 * Time: 16:57
 */

namespace models;

use PDO;

class DatabaseManager
{

    private $databaseConnection;

    public function __construct()
    {
        try {
            $this->databaseConnection = new PDO('mysql:host=localhost;dbname=registration_form',
                "someuser", "password");
        }
        catch (PDOException $e){
            echo "Database connection error";
        }
    }

    // check database for used login
    public function isLoginUsedAlready($login){
        $stmt = $this->databaseConnection->prepare("SELECT login FROM users WHERE login = :login");
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        $result = $stmt->fetch();

        if (empty($result[0])) return false;
        else return true;
    }

    //check database for used invite
    public function isInviteUsedAlready($invite){
        $stmt = $this->databaseConnection->prepare("SELECT invite, status FROM invites WHERE invite = :login");
        $stmt->bindParam(':login', $invite);
        $stmt->execute();
        $result = $stmt->fetch();

        if(empty($result['invite'])) return 1; //"Несуществующий инвайт"
        elseif ($result["status"] == 1) return 2; //"Инвайт уже занят"
    }

    //get all countries to inflate selector
    public function getCountries(){
        $stmt = $this->databaseConnection->prepare("SELECT country_name FROM countries");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    //get cities for specified country to inflate selector
    public function getCities($countryName){
        $stmt = $this->databaseConnection->prepare("SELECT city_name FROM cities WHERE id_country =
                  (SELECT id_country FROM countries WHERE country_name = :countryName)");

        $stmt->bindParam(':countryName', $countryName);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    //insert new user into DB and update invite status
    public function insertNewUser($login, $pass, $phone, $city, $invite){

        $currentTime = time();
        $md5pass = md5($pass);
        $this->databaseConnection->beginTransaction();
        $stmt = $this->databaseConnection->prepare("INSERT INTO users (login, password, phone, id_city, invite)"
                                                . " VALUES (:login, :password, :phone, (SELECT id_city FROM cities WHERE city_name = :city), :invite)");
        $stmt->bindParam(":login", $login);
        $stmt->bindParam(":password", $md5pass);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":city", $city);
        $stmt->bindParam(":invite", $invite);
        $stmt->execute();


        /*$stmtInvite = $this->databaseConnection->prepare("UPDATE invites SET status = 1, date_status_ = $currentTime WHERE invite = :invite");
        $stmtInvite->bindParam(":invite", $invite);
        $stmtInvite->execute();*/


        $this->databaseConnection->commit();


    }


}