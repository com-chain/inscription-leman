<?php
  session_name("Inscription_ML");
  session_start();
  header('Content-Type: text/html; charset=utf-8');
  
  if (!isset($_SESSION['_UserId']) || $_SESSION['_UserId']<=0 ){
    header('Location: login.php');
    exit();	
  }
  
  function isAdmin(){
    return $_SESSION['_IsAdmin'];
  }
  
  function canEdit(){
    return $_SESSION['_CanEdit'];
  }
  
  function getUserId(){
    return $_SESSION['_UserId'];
  }
?>
