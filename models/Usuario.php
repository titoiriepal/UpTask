<?php

namespace Model;

class Usuario extends ActiveRecord{
    protected static $tabla = "usuarios";
    protected static $columnasDB = ['id', 'nombre','email','password', 'token', 'confirmado'];

    public $id;
    public $nombre;
    public $email;
    public $password;
    public $token;
    public $confirmado;

    public function __construct($args=[])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    //Validación para cuentas nuevas
    public function validarNuevaCuenta(){

        if(!$this->nombre){
            self::$alertas['error'][] = 'El nombre del Usuario es obligatorio';
        }
        if(!$this->email){
            self::$alertas['error'][] = 'El Email del Usuario es obligatorio';
        }

        if (!$this->password){
            self::$alertas['error'][] = 'El Password es obligatorio';
        }

        if (strlen($this->password) < 6){
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
        }elseif ($this->password !== $_POST['password2']){
            self::$alertas['error'][] = 'Los Passwords no coinciden';
        }

        return self::$alertas;


    }


    //Hashear Password
    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    //Generar un token
    public function crearToken(){
        $this->token = uniqid();
        //$this->token = md5(uniqid());
    }
}