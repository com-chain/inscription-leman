<?php
ob_start();
include 'checkUser.php';
if (!canEdit()){
    header('Location: ./consult.php');
    exit();
}
include 'connectionFactory.php';
$mysqli= ConnectionFactory::GetConnection();

$new_status=$_GET['stat'];
$id=$_GET['id'];

$uid=getUserId();

$query = "UPDATE Reg_Person SET StatusId =? WHERE Id=?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ii",$new_status,$id);
$stmt->execute();
$stmt->close();

$query = "INSERT INTO Reg_StatusHistory (PersonId,NewStatusId,UserId,EventDate) VALUES (?,?,?,now())";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("iii",$id,$new_status,$uid);
$stmt->execute();
$stmt->close();


header('Location: ./consultPerson.php?id='.$id);

?>
