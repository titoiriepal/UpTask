<?php

namespace Controllers;

use Model\Proyecto;
use MVC\Router;

class DashboardController{

    public static function index(Router $router){
        session_start();

        isAuth();

        $proyectos= Proyecto::belongsTo('propietarioid', $_SESSION['id']);
        

        $router->render('dashboard/index', [
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos
        ]);
    }

    public static function crear_proyecto(Router $router){
        session_start();

        isAuth();
        $alertas=[];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $proyecto = new Proyecto($_POST);
            
            //Validación
            $alertas=$proyecto->validarProyecto();

            if(empty($alertas)){
                //Generar una URL única
                $hash = md5(uniqid());
                $proyecto->url = $hash;
            
                //Almacenar el creador del proyecto
                $proyecto->propietarioid = $_SESSION['id'];

                //Guardar el proyecto
                $proyecto->guardar();

                //Redireccionar

                header('Location: /proyecto?url=' . $proyecto->url);
            }


        }

        $router->render('dashboard/crear_proyecto', [
            'titulo' => 'Crear Proyecto',
            'alertas' => $alertas
        ]);
    }


    public static function proyecto(Router $router){
        session_start();

        isAuth();
        $alertas=[];

        $token = $_GET['url'];

        if(!$token) header('Location: /dashboard');

        $proyecto = Proyecto::where('url', $token);

        if($proyecto->propietarioid !== $_SESSION['id']){
            header('Location: /dashboard');
        }

        //Revisar que la persona que visita el proyecto es quién lo creo

        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto,
            'alertas' => $alertas
        ]);
    }

    public static function perfil(Router $router){
        session_start();

        isAuth();

        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil'
        ]);
    }

}