<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap
{

	protected function initRoutes()
	{

		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);

		$routes['registrar'] = array(
			'route' => '/cadastro',
			'controller' => 'indexController',
			'action' => 'registrar'
		);

		$routes['login'] = array(
			'route' => '/login',
			'controller' => 'indexController',
			'action' => 'login'
		);
		$routes['empresa'] = array(
			'route' => '/empresa',
			'controller' => 'indexController',
			'action' => 'empresa'
		);
		$routes['registraEmpresa'] = array(
			'route' => '/registraEmpresa',
			'controller' => 'indexController',
			'action' => 'registraEmpresa'
		);
		$routes['registraEntregador'] = array(
			'route' => '/registraEntregador',
			'controller' => 'indexController',
			'action' => 'registraEntregador'
		);

		$routes['autenticacao'] = array(
			'route' => '/autenticacao',
			'controller' => 'AuthController',
			'action' => 'autenticacao'
		);

		$routes['sair'] = array(
			'route' => '/sair',
			'controller' => 'AuthController',
			'action' => 'sair'
		);
		$routes['dashboard'] = array(
			'route' => '/dashboard',
			'controller' => 'DashboardController',
			'action' => 'dashboard'
		);

		$routes['registra_produto'] = array(
			'route' => '/registra_produto',
			'controller' => 'DashboardController',
			'action' => 'registraProduto'
		);
		$routes['excluir_produto'] = array(
			'route' => '/excluir_produto',
			'controller' => 'DashboardController',
			'action' => 'excluirProduto'
		);
		$routes['edita_produto'] = array(
			'route' => '/edita_produto',
			'controller' => 'DashboardController',
			'action' => 'editaProduto'
		);
		$routes['entregar'] = array(
			'route' => '/entregar',
			'controller' => 'DashboardController',
			'action' => 'entregar'
		);
		$routes['concluido'] = array(
			'route' => '/concluido',
			'controller' => 'DashboardController',
			'action' => 'concluido'
		);
		$routes['remover_entrega'] = array(
			'route' => '/remover_entrega',
			'controller' => 'DashboardController',
			'action' => 'removerEntrega'
		);
		$this->setRoutes($routes);
	}
}
