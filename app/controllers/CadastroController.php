<?php

class CadastroController extends \HXPHP\System\Controller{
	public function cadastrarAction(){

		$this->view->setFile('index');

		//filtro de validacao email
		$this->request->setCustomFilters(array(
			'email' => FILTER_VALIDATE_EMAIL
		));

		$post = $this->request->post();

		if(!empty($post)){
			$cadastrarUsuario = User::cadastrar($post);

			if ($cadastrarUsuario->status === false) {
				$this->load('Helpers\Alert', array(
					'danger',
					'Ops! Não foi possível efetuar seu cadastro.<br> Verifique os erros abaixo:',
					$cadastrarUsuario->errors
				));
			}
		}
	}
}