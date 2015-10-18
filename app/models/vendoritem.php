<?php

class VendorItem extends BaseModel{

	public $id, $vendor_id, $partnumber, $datasheeturl;

	public function __construct($attributes){
		parent::__construct($attributes);

		$this->validators = array('validate_vendor_id', 'validate_partnumber', 'validate_datasheeturl');
	}

	public function save(){
		$query = DB::connection()->prepare('INSERT INTO VendorItem (vendor_id, partnumber, datasheeturl)
												VALUES (:vendor_id, :partnumber, :datasheeturl)
												RETURNING id');
		$query->execute(array(
			'vendor_id' => $this->vendor_id,
			'partnumber' => $this->partnumber,
			'datasheeturl' => $this->datasheeturl
			));

		$row = $query->fetch();
		$this->id = $row['id'];
	}

	public function update(){
	    $query = DB::connection()->prepare('UPDATE VendorItem SET (vendor_id, partnumber, datasheeturl)
	    										= (:vendor_id, :partnumber, :datasheeturl)
	    										WHERE id = :id');
	    $query->execute(array(
	    	'id' => $this->id,
	    	'vendor_id' => $this->vendor_id,
	    	'partnumber' => $this->partnumber,
	    	'datasheeturl' => $this->datasheeturl
	    ));
	}

	public function destroy(){
	    $query = DB::connection()->prepare('DELETE FROM VendorItem
	    										WHERE id = :id');
	    $query->execute(array(
	    	'id' => $this->id
	    ));
	}

	public static function find($id){
		$query = DB::connection()->prepare('SELECT VendorItem.*
												FROM VendorItem
												WHERE VendorItem.id = :id
												LIMIT 1');
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if($row){
			$vendoritem = new VendorItem(array(
				'id' => $row['id'],
				'vendor_id' => $row['vendor_id'],
		    	'partnumber' => $row['partnumber'],
		    	'datasheeturl' => $row['datasheeturl']
				));

			return $vendoritem;
		}

		return null;
	}

	public static function all($options){
		$query_string = 'SELECT *
							FROM VendorItem';
		if(isset($options['vendor_id'])){
	      $query_string .= ' WHERE vendor_id = :vendor_id';
	    }
	    $query_string .= ' ORDER BY VendorItem.partnumber';
		

		$query = DB::connection()->prepare($query_string);
		$query->execute($options);

		$rows = $query->fetchAll();
		$vendoritems = array();

		foreach($rows as $row){
			$vendoritems[] = new VendorItem(array(
				'id' => $row['id'],
				'vendor_id' => $row['vendor_id'],
		    	'partnumber' => $row['partnumber'],
		    	'datasheeturl' => $row['datasheeturl']
				));
		}

		return $vendoritems;
	}

	public function getVendor_Name() {
		$query = DB::connection()->prepare('SELECT Vendor.name AS vendor_name
												FROM VendorItem, Vendor
												WHERE VendorItem.id = :id
												AND VendorItem.vendor_id = Vendor.id
												LIMIT 1');

		$query->execute(array('id' => $this->id));
		$row = $query->fetch();

		return $row['vendor_name'];
	}

	public function getWhereUsed() {
		$query = DB::connection()->prepare('SELECT Item.*
												FROM Item, ItemToVendorItemMap
												WHERE ItemToVendorItemMap.vendorItem_id = :id
												AND ItemToVendorItemMap.item_id = Item.id');

		$query->execute(array('id' => $this->id));
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

	public function validate_vendor_id() {
		$errors = array();

		$query = DB::connection()->prepare('SELECT COUNT(*)
												FROM Vendor
												WHERE id = :id');
		$query->execute(array('id' => $this->vendor_id));
		$row = $query->fetch();

		if($row['count'] != 1) {
			$errors[] = 'Vendor does not exist!';
		}

		return $errors;
	}

	public function validate_partnumber() {
		$errors = array();

		if($this->partnumber == '' || $this->partnumber == null){
			$errors[] = 'The part number cannot be left empty!';
		}
		if(strlen($this->partnumber) < 3){
			$errors[] = 'The partnumber must be at least 3 characters long!';
		}

		return $errors;
	}

	public function validate_datasheeturl() {
		$errors = array();

		if($this->datasheeturl != '' && !filter_var($this->datasheeturl, FILTER_VALIDATE_URL)){
			$errors[] = 'Invalid URL. Make sure you included http(s)://';
		}

		return $errors;
	}
}
