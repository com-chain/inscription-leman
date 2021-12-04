<?php  
  ob_start();
  include 'checkUser.php';
  include 'connectionFactory.php';
  $mysqli= ConnectionFactory::GetConnection();
  
   if(!isAdmin()){ 
    header('Location: ./consult.php');
    exit();
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
  <a class="button" href="consult.php">Retour</a><br/>
                <h2>Gestion des d\'utilisateurs </h2>


          <a class="button" href="changeUser.php?id=0" title="Nouvel Utilisateur">Nouvel Utilisateur</a>

      <table class="wt"><tr class="tblHeader"><td >Identifiant</td>
      <td>Nom court</td>
      <td>Derni&egrave;re connection</td>
      <td >Admin</td>
      <td >Droit d\'édition</td>
      <td >Droit de connection</td>
      <td >Action</td>
      </tr>';
     $stmt = $mysqli->prepare("SELECT Id,EMail,Short, LastLoggedIn,Salt, IsAdmin, CanEdit, CanLogIn FROM Reg_SiteUser ");
     $stmt->bind_result( $Id, $EMail,$short,$last,$s, $IsAdmin,$CanEdit,$CanLogIn);
     $stmt->execute();
     while ($stmt->fetch()){
     
     $date='';
     if (isset($last)){
       $d1=new DateTime($last);
       $date=$d1->format('d/m/Y');
     }
     echo' <tr ><td >'.$Id.' - '. $EMail.'</td>
      <td>'.$short.'</td>
      <td>'.$date.'</td>
      <td class="rt" >'.$IsAdmin.'</td>
      <td class="rt" >'.$CanEdit.'</td>
      <td class="rt">'.$CanLogIn.'</td>
      <td class="rt"><a href="./changeUser.php?uid='.$Id.'" class="button" >Modifier</a>
      </tr>';
     }
     
     $stmt->close();
     echo '</table>
           ';
 
     
     echo '    
               </span>
               </span>
     </body>
   </html>'; 
?>


