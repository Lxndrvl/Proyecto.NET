<?php
session_start();

require_once '../models/Usuario.php';

if (isset($_GET['op'])){

    //Instancia de la clase usuario
    $usuario = new Usuario();

    //Iniciar Sesión
    if ($_GET['op'] == 'login'){

        //Array asociativo
        $datos = ["username" => $_GET['username']];
        $resultado = $usuario->login($datos);
        //Acceso al sistema
        if ($resultado){
            //Acceso correcto
            $registro = $resultado[0];
            $claveValidar = $_GET['contraseña'];

            //Validar contraseña
            if (password_verify($claveValidar, $registro['contraseña'])){
                //Contraseña correcta
                $_SESSION['acceso'] = true;
                $_SESSION['id_usuario'] = $registro['id_usuario'];
                $_SESSION['nombre_completo'] = $registro['nombre_completo'];
                $_SESSION['nombre_usuario'] = $registro['nombre_usuario'];
                $_SESSION['contraseña'] = $registro['contraseña'];
            } else {
                //Contraseña incorrecta
                $_SESSION['acceso'] = false;
                $_SESSION['id_usuario'] = '';
                $_SESSION['nombre_completo'] = '';
                $_SESSION['nombre_usuario'] = '';
                $_SESSION['contraseña'] = '';

                echo "Password invalid";
            }
            
        } else {
            //Acceso fallido
            $_SESSION['acceso'] = false;
            $_SESSION['id_usuario'] = '';
            $_SESSION['nombre_completo'] = '';
            $_SESSION['nombre_usuario'] = '';
            $_SESSION['contraseña'] = '';

            echo "User not exist";
        }
    }

    //Cerrar Sesión
    if ($_GET['op'] == 'logout'){
        session_destroy();
        session_unset();
        header('Location:../');
    }

    //Cambiar Contraseña
    if ($_GET['op'] == 'changepassword'){
        //Verificar que las contraseñas coincidan
        $oldpassword = $_GET['clave1'];
        $newpassword = $_GET['clave2'];

        //Desencriptando variables
        if (password_verify($oldpassword, $_SESSION['contraseña'])){
            //Las variables coinciden
            $datosenviar = [
                "id_usuario" => $_SESSION['id_usuario'], 
                "password" => password_hash($newpassword, PASSWORD_BCRYPT)
            ];
            $usuario->changepassword($datosenviar);
            echo "";
        } else {
            //Las variables no coinciden
            echo "Las contraseña ingresada no es correcta";
        }
    }

}

?>