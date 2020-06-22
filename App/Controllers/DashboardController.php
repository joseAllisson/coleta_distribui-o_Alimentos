<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class DashboardController extends Action
{

    public function validaAutenticacao(){
        session_start();
        if (!isset($_SESSION['id']) || $_SESSION['id'] == null) {
            header('Location: /?login=erro');
        }
    }

    public function dashboard(){
        $this->validaAutenticacao();

        if ($_SESSION['cpf'] == false) {
            $produto = Container::getModel('Produto');
            $produto->id = $_SESSION['id'];
            $this->view->empresa = $produto->pegaProdutosEmpresa();

            $this->render('dashboard_empresa', "dash_empresa");
        } else {

            $produto = Container::getModel('Produto');

            $this->view->entregas = $produto->pegaTodosProdutos();
            $produto->id = $_SESSION['id'];
            $this->view->area = $produto->area_entregador();
            
            $this->render('dashboard_entregador', "dash_entregador");
        }
    }

    public function registraProduto(){
        if (isset($_FILES['img']) && $_FILES['img'] != '') {
            $extensao = strtolower(substr($_FILES['img']['name'], -4));
            $novo_nome = md5(time()) . $extensao;
            move_uploaded_file($_FILES['img']['tmp_name'], "img/produtos/$novo_nome");
        }

        $usuario = Container::getModel('Produto');
        $usuario->id = $_POST['id'];
        $usuario->nome = $_POST['nome'];
        $data = $_POST['validade'];
        date('Y-m-d', strtotime($data));
        $usuario->data_validade = $data;
        $usuario->local_coleta = $_POST['local'];
        $usuario->img = $novo_nome;



        if ($usuario->registraProduto()) {
            echo "<script>alert('Produto cadastrado com sucesso!')</script>";
            echo "<script> location.href = '/dashboard' </script>";
        } else {
            echo "<script>alert('Ops! Ocorreu um erro!')</script>";
            echo "<script> location.href = '/dashboard' </script>";
        }
    }

    public function excluirProduto(){

        $this->validaAutenticacao();

        if (isset($_GET['id'])) {
            $produto = Container::getModel('Produto');
            $produto->id = $_GET['id'];
            $produto->excluirProduto();

            echo "<script>alert('produto excluido com sucesso!')</script>";
        } else {
            echo "<script>alert('Selecione um produto para continuar!')</script>";
        }
        echo "<script> location.href = '/dashboard' </script>";
    }

    public function editaProduto(){

        $this->validaAutenticacao();

        if (isset($_POST['id'])) {
            $produto = Container::getModel('Produto');

            if ($_FILES['img'] != '') {
                $extensao = strtolower(substr($_FILES['img']['name'], -4));
                $novo_nome = md5(time()) . $extensao;
                move_uploaded_file($_FILES['img']['tmp_name'], "img/produtos/$novo_nome");
            }

            $produto->id = $_POST['id'];
            $produto->nome = $_POST['nome'];
            $data = $_POST['validade'];
            date('Y-m-d', strtotime($data));
            $produto->data_validade = $data;
            $produto->local_coleta = $_POST['local'];
            $produto->img = $novo_nome;
            
            if($produto->editaProduto()){
                echo "<script>alert('produto editado com sucesso!')</script>";
            }else{
                echo "<script>alert('produto não atualizou!')</script>";
            }
            
        } else {
            echo "<script>alert('Ops, ocorreu um erro!')</script>";
        }
        echo "<script> location.href = '/dashboard' </script>";
    }

    public function entregar(){
        $this->validaAutenticacao();
        
        $produto = Container::getModel('Produto');

        $produto->id = $_SESSION['id'];
        $produto->fk = $_GET['id'];
        if ($produto->verificarEntrega()) {
            if ($produto->entregar()) {
                echo "<script>alert('Adicionado na demanda com sucesso!!')</script>";
                echo "<script> location.href = '/dashboard' </script>";
            }else{
                echo "<script>alert('Ops!Erro ao adicionar!')</script>";
                echo "<script> location.href = '/dashboard' </script>";
            }
        }else {
            echo "<script>alert('Item já foi adicionado!')</script>";
        }
        
        

        echo "<script> location.href = '/dashboard' </script>";
    }

    public function concluido(){
        $this->validaAutenticacao();

        $produto = Container::getModel('Produto');
        $produto->id = $_GET['id'];

        $produto->concluido();
        echo "<script>alert('Entrega realizada com sucesso!')</script>";
        echo "<script> location.href = '/dashboard' </script>";

    }

    public function removerEntrega(){
        $this->validaAutenticacao();

        if (isset($_GET['id'])) {
            $produto = Container::getModel('Produto');
            $produto->id = $_SESSION['id'];
            $produto->fk = $_GET['id'];
            $produto->removerEntrega();

            echo "<script>alert('Produto retirado da demanda com sucesso!')</script>";
        } else {
            echo "<script>alert('Selecione um produto para continuar!')</script>";
        }
        echo "<script> location.href = '/dashboard' </script>";
    }


}
