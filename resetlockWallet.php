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
    $origin=$_GET['o'];
    $add=$_GET['add'];
  
    // insert address
    $query = 'UPDATE  Reg_Wallet SET Validated=0, valid_date=NULL WHERE  address=? and PersonId=? ';       
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param("si",$add,$pid);
    $stmt->execute();
    $stmt->close();	

    header('Location: ./consultPerson.php?id='.$pid.'&o='.$origin);
  exit();
?>
