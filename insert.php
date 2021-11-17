<?php
   ob_start();
  include 'checkUser.php';
  include 'connectionFactory.php';
  $mysqli= ConnectionFactory::GetConnection();
  
  $file_name = "./2021_export_ML_InterfaceADMIN_export_data_RECOVERY_02-05.03.csv"; 
  
  $handle = fopen($file_name, "r");
  
function formatDate($text) {
    if (strlen($text)==0) {
        return NULL;
    } else {
         $pp = explode(".", $text);
         return $pp[2].'-'.$pp[1].'-'.$pp[0];
    }
}
  
  
  if ($handle) {
    for ($i = 0; $row = fgetcsv($handle ); ++$i) {
        if ($i>0) {
            $id = 1000+$row[0] ;
            /*
            
            $RecordTypeId = $row[1]=="Entreprise"?1:2;
            $Reg_Status = 1;
            if ($row[2]=='Demande de Complément') {
                $Reg_Status = 2;
            } else if ($row[2]=='Accepté') {
                $Reg_Status = 3;
            }
            $Email = $row[3];
            $Phone = $row[4];
            $Address = $row[5];
            $AddressComplement = $row[6];
            $npa = $row[7];
            $city = $row[8];
            $country = $row[9];
            
            $PostalAddress = $row[10];
            $PostalAddressComplement = $row[11];
            $PostalNPA = $row[12];
            $PostalCity = $row[13];
            $PostalCountry = $row[14];
            
            $Membership = $row[15];
            $AccountRequest = $row[16];
            $Newsletter = $row[17];
            
            $pep = $row[18];
            $peprelated = $row[19]; 
            
            $AED = $row[20];
            
            $AED_1_FirstName = $row[21];
            $AED_1_LastName = $row[22];
            $AED_1_Address = $row[23];
            $AED_1_AddressComplement = $row[24];
            $AED_1_NPA = $row[25];
            $AED_1_City = $row[26];
            $AED_1_Country = $row[27];
            $AED_1_Citizenship = $row[28];
            $AED_1_BirthDate = formatDate($row[29]);
  
  
            $AED_2_FirstName = $row[30];
            $AED_2_LastName = $row[31];
            $AED_2_Address = $row[32];
            $AED_2_AddressComplement = $row[33];
            $AED_2_NPA = $row[34];
            $AED_2_City = $row[35];
            $AED_2_Country = $row[36];
            $AED_2_Citizenship = $row[37];
            $AED_2_BirthDate= formatDate($row[38]);
  
            $AED_3_FirstName = $row[39];
            $AED_3_LastName = $row[40];
            $AED_3_Address = $row[41];
            $AED_3_AddressComplement = $row[42];
            $AED_3_NPA = $row[43];
            $AED_3_City = $row[44];
            $AED_3_Country = $row[45];
            $AED_3_Citizenship = $row[46];
            $AED_3_BirthDate  = formatDate($row[47]);
  
  
            $AED_4_FirstName = $row[48];
            $AED_4_LastName = $row[49];
            $AED_4_Address = $row[50];
            $AED_4_AddressComplement = $row[51];
            $AED_4_NPA = $row[52];
            $AED_4_City = $row[53];
            $AED_4_Country = $row[54];
            $AED_4_Citizenship = $row[55];
            $AED_4_BirthDate = formatDate($row[56]);
            
            if (strlen($AED_1_BirthDate)>0) {
            
           $query = 'INSERT INTO Reg_Person (
Id, 
RecordTypeId,
StatusId,
Email,
Phone,
  
  Address ,
  AddressComplement ,
  NPA  ,
  City  ,
  Country ,
  
  PostalAddress,
  PostalAddressComplement,
  PostalNPA,
  PostalCity,
  PostalCountry ,
  
  
  Membership,
  AccountRequest,
  Newsletter,
  
  
  PEP,
  PEPRelated ,
  
  AED,
  
  AED_1_FirstName,
  AED_1_LastName,
  AED_1_Address,
  AED_1_AddressComplement,
  AED_1_NPA,
  AED_1_City,
  AED_1_Country,
  AED_1_Citizenship,
  AED_1_BirthDate,
  
  
  AED_2_FirstName,
  AED_2_LastName,
  AED_2_Address,
  AED_2_AddressComplement ,
  AED_2_NPA,
  AED_2_City,
  AED_2_Country,
  AED_2_Citizenship,
  AED_2_BirthDate,
  
  AED_3_FirstName,
  AED_3_LastName ,
  AED_3_Address  ,
  AED_3_AddressComplement,
  AED_3_NPA ,
  AED_3_City,
  AED_3_Country,
  AED_3_Citizenship ,
  AED_3_BirthDate  ,
  
  
  AED_4_FirstName,
  AED_4_LastName,
  AED_4_Address,
  AED_4_AddressComplement,
  AED_4_NPA,
  AED_4_City,
  AED_4_Country,
  AED_4_Citizenship,
  AED_4_BirthDate,
  DataUsage) 
  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,1)';
	         
	          
	          
	        $stmt = $mysqli->prepare($query);
	       

	        $stmt->bind_param("iiisssssssssssssiisssssssssssssssssssssssssssssssssssssss",
	        $id, 
	        $RecordTypeId,
            $Reg_Status,
            $Email,
            $Phone,
            $Address,
            $AddressComplement,
            $npa,
            $city,
            $country,            
            $PostalAddress,
            $PostalAddressComplement,
            $PostalNPA,
            $PostalCity,
            $PostalCountry,
            $Membership,
            $AccountRequest,
            $Newsletter,
            $pep,
            $peprelated,
            $AED,
            $AED_1_FirstName,
            $AED_1_LastName,
            $AED_1_Address,
            $AED_1_AddressComplement,
            $AED_1_NPA,
            $AED_1_City,
            $AED_1_Country,
            $AED_1_Citizenship,
            $AED_1_BirthDate,
            $AED_2_FirstName,
            $AED_2_LastName,
            $AED_2_Address,
            $AED_2_AddressComplement,
            $AED_2_NPA,
            $AED_2_City,
            $AED_2_Country,
            $AED_2_Citizenship,
            $AED_2_BirthDate,
            $AED_3_FirstName,
            $AED_3_LastName,
            $AED_3_Address,
            $AED_3_AddressComplement,
            $AED_3_NPA,
            $AED_3_City,
            $AED_3_Country,
            $AED_3_Citizenship,
            $AED_3_BirthDate,
            $AED_4_FirstName,
            $AED_4_LastName,
            $AED_4_Address,
            $AED_4_AddressComplement,
            $AED_4_NPA,
            $AED_4_City,
            $AED_4_Country,
            $AED_4_Citizenship,
            $AED_4_BirthDate);
            //$stmt->execute();
            echo  $mysqli -> error;
            $stmt->close();	
            
            
      }  
  
       if ($RecordTypeId == 2) {*/
         /*   $Ind_FirstName = $row[57];
            $Ind_LastName = $row[58];
            $Ind_Gender = $row[59];
            $Ind_Citizenship = $row[60];
            $Ind_BirthDate = $row[61];
            
            $query = 'INSERT INTO Reg_Individual ( 
                        Id,
                        FirstName,
                        LastName,
                        Gender,
                        Citizenship,
                        BirthDate)
                      VALUES (?,?,?,?,?,?)';
           $stmt = $mysqli->prepare($query);
	       $stmt->bind_param("isssss", $id, $Ind_FirstName, $Ind_LastName, $Ind_Gender, $Ind_Citizenship, $Ind_BirthDate);
           $stmt->execute();
            echo  $mysqli -> error;
           $stmt->close();	*/
        /*   
        } else {
           $Leg_Name = $row[62];
           $Leg_refName = $row[63];
           $Leg_contact = $row[64];
           $Leg_contactSurname = $row[65];
           $Leg_contactGender = $row[66];
           $Leg_legalform = $row[67];
           $Leg_creation = formatDate($row[68]);
           $Leg_activityField = $row[69];
           $Leg_activityFieldSeg = $row[70];
           $Leg_activitydescr = $row[71];
           $Leg_eft = $row[72];
           $Leg_site = $row[73];
           
           $leg_ST_1_FirstName = $row[74];
           $leg_ST_1_LastName = $row[75];
           $leg_ST_1_Address = $row[76];
           $leg_ST_1_AddressCompl = $row[77];
           $leg_ST_1_NPA = $row[78];
           $leg_ST_1_City = $row[79];
           $leg_ST_1_Country = $row[80];
           $leg_ST_1_Citizenship = $row[81];
           $leg_ST_1_BirthDate = formatDate($row[82]);
        
           $leg_ST_2_FirstName = $row[83];
           $leg_ST_2_LastName = $row[84];
           $leg_ST_2_Address = $row[85];
           $leg_ST_2_AddressCompl = $row[86];
           $leg_ST_2_NPA = $row[87];
           $leg_ST_2_City = $row[88];
           $leg_ST_2_Country = $row[89];
           $leg_ST_2_Citizenship = $row[90];
           $leg_ST_2_BirthDate = formatDate($row[91]);
           
           $leg_ST_3_FirstName = $row[92];
           $leg_ST_3_LastName = $row[93];
           $leg_ST_3_Address = $row[94];
           $leg_ST_3_AddressCompl = $row[95];
           $leg_ST_3_NPA = $row[96];
           $leg_ST_3_City = $row[97];
           $leg_ST_3_Country = $row[98];
           $leg_ST_3_Citizenship = $row[99];
           $leg_ST_3_BirthDate = formatDate($row[100]);
           
           $leg_ST_4_FirstName = $row[101];
           $leg_ST_4_LastName = $row[102];
           $leg_ST_4_Address = $row[103];
           $leg_ST_4_AddressCompl = $row[104];
           $leg_ST_4_NPA = $row[105];
           $leg_ST_4_City = $row[106];
           $leg_ST_4_Country = $row[107];
           $leg_ST_4_Citizenship = $row[108];
           $leg_ST_4_BirthDate = formatDate($row[109]);
           
           if (strlen($leg_ST_1_BirthDate)>0) {
           
           $query = 'INSERT INTO Reg_Legal ( 
                      Id,
                      Name ,
                      RefName,
                      Contact,
                      ContactSurname ,
                      ContactGender,
                      LegalForm,
                      CreationDate,
                      ActivityField,
                      ActivityFieldSeg,
                      ActivityDescription,
                      EFT ,
                      Website,
                      
                      ST_1_FirstName,
                      ST_1_LastName,
                      ST_1_Address,
                      ST_1_AddressComplement,
                      ST_1_NPA,
                      ST_1_City,
                      ST_1_Country,
                      ST_1_Citizenship,
                      ST_1_BirthDate, 
                                           
                      ST_2_FirstName,
                      ST_2_LastName,
                      ST_2_Address,
                      ST_2_AddressComplement,
                      ST_2_NPA,
                      ST_2_City,
                      ST_2_Country,
                      ST_2_Citizenship,
                      ST_2_BirthDate,
                                            
                      ST_3_FirstName,
                      ST_3_LastName,
                      ST_3_Address,
                      ST_3_AddressComplement,
                      ST_3_NPA,
                      ST_3_City,
                      ST_3_Country,
                      ST_3_Citizenship,
                      ST_3_BirthDate,
                                            
                      ST_4_FirstName,
                      ST_4_LastName,
                      ST_4_Address,
                      ST_4_AddressComplement,
                      ST_4_NPA,
                      ST_4_City,
                      ST_4_Country,
                      ST_4_Citizenship,
                      ST_4_BirthDate
  )
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                      ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
           $stmt = $mysqli->prepare($query);
	       $stmt->bind_param("issssssssssdsssssssssssssssssssssssssssssssssssss", 
	               $id, 
	               $Leg_Name,
                   $Leg_refName,
                   $Leg_contact,
                   $Leg_contactSurname,
                   $Leg_contactGender,
                   $Leg_legalform,
                   $Leg_creation,
                   $Leg_activityField ,
                   $Leg_activityFieldSeg ,
                   $Leg_activitydescr,
                   $Leg_eft,
                   $Leg_site,
                   $leg_ST_1_FirstName,
                   $leg_ST_1_LastName,
                   $leg_ST_1_Address,
                   $leg_ST_1_AddressCompl,
                   $leg_ST_1_NPA ,
                   $leg_ST_1_City ,
                   $leg_ST_1_Country ,
                   $leg_ST_1_Citizenship,
                   $leg_ST_1_BirthDate ,
                   $leg_ST_2_FirstName ,
                   $leg_ST_2_LastName ,
                   $leg_ST_2_Address ,
                   $leg_ST_2_AddressCompl ,
                   $leg_ST_2_NPA,
                   $leg_ST_2_City ,
                   $leg_ST_2_Country ,
                   $leg_ST_2_Citizenship ,
                   $leg_ST_2_BirthDate ,
                   $leg_ST_3_FirstName ,
                   $leg_ST_3_LastName ,
                   $leg_ST_3_Address ,
                   $leg_ST_3_AddressCompl ,
                   $leg_ST_3_NPA ,
                   $leg_ST_3_City ,
                   $leg_ST_3_Country,
                   $leg_ST_3_Citizenship,
                   $leg_ST_3_BirthDate,
                   $leg_ST_4_FirstName,
                   $leg_ST_4_LastName ,
                   $leg_ST_4_Address ,
                   $leg_ST_4_AddressCompl ,
                   $leg_ST_4_NPA,
                   $leg_ST_4_City ,
                   $leg_ST_4_Country ,
                   $leg_ST_4_Citizenship ,
                   $leg_ST_4_BirthDate         
	       );
           $stmt->execute();
            echo  $mysqli -> error;
           $stmt->close();	
        }
        }
        */
         $comptes = $row[110];
         echo '<div> <h2> Internal Id '.$id.'</h2>
                      Raw info = '.$comptes.'<br/>
         ';
         
         $pieces = explode(",", $comptes);
         foreach ($pieces as &$piece) {
            $piece=trim($piece);
            echo ' Processing:'.$piece.':<br/>';  
            if (strpos($piece, '(') === 0) {
               $linked_code = trim(trim($piece, '('), ')');
               
              // echo ' starts with (  => isolated code '. $linked_code.' ';
               unset($stored_code_id_1);
               $query = 'SELECT Id, PersonId FROM Reg_Code WHERE Code=?';
               $stmt = $mysqli->prepare($query);
               $stmt->bind_param("s",$linked_code);
               $stmt->bind_result($stored_code_id_1, $stored_p_id_1);
               $stmt->execute();
               $stmt->fetch();
               $stmt->close();
               
               if (!isset($stored_code_id_1)) {
                   $query = 'INSERT INTO Reg_Code (PersonId, Code) VALUES (?,?)';
                   $stmt = $mysqli->prepare($query);
	               $stmt->bind_param("is", $id, $linked_code);
                   $stmt->execute();
                   echo  $mysqli -> error;
                   
                   $stmt->close();
                   echo ' Code unknown: inserted <br/><br/>' ;
               } else {
                //   echo ' This code is already in and linked to '.$stored_p_id_1;
                   
                   if ($stored_p_id_1!=$id) {
                       $query = 'UPDATE  Reg_Code SET PersonId=? WHERE Code=?';
                       $stmt = $mysqli->prepare($query);
	                   $stmt->bind_param("is", $id, $linked_code);
                       $stmt->execute();
                       echo  $mysqli -> error;
                       $stmt->close();
                   
                        echo ' Relinked to the right person ('.$stored_p_id_1.' to '.$id.')';
                   }
                   
                   echo '<br/><br/>' ;
               }	
           } else if (strpos($piece, '0x') === 0) {
               // starts with 0x => address
               $cpt = explode("(", $piece);
               $cmpt = $cpt[0];
               
              // echo ' starts with 0x => address '.$cmpt.' ';
               
               $valid_code =  trim($cpt[1], ')');
               $codeId = NULL;
               if (strlen($valid_code)>=35) {
                  // Code is present
                  $linked_code = substr($valid_code, -32);
                 // echo ' code available '. $linked_code.' ';
                  
                  $valid_code = trim(str_replace($linked_code, "", $valid_code));
                  // Already inserted?
                  unset($stored_code_id);
                  $query = 'SELECT Id, PersonId FROM Reg_Code WHERE Code=?';
	              $stmt = $mysqli->prepare($query);
	              $stmt->bind_param("s",$linked_code);
                  $stmt->bind_result($stored_code_id, $stored_p_id_2);
                  $stmt->execute();
                  echo  $mysqli -> error;
                  $stmt->fetch();
                  $stmt->close();
                  if (isset($stored_code_id)) {
                     // yes: use it
                     $codeId = $stored_code_id;
                     //echo ' The code '.$codeId.'is already in and linked to '.$stored_p_id_2.' ';
                     
                     if ($stored_p_id_2!=$id) {
                       $query = 'UPDATE  Reg_Code SET PersonId=? WHERE Code=?';
                       $stmt = $mysqli->prepare($query);
	                   $stmt->bind_param("is", $id, $linked_code);
                       $stmt->execute();
                       echo  $mysqli -> error;
                       $stmt->close();
                   
                       echo ' Relinked code to the right person <br/>';
                   }
                     
                  }	else {
                    // no: insert it
                    $query = 'INSERT INTO Reg_Code (PersonId, Code) VALUES (?,?)';
                    $stmt = $mysqli->prepare($query);
	                $stmt->bind_param("is", $id, $linked_code);
                    $stmt->execute();
                    echo  $mysqli -> error;
                    $stmt->close();	
                    $codeId = $mysqli->insert_id;
                    echo ' Code unknown: inserted ' ;
                  }
               }
               
              // echo ' Code Id ='.$codeId.' ' ;
               
               $valid_date = trim(trim(trim($valid_code),'-'));
               
               // echo ' raw date ='.$valid_date.' ' ;
               $validated = strlen($valid_date)>0?1:0;
               if( strlen($valid_date)==0) {
                    $valid_date =NULL;
              //     echo ' date is not valid ' ;
               } else {
               //    echo ' date is valid ' ;
               }
               unset($address_stored);
               $query = 'select address, PersonId, CodeId from Reg_Wallet where address=?';
               $stmt = $mysqli->prepare($query);
               $stmt->bind_param("s", $cmpt);
               $stmt->bind_result($address_stored, $stored_p_id_3, $stored_c_id);
               $stmt->execute();
               echo  $mysqli -> error;
               $stmt->fetch();
               $stmt->close();
               
               if (!isset($address_stored)) {
                   
                   $query = 'INSERT INTO Reg_Wallet (address, PersonId, CodeId, Validated, valid_date) VALUES (?,?,?,?,?)';
                   $stmt = $mysqli->prepare($query);
                   $stmt->bind_param("siiis", $cmpt, $id, $codeId, $validated, $valid_date);
                   $stmt->execute();
                   echo  $mysqli -> error;
                   $stmt->close();
                    echo ' Address inserted <br/><br/>' ;
               } else {
                //   echo ' Address already in linked to '.$stored_p_id_3.' ' ;
                   
                   if ($stored_p_id_3!=$id || $codeId!= $stored_c_id) {
                       $query = 'UPDATE Reg_Wallet SET PersonId=?, CodeId=?, Validated=?, valid_date=? WHERE address=?';
                       $stmt = $mysqli->prepare($query);
                       echo  $mysqli -> error;
                       $stmt->bind_param("iiiss", $id, $codeId, $validated, $valid_date, $cmpt);
                       $stmt->execute();
                       echo  $mysqli -> error;
                       $stmt->close(); 
                       
                       
                        echo ' relinking code/person ' ;
                   }
               
               
                   echo '  <br/><br/>' ;
               }	
   
           }
         }
         
          echo '</div>';
        
       
   }    
  }
  fclose($handle);
  echo "Done!";
}  else {
     echo "Erreur: fopen() a échoué<br/>";
}
  
  
?>  
