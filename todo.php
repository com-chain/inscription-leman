<?php

include 'checkUser.php';
include 'connectionFactory.php';
$mysqli= ConnectionFactory::GetConnection();


// Check addresses without link

 $query = 'SELECT Id, address
	          FROM Reg_Wallet
	          WHERE PersonId IS NULL and  CodeId IS NULL';
	$stmt = $mysqli->prepare($query);
    $stmt->bind_result($add_id, $addr);
    $stmt->execute();
    $add_without_code =0;
    $add_without_code_l = []; 
    
    $to_add_addr=[];
    $to_add_code=[];
    while ($stmt->fetch()) {
           // get code
            $code='';
            $codeId='';
            $url = "https://node-001.cchosting.org/specific/MLGetCode.php";
                    $data = array('server' => 'Monnaie-Leman', 'addresses'=>$addr);
                    $options = array(
                    'http' => array(
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method'  => 'POST',
                        'content' => http_build_query($data)
            ));
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);

            $res = json_decode($result);
            if ($result !== FALSE && $result!='KO' && isset($res->$addr)) {
                
                $code = $res->$addr;
                $to_add_addr[]=$addr;
                $to_add_code[]= $code; 
            } else { 
                // no code found...
                $add_without_code+=1;
                $add_without_code_l[] = $addr;
            }
    }
    
    $stmt->close(); 
    
    
    for ($index=0; $index<count($to_add_addr); $index++) {
      $code = $to_add_code[$index];
      $addr =   $to_add_addr[$index];
      $query = 'SELECT Id, PersonId
	                      FROM Reg_Code
	                      WHERE Code=? 
	                       ';
	$stmt2 = $mysqli->prepare($query);
	$stmt2->bind_param("s",$code);
	$stmt2->bind_result($codeId, $pid);
	$stmt2->execute();
	$stmt2->fetch();
	$stmt2->close();
	if (!isset($codeId ) ) {
		// code unknow
		// insert code without the person
		$query = 'INSERT INTO  Reg_Code (Code) VALUES (?)';  
		$stmt2 = $mysqli->prepare($query);
		$stmt2->bind_param("s",$code);
		$stmt2->execute();
		$codeId = $stmt2->insert_id;
		$stmt2->close();	

		$query = 'INSERT INTO  Reg_Wallet (address, CodeId, Validated) VALUES (?,?,0)';       
		$stmt2 = $mysqli->prepare($query);
		$stmt2->bind_param("si",$addr,$codeId);
		$stmt2->execute();
		$stmt2->close();	
	} else {
		$query = 'INSERT INTO  Reg_Wallet (address, PersonId, CodeId, Validated) VALUES (?,?,?,0)';       
		$stmt2 = $mysqli->prepare($query);
		$stmt2->bind_param("sii",$addr,$pid,$codeId);
		$stmt2->execute();
		$stmt2->close();	
	} 
   }


////


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
    
    if ($add_without_code>0) {
        echo '<h2> Il y a '.$add_without_code.' adresses sans code et non liées en DB</h2><br>';
        foreach ($add_without_code_l as $add_non_lie) {
           echo $add_non_lie.'<br/>';
        } 
    }
    
    
    
    $filter=$_GET['filter'];
    if (!isset($filter)) {
        $filter=1;
    }
    
    
    echo '<h2> Demandes à traiter </h2>
    <form action="todo.php"  method="get">
    <select name="filter">
        <option value="1" '; if ($filter==1){echo ' selected="selected"';} echo'>Compte demandé</option>
        <option value="2" '; if ($filter==2){echo ' selected="selected"';} echo'>Adhésion simple</option>
        <option value="3"'; if ($filter==3){echo ' selected="selected"';} echo'>Compte à débloquer</option>
        <option value="4"'; if ($filter==4){echo ' selected="selected"';} echo'>Code Manquant</option>
        <option value="0">Tout</option>
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
	           Reg_SiteUser.Short,
	           Reg_Person.Email,
	           count(Reg_Code.Id),
	           min(ABS(Reg_Wallet.Validated)),
	           count(Reg_Wallet.Validated)
	          FROM Reg_Person 
	            LEFT OUTER JOIN Reg_RecordType on Reg_RecordType.Id=Reg_Person.RecordTypeId
	            LEFT OUTER JOIN Reg_Individual on Reg_Individual.Id=Reg_Person.Id
	            LEFT OUTER JOIN Reg_Legal on Reg_Legal.Id=Reg_Person.Id
	            LEFT OUTER JOIN Reg_Status on Reg_Status.Id=Reg_Person.StatusId
	            LEFT OUTER JOIN Reg_StatusHistory on Reg_StatusHistory.NewStatusId=Reg_Person.StatusId AND Reg_StatusHistory.PersonId=Reg_Person.Id
	            LEFT OUTER JOIN Reg_SiteUser on Reg_StatusHistory.UserId = Reg_SiteUser.Id
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
	           Reg_SiteUser.Short,
	           Reg_Person.Email
	          ORDER BY Reg_StatusHistory.EventDate desc, Reg_Person.Id desc';
	          
$stmt = $mysqli->prepare($query);
echo $mysqli->error;
$stmt->bind_result($id,$member,$ac_req,$type,$typeName,$i_name,$e_name,$date,$statusid,$status,$user,$mail,$code,$valid,$wall);
$stmt->execute();
while ($stmt->fetch()){ 
   $accept= true;// ($ac_req==1 && $code==0) || ($wall>0 && $valid==0) || ($member=='Oui' && $statusid<2);
   if ($filter==1) {
      $accept =  $ac_req==1 && $statusid<2;
   }
   
   if ($filter==2) {
      $accept =  ($member=='Oui' && $statusid<2 && $ac_req==0);
   }
   
   if ($filter==3) {
      $accept = ($wall>0 && $valid==0);
   }
   
   if ($filter==4) {
      $accept =  ($ac_req==1 && $code==0);
   }
   
   
    if ($accept){
        echo '<tr><td>'.$typeName.'</td><td>';
        if ($type==1){
            echo $e_name;
        } else {
            echo $i_name;
        }
        echo'</td><td>'.$date.'</td><td>'.$status;
        if (isset($user)) {
            echo '<br/>('.$user.')';
        }
        echo'</td><td>'.$mail.'</td>
        <td>'.$member.'</td><td>';
         echo  $ac_req==1?'OUI':'NON';
        
        echo'</td>
        <td><a class="button" href="consultPerson.php?id='.$id.'&o=0_'.$filter.'">Consulter</a></td></tr>';
    }
}
$stmt->close();	
	echo'</table>';
	          
	          
	          
	    


    
echo '   
   </span>
</body>
</html>';
?>
