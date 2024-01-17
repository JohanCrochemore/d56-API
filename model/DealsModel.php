<?php

class DealsModel
{

    private $connexion;

    private $id = '';

    private $name = '';

    private $salePrice = '';

    private $retailPrice = '';

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

    function setSalePrice($salePrice)
    {
        $this->salePrice = $salePrice;
    }

    function setRetailPrice($retailPrice)
    {
        $this->retailPrice = $retailPrice;
    }

    function getId()
    {
        return $this->id;
    }

    function getName()
    {
        return $this->name;
    }

    function getSalePrice()
    {
        return $this->salePrice;
    }

    function getRetailPrice()
    {
        return $this->retailPrice;
    }


    function findByID($id)
    {

        $result = false;

        try{
            $requete = 'SELECT * FROM deals WHERE id = :id LIMIT 1;';
            $request = $this->connexion->prepare($requete);
            $request->execute(['id' => $id]); 
            $result = $request->fetch();
        }
        catch(PDOException $e){
            printf("Erreur de la requete  : %s\n", $e->getMessage());
            exit();
        }
       
        return $result;
    }

    function findAll()
    {
        $result = false;

        try{
            $requete = 'SELECT * FROM deals ;';
        
            $request = $this->connexion->prepare($requete);
            $request->execute(); 
            $result = $request->fetchAll();
        }
        catch(PDOException $e){
            printf("Erreur de la requete  : %s\n", $e->getMessage());
            exit();
        }
        return $result;
    } 
    
    function insert()
    {
        $data = [];
        try{
            $requete = "INSERT INTO deals (id, name, salePrice, retailPrice) VALUES (:id, :name, :salePrice, :retailPrice)";
            $request= $this->connexion->prepare($requete);
            $request->execute($data);

            $data['id'] = $this->id;
            $data['name'] = $this->name;
            $data['salePrice'] = $this->salePrice;
            $data['retailPrice'] = $this->retailPrice;
        }
        catch(PDOException $e){
            printf("Erreur de la requete  : %s\n", $e->getMessage());
            exit();
        }
        return $data;
    }

    function formatOneDeals($data)
    {
        if(isset($data['gameInfo']['name']))
        { 
            $this->name = $data['gameInfo']['name'];
            $this->salePrice = $data['gameInfo']['salePrice'];
            $this->retailPrice = $data['gameInfo']['retailPrice'];    
        }        
    }

    function formatManyDeals($data)
    {
        $deals = [];
    
        foreach($data as $deal)
        {
            $newDeal['id']=urldecode($deal['dealID']);
            $newDeal['name']=$deal['title'];
            $newDeal['salePrice']=$deal['salePrice'];
            $newDeal['retailPrice']=$deal['normalPrice'];
            $deals[]=$newDeal;
        }    
        return $deals;
    }

}