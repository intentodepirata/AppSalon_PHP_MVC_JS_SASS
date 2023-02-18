<?php 
namespace Controllers;

use MVC\Router;

class CitaController {
    public static function index(Router $router){

        session_start();

        //Proteger la vista si no esta autenticado
        isAuth();

        //debuguear($_SESSION);
        $router->render('cita/index',[
            'nombre'=> $_SESSION['nombre'],
            'id' => $_SESSION['id']
        ]);
    }
}