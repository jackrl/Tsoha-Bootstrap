<?php

class UserController extends BaseController{

  public static function index(){
    $users = User::all();

    View::make('user/index.html', array('users' => $users));
  }

  public static function create(){
    self::check_logged_in();

    View::make('user/new.html');
  }

  public static function edit($id){
    self::check_logged_in();

    $user = User::find($id);
    View::make('user/edit.html', array('user' => $user));
  }

  public static function store(){
    self::check_logged_in();

    $params = $_POST;

    $errors = array();

    if ($params['password'] == '') {
      $errors[] = 'The password cannot be left blank!';
    }

    if (array_key_exists('admin', $params)) {
      $params['admin'] = 't';
    }
    else {
      $params['admin'] = 'f';
    }

    $attributes = array(
      'username' => $params['username'],
      'password' => $params['password'],
      'admin' => $params['admin']
      );

    $user = new User($attributes);

    if(count($errors) == 0){
      $user->save();

      Redirect::to('/user', array('message' => 'The new user has been added to the database'));
    }else{
      View::make('user/new.html', array('errors' => $errors));
    }
  }

  public static function update($id){
    self::check_logged_in();

    $params = $_POST;

    if ($params['password'] == '') {
      $params['password'] = User::find($id)->password;
    }

    if (array_key_exists('admin', $params)) {
      $params['admin'] = 't';
    }
    else {
      $params['admin'] = 'f';
    }

    $attributes = array(
      'id' => $id,
      'username' => $params['username'],
      'password' => $params['password'],
      'admin' => $params['admin']
      );

    $user = new User($attributes);
    $user->update();

    Redirect::to('/user', array('message' => 'The user has been modified successfully!'));
  }

  public static function destroy($id){
    self::check_logged_in();
    
    $user = new User(array('id' => $id));
    $user->destroy();

    Redirect::to('/user', array('message' => 'The user has been removed successfully!'));
  }

  public static function login(){
      View::make('user/login.html');
  }

  public static function handle_login(){
    $params = $_POST;

    $user = User::authenticate($params['username'], $params['password']);

    if(!$user){
      View::make('user/login.html', array('error' => 'Wrong username or password!', 'username' => $params['username']));
    }else{
      $_SESSION['user'] = $user->id;

      Redirect::to('/', array('message' => 'Welcome back ' . $user->username . '!'));
    }
  }

  public static function logout(){
    $_SESSION['user'] = null;
    Redirect::to('/login', array('message' => 'You have successfully been logged out!'));
  }
}