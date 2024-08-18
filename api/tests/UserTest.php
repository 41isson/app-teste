<?php
require "./User.php" ;

use Controller\UserController;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{


    public function teste_isArray(){
        
        $user = new User;
        $userController = new UserController();  
        $userData = [
            'nome' => 'John Doe',
            'casa_cep' => '12345',
            'email' => 'john@example.com',
            'senha' => 'password123'
        ];

        $cond = $user->isArray($userController->postUser($userData));
        
        $this->assertTrue($cond,'valor esperado true mas, esta retornando false');
    }
    public function test_IsNull()
    {
        $user = new User;
        $userController = new UserController();  
        $cond = $user->isNull($userController->getUser());
        
        $this->assertTrue($cond,'valor esperado true mas, esta retornando false');
    }


    
}