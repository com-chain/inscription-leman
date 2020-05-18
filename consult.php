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

$tp = $_POST['tp'];
$st = $_POST['st'];
$name = $_POST['name'];


echo '
  <span class="fond"></span>
  <span class="cont">
  
  
    <a class="button" href="user.php">Mon Compte</a>';
    if (isAdmin()){
         echo'<a class="button" href="admin.php">Admin</a>';
    }
    echo'<a class="button" href="todo.php">A traiter</a><a class="button" href="login.php">Logout</a><br/>';
  
  
    echo'<h2> Critères de recherche </h2>
    <form action="./consult.php" method="post">
    
    <span class="fitem">
	   <span class="label" >Restrindre au type:</span>
	    <select  class="inputText" name="tp" >
	    <option value ="0">--</option>
	    <option value ="1"';
	    if ($tp==1) {echo ' selected="selected" ';}
	    echo '>Entreprise</option>
	    <option value ="2"';
	    if ($tp==2) {echo ' selected="selected" ';}
	    echo '>Personne</option>
	   </select><br/>
	 </span>
	 <span class="fitem">
	   <span class="label" >Restrindre au status:</span>
	    <select  class="inputText" name="st" >
	    <option value ="0">--</option>
	    <option value ="1" ';
	    if ($st==1) {echo ' selected="selected" ';}
	    echo '>Soumis</option>
	    <option value ="2"';
	    if ($st==2) {echo ' selected="selected" ';}
	    echo '>Demande de Complément</option>
	    <option value ="3"';
	    if ($st==3) {echo ' selected="selected" ';}
	    echo '>Accepté</option>
	    <option value ="100"';
	    if ($st==100) {echo ' selected="selected" ';}
	    echo '>Refusé</option>
	   </select><br/>
	 </span>
	 <span class="fitem">
	   <span class="label" id="lb_name">Nom (personne / entreprise)</span>
	   <input class="inputText"  type="text" id ="name" name="name" value="'.$name.'" placeholder="nom à chercher" /><br/>
	 </span>
	   <input class="button"  type="submit"  value="Chercher"  /><br/>
	</form>
	 ';
  
  
  if ((isset($tp) && $tp>0) || (isset($st) && $st>0) || (isset($name) && $name!='')){
  
	echo'<h2> Demandes d\'ouverture / d\'adhésion </h2>
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
	            
	          WHERE ';
	          
	  $first=true;
	  if (isset($tp) && $tp>0){
	    $query =$query . ' Reg_Person.RecordTypeId='.$tp;
	    $first=false;
	  }
	  
	  if (isset($st) && $st>0){
	    if (!$first){
	       $query =$query . ' AND ';
	    }
	    $query =$query . ' Reg_Person.StatusId='.$st;
	    $first=false;
	  }
	  
	  if (isset($name) && $name!=''){
	    if (!$first){
	       $query =$query . ' AND ';
	    }
	    $query =$query . " (Reg_Legal.Name LIKE '%".$name."%' OR Reg_Individual.FirstName LIKE '%".$name."%' OR Reg_Individual.LastName LIKE '%".$name."%' )";
	    
	  }
	   
	  $query =$query .' ORDER BY Reg_StatusHistory.EventDate desc, Reg_Person.Id desc';      
	          
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
	
  }
	
	
	



    
echo '   
   </span>
</body>
</html>';
?>
