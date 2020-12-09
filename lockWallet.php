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
  
    // insert address
    $query = 'UPDATE  Reg_Wallet SET Validated=-1, valid_date=now() WHERE  address=? and PersonId=? ';       
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param("si",$add,$pid);
    $stmt->execute();
    $stmt->close();	

    header('Location: ./consultPerson.php?id='.$pid);
  exit();
?>
