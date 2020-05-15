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
    echo'<a class="button" href="unlockRequest.php">Déblocage</a><a class="button" href="login.php">Logout</a><br/>
  
    <h2> Demandes de déblocage à traiter </h2>
    
    il y a '.$dbn.' demande(s) à traiter <a class="button" href="unlockRequest.php">Déblocage</a><br/><br/>
    
	<h2> Demandes d\'ouverture à traiter </h2>
	
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
	           Reg_Status.Name,
	           Email
	          FROM Reg_Person 
	            LEFT OUTER JOIN Reg_RecordType on Reg_RecordType.Id=Reg_Person.RecordTypeId
	            LEFT OUTER JOIN Reg_Individual on Reg_Individual.Id=Reg_Person.Id
	            LEFT OUTER JOIN Reg_Legal on Reg_Legal.Id=Reg_Person.Id
	            LEFT OUTER JOIN Reg_Status on Reg_Status.Id=Reg_Person.StatusId
	            LEFT OUTER JOIN Reg_StatusHistory on Reg_StatusHistory.NewStatusId=Reg_Person.StatusId AND Reg_StatusHistory.PersonId=Reg_Person.Id
	            
	          WHERE Reg_Person.StatusId = 1 ORDER BY Reg_StatusHistory.EventDate desc, Reg_Person.Id desc';
	          
	          
	$stmt = $mysqli->prepare($query);
$stmt->bind_result($id,$member,$ac_req,$type,$typeName,$i_name,$e_name,$date,$status,$mail);
$stmt->execute();
while ($stmt->fetch()){ 
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
$stmt->close();	
	echo'</table>';
	
	echo'<h2> Demandes d\'ouverture en attente </h2>
	
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
	           Reg_Status.Name,
	           Email
	          FROM Reg_Person 
	            LEFT OUTER JOIN Reg_RecordType on Reg_RecordType.Id=Reg_Person.RecordTypeId
	            LEFT OUTER JOIN Reg_Individual on Reg_Individual.Id=Reg_Person.Id
	            LEFT OUTER JOIN Reg_Legal on Reg_Legal.Id=Reg_Person.Id
	            LEFT OUTER JOIN Reg_Status on Reg_Status.Id=Reg_Person.StatusId
	            LEFT OUTER JOIN Reg_StatusHistory on Reg_StatusHistory.NewStatusId=Reg_Person.StatusId AND Reg_StatusHistory.PersonId=Reg_Person.Id
	            
	          WHERE Reg_Person.StatusId = 2 ORDER BY Reg_StatusHistory.EventDate desc, Reg_Person.Id desc';
	          
	          
	$stmt = $mysqli->prepare($query);
$stmt->bind_result($id,$member,$ac_req,$type,$typeName,$i_name,$e_name,$date,$status,$mail);
$stmt->execute();
while ($stmt->fetch()){ 
    echo '<tr><td>'.$typeName.'</td><td>';
    if ($type==1){
        echo $e_name;
    } else {
        echo $i_name;
    }
    echo'</td><td>'.$date.'</td><td>'.$status.'</td><td>'.$mail.'</td>
    <td>'.$member.'</td><td>';
     echo  $ac_req==1?'OUI':'NON';
    
    echo'<td><a class="button" href="consultPerson.php?id='.$id.'">Consulter</a></td></tr>';
}
$stmt->close();	
	echo'</table>';
	
	echo'<h2> Demandes d\'ouverture complétées </h2>
	
	<table>
	    <tr><td>Type</td><td>Nom</td><td>Date</td><td>Status</td><td>Email</td><td>Membre</td><td>Compte</td><td>Action</td></tr>
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
	           Reg_Status.Name,
	           Email
	          FROM Reg_Person 
	            LEFT OUTER JOIN Reg_RecordType on Reg_RecordType.Id=Reg_Person.RecordTypeId
	            LEFT OUTER JOIN Reg_Individual on Reg_Individual.Id=Reg_Person.Id
	            LEFT OUTER JOIN Reg_Legal on Reg_Legal.Id=Reg_Person.Id
	            LEFT OUTER JOIN Reg_Status on Reg_Status.Id=Reg_Person.StatusId
	            LEFT OUTER JOIN Reg_StatusHistory on Reg_StatusHistory.NewStatusId=Reg_Person.StatusId AND Reg_StatusHistory.PersonId=Reg_Person.Id
	            
	          WHERE Reg_Person.StatusId = 3 ORDER BY Reg_StatusHistory.EventDate desc, Reg_Person.Id desc';
	          
	          
	$stmt = $mysqli->prepare($query);
$stmt->bind_result($id,$member,$ac_req,$type,$typeName,$i_name,$e_name,$date,$status,$mail);
$stmt->execute();
while ($stmt->fetch()){ 
    echo '<tr><td>'.$typeName.'</td><td>';
    if ($type==1){
        echo $e_name;
    } else {
        echo $i_name;
    }
    echo'</td><td>'.$date.'</td><td>'.$status.'</td><td>'.$mail.'</td>
    <td>'.$member.'</td><td>';
     echo  $ac_req==1?'OUI':'NON';
    
    echo'<td><a class="button" href="consultPerson.php?id='.$id.'">Consulter</a></td></tr>';
}
$stmt->close();	
	echo'</table>';
	
	echo'<h2> Demandes d\'ouverture refusées </h2>
	
	<table>
	    <tr><td>Type</td><td>Nom</td><td>Date</td><td>Status</td><td>Email</td><td>Membre</td><td>Compte</td><td>Action</td></tr>
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
	           Reg_Status.Name,
	           Email
	          FROM Reg_Person 
	            LEFT OUTER JOIN Reg_RecordType on Reg_RecordType.Id=Reg_Person.RecordTypeId
	            LEFT OUTER JOIN Reg_Individual on Reg_Individual.Id=Reg_Person.Id
	            LEFT OUTER JOIN Reg_Legal on Reg_Legal.Id=Reg_Person.Id
	            LEFT OUTER JOIN Reg_Status on Reg_Status.Id=Reg_Person.StatusId
	            LEFT OUTER JOIN Reg_StatusHistory on Reg_StatusHistory.NewStatusId=Reg_Person.StatusId AND Reg_StatusHistory.PersonId=Reg_Person.Id
	            
	          WHERE Reg_Person.StatusId = 100 ORDER BY Reg_StatusHistory.EventDate desc, Reg_Person.Id desc';
	          
	          
	$stmt = $mysqli->prepare($query);
$stmt->bind_result($id,$member,$ac_req,$type,$typeName,$i_name,$e_name,$date,$status,$mail);
$stmt->execute();
while ($stmt->fetch()){ 
    echo '<tr><td>'.$typeName.'</td><td>';
    if ($type==1){
        echo $e_name;
    } else {
        echo $i_name;
    }
    echo'</td><td>'.$date.'</td><td>'.$status.'</td><td>'.$mail.'</td>
    <td>'.$member.'</td><td>';
     echo  $ac_req==1?'OUI':'NON';
    
    echo'<td><a class="button" href="consultPerson.php?id='.$id.'">Consulter</a></td></tr>';
}
$stmt->close();	
	echo'</table>';

      


    
echo '   
   </span>
</body>
</html>';
?>
