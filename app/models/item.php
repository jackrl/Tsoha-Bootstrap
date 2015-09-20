<?php

class Item extends BaseModel{

	public $id, $itemtype_id, $partnumber, $description, $hasbom, $itemtype_name;

	public function __construct($attributes){
		parent::__construct($attributes);
	}

	public function save(){
    $query = DB::connection()->prepare('INSERT INTO Item (itemtype_id, partnumber, description)
    										VALUES (:itemtype_id, :partnumber, :description)
    										RETURNING id, hasbom');
    $query->execute(array(
    	'itemtype_id' => $this->itemtype_id,
    	'partnumber' => $this->partnumber,
    	'description' => $this->description
    ));

    $row = $query->fetch();
    $this->id = $row['id'];
    $this->hasbom = $row['hasbom'];
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
				'description' => $row['description'],
				'hasbom' => $row['hasbom'],
				'itemtype_name' => $row['itemtype_name']
				));

			return $item;
		}

		return null;
	}

	public static function all(){
		$query = DB::connection()->prepare('SELECT Item.*, ItemType.name AS itemtype_name
												FROM Item, ItemType
												WHERE Item.itemtype_id = ItemType.id
												ORDER BY Item.partnumber');
		$query->execute();
		$rows = $query->fetchAll();
		$items = array();

		foreach($rows as $row){
			$items[] = new Item(array(
				'id' => $row['id'],
				'itemtype_id' => $row['itemtype_id'],
				'partnumber' => $row['partnumber'],
				'description' => $row['description'],
				'hasbom' => $row['hasbom'],
				'itemtype_name' => $row['itemtype_name']
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
}
