<?php

class Database
{

    public $user = 'root';

    public $pass = '';
    
    public $server = 'localhost';

    public $base = 'api';

    function __construct()
    {

    }

    function getConnexion()
    {
        $dsn="mysql:dbname=".$this->base.";host=".$this->server;
        try{
          $connexion=new PDO($dsn,$this->user,$this->pass);
          $connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
          printf("Échec de la connexion : %s\n", $e->getMessage());
          exit();
        }
    
        return $connexion;
    }
}