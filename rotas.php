<?php

use Pecee\SimpleRouter\SimpleRouter;
use sistema\Nucleo\Helpers;

try{
    SimpleRouter::setDefaultNamespace('sistema\Controlador');

    SimpleRouter::get(URL_SIE,'SiteControlador@index');
    SimpleRouter::get(URL_SIE.'sobre', 'SiteControlador@sobre');
    SimpleRouter::get(URL_SIE.'404', 'SiteControlador@erro404');

    SimpleRouter::start();

} catch (Pecee\SimpleRouter\Exceptions\NotFoundHttpException $ex){
    if (Helpers::localHost()) {
        echo $ex;
    }else {
        Helpers::redirecionar('404');
    }
}