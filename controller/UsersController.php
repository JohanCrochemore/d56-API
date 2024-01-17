<?php

class UsersController
{
    private $users; 

    function __construct()
    {
        $this->users = new UsersModel();
    }

    function isAuthorized()
    {
        $result = false;
        
        $token = '';

        $headers = getallheaders();        

        if(isset($headers['Authorization']) && !empty($headers['Authorization']))
        {
            $token = trim(str_replace('Bearer', '', $headers['Authorization']));
        }
     
        if(strlen($token) == 64 && ctype_alnum($token))
            $result = $this->users->findByToken($token);
    
        return $result;
    }
}
