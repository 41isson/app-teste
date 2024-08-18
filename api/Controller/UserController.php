<?php
namespace Controller;
use Slim\Psr7\Request;
use DAO\UserDAO;

class UserController {

    public function getUser(){
         $userDAO = new UserDAO();
         $result = json_encode($userDAO->GetUserDAO());
         return $result;
    }


    public function postUser(array $userData) {
        $userDAO = new UserDAO();
        $result = $userDAO->PostUserDAO($userData);
        var_dump($result);
        return $result;
    }
}
