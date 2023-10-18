<?php
   ob_start();
  include 'checkUser.php';
  include 'connectionFactory.php';
  include 'downloadFile.php';
  $mysqli= ConnectionFactory::GetConnection();
  
 /*  if(!isAdmin()){ 
    header('Location: ./consult.php');
    exit();
  }*/
  
  if (isset($_GET['id'])){
        $id=(int)$_GET['id'];
        
        
        
        //collect images
        
        
$query = 'SELECT 
	          Reg_RecordType.Id,
	          Reg_RecordType.Name, 
	          Reg_Status.Id,
	          Reg_Status.Name,
	           
	          Email,
	          Phone,
  
              Address,
              AddressComplement,
              NPA,
              City,
              Country,
  
              PostalAddress,
              PostalAddressComplement,
              PostalNPA ,
              PostalCity ,
              PostalCountry ,
  
              Membership,
              AccountRequest,
              Newsletter,

              PEP,
              PEPRelated,
              
              AED,
  
              AED_1_FirstName,
              AED_1_LastName,
              AED_1_Address,
              AED_1_AddressComplement,
              AED_1_NPA,
              AED_1_City,
              AED_1_Country,
              AED_1_Citizenship,
              AED_1_BirthDate ,
              
              
              AED_2_FirstName,
              AED_2_LastName,
              AED_2_Address,
              AED_2_AddressComplement,
              AED_2_NPA,
              AED_2_City,
              AED_2_Country,
              AED_2_Citizenship,
              AED_2_BirthDate ,
              
              AED_3_FirstName,
              AED_3_LastName,
              AED_3_Address,
              AED_3_AddressComplement,
              AED_3_NPA,
              AED_3_City,
              AED_3_Country,
              AED_3_Citizenship,
              AED_3_BirthDate ,
              
              
              AED_4_FirstName,
              AED_4_LastName,
              AED_4_Address,
              AED_4_AddressComplement,
              AED_4_NPA,
              AED_4_City,
              AED_4_Country,
              AED_4_Citizenship,
              AED_4_BirthDate ,
  
	          Reg_Individual.FirstName, 
	          Reg_Individual.LastName, 
	          Reg_Individual.Gender,
              Reg_Individual.Citizenship,
              Reg_Individual.BirthDate,
              Reg_Individual.IdCard,
	          
	          Reg_Legal.Name,
	          Reg_Legal.RefName,
	          Reg_Legal.Contact,
	          Reg_Legal.ContactSurname,
	          Reg_Legal.ContactGender,
              Reg_Legal.LegalForm,
              Reg_Legal.CreationDate,
              Reg_Legal.ActivityField,
              Reg_Legal.ActivityFieldSeg,
              Reg_Legal.ActivityDescription,
              Reg_Legal.EFT,
              Reg_Legal.Website,
              
              ST_1_FirstName,
              ST_1_LastName,
              ST_1_Address,
              ST_1_AddressComplement,
              ST_1_NPA,
              ST_1_City,
              ST_1_Country,
              ST_1_Citizenship,
              ST_1_BirthDate ,
              
              
              ST_2_FirstName,
              ST_2_LastName,
              ST_2_Address,
              ST_2_AddressComplement,
              ST_2_NPA,
              ST_2_City,
              ST_2_Country,
              ST_2_Citizenship,
              ST_2_BirthDate ,
              
              ST_3_FirstName,
              ST_3_LastName,
              ST_3_Address,
              ST_3_AddressComplement,
              ST_3_NPA,
              ST_3_City,
              ST_3_Country,
              ST_3_Citizenship,
              ST_3_BirthDate ,
              
              
              ST_4_FirstName,
              ST_4_LastName,
              ST_4_Address,
              ST_4_AddressComplement,
              ST_4_NPA,
              ST_4_City,
              ST_4_Country,
              ST_4_Citizenship,
              ST_4_BirthDate ,
             
             
              Reg_Legal.IdCard_1,
              Reg_Legal.IdCard_2,
              Reg_Legal.IdCard_3,
              Reg_Legal.IdCard_4,
              Reg_Legal.IdCard_5,
              Reg_Legal.IdCard_6,
              Reg_Legal.IdCard_7,
              Reg_Legal.IdCard_8,
              Reg_Legal.IdCard_9,
              Reg_Legal.IdCard_10,
              Reg_Legal.IdCard_11,
              Reg_Legal.IdCard_12,
              Reg_Legal.FinState_1,
              Reg_Legal.FinState_2,
              Reg_Legal.FinState_3,
              Reg_Legal.Registration_1,
              Reg_Legal.Registration_2,
              Reg_Legal.Registration_3
	           
	          FROM Reg_Person 
	            LEFT OUTER JOIN Reg_RecordType on Reg_RecordType.Id=Reg_Person.RecordTypeId
	            LEFT OUTER JOIN Reg_Individual on Reg_Individual.Id=Reg_Person.Id
	            LEFT OUTER JOIN Reg_Legal on Reg_Legal.Id=Reg_Person.Id
	            LEFT OUTER JOIN Reg_Status on Reg_Status.Id=Reg_Person.StatusId
	            
	            
	          WHERE Reg_Person.Id = ?';
	          
	          
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param("i",$id);
    $stmt->bind_result($type,$typeName,$status,$statusName,$mail,$phone,
                       $address,$addressComplement,$NPA,$city,$count,
                       $p_address,$p_addressComplement,$p_NPA,$p_city,$p_country,
                       $membership ,$acc_req ,$newsletter,$PEP,$PEPRelated,$aed,
                       $AED_1_FirstName,$AED_1_LastName,$AED_1_Address,$AED_1_ComplAddress, $AED_1_ZIP, $AED_1_City, $AED_1_Country, $AED_1_Citizenship,$AED_1_BirthDate,
                       $AED_2_FirstName,$AED_2_LastName,$AED_2_Address,$AED_2_ComplAddress, $AED_2_ZIP, $AED_2_City, $AED_2_Country, $AED_2_Citizenship,$AED_2_BirthDate,
                       $AED_3_FirstName,$AED_3_LastName,$AED_3_Address,$AED_3_ComplAddress, $AED_3_ZIP, $AED_3_City, $AED_3_Country, $AED_3_Citizenship,$AED_3_BirthDate,
                       $AED_4_FirstName,$AED_4_LastName,$AED_4_Address,$AED_4_ComplAddress, $AED_4_ZIP, $AED_4_City, $AED_4_Country, $AED_4_Citizenship,$AED_4_BirthDate,
                       $FirstName,$LastName,$Gender,$Citizenship,$BirthDate,$IdCard,
                       $Name,$RefName, $Contact, $ContactSurname, $ContactGender,$LegalForm,$CreationDate,$ActivityField,$ActivityFieldSeg,$ActivityDescription,$EFT,$site,
                       
                       
                       $ST_1_FirstName,$ST_1_LastName,$ST_1_Address,$ST_1_ComplAddress, $ST_1_ZIP, $ST_1_City, $ST_1_Country, $ST_1_Citizenship,$ST_1_BirthDate,
                       $ST_2_FirstName,$ST_2_LastName,$ST_2_Address,$ST_2_ComplAddress, $ST_2_ZIP, $ST_2_City, $ST_2_Country, $ST_2_Citizenship,$ST_2_BirthDate,
                       $ST_3_FirstName,$ST_3_LastName,$ST_3_Address,$ST_3_ComplAddress, $ST_3_ZIP, $ST_3_City, $ST_3_Country, $ST_3_Citizenship,$ST_3_BirthDate,
                       $ST_4_FirstName,$ST_4_LastName,$ST_4_Address,$ST_4_ComplAddress, $ST_4_ZIP, $ST_4_City, $ST_4_Country, $ST_4_Citizenship,$ST_4_BirthDate,
                       
                       
                       
                       $IdCard_1,$IdCard_2,$IdCard_3,$IdCard_4,$IdCard_5,$IdCard_6,
                       $IdCard_7,$IdCard_8,$IdCard_9,$IdCard_10,$IdCard_11,$IdCard_12,
                       $FinState_1,$FinState_2,$FinState_3,$Registration_1,$Registration_2,$Registration_3);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();	
    
    
    
    
    // code et comptes
    
    $query = 'SELECT Code, address fROM Reg_Wallet LEFT OUTER JOIN Reg_Code ON Reg_Code.Id=Reg_Wallet.CodeId WHERE Reg_Wallet.PersonId=?';
	          
	          
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param("i",$id);
    $stmt->bind_result($code,$add);
    $stmt->execute();
    $wallets='';
    while($stmt->fetch()){
            if ($wallets!=''){
             $wallets=$wallets.', ';
            }
            $wallets=$wallets.$code.'-'.$add;
    }
    $stmt->close();
    
    $query = 'SELECT Code fROM Reg_Code  LEFT OUTER JOIN Reg_Wallet ON Reg_Code.Id=Reg_Wallet.CodeId WHERE Reg_Code.PersonId=?  and Reg_Wallet.CodeId IS NULL';
	          
	          
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param("i",$id);
    $stmt->bind_result($code);
    $stmt->execute();
    while($stmt->fetch()){
            if ($wallets!=''){
             $wallets=$wallets.', ';
            }
            $wallets=$wallets.$code;
    }
    $stmt->close();
    
    	
    
    
    
	$folder = './Data/img_'.$id.'/';
	
	$list=[$IdCard,$IdCard_1,$IdCard_2,$IdCard_3,$IdCard_4,$IdCard_5,$IdCard_6,
                       $IdCard_7,$IdCard_8,$IdCard_9,$IdCard_10,$IdCard_11,$IdCard_12,
                       $FinState_1,$FinState_2,$FinState_3,$Registration_1,$Registration_2,$Registration_3];
    // build the arxive
	$ar_name = "./out/Request_".uniqid().".tar";
    $ar = new PharData($ar_name);
	foreach($list as $file) {
	     if ($file!=''){
	        $ar->addFile($folder.$file,$file);
	     }
	}
	
    // add CSV
    $csv_name = "./out/data_".uniqid().".csv";
    $csv_data = array (
        array("Reg_RecordType.Name", "Reg_Status.Name", "Email", "Phone", "Address", "AddressComplement", "NPA", "City", "Country", "PostalAddress", "PostalAddressComplement", "PostalNPA", "PostalCity", "PostalCountry", "Membership", "AccountRequest", "Newsletter", "PEP", "PEPRelated", "AED", "AED_1_FirstName", "AED_1_LastName", "AED_1_Address", "AED_1_AddressComplement", "AED_1_NPA", "AED_1_City", "AED_1_Country", "AED_1_Citizenship", "AED_1_BirthDate", "AED_2_FirstName", "AED_2_LastName", "AED_2_Address", "AED_2_AddressComplement", "AED_2_NPA", "AED_2_City", "AED_2_Country", "AED_2_Citizenship", "AED_2_BirthDate", "AED_3_FirstName", "AED_3_LastName", "AED_3_Address", "AED_3_AddressComplement", "AED_3_NPA", "AED_3_City", "AED_3_Country", "AED_3_Citizenship", "AED_3_BirthDate", "AED_4_FirstName", "AED_4_LastName", "AED_4_Address", "AED_4_AddressComplement", "AED_4_NPA", "AED_4_City", "AED_4_Country", "AED_4_Citizenship", "AED_4_BirthDate", "Reg_Individual.FirstName", "Reg_Individual.LastName", "Reg_Individual.Gender", "Reg_Individual.Citizenship", "Reg_Individual.BirthDate", "Reg_Legal.Name", "Reg_Legal.RefName", "Reg_Legal.Contact", "Reg_Legal.ContactSurname", "Reg_Legal.ContactGender", "Reg_Legal.LegalForm", "Reg_Legal.CreationDate", "Reg_Legal.ActivityField", "Reg_Legal.ActivityFieldSeg", "Reg_Legal.ActivityDescription", "Reg_Legal.EFT", "Reg_Legal.Website", "ST_1_FirstName", "ST_1_LastName", "ST_1_Address", "ST_1_AddressComplement", "ST_1_NPA", "ST_1_City", "ST_1_Country", "ST_1_Citizenship", "ST_1_BirthDate", "ST_2_FirstName", "ST_2_LastName", "ST_2_Address", "ST_2_AddressComplement", "ST_2_NPA", "ST_2_City", "ST_2_Country", "ST_2_Citizenship", "ST_2_BirthDate", "ST_3_FirstName", "ST_3_LastName", "ST_3_Address", "ST_3_AddressComplement", "ST_3_NPA", "ST_3_City", "ST_3_Country", "ST_3_Citizenship", "ST_3_BirthDate", "ST_4_FirstName", "ST_4_LastName", "ST_4_Address", "ST_4_AddressComplement", "ST_4_NPA", "ST_4_City", "ST_4_Country", "ST_4_Citizenship", "ST_4_BirthDate","Code"),
        array($typeName,$statusName,$mail,$phone,
                       $address,$addressComplement,$NPA,$city,$count,
                       $p_address,$p_addressComplement,$p_NPA,$p_city,$p_country,
                       $membership ,$acc_req ,$newsletter,$PEP,$PEPRelated,$aed,
                       $AED_1_FirstName,$AED_1_LastName,$AED_1_Address,$AED_1_ComplAddress, $AED_1_ZIP, $AED_1_City, $AED_1_Country, $AED_1_Citizenship,$AED_1_BirthDate,
                       $AED_2_FirstName,$AED_2_LastName,$AED_2_Address,$AED_2_ComplAddress, $AED_2_ZIP, $AED_2_City, $AED_2_Country, $AED_2_Citizenship,$AED_2_BirthDate,
                       $AED_3_FirstName,$AED_3_LastName,$AED_3_Address,$AED_3_ComplAddress, $AED_3_ZIP, $AED_3_City, $AED_3_Country, $AED_3_Citizenship,$AED_3_BirthDate,
                       $AED_4_FirstName,$AED_4_LastName,$AED_4_Address,$AED_4_ComplAddress, $AED_4_ZIP, $AED_4_City, $AED_4_Country, $AED_4_Citizenship,$AED_4_BirthDate,
                       $FirstName,$LastName,$Gender,$Citizenship,$BirthDate,
                       $Name,$RefName, $Contact, $ContactSurname, $ContactGender,$LegalForm,$CreationDate,$ActivityField,$ActivityFieldSeg,$ActivityDescription,$EFT,$site,
                       
                       
                       $ST_1_FirstName,$ST_1_LastName,$ST_1_Address,$ST_1_ComplAddress, $ST_1_ZIP, $ST_1_City, $ST_1_Country, $ST_1_Citizenship,$ST_1_BirthDate,
                       $ST_2_FirstName,$ST_2_LastName,$ST_2_Address,$ST_2_ComplAddress, $ST_2_ZIP, $ST_2_City, $ST_2_Country, $ST_2_Citizenship,$ST_2_BirthDate,
                       $ST_3_FirstName,$ST_3_LastName,$ST_3_Address,$ST_3_ComplAddress, $ST_3_ZIP, $ST_3_City, $ST_3_Country, $ST_3_Citizenship,$ST_3_BirthDate,
                       $ST_4_FirstName,$ST_4_LastName,$ST_4_Address,$ST_4_ComplAddress, $ST_4_ZIP, $ST_4_City, $ST_4_Country, $ST_4_Citizenship,$ST_4_BirthDate,$wallets)
    );

    $fp = fopen($csv_name, 'w');

    foreach ($csv_data as $fields) {
        fputcsv($fp, $fields);
    }

    fclose($fp);
    
    
    $ar->addFile($csv_name,'data.csv');
    $ar->compress(Phar::GZ);
    unlink($ar_name);
    unlink($csv_name);
    $ar_name=$ar_name.".gz";

    // get the client name
    
    $Export_name = trim($FirstName.' '.$LastName.' '.$Name.' Export.tar');
 

    // stream it
    DownloadFile::download("application/octet-stream",$Export_name,$ar_name);
    //remove the temp file
    unlink($ar_name);
    
  }
  
   
?>
