<?php
include 'connectionFactory.php';
$mysqli= ConnectionFactory::GetConnection();

if (isset($_POST['address'])){
    $query = "INSERT INTO Reg_UnlockRequest (address, EventDate ) VALUES (?,now())";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s",$_POST['address']); 
    $stmt->execute();
    $stmt->close();	
}             

/* debug
if (isset($_GET['address'])){
    $query = "INSERT INTO Reg_UnlockRequest (address, EventDate) VALUES (?,now())";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s",$_GET['address']); 
    $stmt->execute();
    $stmt->close();	
} */
?>
