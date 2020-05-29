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

if ($new_status<1000) {

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
} else if ($new_status==1000) {
    $query = "DELETE FROM Reg_Wallet WHERE PersonId=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();
    
    $query = "DELETE FROM Reg_Code WHERE PersonId=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();
    
     $query = "DELETE FROM Reg_StatusHistory WHERE PersonId=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close(); 
    
    $query = "DELETE FROM Reg_Individual WHERE Id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();
    
    $query = "DELETE FROM Reg_Legal WHERE Id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();
    
    $query = "DELETE FROM Reg_Person WHERE Id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();
    
    $folder = './Data/img_'.$id;
    array_map('unlink', glob("$folder/*.*"));
    rmdir($folder);
    
    header('Location: ./consult.php');
}

?>
