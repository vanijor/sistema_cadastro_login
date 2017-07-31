<?php

class User extends \HXPHP\System\Model
{
	public static function cadastrar(array $post)
	{
		$role = Role::find_by_role('user');
		$post = array_merge($post, array(
			'role_id' => $role->id,
			'status' => 1
		));
		//criptografando password
		$password = \HXPHP\System\Tools::hashHX($post['password']);

		$post = array_merge($post, $password);
		//criando um usuario
		return self::create($post);

	}
}