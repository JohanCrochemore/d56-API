<?php

class DealsController
{
    private $deals; 

    function __construct()
    {
        $this->deals = new DealsModel();
    }

    function route()
    {
        if(isset($_GET['id']) && $_GET['id'] != '')
        {
           return $this->findById($_GET['id']);
        }
        else
        {
           return $this->all();
        }
    }

    function all()
    {
        $datas = $this->deals->findAll();

        if(count($datas) == 0)
        {
            $api = new CheapShark();
        
            $dataApi = $api->findDealsAll();

            if($dataApi)
            {
                $dataApi = $this->deals->formatManyDeals($dataApi);

                foreach($dataApi as $deal)
                {
                    if(!$this->deals->findByID($deal['id']))
                    {
                        $newDeal = new DealsModel();
                        $newDeal->setId($deal['id']);
                        $newDeal->setName($deal['name']);
                        $newDeal->setSalePrice($deal['salePrice']);
                        $newDeal->setRetailPrice($deal['retailPrice']);

                        $datas [] = $newDeal->insert();
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
       
        $id = str_replace(' ','+',$id);        
        $datas = $this->deals->findByID($id);

        if(!$datas)
        {
            $api = new CheapShark();
        
            $dataApi = $api->findDealsById($id);
            
           if($dataApi)
           {
                $this->deals->setId($id);

                $this->deals->formatOneDeals($dataApi);  
                
                $datas = $this->deals->insert();
           }
           else
           {
                $datas = ["status"=>"404", "message"=>"id non trouvé"];
           }
        }

        return $datas; 
    }

}