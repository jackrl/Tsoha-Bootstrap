<?php

class ItemController extends BaseController{

	public static function index(){
		$items = Item::all();

		View::make('item/index.html', array('items' => $items));
	}

	public static function show($id){
		$item = Item::find($id);

		View::make('item/show.html', array('item' => $item));
	}

	public static function create(){
		$itemtypes = ItemType::all();

		View::make('item/new.html', array('itemtypes' => $itemtypes));
	}

	public static function store(){
		$params = $_POST;

		$itemtype = ItemType::find($params['itemtype_id']);

		$PN =$itemtype->getNextPN();

		$item = new Item(array(
			'itemtype_id' => $params['itemtype_id'],
			'partnumber' => $PN,
			'description' => $params['description']
			));

		$item->save();

		Redirect::to('/item/' . $item->id, array('message' => 'Item ' . $PN . ' has been added to the database'));
	}

}
