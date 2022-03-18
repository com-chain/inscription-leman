<?php
    ob_start();
    include 'checkUser.php';
    if (!canEdit()){
        header('Location: ./consult.php');
        exit();
    }
    include 'connectionFactory.php';
    $mysqli= ConnectionFactory::GetConnection();
        
    $pid=$_GET['id'];
    $add=$_GET['add'];
    $validation = isset($_GET['inv'])?0:1;
  
  //echo $validation.'<br/>';
  
    // insert address
    $query = 'UPDATE  Reg_Wallet SET Validated=?, valid_date=now() WHERE  address=? and PersonId=? ';       
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param("isi",$validation,$add,$pid);
    $stmt->execute();
    $stmt->close();	
    
    if($validation){
        // get data 
        $query_data = 'SELECT 
                  Reg_Person.Email,
                  Reg_Person.RecordTypeId,
	              Reg_Wallet.Currency,
	              Reg_Individual.FirstName, 
	              Reg_Individual.LastName, 
	              
	              Reg_Legal.Name,
	              Reg_Legal.Contact,
	              Reg_Legal.ContactSurname

	              FROM Reg_Person 
	                LEFT OUTER JOIN Reg_Individual on Reg_Individual.Id=Reg_Person.Id
	                LEFT OUTER JOIN Reg_Legal on Reg_Legal.Id=Reg_Person.Id
	                LEFT OUTER JOIN Reg_Wallet on Reg_Wallet.PersonId=Reg_Person.Id AND address=?
	              WHERE Reg_Person.Id = ?';            
        $stmt = $mysqli->prepare($query_data);
	    $stmt->bind_param("si",$add, $pid);
        $stmt->bind_result($mail, $type, $currency, $ind_first, $ind_last, $leg_name, $leg_c_last, $leg_c_first);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();	
        
        $full_name = "".$ind_first;
        if ($type == 1) {
            $full_name = "".$leg_name;
        }
        
        
        include 'p_mail.php';
        sendUnlockingMail($mail, $add, $full_name, $type, $currency);
        
    }

    header('Location: ./consultPerson.php?id='.$pid);
  exit();
?>
