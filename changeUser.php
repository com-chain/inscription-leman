<?php  
  ob_start();
  include 'checkUser.php';
  include 'connectionFactory.php';
  $mysqli= ConnectionFactory::GetConnection();
  
   if(!isAdmin()){ 
    header('Location: ./consult.php');
    exit();
  }

	$isReadonly=0;
	$readonly='';
	$button='Cr&eacute;er';
	if ($_GET['uid']>0 ){
	  $isReadonly=1;
	  $readonly=' readonly="readonly" ';
	  $button='Modifier';
	}
	
	$stmt = $mysqli->prepare("SELECT Id,EMail,LastLoggedIn,Salt,IsAdmin, CanEdit, CanLogIn FROM Reg_SiteUser WHERE Id=? ");
	$stmt->bind_param("i",$_GET['uid'] );
    $stmt->bind_result( $Id, $EMail,$last,$s, $IsAdmin,$CanEdit,$CanLogIn);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();
    
    $linked=0;
    if (isset($pid)){
        $linked=1;
    }

echo '<!DOCTYPE html>
          <html>
            <head>
              ';
include 'p_head.php';
makeHead(10);
echo'  
</head>
<body>
    <span class="fond"></span>
    <span class="cont">
       <a class="button" href="admin.php">Retour</a><br/>
       <h2>Utilisateur </h2>
       <form action="./addUser.php" method="post"> 
          <input type="hidden" name="uid" value="'.$Id.'"/>
          <span class="fitem">
            <span class="label">Identifiant* :</span>
            <input type="text" name="mail" value="'.$EMail.'" '.$readonly.'/>
          </span>';
          if ($isReadonly==0){
                    echo' <span class="fitem"><span class="label">Mot de passe* :</span><input type="text" name="psw" /></span>';
                } 
          echo'
          <span class="fitem">
            <span class="label">Droits d\'admin :</span><input type="checkbox" name="da" value="1" '; 
            if ($IsAdmin==1) {echo 'checked="cheched"';} 
            echo'"/>
          </span>
          <span class="fitem">
            <span class="label">Droits d\'édition :</span>
            <input type="checkbox" name="de" value="1" '; 
            if ($CanEdit==1) {echo 'checked="cheched"';} 
            echo'"/>
          </span>
          <span class="fitem">
            <span class="label">Droits de connection :</span>
            <input type="checkbox" name="dl" value="1" '; 
            if ($CanLogIn==1) {echo 'checked="cheched"';} 
            echo'"/>
          </span>
          <input class="button" type="submit" value="'.$button.'" title="'.$button.'" />   
        </form>        
      </span> 
      </span>
    </body>
</html>';
