<?php
    ob_start();
    include 'checkUser.php';
    if (!canEdit()){
        header('Location: ./consult.php');
        exit();
    }
    
    $pid=$_POST['id'];
    $origin=$_POST['o'];
    $validated=0;
    if (isset($_POST['validated'])){
        $validated=1;
    }
    
    // Check format
    $addr = strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $_POST['wallet']));
    if (strlen($addr) != 42) {
        header('Location: ./addWallet.php?id='.$pid.'&wallet='.$_POST['wallet'].'&error=1&o='.$origin);
        exit();
    }

    include 'connectionFactory.php';
    $mysqli= ConnectionFactory::GetConnection();	

  
  
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
        header('Location: ./addWallet.php?id='.$pid.'&wallet='.$_POST['wallet'].'&error=2&o='.$origin);
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
    } else {
        ////  insert without code 
        $query = 'INSERT INTO  Reg_Wallet (address, PersonId, Validated) VALUES (?,?,?)';       
	    $stmt = $mysqli->prepare($query);
	    $stmt->bind_param("sii",$addr,$pid,$validated);
        $stmt->execute();
        $stmt->close();	
        header('Location: ./consultPerson.php?id='.$pid);
        //header('Location: ./addWallet.php?id='.$pid.'&wallet='.$_POST['wallet'].'&error=3');
        exit();
    }
    
    // CHECK code belong to the right person
    if($code!=''){
        $query = 'SELECT Id, PersonId
	              FROM Reg_Code
	              WHERE Code=? 
	               ';
	    $stmt = $mysqli->prepare($query);
	    $stmt->bind_param("s",$code);
        $stmt->bind_result($codeId, $conflictingid);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();
        if ($conflictingid>0  ){
            if ($conflictingid !=$pid) {
                header('Location: ./addWallet.php?id='.$pid.'&wallet='.$_POST['wallet'].'&error=4&cid='.$codeId.'&o='.$origin);
                exit();
            } else {
                // code ok
            }
        } else {
            // insert code
            $query = 'INSERT INTO  Reg_Code (PersonId,Code) VALUES (?,?)';  
	        $stmt = $mysqli->prepare($query);
	        $stmt->bind_param("is",$pid,$code);
            $stmt->execute();
            $codeId = $stmt->insert_id;
            $stmt->close();	
        }
    }
    
    // insert address
    $query = 'INSERT INTO  Reg_Wallet (address, PersonId, CodeId, Validated) VALUES (?,?,?,?)';       
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param("siii",$addr,$pid,$codeId,$validated);
    $stmt->execute();
    $stmt->close();	

    header('Location: ./consultPerson.php?id='.$pid.'&o='.$origin);
  exit();
?>
