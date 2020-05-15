<?php  
  ob_start();
    include 'checkUser.php';
  header('Content-Type: text/html; charset=utf-8');
  
  if (!isset($_SESSION['_UserId']) || $_SESSION['_UserId']<=0 ){
    header('Location: index.php');
    exit();	
  }
  include 'connectionFactory.php';
  $mysqli= ConnectionFactory::GetConnection();
   
  $pswError='';
  // change password
  if (isset($_POST['opsw']) || isset($_POST['npsw']) || isset($_POST['cnpsw'])){
    if (!($stmt = $mysqli->prepare("SELECT Password,Salt FROM Reg_SiteUser WHERE Id =?"))){
      echo 'prepare error'; exit;
    }

    if (!($stmt->bind_param("i", $_SESSION['_UserId'] ))){
    // echo 'bind error'; exit;
    }

    $stmt->bind_result( $Password, $Salt);
    $stmt->execute(); 
    $stmt->fetch();
    $stmt->close();

    $storedPasword = $Password;
    $opsw_md5 = md5($_POST['opsw'].$Salt);
    $npsw_md5 = md5($_POST['npsw'].$Salt);
    $cnpsw_md5 = md5($_POST['cnpsw'].$Salt);
    if (strlen ($_POST['npsw'])>5){
      if (similar_text($opsw_md5, $storedPasword, $percent)==32){
         if (similar_text($npsw_md5, $cnpsw_md5, $percent)==32){
           $stmt = $mysqli->prepare("Update  Reg_SiteUser set Password=? WHERE Id =?");
           $stmt->bind_param("si",$npsw_md5 ,$_SESSION['_UserId'] );
	   $stmt->execute();
 	   $stmt->close();
           $pswError= 'le mot de passe a &eacute;t&eacute; chang&eacute;.';
           $_SESSION['_ResetPass']=0;
           
         } else{
           $pswError= 'Le nouveau mot de passe et sa confirmation ne correspondent pas.';
         }
      } else {
        $pswError= 'L\'ancien mot de passe est incorrecte.';
      }
   } else {
     $pswError= 'Le nouveau mot de passe est trop court (min 6 caract&egrave;res).';
   }
 }


echo'
<!DOCTYPE html>
<html>
  <head>';
include 'p_head.php';
makeHead(10);
echo' 
  </head>
<body>
  <span class="fond"></span>
  <span class="cont">
  
    <a class="button" href="consult.php">Retour</a><br/>
	<h2> Mon Compte Utilisateur </h2>';

  $stmt = $mysqli->prepare("SELECT Id,EMail,LastLoggedIn,Salt,IsAdmin, CanEdit, CanLogIn FROM Reg_SiteUser WHERE Id=? ");
	$stmt->bind_param("i",$_SESSION['_UserId'] );
    $stmt->bind_result( $uid, $EMail,$last,$s, $IsAdmin,$CanEdit,$CanLogIn);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();
    
     $date='';
     if (isset($last)){
       $d1=new DateTime($last);
       $date=$d1->format('d/m/Y');
     }
  echo '      
        
         <span class="fitem"><span class="label">Nom d\'utilisateur:</span>'. $EMail.'</span>
         <span class="fitem"><span class="label">Dernier login:</span>'.$date.'</span>';
         
  

  echo'   <h2>Mes droits d\'acc&egrave;s</h2>
     <span class="textes">Je peux consulter les demandes.</span><br/> ';

    if ($_SESSION['_CanEdit'] ==1){
     echo ' <span class="textes">J\'ai les droits pour modifier les demandes et leurs documents </span><br/>';
     }

     if ($_SESSION['_IsAdmin'] ==1){
      echo ' <span class="textes">J\'ai les droits d\'administration des utilisateurs</span><br/>';
    }         
 
  
         
         
         
 echo '        
               <h2 >Changer de mot de passe</h2>
<span class="formNotice">Nous ne stoquons pas vos mots de passe sous une forme lisible n&eacute;anmoins nous vous recommandons fortement d\'utiliser un mot de passe sp&eacute;cifique et de ne pas le r&eacute;utiliser ailleur. </span><br/><br/>
<form action="./user.php#changepsw" method="post">
         <span class="fitem"><span class="labelUser">Ancien mot de passe : </span> <input type="password" name="opsw"/></span>
	    <span class="fitem"><span class="labelUser">Nouveau mot de passe : </span> <input type="password" name="npsw"/></span>
	     <span class="fitem"><span class="labelUser">Nouveau mot de passe : </span> <input type="password" name="cnpsw"/></span>';
  if (strlen ($pswError)>0){
    echo '<span class="formMessage">'.$pswError.'</span><br/>';
  }
  echo'	      
                  <input class="button" type="submit" title="Changer"value="Changer"/> 
              
        </form>

       ';
        
        echo'
    </span>
  </span >
</body>
</html>';


?>


