<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function index() {

		$this->render('index');
	}

	public function sobre() {

		$this->render('sobre');
	}

	public function contato() {

		$this->render('contato');
	}

	public function login() {
		$this->render('login', 'login');
	}

	public function registrar() {
		$this->view->erroCadastro = false;
		$this->view->usuarioExistente = false;
		$this->view->usuario = [
			'nome' => '',
			'email' => '',
			'cpf' => '',
			'telefone' => '',
			'senha' => '',
			'confirmar_senha' => ''
		];

		$this->render('registrar', 'login');
	}
	
	public function empresa() {
		$this->view->erroCadastro = false;
		$this->view->usuarioExistente = false;
		$this->view->usuario = [
			'nome' => '',
			'email' => '',
			'telefone' => '',
			'senha' => '',
			'confirmar_senha' => ''
		];

		$this->render('empresa', 'login');
	}

	public function registraEmpresa() {
		$usuario = Container::getModel('Usuario');
		$usuario->nome = $_POST['nome'];
		$usuario->telefone = $_POST['telefone'];
		$usuario->email = $_POST['email'];
		$usuario->senha = md5($_POST['senha']);

		if($usuario->validaRegistroEmpresa() && $usuario->dadosEmailEntregador() && $usuario->verificadorEmpresa() && $_POST['senha'] == $_POST['confirmar_senha']){
		 	$usuario->registraEmpresa();
			
			 echo "<script>alert('Cadastrado com sucesso! faça login')</script>";
			 echo "<script> location.href = '/login' </script>";
		}
		else{
			$this->view->usuario = [
				'nome' => $_POST['nome'],
				'email' => $_POST['email'],
				'telefone' => $_POST['telefone'],
				'senha' => $_POST['senha'],
				'confirmar_senha' => $_POST['confirmar_senha']
			];

			if(!$usuario->validaRegistroEmpresa()){
				//Existem dados que não foram preenchidos
				$this->view->erroCadastroDados = 1;
			}
			else if($_POST['senha'] != $_POST['confirmar_senha']){
				//As senhas não correspondem
				$this->view->erroCadastroDados = 2;
			}else{
				//O e-mail ja foi cadastrado
				$this->view->erroCadastroDados = 4;
			}

			
			$this->render('empresa', 'login');
		}
	}

	public function registraEntregador() {
		$usuario = Container::getModel('Usuario');
		$usuario->nome = $_POST['nome'];
		$usuario->cpf = $_POST['cpf'];
		$usuario->telefone = $_POST['telefone'];
		$usuario->email = $_POST['email'];
		$usuario->senha = md5($_POST['senha']);

		if($usuario->validaRegistro() && $usuario->verificadorEmpresa() && $usuario->pegaDadosCpf() && $usuario->dadosEmailEntregador() && $_POST['senha'] == $_POST['confirmar_senha']){
		 	$usuario->registraEntregador();
			
			 echo "<script>alert('Cadastrado com sucesso! faça login')</script>";
			 echo "<script> location.href = '/login' </script>";
		}
		else{
			$this->view->usuario = [
				'nome' => $_POST['nome'],
				'email' => $_POST['email'],
				'cpf' => $_POST['cpf'],
				'telefone' => $_POST['telefone'],
				'senha' => $_POST['senha'],
				'confirmar_senha' => $_POST['confirmar_senha']
			];

			if(!$usuario->validaRegistro()){
				//Existem dados que não foram preenchidos
				$this->view->erroCadastroDados = 1;
			}
			else if($_POST['senha'] != $_POST['confirmar_senha']){
				//As senhas não correspondem
				$this->view->erroCadastroDados = 2;
			}else if(!$usuario->pegaDadosCpf()){
				//Um usuário ja possui este CPF
				$this->view->erroCadastroDados = 3;
			}
			else{
				//O e-mail ja foi cadastrado
				$this->view->erroCadastroDados = 4;
			}

			
			$this->render('registrar', 'login');
		}
	}
}
