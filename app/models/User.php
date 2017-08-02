<?php

class User extends \HXPHP\System\Model
{
	static $validates_presnce_of = array(
		array(
			'name',
			'message' => 'O Nome é um campo obrigatório!'
		),
		array(
			'email',
			'message' => 'O Email é um campo obrigatório!'
		),
		array(
			'username',
			'message' => 'O Usuário é um campo obrigatório!'
		),
		array(
			'password',
			'message' => 'A Senha é um campo obrigatório!'
		)
	);
	static $validates_uniqueness_of = array(
		array(
			array('username', 'email'),
			'message' => 'Já existe um usuário com este email e/ou nome de usuário cadastrado'
		)
	);
	public static function cadastrar(array $post)
	{
		$userObj = new \stdClass; //é uma classe vazia
		$userObj->user = null;
		$userObj->status = false;
		$userObj->errors = array();

		$role = Role::find_by_role('user');

		if(is_null($role)){
			array_push($userObj->errors, 'A role user não existe . Contate o administrador');
			return $userObj;
		}

		$post = array_merge($post, array(
			'role_id' => $role->id,
			'status' => 1
		));
		//criptografando password
		$password = \HXPHP\System\Tools::hashHX($post['password']);

		$post = array_merge($post, $password);

		//criando um usuario
		$cadastrar = self::create($post);//recebendo usuário

		if ($cadastrar->is_valid()) {
			$userObj->user = $cadastrar;
			$userObj->status = true;
			return $userObj;
		}

		$errors = $cadastrar->errors->get_raw_errors();

		foreach ($errors as $field => $message){
			array_push($userObj->errors, $message[0]);
		}

		return $userObj;
	}
}