<?php

class Item extends BaseModel{

	public $id, $itemtype_id, $partnumber, $description;

	public function __construct($attributes){
		parent::__construct($attributes);

		$this->validators = array('validate_itemtype_id', 'validate_description');
	}

	public function setPN($PN) {
		$this->partnumber = $PN;
	}

	public function save(){
		$query = DB::connection()->prepare('INSERT INTO Item (itemtype_id, partnumber, description)
												VALUES (:itemtype_id, :partnumber, :description)
												RETURNING id');
		$query->execute(array(
			'itemtype_id' => $this->itemtype_id,
			'partnumber' => $this->partnumber,
			'description' => $this->description
			));

		$row = $query->fetch();
		$this->id = $row['id'];
	}

	public function update(){
	    $query = DB::connection()->prepare('UPDATE Item SET (description)
	    										= (:description)
	    										WHERE id = :id');
	    $query->execute(array(
	    	'id' => $this->id,
	    	'description' => $this->description
	    ));
	}

	public function destroy(){
	    $query = DB::connection()->prepare('DELETE FROM Item
	    										WHERE id = :id');
	    $query->execute(array(
	    	'id' => $this->id
	    ));
	}

	public static function find($id){
		$query = DB::connection()->prepare('SELECT Item.*, ItemType.name AS itemtype_name
												FROM Item, ItemType
												WHERE Item.id = :id
												AND Item.itemtype_id = ItemType.id
												LIMIT 1');
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if($row){
			$item = new Item(array(
				'id' => $row['id'],
				'itemtype_id' => $row['itemtype_id'],
				'partnumber' => $row['partnumber'],
				'description' => $row['description']
				));

			return $item;
		}

		return null;
	}

	public static function all($options){
		$query_string = 'SELECT *
							FROM Item';
		if(isset($options['itemtype_id'])){
	      $query_string .= ' WHERE itemtype_id = :itemtype_id';
	    }
	    $query_string .= ' ORDER BY Item.partnumber';
		

		$query = DB::connection()->prepare($query_string);
		$query->execute($options);

		$rows = $query->fetchAll();
		$items = array();

		foreach($rows as $row){
			$items[] = new Item(array(
				'id' => $row['id'],
				'itemtype_id' => $row['itemtype_id'],
				'partnumber' => $row['partnumber'],
				'description' => $row['description']
				));
		}

		return $items;
	}

	public function getItemType_Name() {
		$query = DB::connection()->prepare('SELECT ItemType.name AS itemtype_name
												FROM Item, ItemType
												WHERE Item.id = :id
												AND Item.itemtype_id = ItemType.id
												LIMIT 1');

		$query->execute(array('id' => $this->id));
		$row = $query->fetch();

		return $row['itemtype_name'];
	}

	public function validate_itemtype_id() {
		$errors = array();

		$query = DB::connection()->prepare('SELECT COUNT(*)
												FROM ItemType
												WHERE id = :id');
		$query->execute(array('id' => $this->itemtype_id));
		$row = $query->fetch();

		if($row['count'] != 1) {
			$errors[] = 'Item type does not exist!';
		}

		return $errors;
	}

	public function validate_description() {
		$errors = array();

		if($this->description == '' || $this->description == null){
			$errors[] = 'The description cannot be left empty!';
		}
		if(strlen($this->description) < 10){
			$errors[] = 'The description must be over 10 characters long!';
		}

		return $errors;
	}
}
