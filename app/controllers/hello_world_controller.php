<?php

class HelloWorldController extends BaseController{

  public static function index(){
   	  View::make('home.html');
  }

  public static function item_list(){
    View::make('item_list.html');
  }

  public static function itemtype_list(){
    View::make('itemtype_list.html');
  }

  public static function vendoritem_list(){
    View::make('vendoritem_list.html');
  }

  public static function vendor_list(){
    View::make('vendor_list.html');
  }

  public static function item_show(){
    View::make('item_show.html');
  }

  public static function bom_show(){
    View::make('bom_show.html');
  }

  public static function itemtype_show(){
    View::make('itemtype_show.html');
  }

  public static function vendoritem_show(){
    View::make('vendoritem_show.html');
  }

  public static function vendor_show(){
    View::make('vendor_show.html');
  }

  public static function item_edit(){
    View::make('item_edit.html');
  }

  public static function itemtype_edit(){
    View::make('itemtype_edit.html');
  }

  public static function vendoritem_edit(){
    View::make('vendoritem_edit.html');
  }

  public static function vendor_edit(){
    View::make('vendor_edit.html');
  }

  public static function sandbox(){
      // Testaa koodiasi täällä
    View::make('helloworld.html');
  }
}
