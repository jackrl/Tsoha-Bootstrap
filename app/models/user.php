<?php

class User extends BaseModel{

	public $id, $username, $password, $admin;

	public function __construct($attributes){
		parent::__construct($attributes);
	}

	public function authenticate($username, $password) {
		$query = DB::connection()->prepare('SELECT *
												FROM Users
												WHERE username = :username
													AND password = :password
												LIMIT 1');
		$query->execute(array(
							'username' => $username,
							'password' => $password));
		$row = $query->fetch();

		$user = null;
		if($row){
			$user = new User(array(
				'username' => $row['username'],
				'password' => $row['password'],
				'admin' => $row['admin']
				));
		}
		
		return $user;
	}

	public static function find($id){
		$query = DB::connection()->prepare('SELECT *
												FROM Users
												WHERE id = :id
												LIMIT 1');
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		$user = null;
		if($row){
			$user = new User(array(
				'username' => $row->username,
				'password' => $row->password,
				'admin' => $row->admin
				));
		}
		
		return $user;
	}
}
