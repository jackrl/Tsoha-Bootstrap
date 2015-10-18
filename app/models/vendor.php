<?php

class Vendor extends BaseModel{

	public $id, $name;

	public function __construct($attributes){
		parent::__construct($attributes);

		$this->validators = array('validate_name');
	}

	public function save(){
		$query = DB::connection()->prepare('INSERT INTO Vendor (name)
												VALUES (:name)
												RETURNING id');
		$query->execute(array(
			'name' => $this->name
			));

		$row = $query->fetch();
		$this->id = $row['id'];
	}

	public function update(){
		$query = DB::connection()->prepare('UPDATE Vendor SET (name)
												= (:name)
												WHERE id = :id');
		$query->execute(array(
			'id' => $this->id,
			'name' => $this->name
			));
	}

	public function destroy(){
		$query = DB::connection()->prepare('DELETE FROM Vendor
												WHERE id = :id');
		$query->execute(array(
			'id' => $this->id
			));
	}

	public static function find($id){
		$query = DB::connection()->prepare('SELECT *
												FROM Vendor
												WHERE id = :id
												LIMIT 1');
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if($row){
			$vendor = new Vendor(array(
				'id' => $row['id'],
				'name' => $row['name']
				));

			return $vendor;
		}

		return null;
	}

	public static function all(){
		$query = DB::connection()->prepare('SELECT *
												FROM Vendor
												ORDER BY name');
		$query->execute();
		$rows = $query->fetchAll();
		$vendors = array();

		foreach($rows as $row){
			$vendors[] = new Vendor(array(
				'id' => $row['id'],
				'name' => $row['name']
				));
		}

		return $vendors;
	}

	public function validate_name() {
		$errors = array();

		if($this->name == '' || $this->name == null){
			$errors[] = 'The name cannot be left empty!';
		}
		if(strlen($this->name) < 3){
			$errors[] = 'The name must be at least 3 characters long!';
		}

		return $errors;
	}
}
