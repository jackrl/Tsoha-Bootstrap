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
				'id' => $row['id'],
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
				'id' => $row['id'],
				'username' => $row['username'],
				'password' => $row['password'],
				'admin' => $row['admin']
				));
		}
		
		return $user;
	}

	public static function all(){
		$query = DB::connection()->prepare('SELECT *
												FROM Users');
		$query->execute();

		$rows = $query->fetchAll();
		$users = array();

		foreach($rows as $row){
			$users[] = new User(array(
				'id' => $row['id'],
				'username' => $row['username'],
				'password' => $row['password'],
				'admin' => $row['admin']
				));
		}

		return $users;
	}

	public function save(){
		$query = DB::connection()->prepare('INSERT INTO Users (username, password, admin)
												VALUES (:username, :password, :admin)
												RETURNING id');
		$query->execute(array(
			'username' => $this->username,
			'password' => $this->password,
			'admin' => $this->admin
			));

		$row = $query->fetch();
		$this->id = $row['id'];
	}

	public function update(){
	    $query = DB::connection()->prepare('UPDATE Users SET (username, password, admin)
	    										= (:username, :password, :admin)
	    										WHERE id = :id');
	    $query->execute(array(
	    	'id' => $this->id,
	    	'username' => $this->username,
			'password' => $this->password,
			'admin' => $this->admin
	    ));
	}

	public function destroy(){
	    $query = DB::connection()->prepare('DELETE FROM Users
	    										WHERE id = :id');
	    $query->execute(array(
	    	'id' => $this->id
	    ));
	}
}
