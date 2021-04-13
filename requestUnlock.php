<?php
include 'connectionFactory.php';
$mysqli= ConnectionFactory::GetConnection();
header('Access-Control-Allow-Origin: *');

if (isset($_POST['address'])){

    $addr = strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $_POST['address']));
    if (strlen($addr) != 42) {
        exit();
    }

  // Check unique
  
   $query = 'SELECT count(Id)
	          FROM Reg_Wallet
	          WHERE address=? 
	           ';
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param("s",$addr);
    $stmt->bind_result($number);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();
    
    if ($number>0){
        $query = 'UPDATE TABLE Reg_Wallet
                  SET Validated=0
	              WHERE address=? 
	           ';
	    $stmt = $mysqli->prepare($query);
	    $stmt->bind_param("s",$addr);
        $stmt->execute();
        $stmt->close();
        exit();
    }
    
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
        
        $query = 'SELECT Id, PersonId
	              FROM Reg_Code
	              WHERE Code=? 
	               ';
	    $stmt = $mysqli->prepare($query);
	    $stmt->bind_param("s",$code);
        $stmt->bind_result($codeId, $pid);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();
        if (!isset($codeId ) ) {
            // code unknow
            // insert code without the person
            $query = 'INSERT INTO  Reg_Code (Code) VALUES (?)';  
	        $stmt = $mysqli->prepare($query);
	        $stmt->bind_param("s",$code);
            $stmt->execute();
            $codeId = $stmt->insert_id;
            $stmt->close();	
            
            $query = 'INSERT INTO  Reg_Wallet (address, CodeId, Validated) VALUES (?,?,0)';       
	        $stmt = $mysqli->prepare($query);
	        $stmt->bind_param("si",$addr,$codeId);
            $stmt->execute();
            $stmt->close();	
        } else {
         $query = 'INSERT INTO  Reg_Wallet (address, PersonId, CodeId, Validated) VALUES (?,?,?,0)';       
	     $stmt = $mysqli->prepare($query);
	     $stmt->bind_param("sii",$addr,$pid,$codeId);
         $stmt->execute();
         $stmt->close();	
        }
        
        
        
        
    } else {
        // No code available store as it
        $query = 'INSERT INTO  Reg_Wallet (address, Validated) VALUES (?,0)';       
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s",$addr);
        $stmt->execute();
        $stmt->close();	
    } 
 }   
     
    
             

?>
