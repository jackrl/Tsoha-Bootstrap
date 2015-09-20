<?php

class ItemType extends BaseModel{

	public $id, $name, $pnprefix, $nextpn;

	public function __construct($attributes){
		parent::__construct($attributes);
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
												FROM ItemType');
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
}
