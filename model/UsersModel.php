<?php

class UsersModel
{
    private $connexion;

    private $id = '';

    private $name = '';

    private $token = '';

    function __construct()
    {
        $database = new Database();

        $this->connexion = $database->getConnexion();
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setName($name)
    {
        $this->name = $name;
    }

    function setToken($token)
    {
        $this->token = $token;
    }

    function getId()
    {
        return $this->id;
    }

    function getName()
    {
        return $this->name;
    }

    function getToken()
    {
        return $this->token;
    }

    function findByToken($token)
    {
        $result = false;

        try{
            $requete = 'SELECT * FROM users WHERE token = :token LIMIT 1;';
            $request = $this->connexion->prepare($requete);
            $request->execute(['token' => $token]); 
            $result = $request->fetch();
        }
        catch(PDOException $e){
            printf("Erreur de la requete  : %s\n", $e->getMessage());
            exit();
        }
       
        return $result;
    }
}