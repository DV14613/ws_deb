<?php
session_start();
require_once 'autoload.php';
require_once 'config/db.php';
require_once 'config/parameters.php';
require_once 'helpers/Utils.php';

function show_Error(){
  $error = new ErrorController();
  $error->index();
}


//require_once 'views/layouts/layout1/login.php';
//require_once 'views/layouts/layout1/sidebar.php';

if(isset($_GET['controller'])){
  $nombre_controlador = $_GET['controller'].'Controller';
}elseif(!isset($_GET['controller']) && !isset($_GET['action'])){
  $nombre_controlador = DEFAULT_CONTROLLER;
}else{
  show_error();
  exit();
}

if(class_exists($nombre_controlador)){  
  $controlador = new $nombre_controlador();
  
  if(isset($_GET['action']) && method_exists($controlador, $_GET['action'])){
    $action = $_GET['action'];
    $controlador->$action();
  }elseif(!isset($_GET['controller']) && !isset($_GET['action'])){
    $action_default = ACTION_DEFAULT;
    $controlador->$action_default();
  }else{
    show_error();
  }
}else{
  show_error();
}
//require_once 'views/layouts/layout1/footer.php'; 
?>