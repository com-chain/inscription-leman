<?php
      ob_start();
      session_name("Inscription_ML");	
      session_start(); 				
      if($_POST && !empty($_POST['login']) && !empty($_POST['mdp']))
	{
	    
         include 'connectionFactory.php';
         $mysqli= ConnectionFactory::GetConnection(); 
         

	  if (!($stmt = $mysqli->prepare("SELECT Id,EMail,Salt,Password,IsAdmin, CanEdit , CanLogIn FROM Reg_SiteUser WHERE EMail =?"))){
  	     echo '<span class="error">Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error.'</span>';
  	  }

  	  $stmt->bind_param("s", $_POST['login'] );
          if (!($stmt->execute())){
             echo '<span class="error">Execute failed: (' . $mysqli->errno . ') ' . $mysqli->error.'</span>';
          }

          $stmt->bind_result( $UserId,$email, $Salt, $Password, $IsAdmin, $canEdit, $canLog);
          $stmt->fetch();
	  $stmt->close();

          if (!isset($UserId) || $canLog!=1){
	    header('Location: login.php');
            exit();	
          }
          $password_md5 = md5($_POST['mdp'].$Salt);
     // echo $password_md5; exit();
	 if(similar_text($password_md5, $Password, $percent)==32){
	   $_SESSION['_UserId'] = $UserId;
	   $_SESSION['_IsAdmin'] = $IsAdmin;
	   $_SESSION['_CanEdit'] = $canEdit;
	   
	   $stmt = $mysqli->prepare("Update  Reg_SiteUser set LastLoggedIn=now() WHERE Id =?");
       $stmt->bind_param("i", $UserId );
	   $stmt->execute();
 	   $stmt->close();

	   	header('Location: ./consult.php');
	   
	 } else {
	   header('Location: login.php');	 
	 }
     } else {
        // LogOut
	$_SESSION = array();
	if (ini_get("session.use_cookies")) {
	   $params = session_get_cookie_params();
	   setcookie(session_name(), '', time() - 42000,$params["path"], $params["domain"],$params["secure"], $params["httponly"]);
	}
	session_destroy();
        header('Location: login.php');
     }
     exit();	
?>




	
