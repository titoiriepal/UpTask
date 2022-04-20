<?php

namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
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

        $alertas = [];
        $usuario = Usuario::find($_SESSION['id']);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $_POST['email'] = strtolower($_POST['email']);
            //debuguear($_POST);

            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarPerfil();

            if (empty($alertas)){
                $existeUsuario = Usuario::where('email', $_POST['email']);
                //debuguear($existeUsuario);
                if(!$existeUsuario || $existeUsuario->id === $usuario->id){
                    $usuario->guardar();

                    //Actualizar SESSION
                    $_SESSION['nombre'] = $usuario->nombre;
                    $_SESSION['email'] = $usuario->email;

                    Usuario::setAlerta('exito','Usuario actualizado correctamente');

                }else{
                    Usuario::setAlerta('error','Ya existe un usuario con ese mail');
                }

                $alertas = Usuario::getAlertas();
            }

            

        }

       

        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function cambiar_password(Router $router){
        session_start();

        isAuth();

        $alertas = [];
        

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $passwords = [$_POST['password_actual'], $_POST['password']];
            $nombres = [' EL Password actual', 'La Nueva Contraseña'];
            $usuario = Usuario::find($_SESSION['id']);
            $alertas = validarPasswords($passwords, $nombres);
            if (empty($alertas)){
                if(password_verify($_POST['password_actual'], $usuario->password)){
                    $usuario->password = $_POST['password'];
                    $usuario->hashPassword();
                    if($usuario->guardar()){
                        Usuario::setAlerta('exito','La contraseña se cambió correctamente');
                    }
                    
                }else{
                    Usuario::setAlerta('error','La contraseña actual no es correcta');
                }

                $alertas = Usuario::getAlertas();
            }
            

        }

        

        $router->render('dashboard/cambiar-password', [
            'titulo' => 'Cambiar contraseña',
            'alertas' => $alertas
        ]);

    }

}