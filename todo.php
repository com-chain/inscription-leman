<?php

include 'checkUser.php';
include 'connectionFactory.php';
$mysqli= ConnectionFactory::GetConnection();



echo'
<!DOCTYPE html>
<html>
  <head>';
include 'p_head.php';
makeHead(10);
echo'  
  </head>
<body>';


$query = 'SELECT count(*) FROM Reg_UnlockRequest'; 
$stmt = $mysqli->prepare($query);
$stmt->bind_result($dbn);
$stmt->execute();
$stmt->fetch();
$stmt->close();	


echo '
  <span class="fond"></span>
  <span class="cont">
  
  
    <a class="button" href="user.php">Mon Compte</a>';
    if (isAdmin()){
         echo'<a class="button" href="admin.php">Admin</a>';
    }
    echo'<a class="button" href="consult.php">Recherche</a>
    <a class="button" href="login.php">Logout</a><br/>';
    
    
    $query = 'SELECT count(*) FROM Reg_Code WHERE PersonId IS NULL';
    $stmt = $mysqli->prepare($query);
    $stmt->bind_result($nb);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();	
    if ($nb>0){
        echo '<h2> Codes non lié à une personne </h2><br>';
        $query = 'SELECT code, address FROM Reg_Code LEFT OUTER JOIN Reg_Wallet ON CodeId = Reg_Code.Id WHERE Reg_Code.PersonId IS NULL';
        $stmt = $mysqli->prepare($query);
        $stmt->bind_result($code,$add);
        $stmt->execute();
        echo '<table>
	    <tr><td>Code</td><td>Compte</td></tr>';
        while ($stmt->fetch()){
            echo '<tr><td>'.$code.'</td><td>'.$add.'</td></tr>';
        }
        $stmt->close();	
        echo '</table>';
         
    }
    
    
    
    $filter=$_GET['filter'];
    
    
    echo '<h2> Demandes à traiter </h2>
    <form action="todo.php"  method="get">
    <select name="filter">
        <option value="">Toutes</option>
        <option value="1" '; if ($filter==1){echo ' selected="selected"';} echo'>Adhésion à traiter</option>
        <option value="2"'; if ($filter==2){echo ' selected="selected"';} echo'>Compte à débloquer</option>
        <option value="3"'; if ($filter==3){echo ' selected="selected"';} echo'>Code Manquant</option>
    </select><br>
    <input class="button" type="submit" value="Rafraichir">
    </form> <br>
    <br>
    
    
    <table>
	    <tr><td>Type</td><td>Nom</td><td>Date</td><td>Status</td><td>Email</td><td>Membre</td><td>Compte</td><td>Actions</td></tr>
	';
    
    $query = 'SELECT 
	           Reg_Person.Id,
	           Reg_Person.Membership,
	           Reg_Person.AccountRequest,
	           Reg_RecordType.Id,
	           Reg_RecordType.Name, 
	           CONCAT(Reg_Individual.FirstName, " ", Reg_Individual.LastName), 
	           Reg_Legal.Name,
	           Reg_StatusHistory.EventDate,
	           Reg_Status.id,
	           Reg_Status.Name,
	           Email,
	           count(Reg_Code.Id),
	           min(ABS(Reg_Wallet.Validated)),
	           count(Reg_Wallet.Validated)
	          FROM Reg_Person 
	            LEFT OUTER JOIN Reg_RecordType on Reg_RecordType.Id=Reg_Person.RecordTypeId
	            LEFT OUTER JOIN Reg_Individual on Reg_Individual.Id=Reg_Person.Id
	            LEFT OUTER JOIN Reg_Legal on Reg_Legal.Id=Reg_Person.Id
	            LEFT OUTER JOIN Reg_Status on Reg_Status.Id=Reg_Person.StatusId
	            LEFT OUTER JOIN Reg_StatusHistory on Reg_StatusHistory.NewStatusId=Reg_Person.StatusId AND Reg_StatusHistory.PersonId=Reg_Person.Id
	            LEFT OUTER JOIN Reg_Code ON Reg_Code.PersonId=Reg_Person.Id
	            LEFT OUTER JOIN Reg_Wallet ON Reg_Wallet.PersonId=Reg_Person.Id

	          GROUP BY Reg_Person.Id,
	           Reg_Person.Membership,
	           Reg_Person.AccountRequest,
	           Reg_RecordType.Id,
	           Reg_RecordType.Name, Reg_Individual.FirstName,  Reg_Individual.LastName, 
	           Reg_Legal.Name,
	           Reg_StatusHistory.EventDate,
	           Reg_Status.Name,
	           Email
	          ORDER BY Reg_StatusHistory.EventDate desc, Reg_Person.Id desc';
	          
$stmt = $mysqli->prepare($query);
$stmt->bind_result($id,$member,$ac_req,$type,$typeName,$i_name,$e_name,$date,$statusid,$status,$mail,$code,$valid,$wall);
$stmt->execute();
while ($stmt->fetch()){ 
   $accept= ($ac_req==1 && $code==0) || ($wall>0 && $valid==0) || ($member=='Oui' && $statusid<2);
   if ($filter==1) {
      $accept =  ($member=='Oui' && $statusid<2);
   }
   
   if ($filter==2) {
      $accept = ($wall>0 && $valid==0);
   }
   
   if ($filter==3) {
      $accept =  ($ac_req==1 && $code==0);
   }
   
    if ($accept){
        echo '<tr><td>'.$typeName.'</td><td>';
        if ($type==1){
            echo $e_name;
        } else {
            echo $i_name;
        }
        echo'</td><td>'.$date.'</td><td>'.$status.'</td><td>'.$mail.'</td>
        <td>'.$member.'</td><td>';
         echo  $ac_req==1?'OUI':'NON';
        
        echo'</td>
        <td><a class="button" href="consultPerson.php?id='.$id.'">Consulter</a></td></tr>';
    }
}
$stmt->close();	
	echo'</table>';
	          
	          
	          
	    


    
echo '   
   </span>
</body>
</html>';
?>
