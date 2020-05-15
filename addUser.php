<?php
    ob_start();
    include 'checkUser.php';
    if ($_SESSION['_IsAdmin']==0 ){
      header('Location: ./consult.php');
      exit();
    }

  include 'connectionFactory.php';
  $mysqli= ConnectionFactory::GetConnection();	
  $mail=$_POST['mail'];
  $psw    = $_POST["psw"]; 
  $salt   = date('Y-m-d:h:m:s');
  if (isset($_POST["de"])){  $de = 1 ; } else { $de = 0 ;}
  if (isset($_POST["dl"])){  $dl = 1 ; } else { $dl = 0 ;}
  if (isset($_POST["da"])){  $da = 1 ; } else { $da = 0 ;}
  $uid    = $_POST["uid"];
  $password_md5 = md5($psw.$salt);

  if ($uid>0){
      $stmt = $mysqli->prepare("UPDATE Reg_SiteUser SET IsAdmin=?, CanEdit=?, CanLogIn=? WHERE Id=?");
      $stmt->bind_param("iiii",$da,$de,$dl, $uid );
      $stmt->execute();
      $stmt->close();
  } else {
      $stmt = $mysqli->prepare("INSERT  Reg_SiteUser (EMail,Salt,Password,IsAdmin,CanEdit,CanLogIn) VALUES (?,?,?,?,?,?)");
      $stmt->bind_param("sssiii",$mail,$salt,$password_md5,$da,$de,$dl );
      $stmt->execute();
      $uid = $stmt->insert_id;
      $stmt->close();
  }
  
 

//echo $mail.' '.$salt.' '.$password_md5.' '.$da.' '.$de.' '.$de;

  header('Location: ./admin.php');
  exit();
?>
