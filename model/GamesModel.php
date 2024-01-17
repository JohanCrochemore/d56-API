<?php

class GamesModel
{
    private $connexion;

    private $id = '';

    private $title = '';

    private $search = '';

    function __construct()
    {
        $database = new Database();

        $this->connexion = $database->getConnexion();
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setTitle($title)
    {
        $this->title = $title;
    }

    function setSearch($search)
    {
        $this->search = $search;
    }

    function getId()
    {
        return $this->id;
    }

    function getTitle()
    {
        return $this->title;
    }

    function getSearch()
    {
        return $this->search;
    }

    function findByID($id)
    {
        $result = false;

        try{
            $requete = 'SELECT * FROM game WHERE id = :id LIMIT 1;';
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

    function findAll($search)
    {
        $result = false;

        try{
            $requete = 'SELECT * FROM game WHERE search = :search;';
        
            $request = $this->connexion->prepare($requete);
            $request->execute(['search'=>$search]); 
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
            $requete = "INSERT INTO game (id, title, search) VALUES (:id, :title, :search)";
            $request= $this->connexion->prepare($requete);
            $request->execute($data);

            $data['id'] = $this->id;
            $data['title'] = $this->title;
            $data['search'] = $this->search;
        }
        catch(PDOException $e){
            printf("Erreur de la requete  : %s\n", $e->getMessage());
            exit();
        }
        return $data;
    }

    function formatOneGames($data)
    {
        if(isset($data['info']['title']))
        {    
            $this->title = $data['info']['title'];           
        }    
    }

    function formatManyGames($datas)
    {
        $games = [];
        
        foreach($datas as $game)
        {
            $newGame['id'] = $game['gameID'];
            $newGame['title'] = $game['external'];
            $newGame['search'] = $this->search;
            $games[] = $newGame;
        }
        
        return $games;
    }
}