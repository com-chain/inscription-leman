<?php

ob_start();
include 'checkUser.php';
if (!canEdit()){
    header('Location: ./unlockRequest.php');
    exit();
}
include 'connectionFactory.php';
$mysqli= ConnectionFactory::GetConnection();

if(isset($_GET['id'])){
 
    $id=$_GET['id'];
    
    $stmt = $mysqli->prepare("DELETE FROM Reg_UnlockRequest WHERE Id=?" );
	$stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();	
    
    
}
header('Location: ./unlockRequest.php');
?>
