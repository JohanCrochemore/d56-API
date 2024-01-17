<?php

class CheapShark
{
    private $base = 'https://www.cheapshark.com/api/1.0/';

    function __construct()
    {

    }

    function findDealsById($id)
    {
        $endpoint = 'deals';
        $params = '';
              
        if(!empty(trim($id)))
        {

            $params = '?id='.urlencode($id);
        }

        $datas = file_get_contents($this->base . $endpoint . $params);    

        return json_decode($datas, true);
    }

    function findDealsAll()
    {
        $endpoint = 'deals';
        $params = '';

        $datas = file_get_contents($this->base . $endpoint . $params);    

        return json_decode($datas, true);
    }

    function findGamesById($id)
    {
        $endpoint = 'games';
        $params = '';

        if(!empty(trim($id)))
        {
            $params = '?id='.urlencode($id);
        }

        $datas = file_get_contents($this->base . $endpoint . $params);    

        return json_decode($datas, true);
    }

    function findGamesAll($title)
    {   
        $endpoint = 'games';
        $params = '';

        if(!empty(trim($title)))
        {
            $params = '?title='.$title;
        }

        $datas = file_get_contents($this->base . $endpoint . $params);    

        return json_decode($datas, true);
    }

}