<?php

class ItemTypeController extends BaseController{

  /*public static function index(){
    $items = ItemType::all();

    View::make('itemtype/index.html', array('itemtypes' => $itemtypes));
  }*/

  public static function show($id){
    /*$itemtype = ItemType::find($id);

    View::make('itemtype/show.html', array('itemtype' => $itemtype));*/

    // Static
    View::make('itemtype/show.html');
  }
}
