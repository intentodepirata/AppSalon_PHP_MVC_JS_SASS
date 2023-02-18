<?php

namespace Controllers;

use MVC\Router;
use Classes\Email;
use Model\Usuario;

class LoginController {

    public static function login(Router $router){
        $alertas = [];
        $auth = new Usuario;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();
            if(empty($alertas)){
                //Comprobar que exista el ususario
                $usuario = Usuario::where('email', $auth->email);

                if($usuario){
                    //Verificar el pasword
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){
                        //autenticar usuaruio
                        session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . ' '. $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //redireccionamiento
                        if ($usuario->admin === "1"){
                            $_SESSION['admin'] = $usuario->admin ?? null;

                            header('Location: /admin');
                        }else {
                            header('Location: /cita');
                        }
                    }
                    
                } else {
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/login',[
            'alertas' => $alertas,
            'auth' => $auth
        ]);
    }

    public static function crear(Router $router){
        $usuario = new Usuario;
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            
            if(empty($alertas)){
               $resultado =  $usuario->existeUsuario();
               if($resultado->num_rows){
                $alertas = Usuario::getAlertas();
               } else{

                $usuario->hashPasword();

                $usuario->crearToken();

                $email = new Email($usuario->email, $usuario->nombre, $usuario->token);

                $email->enviarConfirmacion();

                $resultado = $usuario->guardar();
                if($resultado){
                    header('Location: /mensaje');
                }
               // debuguear($email);
               }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function logout(Router $router){
        session_start();
        $_SESSION = [];
        
        header('Location: /');
    }

    public static function olvide(Router $router){
        $alertas = [];
      

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

           if(empty($alertas)){
            $usuario = Usuario::where('email', $auth->email);
            
            if($usuario && $usuario->confirmado === "1"){
                //generar un token
                $usuario->crearToken();
                $usuario->guardar();

                //To-Do: Enviar el email
                $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                $email->enviarInstrucciones();

                //Alerta de exito
                Usuario::setAlerta('exito', 'Instrucciones enviadas a tu Correo Electronico');
          
            } else {
                Usuario::setAlerta('error', 'El Usuario no existe o no confirmado');
            }
            
        }
    }
        $alertas = Usuario::getAlertas();   

        $router->render('auth/olvide', [
            'alertas'=>$alertas
        ]);
    }

    public static function recuperar(Router $router){
        $alertas = [];
        $error = false;
        $token = s($_GET['token']);
        
        //Buscar usuario por su token
        $usuario = Usuario::where('token', $token);

        //Crear alertas
        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token no valido');
            $error = true;
        }

        //Reescribir el password
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            //Leer el nuevo password y guardarlo
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();
            
            //Guardar Password y hashearlo
            if(empty($alertas)){
                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPasword();
                $usuario->token = null;

                $resultado = $usuario->guardar();
                if($resultado){
                    header('Location: /');
                }
            }
        
        }

        $alertas = Usuario::getAlertas();
     
        //Renderizar vista
        $router->render('/auth/recuperar',[
            'alertas'=> $alertas,
            'error' => $error
        ]);
    }

    public static function mensaje(Router $router){
        $router->render('/auth/mensaje');
    }
    public static function confirmar(Router $router){
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)){
            //Mostrar mensaje de error
            Usuario::setAlerta('error', 'Token no valido');
        } else {
            //Modificar usuario confirmado
            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta comprobada correctamente');
        }
        //obtener alertas
        $alertas = Usuario::getAlertas();

        //renderizar la vista
        $router->render('/auth/confirmar-cuenta',[
            'alertas'=> $alertas
        ]);
    }
}