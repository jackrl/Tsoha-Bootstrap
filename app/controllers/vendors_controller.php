<?php

class VendorController extends BaseController{

  public static function index(){
    $vendors = Vendor::all();

    View::make('vendor/index.html', array('vendors' => $vendors));
  }

  public static function show($id){
    $vendor = Vendor::find($id);
    $vendoritems = VendorItem::all(array('vendor_id' => $id));

    View::make('vendor/show.html', array('vendor' => $vendor, 'vendoritems' => $vendoritems));
  }

  public static function create(){
    self::check_logged_in();

    View::make('vendor/new.html');
  }

  public static function store(){
    self::check_logged_in();

    $params = $_POST;
    $attributes = array(
      'name' => $params['name'],
      );

    $vendor = new Vendor($attributes);

    $errors = $vendor->errors();

    if(count($errors) == 0){
      $vendor->save();

      Redirect::to('/vendors/' . $vendor->id, array('message' => 'The new vendor has been added to the database'));
    }else{
      View::make('vendor/new.html', array('errors' => $errors, 'attributes' => $attributes));
    }
  }

  public static function edit($id){
    self::check_logged_in();

    $vendor = Vendor::find($id);
    View::make('vendor/edit.html', array('vendor' => $vendor));
  }

  public static function update($id){
    self::check_logged_in();

    $params = $_POST;

    $attributes = array(
      'id' => $id,
      'name' => $params['name'],
      );

    $vendor = new Vendor($attributes);
    $errors = $vendor->errors();

    if(count($errors) > 0){
      $vendor = Vendor::find($id);

      View::make('vendor/edit.html', array('errors' => $errors,
                         'given_name' => $params['name'],
                         'vendor' => $vendor));
    }else{
      $vendor->update();

      Redirect::to('/vendors/' . $vendor->id, array('message' => 'The vendor has been modified successfully!'));
    }
  }

  public static function destroy($id){
    self::check_logged_in();
    
    $vendor = new Vendor(array('id' => $id));
    $vendor->destroy();

    Redirect::to('/vendors', array('message' => 'The vendor has been removed successfully!'));
  }
}
