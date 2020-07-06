<?php
    ob_start();
    include 'checkUser.php';
    if (!canEdit()){
        header('Location: ./consult.php');
        exit();
    }

  include 'connectionFactory.php';
  $mysqli= ConnectionFactory::GetConnection();	
  
  $pid=$_POST['id'];
  $ct=$_POST['ct'];
  $code=$_POST['code'];
  $lc=$_POST['lc'];
  $gen=$_POST['gen'];
  $cid=$_POST['cid'];
  
   if (isset($cid) && $cid>0){
     $query = 'DELETE FROM Reg_Code WHERE PersonId=? AND Id=?';
	 $stmt = $mysqli->prepare($query);
     $stmt->bind_param("ii",$pid,$cid);
     $stmt->execute();
     $stmt->close();
  } else if ($ct!='Link'){
    if ($ct=='Gen'){
       $code=$gen;
    } 
    
    // Check unique
  
   $query = 'SELECT PersonId
	          FROM Reg_Code
	          WHERE Code=? 
	           ';
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param("s",$code);
    $stmt->bind_result($conflictingid);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();
    if ($conflictingid>0 || strlen($code)!=32){
        header('Location: ./addCode.php?id='.$pid.'&code='.$code);
        exit();
    }
    
    
   $query = 'INSERT INTO  Reg_Code (PersonId,Code) VALUES (?,?)';
	          
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param("is",$pid,$code);
    $stmt->execute();
    $stmt->close();	
  
  }  else {
    if ($lc<0){
        header('Location: ./addCode.php?id='.$pid.'&code='.$lc);
        exit();
    }
    
     $query = 'UPDATE Reg_Code SET PersonId=? Where Id=?';
	 $stmt = $mysqli->prepare($query);
     $stmt->bind_param("ii",$pid,$lc);
     $stmt->execute();
     $stmt->close();
     
     $query = 'UPDATE Reg_Wallet SET PersonId=? Where CodeId=?';
	 $stmt = $mysqli->prepare($query);
     $stmt->bind_param("ii",$pid,$lc);
     $stmt->execute();
     $stmt->close();
	        
    
  } 
  
  
  
  

  header('Location: ./consultPerson.php?id='.$pid);
  exit();
?>
