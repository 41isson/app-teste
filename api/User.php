<?php
class User{
    public function isNull(string $users){
        $array = json_decode($users, true);
        $result = empty($array);  
        if($result){
            return true;
        } else {
            return false;
        }
    }

    public function isArray(array $userCreate){
       $result =  gettype($userCreate);
       
       if($result == 'array'){
        return true;
       }
       else{
        return false;
       }
    }

    

}