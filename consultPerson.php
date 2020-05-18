<?php

include 'checkUser.php';
include 'connectionFactory.php';
$mysqli= ConnectionFactory::GetConnection();

$id=$_GET['id'];

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
    
    $query = 'SELECT 
               Reg_Person.Id,
	           count(Reg_Code.Id),
	           min(Reg_Wallet.Validated),
	           count(Reg_Wallet.Validated)
	          FROM Reg_Person 
	            LEFT OUTER JOIN Reg_Code ON Reg_Code.PersonId=Reg_Person.Id
	            LEFT OUTER JOIN Reg_Wallet ON Reg_Wallet.PersonId=Reg_Person.Id
              WHERE Reg_Person.Id=?
	          GROUP BY Reg_Person.Id';
	
	          
    $stmt = $mysqli->prepare($query);
	$stmt->bind_param("i",$id);
    $stmt->bind_result($rpid,$code,$valid,$wall);
    $stmt->execute();
    
    $stmt->fetch();
    $stmt->close();	

if (!isset($p_address)|| $p_address==''){
    $p_address=$address;
    $p_addressComplement=$addressComplement;
    $p_NPA=$NPA;
    $p_city=$city;
    $p_country=$count;
}

$genders = ["Feminin","Masculin","Autre"];


echo'
<!DOCTYPE html>
<html>
  <head>';
include 'p_head.php';
makeHead(10);
echo'  
    <script>
    
      function showAed(id){
            for (var i=1; i<5;i++){
               document.getElementById("aed_"+i+"_other").style.display="none";
               document.getElementById("btn_aed"+i).classList.remove("selected"); 
            }
            
           document.getElementById("aed_"+id+"_other").style.display="block"; 
           document.getElementById("btn_aed"+id).classList.add("selected");
        }
        
    
    function showSt(id){
        for (var i=1; i<5;i++){
           document.getElementById("st_"+i+"_other").style.display="none";
           document.getElementById("btn_st"+i).classList.remove("selected"); 
        }
        
       document.getElementById("st_"+id+"_other").style.display="block"; 
       document.getElementById("btn_st"+id).classList.add("selected");
    }
    </script>
  </head>
<body>';

echo '
  <span class="fond"></span>
  <span class="cont">
  
    <a class="button" href="todo.php">Close</a>
    <a class="button" href="export.php?id='.$id.'" style="float:right;">Exporter</a><br/>
	<h2>  Demande d\'';
	if (trim($membership)=='Oui'){
	    echo 'adhésion à l\'association ';
	    if ($acc_req==1){
	      echo ' et d\'';
	    }
	}
	if ($acc_req==1){
	   echo 'ouverture de compte ';
	}
	echo ' '.$typeName.' <br/>  Status: '.$statusName.'  ';
	
	if ($acc_req==1 && $code==0){
	    echo '<span style="color:red"> &nbsp; Code manquant</span>';
	}
	
	if ($acc_req==1 && $wall>0 && $valid==0){
	    echo '<span style="color:red"> &nbsp; Compte a débloquer</span>';
	}
	
	if (trim($membership)=='Oui' && ($status==1 || $status==2)){
	    echo '<span style="color:red"> &nbsp; Adhésion a valider</span>';
	}
	
	echo '</h2>';
	
	echo '<span class="half">';
	if (canEdit() && $status==1){
	  echo '<a class="button" href="changeStatus.php?id='.$id.'&stat=2">Mettre en attente</a> 
	        <a class="button" href="changeStatus.php?id='.$id.'&stat=3">Accepter</a>
	        <a class="button" href="changeStatus.php?id='.$id.'&stat=100">Refuser</a>';
	}
	
	if (canEdit() && $status==2){
	 echo '<a class="button" href="changeStatus.php?id='.$id.'&stat=3">Accepter</a>
	        <a class="button" href="changeStatus.php?id='.$id.'&stat=100">Refuser</a>';
	}
	echo'
	<h3> Historique des status  </h3>
	<ul>';
	
	$query = 'SELECT 
	           Reg_Status.Name,
	           Reg_SiteUser.EMail,
	           Reg_StatusHistory.EventDate
	          FROM Reg_StatusHistory
	           LEFT OUTER JOIN Reg_Status ON Reg_StatusHistory.NewStatusId = Reg_Status.Id
	           LEFT OUTER JOIN Reg_SiteUser ON Reg_StatusHistory.UserId = Reg_SiteUser.Id
	          WHERE PersonId=? ORDER BY Reg_StatusHistory.EventDate
	           ';
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param("i",$id);
    $stmt->bind_result($hist_stat,$hist_user,$hist_date);
    $stmt->execute();
    while ($stmt->fetch()){ 
        if (!isset($hist_user) || $hist_user==''){
            $hist_user='REQUERANT';
        }
        echo'<li>'.$hist_stat.' / '.$hist_date.' / '.$hist_user.'</li>';
    }
    $stmt->close();	
	
	echo'
	</ul>
	
	</span>
	<span class="half">
	<h3> Code et comptes  </h3>
	Code: ';if (canEdit()){echo'<a href="addCode.php?id='.$id.'" class="buttonlt" >Ajouter</a>';} echo'<br>
	<table>';
	$query = 'SELECT Reg_Code.Code
	          FROM Reg_Code
	          WHERE PersonId=? 
	           ';
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param("i",$id);
    $stmt->bind_result($code_code);
    $stmt->execute();
    $index=1;
    while ($stmt->fetch()){ 
        echo'<tr><td>'.$code_code.'<form target="_blank"  id="form'.$index.'" action="pdf.php" method="post" style="display:inline;">
          <input   type="hidden"  name="code" value="'.$code_code.'" />
          <input class="buttonlt"  type="submit" value="PDF" />
        </form></td></tr>';
        $index++;
    }
    $stmt->close();	
	echo'</table>
	Comptes: ';if (canEdit()){echo'<a href="addWallet.php?id='.$id.'" class="buttonlt" >Ajouter</a>';} echo'<br>
	<table>';
	$query = 'SELECT address,
	            Reg_Code.Code,
	            Validated 
	          FROM Reg_Wallet
	          LEFT OUTER JOIN Reg_Code ON CodeId=Reg_Code.Id
	          WHERE Reg_Wallet.PersonId=? 
	           ';
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param("i",$id);
    $stmt->bind_result($w_add,$w_code,$w_val);
    $stmt->execute();
    echo'<tr><td>Address</td><td>Code</td><td>Statut</td></tr>';
    while ($stmt->fetch()){ 
        echo'<tr><td>
        <input type="text" readonly="readonly" value="'.$w_add.'"/> 
        </td><td>'.substr ($w_code,0,5).'...</td><td>';
        
        if ($w_val==1){
            echo 'validé';
        } else {
            echo ' <a href="unlockWallet.php?id='.$id.'&add='.$w_add.'" class="buttonlt">Débloquer</a>';
        }
        echo'</td></tr>';
    }
    $stmt->close();	
	echo'</table>';
	
	
	echo'</span>';
	
	
	
	
	
	
	
	if($type==1) {
	    echo '<form id="form" enctype="multipart/form-data" action="./updateLegal.php" method="post">
	    <input   type="hidden"  name="id" value="'.$id.'"/>
        <h3> Informations personnelles  </h3>

	 <span class="fitem">
	   <span class="label" id="lb_name">Nom de la société*</span>
	   <input class="inputText"  type="text" id ="name" name="name" value="'.$Name.'" placeholder="Nom de la société*" required="required"/><br/>
	 </span>
	 <span class="fitem">
	   <span class="label" id="lb_RefName">Nom de l’entreprise à géoréférencer (si différente)</span>
	   <textarea class="inputText"   name="RefName"  placeholder="Nom de l’entreprise à géoréférencer (si différente)"/>'.$RefName.'</textarea><br/>
	 </span>
	 
	 
	  <span class="fitem">
	   <span class="label" id="lb_cont_gender">Personne de contact: Civilité*</span>
	   <select  class="inputText" name="cont_gender" id ="cont_gender" >';

	    
	    for ($i=0;$i<3;$i++){
	        echo ' <option value ="'.$genders[$i].'" ';
	        if ($genders[$i]==$ContactGender){
	            echo 'selected="selected"';
	        }
	        echo'>'.$genders[$i].'</option>';
	    }
	    echo'
	   </select><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" id="lb_contact" >Personne de contact: Nom*</span>
	   <input class="inputText"  type="text" id ="contact" name="contact" value="'.$Contact.'" placeholder="Personne de contact: Nom*" required="required"/><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" id="lb_ContactSurname" >Personne de contact: Prénom*</span>
	   <input class="inputText"  type="text" id ="ContactSurname" name="ContactSurname" value="'.$ContactSurname.'" placeholder="Personne de contact: Prénom*" required="required"/><br/>
	 </span>
	 
	 
	 
	 <span class="fitem">
	   <span class="label" id="lb_kind" >Statut juridique*</span>
	   <select  class="inputText" name="kind" id ="kind" >
	   '.getJuridicStatus($status_juridique,$LegalForm).'
	   </select><br/>
	 </span>
	 <span class="fitem">
	   <span class="label" id="lb_created_on">Date de création*</span>
	   <input class="inputText"  type="date" id="created_on" name="created_on" value="'.$CreationDate.'" placeholder="Date de création*" required="required"/><br/>
	 </span>
	 <span class="fitem">
	   <span class="label" id="lb_fieldActivity" >Secteur d’activité*</span>
	   <select  class="inputText" name="fieldActivity" id ="fieldActivity" >
	   '.getActivitySector($activity_sector,$ActivityField).'
	   </select><br/>
	   	 </span>

	 <span class="fitem">
	   <span class="label" id="lb_ActivityFieldSeg" >Secteur d’activité suppl.</span>
	   <select  class="inputText" name="ActivityFieldSeg" id ="ActivityFieldSeg" >
	   '.getActivitySector($activity_sector,$ActivityFieldSeg).'
	   </select><br/>
	 </span>
	  <span class="fitem">
	   <span class="label" id="lb_activityDesc" >Description de l’activité*</span>
	   <input class="inputText"  type="text" id ="activityDesc" name="activityDesc" value="'.$ActivityDescription.'" placeholder="Description de l’activité*" required="required"/><br/>
	 </span>
	 <span class="fitem">
	   <span class="label" id="lb_ETP" >Nombre d’employés (ETP)*</span>
	   <input class="inputText" onchange="computeCotisation()" min="0" step="0.01" type="number" id ="ETP" name="ETP" value="'.$EFT.'" placeholder="Nombre d’employés (ETP)*" required="required" on/><br/>
	 </span>
	 <span class="fitem">
	   <span class="label" id="lb_mail">Email*</span>
	   <input class="inputText"  type="email" id="mail" name="mail" value="'.$mail.'" placeholder="Email*" required="required"/><br/>
	 </span>
	 <span class="fitem">
	   <span class="label" id="lb_phone">Téléphone*</span>
	   <input class="inputText"  type="tel"  id="phone" name="phone" value="'.$phone.'" placeholder="Téléphone*" required="required"/><br/>
	 </span>
	 
	  <span class="fitem">
	   <span class="label" id="lb_www">Site internet</span>
	   <input class="inputText"  type="tel"  id="www" name="www" value="'.$site.'" placeholder="https://www.monsite.com" /><br/>
	 </span>
	 
    <h3> Adresse légale </h3>
	 
	 
	  <span class="fitem">
	   <span class="label" id="lb_street">Rue et numéro*</span>
	   <input class="inputText"  type="text" id="street" name="street" value="'.$address.'" placeholder="Rue et numéro*" required="required"/><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" >Complément d\'adresse</span>
	   <input class="inputText"  type="text" id="compl" name="compl" value="'.$addressComplement.'" placeholder="Complément d\'adresse" /><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" id="lb_zip">Code postal*</span>
	   <input class="inputText"  type="text" id="zip" name="zip" value="'.$NPA.'" placeholder="Code postal*" required="required"/><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" id="lb_city">Vile*</span>
	   <input class="inputText"  type="text" id="city" name="city" value="'.$city.'" placeholder="Vile*" required="required"/><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" id="lb_country">Pays*</span>
	   <select  class="inputText" name="country" id ="country" >
	   '.getCountry($country,$count).'
	   </select><br/>
	 </span>
	 
	  <h3> Adresse postale </h3>
	  
	 
     <span class="fitem">
       <span class="label" id="lb_p_street">Rue et numéro*</span>
       <input class="inputText"  type="text" id="p_street" name="p_street" value="'.$p_address.'" placeholder="Rue et numéro*" required="required"/><br/>
     </span>
     
     <span class="fitem">
       <span class="label" >Complément d\'adresse</span>
       <input class="inputText"  type="text" id="p_compl" name="p_compl" value="'.$p_addressComplement.'" placeholder="Complément d\'adresse" /><br/>
     </span>
     
     <span class="fitem">
       <span class="label" id="lb_p_zip">Code postal*</span>
       <input class="inputText"  type="text" id="p_zip" name="p_zip" value="'.$p_NPA.'" placeholder="Code postal*" required="required"/><br/>
     </span>
     
     <span class="fitem">
       <span class="label" id="lb_p_city">Vile*</span>
       <input class="inputText"  type="text" id="p_city" name="p_city" value="'.$p_city.'" placeholder="Vile*" required="required"/><br/>
     </span>
     
     <span class="fitem">
       <span class="label" id="lb_p_country">Pays*</span>
       <select  class="inputText" name="p_country" id ="p_country" >
       '.getCountry($country,$p_country).'
       </select><br/>
     </span>';
     
     
     echo'<span id="st_other"   >
	    Tiers subordonnés: 
	       <a onClick="showSt(1)" id="btn_st1" class="selected">(1)</a> 
	       <a onClick="showSt(2)" id="btn_st2" >(2)</a>  
	       <a onClick="showSt(3)" id="btn_st3" >(3)</a>  
	       <a onClick="showSt(4)" id="btn_st4" >(4)</a>  <br/>
	       
     
 <span class="aed" id="st_1_other" style="display:block">
	 
	   Tiers subordonné 1
	 <span class="fitem">
	   <span class="label" id="lb_st_1_name">Nom*</span>
	    <input class="inputText"  type="text" name="st_1_name" value="'.$ST_1_LastName.'" placeholder="Nom*"/><br/>
	 
	  </span>   
	 <span class="fitem">
	   <span class="label" id="lb_st_1_surname">Prénom*</span>
	    <input class="inputText"  type="text" name="st_1_surname" value="'.$ST_1_FirstName.'" placeholder="Prénom*"/><br/>
	  
	  </span> 
	  <span class="fitem">
	       <span class="label" id="lb_st_1_add">Rue et numéro*</span>
	       <input class="inputText"  type="text" id="st_1_add" name="st_1_add" value="'.$ST_1_Address.'" placeholder="Rue et numéro*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" >Complément d\'adresse</span>
	       <input class="inputText"  type="text" id="st_1_compl" name="st_1_compl" value="'.$ST_1_ComplAddress.'" placeholder="Complément d\'adresse" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_st_1_zip">Code postal*</span>
	       <input class="inputText"  type="text" id="st_1_zip" name="st_1_zip" value='.$ST_1_ZIP.'"" placeholder="Code postal*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_st_1_city">Ville*</span>
	       <input class="inputText"  type="text" id="st_1_city" name="st_1_city" value="'.$ST_1_City.'" placeholder="Ville*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_st_1_country">Pays*</span>
	       <select  class="inputText" name="st_1_country" id ="st_1_country" >
	       '.getCountry($country,$ST_1_Country).'
	       </select><br/>
	     </span>
	     
	 
	 <span class="fitem">
	    <span class="label" id="lb_st_1_born">Date de naissance*</span>
	    <input class="inputText"  type="date" name="st_1_born" value="'.$ST_1_BirthDate.'" placeholder="Date de naissance*" >
	  
	  </span>  
	    
	 <span class="fitem">
	    <span class="label" id="lb_st_1_cit">Nationalité*</span>
	    <select  class="inputText" name="st_1_cit">'.getCountry($country,$ST_1_Citizenship).'</select><br/>
	 
	  </span>
	</span>
	<span class="aed" id="st_2_other" style="display:none">
	 
	   Tiers subordonné 2
	 <span class="fitem">
	   <span class="label" id="lb_st_2_name">Nom*</span>
	    <input class="inputText"  type="text" name="st_2_name" value="'.$ST_2_LastName.'" placeholder="Nom*"/><br/>
	 
	  </span>   
	 <span class="fitem">
	   <span class="label" id="lb_st_2_surname">Prénom*</span>
	    <input class="inputText"  type="text" name="st_2_surname" value="'.$ST_2_FirstName.'" placeholder="Prénom*"/><br/>
	  
	  </span> 
	  <span class="fitem">
	       <span class="label" id="lb_st_2_add">Rue et numéro*</span>
	       <input class="inputText"  type="text" id="st_2_add" name="st_2_add" value="'.$ST_2_Address.'" placeholder="Rue et numéro*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" >Complément d\'adresse</span>
	       <input class="inputText"  type="text" id="st_2_compl" name="st_2_compl" value="'.$ST_2_ComplAddress.'" placeholder="Complément d\'adresse" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_st_2_zip">Code postal*</span>
	       <input class="inputText"  type="text" id="st_2_zip" name="st_2_zip" value='.$ST_2_ZIP.'"" placeholder="Code postal*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_st_2_city">Ville*</span>
	       <input class="inputText"  type="text" id="st_2_city" name="st_2_city" value="'.$ST_2_City.'" placeholder="Ville*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_st_2_country">Pays*</span>
	       <select  class="inputText" name="st_2_country" id ="st_2_country" >
	       '.getCountry($country,$ST_2_Country).'
	       </select><br/>
	     </span>
	     
	 
	 <span class="fitem">
	    <span class="label" id="lb_st_2_born">Date de naissance*</span>
	    <input class="inputText"  type="date" name="st_2_born" value="'.$ST_2_BirthDate.'" placeholder="Date de naissance*" >
	  
	  </span>  
	    
	 <span class="fitem">
	    <span class="label" id="lb_st_2_cit">Nationalité*</span>
	    <select  class="inputText" name="st_2_cit">'.getCountry($country,$ST_2_Citizenship).'</select><br/>
	 
	  </span>
	</span><span class="aed" id="st_3_other" style="display:none">
	 
	   Tiers subordonné 3
	 <span class="fitem">
	   <span class="label" id="lb_st_3_name">Nom*</span>
	    <input class="inputText"  type="text" name="st_3_name" value="'.$ST_3_LastName.'" placeholder="Nom*"/><br/>
	 
	  </span>   
	 <span class="fitem">
	   <span class="label" id="lb_st_3_surname">Prénom*</span>
	    <input class="inputText"  type="text" name="st_3_surname" value="'.$ST_3_FirstName.'" placeholder="Prénom*"/><br/>
	  
	  </span> 
	  <span class="fitem">
	       <span class="label" id="lb_st_3_add">Rue et numéro*</span>
	       <input class="inputText"  type="text" id="st_3_add" name="st_3_add" value="'.$ST_3_Address.'" placeholder="Rue et numéro*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" >Complément d\'adresse</span>
	       <input class="inputText"  type="text" id="st_3_compl" name="st_3_compl" value="'.$ST_3_ComplAddress.'" placeholder="Complément d\'adresse" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_st_3_zip">Code postal*</span>
	       <input class="inputText"  type="text" id="st_3_zip" name="st_3_zip" value='.$ST_3_ZIP.'"" placeholder="Code postal*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_st_3_city">Ville*</span>
	       <input class="inputText"  type="text" id="st_3_city" name="st_3_city" value="'.$ST_3_City.'" placeholder="Ville*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_st_3_country">Pays*</span>
	       <select  class="inputText" name="st_3_country" id ="st_3_country" >
	       '.getCountry($country,$ST_3_Country).'
	       </select><br/>
	     </span>
	     
	 
	 <span class="fitem">
	    <span class="label" id="lb_st_3_born">Date de naissance*</span>
	    <input class="inputText"  type="date" name="st_3_born" value="'.$ST_3_BirthDate.'" placeholder="Date de naissance*" >
	  
	  </span>  
	    
	 <span class="fitem">
	    <span class="label" id="lb_st_3_cit">Nationalité*</span>
	    <select  class="inputText" name="st_3_cit">'.getCountry($country,$ST_3_Citizenship).'</select><br/>
	 
	  </span>
	</span><span class="aed" id="st_4_other" style="display:none">
	 
	   Tiers subordonné 4
	 <span class="fitem">
	   <span class="label" id="lb_st_4_name">Nom*</span>
	    <input class="inputText"  type="text" name="st_4_name" value="'.$ST_4_LastName.'" placeholder="Nom*"/><br/>
	 
	  </span>   
	 <span class="fitem">
	   <span class="label" id="lb_st_4_surname">Prénom*</span>
	    <input class="inputText"  type="text" name="st_4_surname" value="'.$ST_4_FirstName.'" placeholder="Prénom*"/><br/>
	  
	  </span> 
	  <span class="fitem">
	       <span class="label" id="lb_st_4_add">Rue et numéro*</span>
	       <input class="inputText"  type="text" id="st_4_add" name="st_4_add" value="'.$ST_4_Address.'" placeholder="Rue et numéro*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" >Complément d\'adresse</span>
	       <input class="inputText"  type="text" id="st_4_compl" name="st_4_compl" value="'.$ST_4_ComplAddress.'" placeholder="Complément d\'adresse" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_st_4_zip">Code postal*</span>
	       <input class="inputText"  type="text" id="st_4_zip" name="st_4_zip" value='.$ST_4_ZIP.'"" placeholder="Code postal*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_st_4_city">Ville*</span>
	       <input class="inputText"  type="text" id="st_4_city" name="st_4_city" value="'.$ST_4_City.'" placeholder="Ville*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_st_4_country">Pays*</span>
	       <select  class="inputText" name="st_4_country" id ="st_4_country" >
	       '.getCountry($country,$ST_4_Country).'
	       </select><br/>
	     </span>
	     
	 
	 <span class="fitem">
	    <span class="label" id="lb_st_4_born">Date de naissance*</span>
	    <input class="inputText"  type="date" name="st_4_born" value="'.$ST_4_BirthDate.'" placeholder="Date de naissance*" >
	  
	  </span>  
	    
	 <span class="fitem">
	    <span class="label" id="lb_st_4_cit">Nationalité*</span>
	    <select  class="inputText" name="st_4_cit">'.getCountry($country,$ST_4_Citizenship).'</select><br/>
	 
	  </span>
	</span>
	
	  
	
	 </span>';
     
     
     
     
     
     
	} else {
	  echo'<form id="form"  enctype="multipart/form-data" action="updateIndividual.php" method="post">
	  	    <input   type="hidden"  name="id" value="'.$id.'"/>
    <h3> Informations personnelles  </h3>
     <span class="fitem">
	   <span class="label" >Civilité*</span>
	   <select  class="inputText" name="gender" id ="gender" >
	    <option value =""></option>';
	    
	    
	    for ($i=0;$i<3;$i++){
	        echo ' <option value ="'.$genders[$i].'" ';
	        if ($genders[$i]==$Gender){
	            echo 'selected="selected"';
	        }
	        echo'>'.$genders[$i].'</option>';
	    }
	    echo'
	   </select><br/>
	 </span>
	 <span class="fitem">
	   <span class="label" id="lb_name">Nom*</span>
	   <input class="inputText"  type="text" id ="name" name="name" value="'.$LastName.'" placeholder="Nom*" required="required"/><br/>
	 </span>
	 <span class="fitem">
	   <span class="label" id="lb_surname" >Prénom*</span>
	   <input class="inputText"  type="text" id ="surname" name="surname" value="'.$FirstName.'" placeholder="Prénom*" required="required"/><br/>
	 </span>
	
	 <span class="fitem">
	   <span class="label" id="lb_mail">Email*</span>
	   <input class="inputText"  type="email" id="mail" name="mail" value="'.$mail.'" placeholder="Email*" required="required"/><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" id="lb_phone">Téléphone*</span>
	   <input class="inputText"  type="tel"  id="phone" name="phone" value="'.$phone.'" placeholder="Téléphone*" required="required"/><br/>
	 </span>
	 
	  <span class="fitem">
	   <span class="label" id="lb_street">Rue et numéro*</span>
	   <input class="inputText"  type="text" id="street" name="street" value="'.$address.'" placeholder="Rue et numéro*" required="required"/><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" >Complément d\'adresse</span>
	   <input class="inputText"  type="text" id="compl" name="compl" value="'.$addressComplement.'" placeholder="Complément d\'adresse" /><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" id="lb_zip">Code postal*</span>
	   <input class="inputText"  type="text" id="zip" name="zip" value="'.$NPA.'" placeholder="Code postal*" required="required"/><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" id="lb_city">Vile*</span>
	   <input class="inputText"  type="text" id="city" name="city" value="'.$city.'" placeholder="Vile*" required="required"/><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" id="lb_country">Pays*</span>
	   <select  class="inputText" name="country" id ="country" >
	   '.getCountry($country,$count).'
	   </select><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" id="lb_cit">Nationalité*</span>
	   <select  class="inputText" name="cit" id ="cit" >
	   '.getCountry($country,$Citizenship).'
	   </select><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" id="lb_born">Date de naissence*</span>
	   <input class="inputText"  type="date" id="born" name="born" value="'.$BirthDate.'" placeholder="Date de naissence*" required="required"/><br/>
	 </span>
	 ';
	
	}
	
	echo '
	
	 <h3> Adhésion à l\'association Monnaie-Léman /ouverture de compte/ mailing list </h3>
	   <span class="fitem">
	   <span class="labelWide" id="lb_ad_ass">Demande d\'adhésion à l\'association:</span>
	   <select  class="inputText" name="ad_ass" id ="ad_ass" >';
	    $membership_options = ["Déjà membre","Oui","Non"];
	    
	    for ($i=0;$i<3;$i++){
	        echo ' <option value ="'.$membership_options[$i].'" ';
	        if ($membership_options[$i]==$membership){
	            echo 'selected="selected"';
	        }
	        echo'>'.$membership_options[$i].'</option>';
	    }
	    echo'
	   </select><br/>
	 </span>

	  <span class="fitem">
	   <span class="labelWide" id="lb_ad_ass">Demande d\'ouverture de compte:</span>
	   <select  class="inputText" name="cr_acc" id ="cr_acc" >';
	    $acc_options = ["Non","Oui"];
	    
	    for ($i=0;$i<2;$i++){
	        echo ' <option value ="'.$i.'" ';
	        if ($i==$acc_req){
	            echo 'selected="selected"';
	        }
	        echo'>'.$acc_options[$i].'</option>';
	    }
	    echo'
	   </select><br/>
	 </span>
	 
	 
	 
	  <span class="fitem">
	   <input class="inputCb"  type="checkbox" id="news" name="news" value="1" ';
	   if ($newsletter==1){
	    echo ' checked="checked"';
	   }
	   echo'/>
	   <span  class="labelCb">Accèpte la newsletter de l’association. </span><br/>
	 </span>
	 <h3> Conformité / compliance FINMA  </h3>
	 
	 
	 <span class="fitem">
	   <span class="label" id="lb_pep">ADE est/sont PEP?* </span>
	   <select  class="inputText" id="pep" name="pep">
	    <option value ="1">Oui</option>
	    <option value ="0"';
	    
	    if ($PEP==0){
	        echo ' selected="selected"';
	    }
	    
	    echo'>Non</option>
	   </select><br/>
	 </span>

<span class="fitem">
	   <span class="label"  id="lb_peprel">ADE lié-e-s à une/des PEP?*</span>
	   <select  class="inputText" id="peprel" name="peprel">
	    <option value ="1">Oui</option>
	    <option value ="0"';
	    
	    if ($PEPRelated==0){
	        echo ' selected="selected"';
	    }
	    
	    echo'>Non</option>
	   </select><br/>
	 </span>
	 
     <span class="fitem">
	    <input class="inputCb"  type="radio" name="aed_dec" value="AED" ';
	    
	    if ($aed=="AED"){
	        echo ' checked="checked"';
	    }
	    
	    echo'/>
	    <span  class="labelCb" >AED unique</span><br/>
	 
	    <input class="inputCb"  type="radio" name="aed_dec" value="Autre"   ';
	    
	    if ($aed=="Autre"){
	        echo ' checked="checked"';
	    }
	    
	    echo'/>
	    <span  class="labelCb">Autres AED</span><br/>
	    
	     <span id="aed_other"   >
	    Ayant-e(s) droit économique: 
	       <a onClick="showAed(1)" id="btn_aed1" class="selected">(1)</a> 
	       <a onClick="showAed(2)" id="btn_aed2" >(2)</a>  
	       <a onClick="showAed(3)" id="btn_aed3" >(3)</a>  
	       <a onClick="showAed(4)" id="btn_aed4" >(4)</a>  <br/>
	 <span class="aed" id="aed_1_other" style="display:block">
	    
	   
	    
	    
	    
	    
	    
	    
	    AED 1:
	    <span class="fitem">
	        <span class="label" id="lb_aed_1_name">Nom*</span>
	        <input class="inputText"  type="text" name="aed_1_name" value="'.$AED_1_LastName.'" placeholder="Nom*"/><br/>
	    </span>   
	    <span class="fitem">
	        <span class="label" id="lb_aed_1_surname">Prénom*</span>
	        <input class="inputText"  type="text" name="aed_1_surname" value="'.$AED_1_FirstName.'" placeholder="Prénom*"/><br/>
	    </span>  
	    
	    <span class="fitem">
	       <span class="label" id="lb_aed_1_add">Rue et numéro*</span>
	       <input class="inputText"  type="text" id="aed_1_add" name="aed_1_add" value="'.$AED_1_Address.'" placeholder="Rue et numéro*" /><br/>
	     </span>
	     <span class="fitem">
	       <span class="label" >Complément d\'adresse</span>
	       <input class="inputText"  type="text" id="aed_1_compl" name="aed_1_compl" value="'.$AED_1_ComplAddress.'" placeholder="Complément d\'adresse" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_aed_1_zip">Code postal*</span>
	       <input class="inputText"  type="text" id="aed_1_zip" name="aed_1_zip" value="'.$AED_1_ZIP.'" placeholder="Code postal*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_aed_1_city">Ville*</span>
	       <input class="inputText"  type="text" id="aed_1_city" name="aed_1_city" value="'.$AED_1_City.'" placeholder="Ville*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_aed_1_country">Pays*</span>
	       <select  class="inputText" name="aed_1_country" id ="aed_1_country" >
	       '.getCountry($country,$AED_1_Country).'
	       </select><br/>
	     </span>
	    <span class="fitem">
	        <span class="label" id="lb_aed_1_born">Date de naissence*</span>
	        <input class="inputText"  type="date" name="aed_1_born" value="'.$AED_1_BirthDate.'" placeholder="Date de naissence*" >
	    </span>  
	    
	    <span class="fitem">
	        <span class="label" id="lb_aed_1_cit">Nationalité*</span>
	        <select  class="inputText" name="aed_1_cit">'.getCountry($country,$AED_1_Citizenship).'</select><br/>
	    </span>
	 </span>  
	  
	 <span class="aed" id="aed_2_other" style="display:none">
	 
	 AED 2:
	 <span class="fitem">
	   <span class="label" id="lb_aed_2_name">Nom*</span>
	    <input class="inputText"  type="text" name="aed_2_name" value="'.$AED_2_LastName.'" placeholder="Nom*"/><br/>
	 
	  </span>   
	 <span class="fitem">
	   <span class="label" id="lb_aed_2_surname">Prénom*</span>
	    <input class="inputText"  type="text" name="aed_2_surname" value="'.$AED_2_FirstName.'" placeholder="Prénom*"/><br/>
	  
	  </span> 
<span class="fitem">
	       <span class="label" id="lb_aed_2_add">Rue et numéro*</span>
	       <input class="inputText"  type="text" id="aed_2_add" name="aed_2_add" value="'.$AED_2_Address.'" placeholder="Rue et numéro*" /><br/>
	     </span>
	     <span class="fitem">
	       <span class="label" >Complément d\'adresse</span>
	       <input class="inputText"  type="text" id="aed_2_compl" name="aed_2_compl" value="'.$AED_2_ComplAddress.'" placeholder="Complément d\'adresse" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_aed_2_zip">Code postal*</span>
	       <input class="inputText"  type="text" id="aed_2_zip" name="aed_2_zip" value="'.$AED_2_ZIP.'" placeholder="Code postal*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_aed_2_city">Ville*</span>
	       <input class="inputText"  type="text" id="aed_2_city" name="aed_2_city" value="'.$AED_2_City.'" placeholder="Ville*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_aed_2_country">Pays*</span>
	       <select  class="inputText" name="aed_2_country" id ="aed_2_country" >
	       '.getCountry($country,$AED_2_Country).'
	       </select><br/>
	     </span> 
	 
	 <span class="fitem">
	    <span class="label" id="lb_aed_2_born">Date de naissence*</span>
	    <input class="inputText"  type="date" name="aed_2_born" value="'.$AED_2_BirthDate.'" placeholder="Date de naissence*" >
	  
	  </span>  
	    
	 <span class="fitem">
	    <span class="label" id="lb_aed_2_cit">Nationalité*</span>
	    <select  class="inputText" name="aed_2_cit">'.getCountry($country,$AED_2_Citizenship).'</select><br/>
	 
	  </span>
	  </span>  
	  
	  <span  class="aed" id="aed_3_other" style="display:none">
	 
	 AED 3:
	 <span class="fitem">
	   <span class="label" id="lb_aed_3_name">Nom*</span>
	    <input class="inputText"  type="text" name="aed_3_name" value="'.$AED_3_LastName.'" placeholder="Nom*"/><br/>
	 
	  </span>   
	 <span class="fitem">
	   <span class="label" id="lb_aed_3_surname">Prénom*</span>
	    <input class="inputText"  type="text" name="aed_3_surname" value="'.$AED_3_FirstName.'" placeholder="Prénom*"/><br/>
	  
	  </span> 
	 <span class="fitem">
	       <span class="label" id="lb_aed_3_add">Rue et numéro*</span>
	       <input class="inputText"  type="text" id="aed_3_add" name="aed_3_add" value="'.$AED_3_Address.'" placeholder="Rue et numéro*" /><br/>
	     </span>
	     <span class="fitem">
	       <span class="label" >Complément d\'adresse</span>
	       <input class="inputText"  type="text" id="aed_3_compl" name="aed_3_compl" value="'.$AED_3_ComplAddress.'" placeholder="Complément d\'adresse" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_aed_3_zip">Code postal*</span>
	       <input class="inputText"  type="text" id="aed_3_zip" name="aed_3_zip" value="'.$AED_3_ZIP.'" placeholder="Code postal*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_aed_3_city">Ville*</span>
	       <input class="inputText"  type="text" id="aed_3_city" name="aed_3_city" value="'.$AED_3_City.'" placeholder="Ville*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_aed_3_country">Pays*</span>
	       <select  class="inputText" name="aed_3_country" id ="aed_3_country" >
	       '.getCountry($country,$AED_3_Country).'
	       </select><br/>
	     </span>
	 
	 <span class="fitem">
	    <span class="label" id="lb_aed_3_born">Date de naissence*</span>
	    <input class="inputText"  type="date" name="aed_3_born" value="'.$AED_3_BirthDate.'" placeholder="Date de naissence*" >
	  
	  </span>  
	    
	 <span class="fitem">
	    <span class="label" id="lb_aed_3_cit">Nationalité*</span>
	    <select  class="inputText" name="aed_3_cit">'.getCountry($country,$AED_3_Citizenship).'</select><br/>
	 
	  </span>
	  </span>  
	  
	  <span class="aed" id="aed_4_other" style="display:none">
	 
	 AED 4:
	 <span class="fitem">
	   <span class="label" id="lb_aed_4_name">Nom*</span>
	    <input class="inputText"  type="text" name="aed_4_name" value="'.$AED_4_LastName.'" placeholder="Nom*"/><br/>
	 
	  </span>   
	 <span class="fitem">
	   <span class="label" id="lb_aed_4_surname">Prénom*</span>
	    <input class="inputText"  type="text" name="aed_4_surname" value="'.$AED_4_FirstName.'" placeholder="Prénom*"/><br/>
	  
	  </span> 
	<span class="fitem">
	       <span class="label" id="lb_aed_4_add">Rue et numéro*</span>
	       <input class="inputText"  type="text" id="aed_4_add" name="aed_4_add" value="'.$AED_4_Address.'" placeholder="Rue et numéro*" /><br/>
	     </span>
	     <span class="fitem">
	       <span class="label" >Complément d\'adresse</span>
	       <input class="inputText"  type="text" id="aed_4_compl" name="aed_4_compl" value="'.$AED_4_ComplAddress.'" placeholder="Complément d\'adresse" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_aed_4_zip">Code postal*</span>
	       <input class="inputText"  type="text" id="aed_4_zip" name="aed_4_zip" value="'.$AED_4_ZIP.'" placeholder="Code postal*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_aed_4_city">Ville*</span>
	       <input class="inputText"  type="text" id="aed_4_city" name="aed_4_city" value="'.$AED_4_City.'" placeholder="Ville*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_aed_4_country">Pays*</span>
	       <select  class="inputText" name="aed_4_country" id ="aed_4_country" >
	       '.getCountry($country,$AED_4_Country).'
	       </select><br/>
	     </span>
	 
	 <span class="fitem">
	    <span class="label" id="lb_aed_4_born">Date de naissence*</span>
	    <input class="inputText"  type="date" name="aed_4_born" value="'.$AED_4_BirthDate.'" placeholder="Date de naissence*" >
	  
	  </span>  
	    
	 <span class="fitem">
	    <span class="label" id="lb_aed_4_cit">Nationalité*</span>
	    <select  class="inputText" name="aed_4_cit">'.getCountry($country,$AED_4_Citizenship).'</select><br/>
	 
	  </span>
	 
	   
	 </span>';
	 
	 if (canEdit()){
	  echo '<a class="button" onclick="document.forms[\'form\'].submit()">Enregistrer les modifications</a>';
    } 
  
   echo' </form>
	 <h3> Documents </h3>
	 ';
	 
	 if (canEdit()){
	  echo '<a class="button" href="docs.php?id='.$id.'">Modifier les documents</a>';
    } 
  
	 $doc=['Carte d\'Identité'=>[$IdCard]];
	 if($type==1) {
	    $doc=['Carte d\'Identité'=>[$IdCard_1,$IdCard_2,$IdCard_3,$IdCard_4,$IdCard_5,$IdCard_6,
	           $IdCard_7,$IdCard_8,$IdCard_9,$IdCard_10,$IdCard_11,$IdCard_12],
	        'Etat Financier'=>[$FinState_1,$FinState_2,$FinState_3],
	        'Registre du commerce'=>[$Registration_1,$Registration_2,$Registration_3]];
	 }
	 
	 $folder = './Data/img_'.$id.'/';
	 foreach($doc as $doc_name => $list) {
	    echo '<br/>'.$doc_name.'<br/>';
	    foreach($list as $file) {
	        if ($file!=''){
	            echo '<a href="'.$folder.$file.'" target="_blank">';
	            if (strtolower(substr($file, -4)) === '.pdf'){
	               echo' <img src="css/image/pdf.png" height="100px"/>';
	            } else {
	               echo'<img src="'.$folder.$file.'" height="300px"/>';
	            }
	            echo'</a>';
	        }
	    }
	 }

	
	


    
echo '   
   </span>
</body>
</html>';
?>
