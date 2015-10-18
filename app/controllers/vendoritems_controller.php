<?php

class VendorItemController extends BaseController{

	public static function index(){
		$options = array();
		$vendoritems = VendorItem::all($options);

		View::make('vendoritem/index.html', array('vendoritems' => $vendoritems));
	}

	public static function show($id){
		$vendoritem = VendorItem::find($id);
		$items = $vendoritem->getWhereUsed();

		View::make('vendoritem/show.html', array('vendoritem' => $vendoritem,
												 'items' => $items));
	}

	public static function create(){
		self::check_logged_in();

		$vendors = Vendor::all();

		View::make('vendoritem/new.html', array('vendors' => $vendors));
	}

	public static function store(){
		self::check_logged_in();

		$params = $_POST;
		$attributes = array(
			'vendor_id' => $params['vendor_id'],
			'partnumber' => $params['partnumber'],
			'datasheeturl' => $params['datasheeturl']
			);

		$vendoritem = new VendorItem($attributes);

		$errors = $vendoritem->errors();

		if(count($errors) == 0){
			$vendoritem->save();

			Redirect::to('/vendoritem/' . $vendoritem->id, array('message' => 'The new vendor item has been added to the database'));
		}else{
			$vendors = Vendor::all();

			View::make('vendoritem/new.html', array('errors' => $errors, 'attributes' => $attributes, 'vendors' => $vendors));
		}
	}

	public static function edit($id){
		self::check_logged_in();

		$vendoritem = VendorItem::find($id);
		$vendors = Vendor::all();
		View::make('vendoritem/edit.html', array('vendoritem' => $vendoritem, 'vendors' => $vendors));
	}

	public static function update($id){
		self::check_logged_in();

		$params = $_POST;

		$attributes = array(
			'id' => $id,
			'vendor_id' => $params['vendor_id'],
			'partnumber' => $params['partnumber'],
			'datasheeturl' => $params['datasheeturl']
			);

		$vendoritem = new VendorItem($attributes);
		$errors = $vendoritem->errors();

		if(count($errors) > 0){
			$vendoritem = VendorItem::find($id);
			$vendors = Vendor::all();

			View::make('vendoritem/edit.html', array('errors' => $errors,
											   'attributes' => $attributes,
											   'vendoritem' => $vendoritem,
											   'vendors' => $vendors));
		}else{
			$vendoritem->update();

			Redirect::to('/vendoritem/' . $vendoritem->id, array('message' => 'The vendor item has been modified successfully!'));
		}
	}

	public static function destroy($id){
		self::check_logged_in();
		
		$vendoritem = new VendorItem(array('id' => $id));
		$vendoritem->destroy();

		Redirect::to('/vendoritem', array('message' => 'The vendor item has been removed successfully!'));
	}
}
