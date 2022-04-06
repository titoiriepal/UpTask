<?php

namespace Controllers;

use MVC\Router;

class LoginController{

    public static function login(Router $router){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            echo "Enviando datos...";
        }

        // Renderizar la vista

        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión'
        ]);
    }


    public static function logout(){
        echo "Desde Logout";

    }

    public static function crear(Router $router){
        

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            echo "Creando Cuenta...";
        }

        $router->render('auth/crear', [
            'titulo' => 'Crea tu Cuenta'
        ]);
    }

    public static function olvide(Router $router){
        

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            echo "Cambiando Password...";
        }

            //Muestra la vista
        $router->render('auth/olvide', [
            'titulo' => 'Olvide mi Password'
        ]);
    }

    public static function restablecer(Router $router){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            echo "Reestableciendo Password...";
        }

        $router->render('auth/restablecer', [
            'titulo' => 'Reestablece tu Password'
        ]);
    }

    public static function mensaje(Router $router){
        

        $router->render('auth/mensaje', [
            'titulo' => 'Reestablece tu Password'
        ]);

    }

    public static function confirmar(Router $router){


        $router->render('auth/confirmar', [
            'titulo' => 'Confirma tu cuenta Uptask'
        ]);
    }

}