<?php

$routes->get('/', function() {
	HelloWorldController::index();
});

$routes->get('/item', function() {
	ItemController::index();
});

$routes->post('/item', function(){
	ItemController::store();
});

$routes->get('/item/new', function() {
	ItemController::create();
});

$routes->get('/item/:id', function($id) {
	ItemController::show($id);
});

$routes->get('/itemtype/:id', function($id) {
	ItemTypeController::show($id);
});

$routes->get('/itemtype', function() {
	HelloWorldController::itemtype_list();
});

$routes->get('/vendoritem', function() {
	HelloWorldController::vendorItem_list();
});

$routes->get('/vendors', function() {
	HelloWorldController::vendor_list();
});

$routes->get('/item/1', function() {
	HelloWorldController::item_show();
});

$routes->get('/item/2', function() {
	HelloWorldController::bom_show();
});

$routes->get('/itemtype/1', function() {
	HelloWorldController::itemtype_show();
});

$routes->get('/vendoritem/1', function() {
	HelloWorldController::vendorItem_show();
});

$routes->get('/vendor/1', function() {
	HelloWorldController::vendor_show();
});

$routes->get('/item/1/edit', function() {
	HelloWorldController::item_edit();
});

$routes->get('/itemtype/1/edit', function() {
	HelloWorldController::itemtype_edit();
});

$routes->get('/vendoritem/1/edit', function() {
	HelloWorldController::vendorItem_edit();
});

$routes->get('/vendor/1/edit', function() {
	HelloWorldController::vendor_edit();
});

$routes->get('/sandbox', function() {
	HelloWorldController::sandbox();
});