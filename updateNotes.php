<?php

ob_start();
include 'checkUser.php';
if (!canEdit()){
    header('Location: ./consult.php');
    exit();
}
include 'connectionFactory.php';
$mysqli= ConnectionFactory::GetConnection();

$id=$_GET['id'];
$origin=$_GET['o'];
$note=$_GET['note'];


$query = 'UPDATE Reg_Person SET Notes = ?   WHERE Reg_Person.Id = ?';
$stmt = $mysqli->prepare($query);
$stmt->bind_param("si",$note,$id);
$stmt->execute();
$stmt->close();	
header('Location: ./consultPerson.php?id='.$id.'&o='.$origin);

 
?>
