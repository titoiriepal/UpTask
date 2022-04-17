<?php

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;

class TareaController{

    public static function index(){

        session_start();
        $proyectoUrl = $_GET['url'];
        if(!$proyectoUrl){
            header('Location: /dashboard');
        }

        $proyecto = Proyecto::where('url',$proyectoUrl);
        if(!$proyecto || $proyecto->propietarioid !== $_SESSION['id']) header('Location: /404');

        $tareas = Tarea::belongsTo('proyectoid', $proyecto->id );

        echo json_encode(['tareas' => $tareas]);
        
    }


    public static function crear(){

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();
            $proyectoUrl = $_POST['url'];

            $proyecto = Proyecto::where('url',$proyectoUrl);
            if(!$proyecto || $proyecto->propietarioid !== $_SESSION['id']){
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al agregar la tarea'
                ];

                echo json_encode($respuesta);
                return;
                
            }

            //Todo bien, instanciar y crear la tarea

            $tarea = new Tarea($_POST);
            $tarea->proyectoid = $proyecto->id;
            $resultado = $tarea->guardar();
            $respuesta = [
                'tipo' => 'exito',
                'id' => $resultado['id'],
                'mensaje' => 'La tarea se agrego con éxito',
                'proyectoid' => $proyecto->id
            ];

            echo json_encode($respuesta);

            

        }

    }

    public static function actualizar(){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
        }

    }


    public static function eliminar(){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
        }

    }

}
