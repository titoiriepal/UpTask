<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
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

        $usuario = new Usuario;
        $alertas=[];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);

            $alertas=$usuario->validarNuevaCuenta();

            if(empty($alertas)){
                $existeUsuario = Usuario::where('email', $usuario->email);

                if($existeUsuario){
                    Usuario::setAlerta('error','El Mail ya está registrado');
                    $alertas = Usuario::getAlertas();
                }else{
                    //Hashear el password
                    $usuario->hashPassword();

                    //Generar el token
                    $usuario->crearToken();

                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    //Crear un nuevo usuario
                    $resultado=$usuario->guardar();
                    if($resultado){
                        header('Location: /mensaje');
                    }

                }
            
            }

            
        }

        $router->render('auth/crear', [
            'titulo' => 'Crea tu Cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }


    public static function olvide(Router $router){  
        
        $alertas = [];

        

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);
                

                if($usuario && $usuario->confirmado){
                    
                    //generar un token
                    $usuario->crearToken();
                    $usuario->guardar();
                    

                    //Enviar el email

                    $email = New Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    Usuario::setAlerta('exito', 'Hemos enviado las instrucciones a tu email');
                    

                }else{
                    Usuario::setAlerta('error','El Usuario no existe o no está confirmado');
                }
            }    

            $alertas = Usuario::getAlertas();
        }

            //Muestra la vista
        $router->render('auth/olvide', [
            'titulo' => 'Olvide mi Password',
            'alertas' => $alertas
        ]);
    }


    public static function restablecer(Router $router){
        $alertas = [];
        $mostrar = true;
        $token = s($_GET['token']);
        if(!$token) header('Location: /');
            


        $usuario = Usuario::where('token', $token);
            if(empty($usuario)){
                Usuario::setAlerta('error', 'Token no valido');
                $mostrar = false;
            }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarPassword();
            
            

            if(empty($alertas)){
                $usuario->hashPassword();
                $usuario->token = '';


                $resultado = $usuario->guardar();
                if ($resultado){
                    header('Location: /');
                }

            }
            
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/restablecer', [
            'titulo' => 'Reestablece tu Password',
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);
    }


    public static function mensaje(Router $router){    
        
       
        $router->render('auth/mensaje', [           
            'titulo' => 'Reestablece tu Password'
        ]);

    }


    public static function confirmar(Router $router){

        $alertas = [];
        $token = s($_GET['token']);
        if(!$token) header('Location: /');
        
        $usuario = Usuario::where('token', $token);



        if(empty($usuario)){
            //Mostrar mensaje de error
            Usuario::setAlerta('error','Token no valido');
        }else{
            //Modificar a usuario confirmado
            $usuario->confirmado = "1"; 
            $usuario->token = ''; 
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta activada correctamente');

        }
        
        //Obtener alertas
        $alertas = Usuario::getAlertas();

        //Renderizar la vista
        $router->render('auth/confirmar', [
            'titulo' => 'Confirma tu cuenta Uptask',
            'alertas' => $alertas
        ]);
    }

}