<?php

class ItemTypeController extends BaseController{

  public static function index(){
    $itemtypes = ItemType::all();

    View::make('itemtype/index.html', array('itemtypes' => $itemtypes));
  }

  public static function show($id){
    $itemtype = ItemType::find($id);
    $items = Item::all(array('itemtype_id' => $id));

    View::make('itemtype/show.html', array('itemtype' => $itemtype, 'items' => $items));
  }

  public static function create(){
    self::check_logged_in();

    View::make('itemtype/new.html');
  }

  public static function store(){
    self::check_logged_in();

    $params = $_POST;
    $attributes = array(
      'name' => $params['name'],
      'pnprefix' => $params['pnprefix']
      );

    $itemtype = new ItemType($attributes);

    $errors = $itemtype->errors();

    if(count($errors) == 0){
      $itemtype->save();

      Redirect::to('/itemtype/' . $itemtype->id, array('message' => 'The new item type has been added to the database'));
    }else{
      View::make('itemtype/new.html', array('errors' => $errors, 'attributes' => $attributes));
    }
  }

  public static function edit($id){
    self::check_logged_in();

    $itemtype = ItemType::find($id);
    View::make('itemtype/edit.html', array('itemtype' => $itemtype));
  }

  public static function update($id){
    self::check_logged_in();

    $params = $_POST;

    $attributes = array(
      'id' => $id,
      'name' => $params['name'],
      'pnprefix' => ItemType::find($id)->pnprefix,
      'nextpn' => ItemType::find($id)->nextpn
      );

    $itemtype = new ItemType($attributes);
    $errors = $itemtype->errors();

    if(count($errors) > 0){
      $itemtype = ItemType::find($id);

      View::make('itemtype/edit.html', array('errors' => $errors,
                         'given_name' => $params['name'],
                         'itemtype' => $itemtype));
    }else{
      $itemtype->update();

      Redirect::to('/itemtype/' . $itemtype->id, array('message' => 'The item type has been modified successfully!'));
    }
  }

  public static function destroy($id){
    self::check_logged_in();
    
    $itemtype = new ItemType(array('id' => $id));
    $itemtype->destroy();

    Redirect::to('/itemtype', array('message' => 'The item type has been removed successfully!'));
  }
}
