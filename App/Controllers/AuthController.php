<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AuthController extends Action {

	public function autenticacao(){
        $usuario = Container::getModel('Usuario');
        $usuario->email = $_POST['email'];
        $usuario->senha = md5($_POST['senha']);
        
        if ($usuario->autenticacao()) {
            $usuario->autenticacao();
        }
        else {
            $usuario->autenticacaoEmpresa();
        }
        
        if($usuario->id != null){
            session_start();
            $_SESSION['id'] = $usuario->id;
            if (!isset($_SESSION['cpf']))  {
                $_SESSION['cpf'] = $usuario->cpf;
            }else {
              $_SESSION['cpf'] = false;  
            }
            $_SESSION['nome'] = $usuario->nome;
            $_SESSION['email'] = $usuario->email;
            $_SESSION['telefone'] = $usuario->telefone;
            
            header('Location: /dashboard');
        }
        else{
            header('Location: /login?login=erro');
        }
    }

    public function sair(){
        session_start();
        session_destroy();
        header('Location: /login');
    }

    
}


?>