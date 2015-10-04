<?php

$routes->get('/', function() {
	ItemController::index();
});

// Login and logout
$routes->get('/login', function(){
	UserController::login();
});

$routes->post('/login', function(){
	UserController::handle_login();
});

$routes->post('/logout', function(){
  UserController::logout();
});

// Item
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

$routes->get('/item/:id/edit', function($id){
	ItemController::edit($id);
});

$routes->post('/item/:id/edit', function($id){
	ItemController::update($id);
});

$routes->post('/item/:id/destroy', function($id){
	ItemController::destroy($id);
});

// ItemType
$routes->get('/itemtype', function() {
	ItemTypeController::index();
});

$routes->post('/itemtype', function(){
	ItemTypeController::store();
});

$routes->get('/itemtype/new', function() {
	ItemTypeController::create();
});

$routes->get('/itemtype/:id', function($id) {
	ItemTypeController::show($id);
});

$routes->get('/itemtype/:id/edit', function($id){
	ItemTypeController::edit($id);
});

$routes->post('/itemtype/:id/edit', function($id){
	ItemTypeController::update($id);
});

$routes->post('/itemtype/:id/destroy', function($id){
	ItemTypeController::destroy($id);
});

$routes->get('/sandbox', function() {
	$user = BaseController::get_user_logged_in();

	Kint::dump($user);

	$session_id = $_SESSION['user'];
	Kint::dump($session_id);

	$find_admin = User::find(1);
	Kint::dump($find_admin);

	$find_normalUser = User::find(2);
	Kint::dump($find_normalUser);
});