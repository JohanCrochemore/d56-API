<?php

require_once 'autoload.php';

$pages = ['games','deals','stores'];


$user = new UsersController();

if($user->isAuthorized())
{
    if(isset($_GET['page']) && in_array($_GET['page'], $pages))
    {
        $page = ucfirst($_GET['page']);

        $controller = $page.'Controller';

        $ctrl = new $controller();

        $result = $ctrl->route();
    }
    else
    {
        header('HTTP/1.0 404 Not Found');
        $result = ['status' => '404', 'erreur' => 'Page not found'];    
    }
}
else{
    header('HTTP/1.0 403 Forbidden');
    $result = ['status' => '403', 'erreur' => 'unhautorized ressource'];
}



header("Content-type: application/json; charset=utf-8");
echo json_encode($result);
