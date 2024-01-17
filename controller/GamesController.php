<?php

class GamesController
{
    private $games; 

    function __construct()
    {
        $this->games = new GamesModel();
    }

    function route()
    {
        if(isset($_GET['name']) && $_GET['name'] != '')
        {
            return $this->all($_GET['name']);
        }
        elseif(isset($_GET['id']) && $_GET['id'] != '')
        {
           return $this->findById($_GET['id']);
        }
        else
        {
           return ['status' => '404', 'message'=>"Bad endpoint"];
        }
    }

    function all($title)
    {
        $datas = $this->games->findAll($title);

        if(count($datas) == 0)
        {
            $api = new CheapShark();
        
            $dataApi = $api->findGamesAll($title);

            if($dataApi)
            {
                $this->games->setSearch($title);
                $dataApi = $this->games->formatManyGames($dataApi);

                foreach($dataApi as $game)
                {
                    if(!$this->games->findByID($game['id']))
                    {
                        $newGame = new GamesModel();
                        $newGame->setId($game['id']);
                        $newGame->setTitle($game['title']);
                        $newGame->setSearch($game['search']);

                        $datas [] = $newGame->insert();
                    }

                }
            }
            else
            {
                $datas = ["status"=>"404", "message"=>"Probleme requête API"];
            }
        }

        return $datas;
    }

    function findById($id)
    {
        $datas = $this->games->findByID($id);

        if(!$datas)
        {
            $api = new CheapShark();
        
            $dataApi = $api->findGamesById($id);
            
           if($dataApi)
           {
                $this->games->setId($id);

                $this->games->formatOneGames($dataApi);  
                
                $datas = $this->games->insert();
           }
           else
           {
                $datas = ["status"=>"404", "message"=>"id non trouvé"];
           }
        }

        return $datas; 
    }

}