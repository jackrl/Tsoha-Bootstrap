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

// User
$routes->get('/user', function() {
	UserController::index();
});

$routes->post('/user', function(){
	UserController::store();
});

$routes->get('/user/new', function() {
	UserController::create();
});

$routes->get('/user/:id/edit', function($id){
	UserController::edit($id);
});

$routes->post('/user/:id/edit', function($id){
	UserController::update($id);
});

$routes->post('/user/:id/destroy', function($id){
	UserController::destroy($id);
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

$routes->get('/item/:id/vendoritem', function($id){
	ItemController::addVendorItem($id);
});

$routes->post('/item/:id/vendoritem', function($id){
	ItemController::storeVendorItem($id);
});

$routes->post('/item/:id/vendoritem/remove', function($id){
	ItemController::removeVendorItem($id);
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

// Vendor Item
$routes->get('/vendoritem', function() {
	VendorItemController::index();
});

$routes->post('/vendoritem', function(){
	VendorItemController::store();
});

$routes->get('/vendoritem/new', function() {
	VendorItemController::create();
});

$routes->get('/vendoritem/:id', function($id) {
	VendorItemController::show($id);
});

$routes->get('/vendoritem/:id/edit', function($id){
	VendorItemController::edit($id);
});

$routes->post('/vendoritem/:id/edit', function($id){
	VendorItemController::update($id);
});

$routes->post('/vendoritem/:id/destroy', function($id){
	VendorItemController::destroy($id);
});

// Vendor
$routes->get('/vendors', function() {
	VendorController::index();
});

$routes->post('/vendors', function(){
	VendorController::store();
});

$routes->get('/vendors/new', function() {
	VendorController::create();
});

$routes->get('/vendors/:id', function($id) {
	VendorController::show($id);
});

$routes->get('/vendors/:id/edit', function($id){
	VendorController::edit($id);
});

$routes->post('/vendors/:id/edit', function($id){
	VendorController::update($id);
});

$routes->post('/vendors/:id/destroy', function($id){
	VendorController::destroy($id);
});

$routes->get('/sandbox', function() {
	$url = 'asdas';
	$vendoritem = new VendorItem(array(
							'id' => 0,
							'vendor_id' => 0,
							'partnumber' => 'pn',
							'datasheeturl' => $url));
	Kint::dump($vendoritem);

	$errors = $vendoritem->validate_datasheeturl();
	Kint::dump($errors);
});