<?php
echo'
<!DOCTYPE html>
<html>
  <head>';
include 'p_head.php';

$type_form=1;
if (isset($_GET['adh']) && $_GET['adh']==1){
    $type_form=0;
}

makeHead($type_form);

echo'  

  <script>
  
  
    window.onload = function() {
         const myInput = document.getElementById("mailconf");
         myInput.onpaste = function(e) {
           e.preventDefault();
         }
    }
    
     function setTypeForm(type_form){
        if (type_form==0){
             document.getElementById("title").innerHTML="Adhésion à Monnaie Léman";
             document.getElementById("tot_step").innerHTML=2;
             document.getElementById("adh_next").style.display="None";
             document.getElementById("adh_sub").style.display="inline-block";
             document.getElementById("fld_cr_acc").style.display="inline-block";
             document.getElementById("fld_ce").style.display="block";
             document.getElementById("fld_att").style.display="inline-block";
             document.getElementById("att").checked = false;
             document.getElementById("lb_ad_ass").innerHTML="Confirmation de votre demande d’adhésion?*";
             
             
        } else {
             document.getElementById("title").innerHTML="VOS DONNÉES PERSONELLES";
             document.getElementById("tot_step").innerHTML=4;
             document.getElementById("adh_next").style.display="inline-block";
             document.getElementById("adh_sub").style.display="None";
             document.getElementById("fld_ce").style.display="None";
             document.getElementById("fld_att").style.display="None";
             document.getElementById("lb_ad_ass").innerHTML="Voulez-vous adhérer à l\'association Monnaie Léman?*";
             
        }  
    }
  
      function changeType(){
        setTypeForm(document.getElementById("cr_acc").value);
    }
  
  
    function showSection(section_id){
        var sections = ["sect_ip","sect_add","sect_fin","sect_sign"]
        for (var i=0; i<sections.length; i++){
            document.getElementById(sections[i]).style.display="None";
        }
        document.getElementById(section_id).style.display="inline-block";
        for (var i=0; i<sections.length; i++){
            if (sections[i]==section_id){
                document.getElementById("step").innerHTML=""+(i+1);
            }
        }
    }
    
    function togelPostal(){
        if (document.forms["form"]["postalAsLegal"].checked==1){
            document.getElementById("blk_add_postal").style.display="None";
        } else {
            document.getElementById("blk_add_postal").style.display="block";
        }
    }
    
    function computeCotisation(){
       var country = document.forms["form"]["country"].value;
       var etp  = parseInt(document.forms["form"]["ETP"].value);
       
       var amount_ch=0;
       var amount_fr=0;
       var amount_fr_lem=0;';
       
    foreach ($cotisation_e_ch as $etp => $value){
       echo'
       if (etp>='.$etp.'){
          amount_ch = '.$value.';
       }
       ';
       
    }
    foreach ($cotisation_e_fr as $etp => $value){
       echo'
       if (etp>='.$etp.'){
          amount_fr = '.$value.';
       }
       ';
       
    }
    foreach ($cotisation_e_fr_lem as $etp => $value){
       echo'
       if (etp>='.$etp.'){
          amount_fr_lem = '.$value.';
       }
       '; 
    }
       
       echo'
       
       if (country=="France"){
            document.getElementById("cot_amount").innerHTML="EUR&nbsp;"+amount_fr;
            document.getElementById("cot_amount_2").innerHTML=amount_fr_lem+ " (taux moyen du jour)";
            document.getElementById("coo_ch").style.display="None";
            document.getElementById("coo_fr").style.display="inline-block";
       } else {
            document.getElementById("cot_amount").innerHTML="CHF&nbsp;"+amount_ch;
            document.getElementById("cot_amount_2").innerHTML=amount_ch;
            document.getElementById("coo_fr").style.display="None";
            document.getElementById("coo_ch").style.display="inline-block";
       } 
    }
    
    function validateSectionInfo(){
       var valid = true;
       var fields = ["name","contact","ContactSurname","cont_gender","kind","created_on","fieldActivity","activityDesc","ETP","mail","phone","street","zip","city","country"];
       for (var i=0; i<fields.length; i++){
           var label = document.getElementById("lb_"+fields[i]);
           var x = document.forms["form"][fields[i]].value;
           if (x == "") {
              label.classList.add("missing");
              valid=false;
           } else {
              label.classList.remove("missing");
           }
       }
       
       fields = ["p_street","p_zip","p_city","p_country"];
       var to_validate = document.forms["form"]["postalAsLegal"].checked!=1;
       for (var i=0; i<fields.length; i++){
           var label = document.getElementById("lb_"+fields[i]);
           var x = document.forms["form"][fields[i]].value;
           if (to_validate && x == "") {
              label.classList.add("missing");
              valid=false;
           } else {
              label.classList.remove("missing");
           }
       }
       
       if (document.forms["form"]["mail"].value != document.forms["form"]["mailconf"].value){
           document.getElementById("lb_mailconf").classList.add("missing");
           valid=false;
       } else {
            document.getElementById("lb_mailconf").classList.remove("missing");
       }
       
       
       
       return valid;
    }
    
    function validateSectionAdd(){
         var valid = true;
        var label_adh = document.getElementById("lb_ad_ass");
        var adh_ass = document.forms["form"]["ad_ass"].value;
        if (adh_ass == "") {
          label_adh.classList.add("missing");
          valid=false;
        } else {
          label_adh.classList.remove("missing");
        }
        
        label = document.getElementById("lb_cr_acc");
        var create_account = document.forms["form"]["cr_acc"].value;
        if (create_account == "") {
          label.classList.add("missing");
          valid=false;
        } else {
          label.classList.remove("missing");
        }
        
        if (create_account!=1){
        
            if (adh_ass != "Oui") {
              label_adh.classList.add("missing");
              valid=false;
            } else {
              label_adh.classList.remove("missing");
            }
        
           if (document.forms["form"]["att_0"].checked!=1){
               document.getElementById("lb_att_0").classList.add("missing");
               valid=false;
           } else {
                document.getElementById("lb_att_0").classList.remove("missing");
           }
           if (document.forms["form"]["ce_0"].checked!=1){
               document.getElementById("lb_ce_0").classList.add("missing");
               valid=false;
           } else {
                document.getElementById("lb_ce_0").classList.remove("missing");
           }
        }
        
        
        if (document.forms["form"]["data"].checked!=1){
        document.getElementById("lb_data").classList.add("missing");
           valid=false;
       } else {
            document.getElementById("lb_data").classList.remove("missing");
       }
        return valid;
    }
    
    
    
    var aed_number=1;
    
    function showAed(id){
        for (var i=1; i<5;i++){
           document.getElementById("aed_"+i+"_other").style.display="none";
           document.getElementById("btn_aed"+i).classList.remove("selected"); 
        }
        
       document.getElementById("aed_"+id+"_other").style.display="block"; 
       document.getElementById("btn_aed"+id).classList.add("selected");
    }
    
    
    function addAed(){
        if (aed_number<4){
            aed_number+=1;
            document.getElementById("btn_aed"+aed_number).style.display="inline-block";
            showAed(aed_number);
        }
        
        if (aed_number>=4){
            document.getElementById("btn_aedadd").style.display="none";
        }
    }
    
    
     var st_number=1;
    
    function showSt(id){
        for (var i=1; i<5;i++){
           document.getElementById("st_"+i+"_other").style.display="none";
           document.getElementById("btn_st"+i).classList.remove("selected"); 
        }
        
       document.getElementById("st_"+id+"_other").style.display="block"; 
       document.getElementById("btn_st"+id).classList.add("selected");
    }
    
    
    function addSt(){
        if (st_number<4){
            st_number+=1;
            document.getElementById("btn_st"+st_number).style.display="inline-block";
            showSt(st_number);
        }
        
        if (st_number>=4){
            document.getElementById("btn_stadd").style.display="none";
        }
    }
    
    function togleAed(){
        var x = document.forms["form"]["aed_dec"].value;
        document.getElementById("aed_other").style.display=x=="Autre"?"block":"none";
    }
    
    function toglePA(){
        var x = document.forms["form"]["pa_dec"].value;
        document.getElementById("pa_other").style.display=x==1?"block":"none";
    }
    
    
    
     function validateSectionFin(){
       var valid = true;
       var fields = ["pep","peprel","aed_dec"];
       for (var i=0; i<fields.length; i++){
           var label = document.getElementById("lb_"+fields[i]);
           var x = document.forms["form"][fields[i]].value;
           if (x == "") {
              label.classList.add("missing");
              valid=false;
           } else {
              label.classList.remove("missing");
           }
       }
       
       if (document.forms["form"]["cond"].checked!=1){
        document.getElementById("lb_cond").classList.add("missing");
           valid=false;
       } else {
            document.getElementById("lb_cond").classList.remove("missing");
       }
       
       
       
       for (var st_id =1;st_id<5;st_id++){
               valid_st=true;
               var to_validate = document.forms["form"]["st_"+st_id+"_name"].value!="";
               fields = ["st_"+st_id+"_surname","st_"+st_id+"_add","st_"+st_id+"_born","st_"+st_id+"_zip","st_"+st_id+"_city","st_"+st_id+"_country","st_"+st_id+"_cit"];  
               for (var i=0; i<fields.length; i++){
                   var label = document.getElementById("lb_"+fields[i]);
                   var x = document.forms["form"][fields[i]].value;
                   if (to_validate && x == "") {
                      label.classList.add("missing");
                      valid=false;
                      valid_st=false;
                   } else {
                      label.classList.remove("missing");
                      if (!to_validate){
                        document.forms["form"][fields[i]].value="";
                      } 
                   }
               }
                if (valid_st){
                  document.getElementById("btn_st"+st_id).classList.remove("missing")
               } else {
                  document.getElementById("btn_st"+st_id).classList.add("missing")
               } 
                 
           }
       
       
       
       if (document.forms["form"]["aed_dec"].value=="Autre"){
           var valid_aed=true;
           fields = ["aed_1_name","aed_1_surname","aed_1_add", "aed_1_zip", "aed_1_city", "aed_1_country", "aed_1_born","aed_1_cit"];  
           for (var i=0; i<fields.length; i++){
               var label = document.getElementById("lb_"+fields[i]);
               var x = document.forms["form"][fields[i]].value;
               if (x == "") {
                  label.classList.add("missing");
                  valid=false;
                  valid_aed=false;
               } else {
                  label.classList.remove("missing");
               }
           }
           
           if (valid_aed){
             document.getElementById("btn_aed1").classList.remove("missing")
           } else {
             document.getElementById("btn_aed1").classList.add("missing")
           } 
           
           for (var aed_id =2;aed_id<5;aed_id++){
               valid_aed=true;
               var to_validate = document.forms["form"]["aed_"+aed_id+"_name"].value!="";
               fields = ["aed_"+aed_id+"_surname","aed_"+aed_id+"_add","aed_"+aed_id+"_zip","aed_"+aed_id+"_city","aed_"+aed_id+"_country","aed_"+aed_id+"_born","aed_"+aed_id+"_cit"];  
               for (var i=0; i<fields.length; i++){
                   var label = document.getElementById("lb_"+fields[i]);
                   var x = document.forms["form"][fields[i]].value;
                   if (to_validate && x == "") {
                      label.classList.add("missing");
                      valid=false;
                      valid_aed=false;
                   } else {
                      label.classList.remove("missing");
                      if (!to_validate){
                        document.forms["form"][fields[i]].value="";
                      } 
                   }
               }
            
               if (valid_aed){
                  document.getElementById("btn_aed"+aed_id).classList.remove("missing")
               } else {
                  document.getElementById("btn_aed"+aed_id).classList.add("missing")
               } 
                 
           }
       }
       
       return valid;
    }
    
    

    
    
     function validateSectionDoc(){
       var valid = true;
       var fields = ["cgu","ce","eng","att"];
       for (var i=0; i<fields.length; i++){
           var name = "lb_"+fields[i]
           var label = document.getElementById(name);
           if (document.forms["form"][fields[i]].checked!=1){ 
              label.classList.add("missing");
              valid=false;
           } else {
              label.classList.remove("missing");
           }
       }
       
       if (document.forms["form"]["img_c1"].value==""){
           document.getElementById("lb_img_c").classList.add("missing");
           valid=false;
       } else {
            document.getElementById("lb_img_c").classList.remove("missing");
       }
       
       /*
       if (document.forms["form"]["img_ef1"].value==""){
           document.getElementById("lb_img_ef").classList.add("missing");
           valid=false;
       } else {
            document.getElementById("lb_img_ef").classList.remove("missing");
       }
      
       
       if (document.forms["form"]["img_r1"].value==""){
           document.getElementById("lb_img_r").classList.add("missing");
           valid=false;
       } else {
            document.getElementById("lb_img_r").classList.remove("missing");
       }
        */
       return valid;
    }
  </script>
  </head>
<body>';

echo '
  <span class="fond"></span>
  <span class="cont">
  
  
 <a class="logo" href="http://monnaie-leman.org/"><img src="css/image/logo.png" width="160px"/></a> 
 
	<h2><span id="title">Léman électronique: VOS DONNÉES PERSONELLES</span> - Entreprise (étape <span id="step">1</span>/<span id="tot_step">5</span>)</h2>';

echo '
    <span class="cont_d" >
    <form id="form" enctype="multipart/form-data" action="./submitLegal.php" method="post">
    <div id="sect_ip">
    <h3> Informations générales  </h3>

	 <span class="fitem">
	   <span class="label" id="lb_name">Nom légal de la société*</span>
	   <input class="inputText"  type="text" id ="name" name="name" value="" placeholder="Nom de la société*" required="required"/><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" id="lb_RefName">Nom de l’entreprise à géoréférencer (si différente)</span>
	   <textarea class="inputText"  maxlength="255" name="RefName"  placeholder="Nom de l’entreprise à géoréférencer (si différente)"/></textarea><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" >Personne de contact:</span><br/>
	   <span class="label" id="lb_cont_gender"> Civilité*</span>
	   <select  class="inputText" name="cont_gender" id ="cont_gender" >
	    <option value =""></option>
	    <option value ="Feminin">Mme</option>
	    <option value ="Masculin">M.</option>
	    <option value ="Autre">Autre</option>
	   </select><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" id="lb_contact" > Nom*</span>
	   <input class="inputText"  type="text" id ="contact" name="contact" value="" placeholder="Personne de contact: Nom*" required="required"/><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" id="lb_ContactSurname" >Prénom*</span>
	   <input class="inputText"  type="text" id ="ContactSurname" name="ContactSurname" value="" placeholder="Personne de contact: Prénom*" required="required"/><br/><br/>
	 </span>
	 
	
	 
	 <span class="fitem">
	   <span class="label" id="lb_kind" >Statut juridique*</span>
	   <select  class="inputText" name="kind" id ="kind" >
	   '.$status_juridique.'
	   </select>
	   <br/>
	 </span>
	 <span class="fitem">
	   <span class="label" id="lb_created_on">Date de création*</span>
	   <input class="inputText"  type="date" id="created_on" name="created_on" value="" placeholder="Date de création*" required="required"/><br/>
	 </span>
	 
	 
	 <span class="fitem">
	   <span class="label" id="lb_fieldActivity" >Secteur d’activité*</span>
	   <select  class="inputText" name="fieldActivity" id ="fieldActivity" >
	   '.$activity_sector.'
	   </select><br/>
	   	 </span>

	 <span class="fitem">
	   <span class="label" id="lb_ActivityFieldSeg" >Secteur d’activité suppl.</span>
	   <select  class="inputText" name="ActivityFieldSeg" id ="ActivityFieldSeg" >
	   '.$activity_sector.'
	   </select><br/>
	 </span>
	 
	 
	  <span class="fitem">
	   <span class="label" id="lb_activityDesc" >Description de l’activité*</span>
	   <textarea class="inputText" maxlength="255"  name="activityDesc"  placeholder="Description de l’activité*"/></textarea><br/>
	 </span>
	 <span class="fitem">
	   <span class="label" id="lb_ETP" >Nombre d’employés (ETP)*</span>
	   <input class="inputText" onchange="computeCotisation()" min="0" step="0.05" type="number" id ="ETP" name="ETP" value="" placeholder="Nombre d’employés (ETP)*" required="required" on/><br/>
	 </span>
	 <span class="fitem">
	   <span class="label" id="lb_mail">Email*</span>
	   <input class="inputText"  type="email" id="mail" name="mail" value="" placeholder="Email*" required="required"/><br/>
	 </span>
	 <span class="fitem">
	   <span class="label" id="lb_mailconf">Email (confirmation)*</span>
	   <input class="inputText"  type="email" id="mailconf" name="mailconf" value="" placeholder="Email (confirmation)*" required="required"/><br/>
	 </span>
	 <span class="fitem">
	   <span class="label" id="lb_phone">Téléphone*</span>
	   <input class="inputText"  type="tel"  id="phone" name="phone" value="" placeholder="+41 22 123 45 67 / +33 6 77 77 88 99" required="required"/><br/>
	 </span>
	 <span class="fitem">
	   <span class="label" id="lb_www">Site internet</span>
	   <input class="inputText"  type="tel"  id="www" name="www" value="" placeholder="https://www.monsite.com" /><br/>
	 </span>
	 
    <h3> Adresse légale </h3>
	 
	 
	  <span class="fitem">
	   <span class="label" id="lb_street">Rue et numéro*</span>
	   <input class="inputText"  type="text" id="street" name="street" value="" placeholder="Rue et numéro*" required="required"/><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" >Complément d\'adresse</span>
	   <input class="inputText"  type="text" id="compl" name="compl" value="" placeholder="Complément d\'adresse" /><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" id="lb_zip">Code postal*</span>
	   <input class="inputText"  type="text" id="zip" name="zip" value="" placeholder="Code postal*" required="required"/><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" id="lb_city">Ville*</span>
	   <input class="inputText"  type="text" id="city" name="city" value="" placeholder="Ville*" required="required"/><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" id="lb_country">Pays*</span>
	   <select  class="inputText" name="country" id ="country" onChange="computeCotisation();" >
	   '.$country.'
	   </select><br/>
	 </span>
	 
	  <h3> Adresse postale </h3>
	  <span class="fitem">
	   <input class="inputCb"  type="checkbox" id="postalAsLegal" name="postalAsLegal" value="1" checked="checked" onClick="togelPostal()"/>
	   <span  class="labelCb">Adresse postale identique à l\'adresse légale</span><br/>
	 </span>
	 <span id="blk_add_postal" style="display:none" >
	     <span class="fitem">
	       <span class="label" id="lb_p_street">Rue et numéro*</span>
	       <input class="inputText"  type="text" id="p_street" name="p_street" value="" placeholder="Rue et numéro*" required="required"/><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" >Complément d\'adresse</span>
	       <input class="inputText"  type="text" id="p_compl" name="p_compl" value="" placeholder="Complément d\'adresse" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_p_zip">Code postal*</span>
	       <input class="inputText"  type="text" id="p_zip" name="p_zip" value="" placeholder="Code postal*" required="required"/><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_p_city">Ville*</span>
	       <input class="inputText"  type="text" id="p_city" name="p_city" value="" placeholder="Ville*" required="required"/><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_p_country">Pays*</span>
	       <select  class="inputText" name="p_country" id ="p_country" >
	       '.$country.'
	       </select><br/>
	     </span>
	 </span>
	 <a class="button" onclick="if (validateSectionInfo()){showSection(\'sect_add\');}">Suivant</a>
</div>
<div id="sect_add" style="display:none" >
 <h3> Adhésion à l\'association Monnaie Léman  </h3>
	 
	  <span class="txtWide">L\'association Monnaie Léman gère et promeut l\'utilisation de la monnaie complémentaire le Léman.<br/>
En tant qu\'entreprise vous devez adhérer à l\'association pour pouvoir faire partie du réseau et utiliser le Léman (papier et électronique). <br/> <br/> 

Avec ce compte, vous bénéficiez:<ul>
<li>d‘une ligne de crédit en fonction de la taille de votre entreprise; </li>
<li>sans taux d’intérêt;</li>
<li>dont les frais de service s’élèvent à: 1% à la charge du vendeur dans le commerce de détail, 0.5% entre deux entreprises pour chacune des 2 parties, 0% d’une entreprise à un particulier (salaire) ou entre deux particuliers.</li>
</ul><br/>
	  La cotisation annuelle – qui dépend du nombre des personnes employées – se monte dans votre cas, à <span class="strong" id="cot_amount">CHF 50</span>. Elle doit être réglée dans les 30 jours.<br/> <br/>
	  
	  Les coordonnées bancaires de Monnaie Léman:
 </span>
	     <span class="full" id="coo_ch">
Monnaie Léman Suisse - rue des Savoises 15 - 1205 Genève<br/>
Banque Alternative Suisse - IBAN: CH22 0839 0034 3841 1010 0 - BIC: ABSOCH22 <br/>
	  </span>
	  <span class="full" id="coo_fr">
Monnaie Léman France - 21 avenue de Verdun - 74100 Annemasse<br/>
Caisse d’épargne Rhône Alpes Annemasse<br/>
IBAN: FR76 1382 5002 0008 0092 2674 657 - BIC: CEPAFRPP382<br/>
	  </span><br/>
	  <span class="labelWide">
Vous pouvez régler votre cotisation en lémans électroniques (e-LEM) sur le compte de l’association (clé publique 0x15a18329381cdf1919d51d05834920585066646f): <span class="strong">e-LEM <span  id="cot_amount_2">50(taux moyen du jour)</span></span>.

	  
	 </span>';
	 


if ($type_form==0) {
    echo '
	<span class="labelWide" id="lb_ad_ass" style="display:none;"></span>
	<input  type="hidden"  id="ad_ass" name="ad_ass" value="Oui" />

	 
	  <span class="fitem">
	   <input class="inputCb"  style="margin-left: 20px !important;" type="checkbox"  id="data" name="data" value="1" required="required"/>
	   <span class="labelCb"  style="width: calc(100% - 80px);" id="lb_data">En remplissant ce formulaire, vous acceptez que l\'on utilise vos données pour vous contacter, ou pour toutes autres utilisations permettant de développer le Léman de façon anonyme sans les communiquer à des tiers.*</span><br/>
	 </span>
	 
	 <span class="fitem">
	   <input class="inputCb"  style="margin-left: 20px !important;" type="checkbox" id="news" name="news" value="1" />
	   <span  class="labelCb" style="width: calc(100% - 80px);" >En cochant cette case, je consens à recevoir la newsletter de l’association. </span><br/>
	 </span>
	 
 <span class="fitem" id="fld_ce" style="display:None;">
	     <input class="inputCb" style="margin-left: 20px !important;" type="checkbox" name="ce_0"  value="1" />
	     <span  class="labelCb"  style="width: calc(100% - 80px);" id="lb_ce_0">J\'adhère à la "<a target="_blank" href="'.$url_charte.'" class="it ait">Charte éthique du Léman</a>.* </span><br/>
     </span>
	 
	<span class="fitem" id="fld_att" style="display:None;">
	 <input class="inputCb" style="margin-left: 20px !important;" type="checkbox" name="att_0"  value="1" />
	 <span  class="labelCb"  style="width: calc(100% - 80px);" id="lb_att_0">
    J’atteste que toutes les informations fournies ci-dessus sont, à ma connaissance, authentiques et exactes, et je m’engage à vous informer sans délai de tout changement.* </span><br/>
    </span> 
	 
	 <span class="fitem" id="fld_cr_acc" style="display:None;">
	   <span class="labelWide" id="lb_cr_acc">Voulez vous aussi ouvrir un compte en Léman électronique?*</span>
	   <select  class="inputText" name="cr_acc" id ="cr_acc" onchange="changeType();" >
	    <option value =""></option>
	    <option value ="1">Oui</option>
	    <option value ="0">Non</option>
	   </select><br/>
	 </span>';
} else {

echo '
	 
	  <span class="fitem">
	   <span class="labelWide" id="lb_ad_ass">Voulez vous adhérer à l\'association Monnaie-Léman?*</span>
	   <select  class="inputText" name="ad_ass" id ="ad_ass" >
	    <option value =""></option>
	    <option value ="Oui">Oui</option>
	    <option value ="Déjà membre">L\'entreprise est déjà membre</option>
	   </select><br/>
	 </span>
	 
	  <span class="fitem">
	   <input class="inputCb"  type="checkbox"  id="data" name="data" value="1" required="required"/>
	   <span class="labelCb" id="lb_data">En remplissant ce formulaire, vous acceptez que l\'on utilise vos données pour vous contacter, ou pour toutes autres utilisations permettant de développer le Léman de façon anonyme sans les communiquer à des tiers.*</span><br/>
	 </span>
	 
	 <span class="fitem">
	   <input class="inputCb"  type="checkbox" id="news" name="news" value="1" />
	   <span  class="labelCb">En cochant cette case, je consens à recevoir la newsletter de l’association. </span><br/>
	 </span>
	 
 <span class="fitem" id="fld_ce" style="display:None;">
	     <input class="inputCb" type="checkbox" name="ce_0"  value="1" />
	     <span  class="labelCb" id="lb_ce_0">J\'adhère à la "<a target="_blank" href="'.$url_charte.'" class="it ait">Charte éthique du Léman</a>.* </span><br/>
     </span>
	 
	<span class="fitem" id="fld_att" style="display:None;">
	 <input class="inputCb" type="checkbox" name="att_0"  value="1" />
	 <span  class="labelCb" id="lb_att_0">
    J’atteste que toutes les informations fournies ci-dessus sont, à ma connaissance, authentiques et exactes, et je m’engage à vous informer sans délai de tout changement.* </span><br/>
    </span> 
	 
	 <span class="fitem" id="fld_cr_acc" style="display:None;">
	   <span class="labelWide" id="lb_cr_acc">Voulez vous aussi ouvrir un compte en Léman électronique?*</span>
	   <select  class="inputText" name="cr_acc" id ="cr_acc" onchange="changeType();" >
	    <option value =""></option>
	    <option value ="1">Oui</option>
	    <option value ="0">Non</option>
	   </select><br/>
	 </span>';


	 }	 
	 
echo	 '
	 
     <a  class="button" onclick="showSection(\'sect_ip\');">Précédent</a>
	 <a class="button" id="adh_next" onclick="if (validateSectionAdd()){showSection(\'sect_fin\');}">Suivant</a>
	 <a class="button" id="adh_sub" onclick="if (validateSectionAdd()){document.forms[\'form\'].submit();return false;}">Valider ma demande</a>
</div>
<div id="sect_fin" style="display:none">
<h3> Gestion du compte électronique par des personnes autorisées </h3>
<span class="labelWide"> 
Souhaitez-vous autoriser d’autres personnes à gérer et utiliser le compte électronique de l’entreprise (personnes collaboratrices, mandataires, etc.) ?

 <input class=""  type="radio" name="pa_dec" value="1" onClick="toglePA()"/>&nbsp;Oui / 
	 <input class=""  type="radio" name="pa_dec" value="0" onClick="toglePA()" checked="checked"/>&nbsp;Non
</span>

 <span id="pa_other" style="display:none;"  >
        Veuillez indiquer ci-après les coordonnées de celle(s)-ci.<br/>
	    Personne/s autorisée/s: 
	       <a onClick="showSt(1)" id="btn_st1" class="selected ait">(1)</a> 
	       <a onClick="showSt(2)" id="btn_st2"  class="ait" style="display:none">(2)</a>  
	       <a onClick="showSt(3)" id="btn_st3"  class="ait" style="display:none">(3)</a>  
	       <a onClick="showSt(4)" id="btn_st4"  class="ait" style="display:none">(4)</a>  
	       <a id="btn_stadd" onClick="addSt()"  class="ait" >Ajouter</a><br/>
 <span class="aed" id="st_1_other" style="display:block">
	 
	   Personne autorisée 1
	 <span class="fitem">
	   <span class="label" id="lb_st_1_name">Nom*</span>
	    <input class="inputText"  type="text" name="st_1_name" value="" placeholder="Nom*"/><br/>
	 
	  </span>   
	 <span class="fitem">
	   <span class="label" id="lb_st_1_surname">Prénom*</span>
	    <input class="inputText"  type="text" name="st_1_surname" value="" placeholder="Prénom*"/><br/>
	  
	  </span> 
	  <span class="fitem">
	       <span class="label" id="lb_st_1_add">Rue et numéro*</span>
	       <input class="inputText"  type="text" id="st_1_add" name="st_1_add" value="" placeholder="Rue et numéro*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" >Complément d\'adresse</span>
	       <input class="inputText"  type="text" id="st_1_compl" name="st_1_compl" value="" placeholder="Complément d\'adresse" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_st_1_zip">Code postal*</span>
	       <input class="inputText"  type="text" id="st_1_zip" name="st_1_zip" value="" placeholder="Code postal*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_st_1_city">Ville*</span>
	       <input class="inputText"  type="text" id="st_1_city" name="st_1_city" value="" placeholder="Ville*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_st_1_country">Pays*</span>
	       <select  class="inputText" name="st_1_country" id ="st_1_country" >
	       '.$country.'
	       </select><br/>
	     </span>
	     
	 
	 <span class="fitem">
	    <span class="label" id="lb_st_1_born">Date de naissance*</span>
	    <input class="inputText"  type="date" name="st_1_born" value="" placeholder="Date de naissance*" >
	  
	  </span>  
	    
	 <span class="fitem">
	    <span class="label" id="lb_st_1_cit">Nationalité*</span>
	    <select  class="inputText" name="st_1_cit">'.$country.'</select><br/>
	 
	  </span>
	  </span>
	  
	 <span class="aed" id="st_2_other" style="display:none">
	 
	    Personne autorisée 2
	 <span class="fitem">
	   <span class="label" id="lb_st_2_name">Nom*</span>
	    <input class="inputText"  type="text" name="st_2_name" value="" placeholder="Nom*"/><br/>
	 
	  </span>   
	 <span class="fitem">
	   <span class="label" id="lb_st_2_surname">Prénom*</span>
	    <input class="inputText"  type="text" name="st_2_surname" value="" placeholder="Prénom*"/><br/>
	  
	  </span> 
	  <span class="fitem">
	       <span class="label" id="lb_st_2_add">Rue et numéro*</span>
	       <input class="inputText"  type="text" id="st_2_add" name="st_2_add" value="" placeholder="Rue et numéro*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" >Complément d\'adresse</span>
	       <input class="inputText"  type="text" id="st_2_compl" name="st_2_compl" value="" placeholder="Complément d\'adresse" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_st_2_zip">Code postal*</span>
	       <input class="inputText"  type="text" id="st_2_zip" name="st_2_zip" value="" placeholder="Code postal*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_st_2_city">Ville*</span>
	       <input class="inputText"  type="text" id="st_2_city" name="st_2_city" value="" placeholder="Ville*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_st_2_country">Pays*</span>
	       <select  class="inputText" name="st_2_country" id ="st_2_country" >
	       '.$country.'
	       </select><br/>
	     </span>
	     
	 
	 <span class="fitem">
	    <span class="label" id="lb_st_2_born">Date de naissance*</span>
	    <input class="inputText"  type="date" name="st_2_born" value="" placeholder="Date de naissance*" >
	  
	  </span>  
	    
	 <span class="fitem">
	    <span class="label" id="lb_st_2_cit">Nationalité*</span>
	    <select  class="inputText" name="st_2_cit">'.$country.'</select><br/>
	 
	  </span>
	  </span>  
	  
	  <span  class="aed" id="st_3_other" style="display:none">
	 
	    Personne autorisée 3
	 <span class="fitem">
	   <span class="label" id="lb_st_3_name">Nom*</span>
	    <input class="inputText"  type="text" name="st_3_name" value="" placeholder="Nom*"/><br/>
	 
	  </span>   
	 <span class="fitem">
	   <span class="label" id="lb_st_3_surname">Prénom*</span>
	    <input class="inputText"  type="text" name="st_3_surname" value="" placeholder="Prénom*"/><br/>
	  
	  </span> 
	 <span class="fitem">
	       <span class="label" id="lb_st_3_add">Rue et numéro*</span>
	       <input class="inputText"  type="text" id="st_3_add" name="st_3_add" value="" placeholder="Rue et numéro*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" >Complément d\'adresse</span>
	       <input class="inputText"  type="text" id="st_3_compl" name="st_3_compl" value="" placeholder="Complément d\'adresse" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_st_3_zip">Code postal*</span>
	       <input class="inputText"  type="text" id="st_3_zip" name="st_3_zip" value="" placeholder="Code postal*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_st_3_city">Ville*</span>
	       <input class="inputText"  type="text" id="st_3_city" name="st_3_city" value="" placeholder="Ville*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_st_3_country">Pays*</span>
	       <select  class="inputText" name="st_3_country" id ="st_3_country" >
	       '.$country.'
	       </select><br/>
	     </span>
	 
	 <span class="fitem">
	    <span class="label" id="lb_st_3_born">Date de naissance*</span>
	    <input class="inputText"  type="date" name="st_3_born" value="" placeholder="Date de naissance*" >
	  
	  </span>  
	    
	 <span class="fitem">
	    <span class="label" id="lb_st_3_cit">Nationalité*</span>
	    <select  class="inputText" name="st_3_cit">'.$country.'</select><br/>
	 
	  </span>
	  </span>  
	  
	  <span class="aed" id="st_4_other" style="display:none">
	 	  
  Personne autorisée 4
	 <span class="fitem">
	   <span class="label" id="lb_st_4_name">Nom*</span>
	    <input class="inputText"  type="text" name="st_4_name" value="" placeholder="Nom*"/><br/>
	 
	  </span>   
	 <span class="fitem">
	   <span class="label" id="lb_st_4_surname">Prénom*</span>
	    <input class="inputText"  type="text" name="st_4_surname" value="" placeholder="Prénom*"/><br/>
	  
	  </span> 
	  <span class="fitem">
	       <span class="label" id="lb_st_4_add">Rue et numéro*</span>
	       <input class="inputText"  type="text" id="st_4_add" name="st_4_add" value="" placeholder="Rue et numéro*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" >Complément d\'adresse</span>
	       <input class="inputText"  type="text" id="st_4_compl" name="st_4_compl" value="" placeholder="Complément d\'adresse" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_st_4_zip">Code postal*</span>
	       <input class="inputText"  type="text" id="st_4_zip" name="st_4_zip" value="" placeholder="Code postal*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_st_4_city">Ville*</span>
	       <input class="inputText"  type="text" id="st_4_city" name="st_4_city" value="" placeholder="Ville*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_st_4_country">Pays*</span>
	       <select  class="inputText" name="st_4_country" id ="st_4_country" >
	       '.$country.'
	       </select><br/>
	     </span> 
	 
	 <span class="fitem">
	    <span class="label" id="lb_st_4_born">Date de naissance*</span>
	    <input class="inputText"  type="date" name="st_4_born" value="" placeholder="Date de naissance*" >
	  
	  </span>  
	    
	 <span class="fitem">
	    <span class="label" id="lb_st_4_cit">Nationalité*</span>
	    <select  class="inputText" name="st_4_cit">'.$country.'</select><br/>
	 
	  </span>
	  </span>  
	 </span>
	 

<h3> Conformité / compliance FINMA  </h3>

<span class="fitem">
	   <span class="labelWide" id="lb_pep">La/les personne/s ayant droit économique (ADE) est-elle / sont-elles une/des personne/s politiquement exposée/s (<a class="tooltip ait" >PEP<span class="tooltiptext">Les personnes politiquement exposées (PEP) sont des personnes physiques qui exercent une haute fonction publique ou politique ou des personnes connues pour leur être étroitement associées.</span></a>)?* </span>
	   <select  class="inputText" id="pep" name="pep">
	    <option value =""></option>
	    <option value ="1">Oui</option>
	    <option value ="0">Non</option>
	   </select><br/>
	 </span>

<span class="fitem">
	   <span class="labelWide"  id="lb_peprel">La/les personnes ADE est-elle / sont-elles liée/s à une/des <a class="tooltip ait">PEP<span class="tooltiptext">Les personnes politiquement exposées (PEP) sont des personnes physiques qui exercent une haute fonction publique ou politique ou des personnes connues pour leur être étroitement associées.</span></a> (famille, ami-e-s proches, etc.)?*</span>
	   <select  class="inputText" id="peprel" name="peprel">
	    <option value =""></option>
	    <option value ="1">Oui</option>
	    <option value ="0">Non</option>
	   </select><br/>
	 </span>

	   <span class="fitem">
	   
	   <span class="labelWide" >Je prends connaissance et je souscris aux conditions suivantes:<br/> <br/> 
Votre argent est placé dans une banque éthique et ciblé sur des produits "durables".
En cas d\'arrêt des activités de Monnaie Léman, les personnes détentrices de lémans pourront être remboursés en francs suisses.<br/><br/>
Conformité FINMA (applicable pour l’ouverture de comptes électroniques en Suisse):<ul>
<li>Monnaie Léman n\'est pas surveillée par la FINMA;</li>
<li>Les dépôts ne sont pas couverts par la garantie des dépôts.</li></ul>
J’accepte ces conditions. Sinon, je vous le communique dans un délai d’une année à partir de cette date (inscription); au-delà, mon acceptation est considérée comme tacite.
</span><br/>
	 </span>
	 <span class="fitem">
	 <input class="inputCb"  type="checkbox" name="cond" name="cond" value="1" required="required"/>
	 <span  class="labelCb" id="lb_cond">Lu et approuvé* </span><br/>
	 </span>
	  </span>
	  
	  
	  <h3>Déclaration de la / des personne/s bénéficiaire/s et ayant droit économique (ADE)</h3>
	  
	 <span class="label"  id="lb_aed_dec">Je déclare:*</span><br/>
	 <input class="inputCb"  type="radio" name="aed_dec" value="AED" onClick="togleAed()"/>
	 <span  class="labelCb">l\'entreprise être la seule ayant droit économique des valeurs patrimoniales impliquées dans sa relation avec le Léman électronique.</span><br/>
	 
	  <input class="inputCb"  type="radio" name="aed_dec" value="Autre" onClick="togleAed()"/>
	 <span  class="labelCb">que la/les personne/s suivante/s est/sont la/les personne/s ayant droit économique des valeurs patrimoniales impliquées dans la relation avec le Léman électronique.</span><br/>
	 
	   
	 </span>
	 
	 <span id="aed_other"  style="display:none" >
	    Personnes ADE: 
	       <a onClick="showAed(1)" id="btn_aed1" class="selected ait">(1)</a> 
	       <a onClick="showAed(2)" id="btn_aed2" class="ait" style="display:none">(2)</a>  
	       <a onClick="showAed(3)" id="btn_aed3" class="ait"  style="display:none">(3)</a>  
	       <a onClick="showAed(4)" id="btn_aed4" class="ait"  style="display:none">(4)</a>  
	       <a id="btn_aedadd" onClick="addAed()" class="ait" >Ajouter</a><br/>
	 <span class="aed" id="aed_1_other" style="display:block">
	   ADE 1
	    <span class="fitem">
	        <span class="label" id="lb_aed_1_name">Nom*</span>
	        <input class="inputText"  type="text" name="aed_1_name" value="" placeholder="Nom*"/><br/>
	    </span>   
	    <span class="fitem">
	        <span class="label" id="lb_aed_1_surname">Prénom*</span>
	        <input class="inputText"  type="text" name="aed_1_surname" value="" placeholder="Prénom*"/><br/>
	    </span> 
	    
	     <span class="fitem">
	       <span class="label" id="lb_aed_1_add">Rue et numéro*</span>
	       <input class="inputText"  type="text" id="aed_1_add" name="aed_1_add" value="" placeholder="Rue et numéro*" /><br/>
	     </span>

	     <span class="fitem">
	       <span class="label" >Complément d\'adresse</span>
	       <input class="inputText"  type="text" id="aed_1_compl" name="aed_1_compl" value="" placeholder="Complément d\'adresse" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_aed_1_zip">Code postal*</span>
	       <input class="inputText"  type="text" id="aed_1_zip" name="aed_1_zip" value="" placeholder="Code postal*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_aed_1_city">Ville*</span>
	       <input class="inputText"  type="text" id="aed_1_city" name="aed_1_city" value="" placeholder="Ville*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_aed_1_country">Pays*</span>
	       <select  class="inputText" name="aed_1_country" id ="aed_1_country" >
	       '.$country.'
	       </select><br/>
	     </span>
	    
	    
	      
	    <span class="fitem">
	        <span class="label" id="lb_aed_1_born">Date de naissance*</span>
	        <input class="inputText"  type="date" name="aed_1_born" value="" placeholder="Date de naissance*" >
	    </span>  
	    
	    <span class="fitem">
	        <span class="label" id="lb_aed_1_cit">Nationalité*</span>
	        <select  class="inputText" name="aed_1_cit">'.$country.'</select><br/>
	    </span>
	 </span>  
	  
	 <span class="aed" id="aed_2_other" style="display:none">
	 
	 ADE 2
	 <span class="fitem">
	   <span class="label" id="lb_aed_2_name">Nom*</span>
	    <input class="inputText"  type="text" name="aed_2_name" value="" placeholder="Nom*"/><br/>
	 
	  </span>   
	 <span class="fitem">
	   <span class="label" id="lb_aed_2_surname">Prénom*</span>
	    <input class="inputText"  type="text" name="aed_2_surname" value="" placeholder="Prénom*"/><br/>
	  
	  </span> 
	  <span class="fitem">
	       <span class="label" id="lb_aed_2_add">Rue et numéro*</span>
	       <input class="inputText"  type="text" id="aed_2_add" name="aed_2_add" value="" placeholder="Rue et numéro*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" >Complément d\'adresse</span>
	       <input class="inputText"  type="text" id="aed_2_compl" name="aed_2_compl" value="" placeholder="Complément d\'adresse" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_aed_2_zip">Code postal*</span>
	       <input class="inputText"  type="text" id="aed_2_zip" name="aed_2_zip" value="" placeholder="Code postal*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_aed_2_city">Ville*</span>
	       <input class="inputText"  type="text" id="aed_2_city" name="aed_2_city" value="" placeholder="Ville*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_aed_2_country">Pays*</span>
	       <select  class="inputText" name="aed_2_country" id ="aed_2_country" >
	       '.$country.'
	       </select><br/>
	     </span>
	     
	 
	 <span class="fitem">
	    <span class="label" id="lb_aed_2_born">Date de naissance*</span>
	    <input class="inputText"  type="date" name="aed_2_born" value="" placeholder="Date de naissance*" >
	  
	  </span>  
	    
	 <span class="fitem">
	    <span class="label" id="lb_aed_2_cit">Nationalité*</span>
	    <select  class="inputText" name="aed_2_cit">'.$country.'</select><br/>
	 
	  </span>
	  </span>  
	  
	  <span  class="aed" id="aed_3_other" style="display:none">
	 
	 ADE 3
	 <span class="fitem">
	   <span class="label" id="lb_aed_3_name">Nom*</span>
	    <input class="inputText"  type="text" name="aed_3_name" value="" placeholder="Nom*"/><br/>
	 
	  </span>   
	 <span class="fitem">
	   <span class="label" id="lb_aed_3_surname">Prénom*</span>
	    <input class="inputText"  type="text" name="aed_3_surname" value="" placeholder="Prénom*"/><br/>
	  
	  </span> 
	 <span class="fitem">
	       <span class="label" id="lb_aed_3_add">Rue et numéro*</span>
	       <input class="inputText"  type="text" id="aed_3_add" name="aed_3_add" value="" placeholder="Rue et numéro*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" >Complément d\'adresse</span>
	       <input class="inputText"  type="text" id="aed_3_compl" name="aed_3_compl" value="" placeholder="Complément d\'adresse" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_aed_3_zip">Code postal*</span>
	       <input class="inputText"  type="text" id="aed_3_zip" name="aed_3_zip" value="" placeholder="Code postal*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_aed_3_city">Ville*</span>
	       <input class="inputText"  type="text" id="aed_3_city" name="aed_3_city" value="" placeholder="Ville*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_aed_3_country">Pays*</span>
	       <select  class="inputText" name="aed_3_country" id ="aed_3_country" >
	       '.$country.'
	       </select><br/>
	     </span>
	 
	 <span class="fitem">
	    <span class="label" id="lb_aed_3_born">Date de naissance*</span>
	    <input class="inputText"  type="date" name="aed_3_born" value="" placeholder="Date de naissance*" >
	  
	  </span>  
	    
	 <span class="fitem">
	    <span class="label" id="lb_aed_3_cit">Nationalité*</span>
	    <select  class="inputText" name="aed_3_cit">'.$country.'</select><br/>
	 
	  </span>
	  </span>  
	  
	  <span class="aed" id="aed_4_other" style="display:none">
	 
	 ADE 4
	 <span class="fitem">
	   <span class="label" id="lb_aed_4_name">Nom*</span>
	    <input class="inputText"  type="text" name="aed_4_name" value="" placeholder="Nom*"/><br/>
	 
	  </span>   
	 <span class="fitem">
	   <span class="label" id="lb_aed_4_surname">Prénom*</span>
	    <input class="inputText"  type="text" name="aed_4_surname" value="" placeholder="Prénom*"/><br/>
	  
	  </span> 
	  <span class="fitem">
	       <span class="label" id="lb_aed_4_add">Rue et numéro*</span>
	       <input class="inputText"  type="text" id="aed_4_add" name="aed_4_add" value="" placeholder="Rue et numéro*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" >Complément d\'adresse</span>
	       <input class="inputText"  type="text" id="aed_4_compl" name="aed_4_compl" value="" placeholder="Complément d\'adresse" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_aed_4_zip">Code postal*</span>
	       <input class="inputText"  type="text" id="aed_4_zip" name="aed_4_zip" value="" placeholder="Code postal*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_aed_4_city">Ville*</span>
	       <input class="inputText"  type="text" id="aed_4_city" name="aed_4_city" value="" placeholder="Ville*" /><br/>
	     </span>
	     
	     <span class="fitem">
	       <span class="label" id="lb_aed_4_country">Pays*</span>
	       <select  class="inputText" name="aed_4_country" id ="aed_4_country" >
	       '.$country.'
	       </select><br/>
	     </span> 
	 
	 <span class="fitem">
	    <span class="label" id="lb_aed_4_born">Date de naissance*</span>
	    <input class="inputText"  type="date" name="aed_4_born" value="" placeholder="Date de naissance*" >
	  
	  </span>  
	    
	 <span class="fitem">
	    <span class="label" id="lb_aed_4_cit">Nationalité*</span>
	    <select  class="inputText" name="aed_4_cit">'.$country.'</select><br/>
	 
	  </span>
	  </span>  
	 </span>
	 
	 
	 
	  
	  
	
    <a  class="button" onclick="showSection(\'sect_add\');">Précédent</a>  
    <a  class="button" onclick="if (validateSectionFin()){showSection(\'sect_sign\');}">Suivant</a>
</div>
<div id="sect_sign" style="display:none">
 <h3>Documentation et signature </h3>
 
  <span class="fitem">
	 <input class="inputCb"  type="checkbox" name="cgu" name="cgu" value="1" required="required"/>
	 <span  class="labelCb" id="lb_cgu">J’atteste avoir pris connaissance et accepté les <a target="_blank" href="'.$url_cgu.'" class="it ait">Conditions générales d’utilisation</a>.* </span><br/>
  </span>
  <span class="fitem">
	 <input class="inputCb" type="checkbox" name="ce" name="ce" value="1" required="required"/>
	 <span  class="labelCb" id="lb_ce">J’atteste avoir pris connaissance et accepté la <a target="_blank" href="'.$url_charte.'" class="it ait">Charte éthique du Léman</a>.* </span><br/>
  </span>
  
  <span class="fitem">
   <span class="labelWide" id="lb_img_c">Je joins une copie d’une pièce d’identité valide pour chaque personne ayant droit économique (ADE), administratrice et/ou autorisée à utiliser la monnaie électronique.*</span>
  <input class="inputText" next="c2" type="file" id="img_c1" name="img_c1" accept="application/pdf,image/*" >
  <input class="inputText" next="c3" type="file" id="img_c2" name="img_c2" accept="application/pdf,image/*"  style="display:none">
  <input class="inputText" next="c4" type="file" id="img_c3" name="img_c3" accept="application/pdf,image/*"  style="display:none">
  <input class="inputText" next="c5" type="file" id="img_c4" name="img_c4" accept="application/pdf,image/*"  style="display:none">
  <input class="inputText" next="c6" type="file" id="img_c5" name="img_c5" accept="application/pdf,image/*"  style="display:none">
  <input class="inputText" next="c7" type="file" id="img_c6" name="img_c6" accept="application/pdf,image/*" style="display:none">
  <input class="inputText" next="c8" type="file" id="img_c7" name="img_c7" accept="application/pdf,image/*" style="display:none">
  <input class="inputText" next="c9" type="file" id="img_c8" name="img_c8" accept="application/pdf,image/*" style="display:none">
  <input class="inputText" next="c10" type="file" id="img_c9" name="img_c9" accept="application/pdf,image/*" style="display:none">
  <input class="inputText" next="c11" type="file" id="img_c10" name="img_c10" accept="application/pdf,image/*" style="display:none">
  <input class="inputText" next="c12" type="file" id="img_c11" name="img_c11" accept="application/pdf,image/*" style="display:none">
  <input class="inputText" next="" type="file" id="img_c12" name="img_c12" accept="application/pdf,image/*" style="display:none"><br/>
    </span>
    
  <span class="fitem">
   <span class="labelWide" id="lb_img_ef">Je joins les deux derniers états financiers (si disponibles).</span>
  <input class="inputText" next="ef2" type="file" id="img_ef1" name="img_ef1" accept="application/pdf,image/*" >
  <input class="inputText" next="ef3" type="file" id="img_ef2" name="img_ef2" accept="application/pdf,image/*"  style="display:none">
  <input class="inputText" next="" type="file" id="img_ef3" name="img_ef3" accept="application/pdf,image/*"  style="display:none"><br/>
    </span>
    
  <span class="fitem">
   <span class="labelWide" id="lb_img_r">Je joins un extrait du <span class="it">Registre du commerce</span> (si applicable).</span>
  <input class="inputText" next="r2"type="file" id="img_r1" name="img_r1" accept="application/pdf,image/*" required="required">
  <input class="inputText" next="r3"type="file" id="img_r2" name="img_r2" accept="application/pdf,image/*"  style="display:none">
  <input class="inputText" next="" type="file" id="img_r3" name="img_r3" accept="application/pdf,image/*"  style="display:none"><br/>
    </span>
    
    
    
    
  <span class="fitem">
	 <input class="inputCb" type="checkbox" name="eng" name="eng" value="1" required="required"/>
	 <span  class="labelCb" id="lb_eng">J\'ai pris note que remplir intentionnellement ce formulaire de manière erronée est constitutif du délit de faux dans les titres au sens de l’<span class="it">Art. 251 du Code pénal suisse</span>.* </span><br/>
  </span>  
  
  <span class="fitem">
	 <input class="inputCb" type="checkbox" name="att" id="att" value="1" required="required"/>
	 <span  class="labelCb" id="lb_att">
    J’atteste que toutes les informations fournies ci-dessus sont, à ma connaissance, authentiques et exactes, et je m’engage à vous informer sans délai de tout changement.* </span><br/>
  </span> '; 
  

  
  echo' 
  
  
  
  <h3>EN VALIDANT CETTE DEMANDE, VOUS PASSEZ À LA PHASE 2: L\'OUVERTURE DE VOTRE COMPTE </h3>
  
 <a  class="button" onclick="showSection(\'sect_fin\');">Précédent</a>
 <a class="button" onclick="if (validateSectionDoc()){document.forms[\'form\'].submit();}">Valider ma demande</a>

 
</div>
    </form>
   
     
   
  </span>
   </span>
</body>
<script>

    function showNext(postfix){
        document.getElementById("img_"+postfix).style.display="block";
    }

    function handleFileDialog(id,changed) {
       
        if (changed){
            var file = document.getElementById(id).files[0];

            if(file && file.size < 1048576*'.$uploal_limit_MB.') { // 1 MB (this size is in bytes)
                if (document.getElementById(id).getAttribute("next")!=""){
                   showNext(document.getElementById(id).getAttribute("next"));
                }
            } else {
                alert("Ce fichier est trop volumineux! il fait "+Math.round(file.size/10485.76)/100+"MB, la limite est de '.$uploal_limit_MB.'MB.");
                document.getElementById(id).value="";
            }
        
        }
    }
';

$ids = ["img_c1","img_c2","img_c3","img_c4","img_c5","img_c6","img_c7","img_c8","img_c9","img_c10","img_c11","img_c12","img_ef1","img_ef2","img_ef3","img_r1","img_r2","img_r3"];
foreach($ids as $img_id){
    echo'
    var fileSelected'.$img_id.' = null;
    document.getElementById("'.$img_id.'").onchange = function(e) { // will trigger each time
        handleFileDialog("'.$img_id.'", document.getElementById("'.$img_id.'").value !== fileSelected'.$img_id.');
    }';
}
echo'
    setTypeForm('.$type_form.');';
    if ($type_form==1){
      echo'
    document.getElementById("cr_acc").value=1;';
    }
    echo'

</script>


</html>';
