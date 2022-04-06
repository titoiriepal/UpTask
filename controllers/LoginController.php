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

    public static function olvide(){
        echo "Desde Olvide mi Password";

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            echo "Cambiando Password...";
        }
    }

    public static function restablecer(){
        echo "Desde restablecer mi Password";

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            echo "Restableciendo Password...";
        }
    }

    public static function mensaje(){
        echo "Desde Mensaje";

    }

    public static function confirmar(){
        echo "Desde Confirmar";

    }
}