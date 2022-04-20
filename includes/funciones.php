<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Función que revisa que el usuario este autenticado
function isAuth() : void {
    if(!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

function validarPasswords($passwords, $nombres) : array {
    $alertas = [];
    $nombre = 0;
    foreach ($passwords as $password){
        if ($password === '') {
            $alertas['error'][] = $nombres[$nombre] . ' es obligatorio ';
        }

        if(strlen($password) <6){
            $alertas['error'][] =  $nombres[$nombre] . ' debe contener al menos 6 caracteres ';
        }
        $nombre += 1;
        
    }
    return $alertas;
}
