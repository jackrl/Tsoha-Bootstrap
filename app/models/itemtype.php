<?php

class ItemType extends BaseModel{

	public $id, $name, $pnprefix, $nextpn;

	public function __construct($attributes){
		parent::__construct($attributes);

		$this->validators = array('validate_name', 'validate_pnprefix');
	}

	public function save(){
		$query = DB::connection()->prepare('INSERT INTO ItemType (name, pnprefix, nextpn)
												VALUES (:name, :pnprefix, :nextpn)
												RETURNING id');
		$query->execute(array(
			'name' => $this->name,
			'pnprefix' => $this->pnprefix,
			'nextpn' => 0
			));

		$row = $query->fetch();
		$this->id = $row['id'];
	}

	public function update(){
		$query = DB::connection()->prepare('UPDATE ItemType SET (name, pnprefix, nextpn)
												= (:name, :pnprefix, :nextpn)
												WHERE id = :id');
		$query->execute(array(
			'id' => $this->id,
			'name' => $this->name,
			'pnprefix' => $this->pnprefix,
			'nextpn' => $this->nextpn
			));
	}

	public function destroy(){
		$query = DB::connection()->prepare('DELETE FROM ItemType
												WHERE id = :id');
		$query->execute(array(
			'id' => $this->id
			));
	}

	public static function find($id){
		$query = DB::connection()->prepare('SELECT *
												FROM ItemType
												WHERE ItemType.id = :id
												LIMIT 1');
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if($row){
			$itemtype = new ItemType(array(
				'id' => $row['id'],
				'name' => $row['name'],
				'pnprefix' => $row['pnprefix'],
				'nextpn' => $row['nextpn']
				));

			return $itemtype;
		}

		return null;
	}

	public static function all(){
		$query = DB::connection()->prepare('SELECT *
			FROM ItemType
			ORDER BY name');
		$query->execute();
		$rows = $query->fetchAll();
		$itemtypes = array();

		foreach($rows as $row){
			$itemtypes[] = new ItemType(array(
				'id' => $row['id'],
				'name' => $row['name'],
				'pnprefix' => $row['pnprefix'],
				'nextpn' => $row['nextpn']
				));
		}

		return $itemtypes;
	}

	public function getNextPN(){
		$number = strval($this->nextpn);

		while (strlen($number) < 6) { 
			$number = '0' . $number;
		}

		$this->nextpn++;

		$this->update();
		
		return $this->pnprefix . '-' . $number;
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

	public function validate_pnprefix() {
		$errors = array();

		$query = DB::connection()->prepare('SELECT COUNT(*)
												FROM ItemType
												WHERE pnprefix = :pnprefix');
		$query->execute(array('pnprefix' => $this->pnprefix));
		$row = $query->fetch();

		if($this->pnprefix == '' || $this->pnprefix == null){
			$errors[] = 'The part number prefix cannot be left empty!';
		}
		else if(strlen($this->pnprefix) < 2){
			$errors[] = 'The part number prefix must be at least 2 characters long!';
		} else if($row['count'] != 0) {
			$errors[] = 'The part number prefix chosen is already being used!';
		}

		return $errors;
	}
}
