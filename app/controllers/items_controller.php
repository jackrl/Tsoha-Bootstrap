<?php

class ItemController extends BaseController{

	public static function index(){
		$options = array();
		$items = Item::all($options);

		View::make('item/index.html', array('items' => $items));
	}

	public static function show($id){
		$item = Item::find($id);
		$vendoritems = $item->getVendorItems($id);

		View::make('item/show.html', array('item' => $item, 'vendoritems' => $vendoritems));
	}

	public static function create(){
		self::check_logged_in();

		$itemtypes = ItemType::all();

		View::make('item/new.html', array('itemtypes' => $itemtypes));
	}

	public static function store(){
		self::check_logged_in();

		$params = $_POST;
		$attributes = array(
			'itemtype_id' => $params['itemtype_id'],
			'description' => $params['description']
			);

		$item = new Item($attributes);

		$errors = $item->errors();

		if(count($errors) == 0){
			// The part number is added when the existance of the part type is validated
			$itemtype = ItemType::find($params['itemtype_id']);
			$item->setPN($itemtype->getNextPN());

			$item->save();

			Redirect::to('/item/' . $item->id, array('message' => 'The new item has been added to the database'));
		}else{
			$itemtypes = ItemType::all();

			View::make('item/new.html', array('errors' => $errors, 'attributes' => $attributes, 'itemtypes' => $itemtypes));
		}
	}

	public static function edit($id){
		self::check_logged_in();

		$item = Item::find($id);
		$itemtype = ItemType::find($item->itemtype_id);
		View::make('item/edit.html', array('item' => $item, 'itemtype' => $itemtype));
	}

	public static function update($id){
		self::check_logged_in();

		$params = $_POST;

		$attributes = array(
			'id' => $id,
			'itemtype_id' => Item::find($id)->itemtype_id,
			'description' => $params['description']
			);

		$item = new Item($attributes);
		$errors = $item->errors();

		if(count($errors) > 0){
			$item = Item::find($id);
			$itemtype = ItemType::find($item->itemtype_id);

			View::make('item/edit.html', array('errors' => $errors,
											   'given_description' => $params['description'],
											   'item' => $item,
											   'itemtype' => $itemtype));
		}else{
			$item->update();

			Redirect::to('/item/' . $item->id, array('message' => 'The item has been modified successfully!'));
		}
	}

	public static function destroy($id){
		self::check_logged_in();
		
		$item = new Item(array('id' => $id));
		$item->destroy();

		Redirect::to('/item', array('message' => 'The item has been removed successfully!'));
	}

	public static function addVendorItem($id){
		self::check_logged_in();

		$item = new Item(array('id' => $id));

		$options = array();
		$allvendoritems = VendorItem::all($options);
		$curvendoritems = $item->getVendorItems();

		function compare_vendoritems($obj_a, $obj_b) { return $obj_a->id - $obj_b->id; }
		$vendoritems = array_udiff($allvendoritems, $curvendoritems, 'compare_vendoritems');

		View::make('item/vendoritem/add.html', array('item_id' => $id, 'vendoritems' => $vendoritems));
	}
	
	public static function storeVendorItem($id){
		self::check_logged_in();

		$params = $_POST;

		$query = DB::connection()->prepare('INSERT INTO ItemToVendorItemMap (item_id, vendoritem_id)
												VALUES (:item_id, :vendoritem_id)');
		$query->execute(array(
			'item_id' => $id,
			'vendoritem_id' => $params['vendoritem_id']
			));

		Redirect::to('/item/' . $id, array('message' => 'The vendor item has been added succesfully to this item'));
	}

	public static function  removeVendorItem($id){
		self::check_logged_in();
		
		$params = $_POST;

		$query = DB::connection()->prepare('DELETE FROM ItemToVendorItemMap
    										WHERE item_id = :item_id
											AND vendoritem_id = :vendoritem_id');
    	$query->execute(array('item_id' => $id,
							  'vendoritem_id' => $params['vendoritem_id']));

		Redirect::to('/item/' . $id, array('message' => 'The vendor item has been removed successfully from this item!'));
	}
}
