<?php
echo'
<!DOCTYPE html>
<html>
  <head>
    <script src="resources/jquery/jquery.min.js"></script>
';
include 'p_head.php';

$type_form=1;
if (isset($_GET['adh']) && $_GET['adh']==1){
    $type_form=0;
}

makeHead($type_form);




$payload = file_get_contents('https://www.ecb.europa.eu/stats/policy_and_exchange_rates/euro_reference_exchange_rates/html/eurofxref-graph-chf.en.html');  
preg_match_all("/rateLatest='([0-9.]*)'/", $payload, $out, PREG_PATTERN_ORDER);
$rate=$out[1][0];
preg_match_all("/rateLatestInverse='([0-9.]*)'/", $payload, $out, PREG_PATTERN_ORDER);
$rateInverse=$out[1][0];





echo'  

  <script>
    var type_form ='. $type_form.';
  
    window.onload = function() {
         const myInput = document.getElementById("mailconf");
         myInput.onpaste = function(e) {
           e.preventDefault();
         }
    }
    
    function setTypeForm(tp_form){
        type_form = tp_form;
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
             document.getElementById("curr_sel").style.display="None";
             
             
        } else {
             document.getElementById("title").innerHTML="VOS DONNÉES";
             document.getElementById("tot_step").innerHTML=4;
             document.getElementById("adh_next").style.display="inline-block";
             document.getElementById("adh_sub").style.display="None";
             document.getElementById("fld_ce").style.display="None";
             document.getElementById("fld_att").style.display="None";
             document.getElementById("lb_ad_ass").innerHTML="Voulez-vous adhérer à l\'association Monnaie Léman?*";
             document.getElementById("curr_sel").style.display="inline-block";
             
        }  
    }
    
    
    
    
    function changeType(){
        setTypeForm(document.getElementById("cr_acc").value);
        if (document.getElementById("cr_acc").value==1) {
            showSection(\'sect_ip\');
        }
    }
    
    function adjustCurrency(){
       var country = document.forms["form"]["country"].value;
       if (country=="France"){
           document.getElementById("chx_curr_eur").checked = true;
       } else if (country=="Suisse"){
           document.getElementById("chx_curr_chf").checked = true;
       } else {
           document.getElementById("chx_curr_chf").checked = true;
           document.getElementById("chx_curr_chf").checked = false;
       }
    }
    
    
    
    function computeCotisation(){
  
       var country = document.forms["form"]["country"].value;
       var currency = document.forms["form"]["chx_curr"].value;
       
       var amount_ch='.number_format($cotisation_i_ch, 2, '.', '').';
       var amount_ch_changed='.number_format(chf_from_eur($cotisation_i_fr, $rate), 2, '.', '').';
       var amount_fr='.number_format($cotisation_i_fr, 2, '.', '').';
       var amount_fr_changed='.number_format(eur_from_chf($cotisation_i_ch, $rateInverse), 2, '.', '').';
       
       document.getElementById("ad_ch_p").style.display="None";
       document.getElementById("ad_fr_p").style.display="None";
       document.getElementById("ad_ch_ep").style.display="None";
       document.getElementById("ad_fr_ep").style.display="None";
       
       // Display Selection
       if (country== "France" || currency!="CHF") {
          // Request for eLEM-EUR => FR display
          // -> option
          if  (type_form==1) {
            document.getElementById("opt_adh_deja").style.display="None";
            document.getElementById("opt_adh_oui").style.display="None";
            document.getElementById("opt_adh_non").style.display="None";
            document.getElementById("opt_adh_ut").style.display="inline";
            document.getElementById("opt_adh_sym").style.display="inline";
          }
          
          
          // -> text selection
          document.getElementById("ad_ch_1").style.display="None";
          document.getElementById("ad_fr_1").style.display="inline-block";
          document.getElementById("ad_fr_2").style.display="inline-block";
          document.getElementById("ad_fr_3").style.display="inline-block";
          
          // -> question
          document.getElementById("lb_ad_ass").innerHTML="Quelle type d\'adhésion choisissez-vous?*";
          
       } else {
          // No eLEM-EUR => CH display
          // -> option
          if  (type_form==1) {
               document.getElementById("opt_adh_deja").style.display="inline";
               document.getElementById("opt_adh_oui").style.display="inline";
               document.getElementById("opt_adh_non").style.display="inline";
               document.getElementById("opt_adh_ut").style.display="None";
               document.getElementById("opt_adh_sym").style.display="None";
          }
          
          // -> text selection
          document.getElementById("ad_ch_1").style.display="inline-block";
          document.getElementById("ad_fr_1").style.display="None";
          document.getElementById("ad_fr_2").style.display="None";
          document.getElementById("ad_fr_3").style.display="None";
          
          // -> question
          document.getElementById("lb_ad_ass").innerHTML="Voulez vous adhérer à l\'association Monnaie-Léman?*";
       }
       
       // Amount Selection 
       if (country=="Suisse") {
           document.getElementById("cot_amount").innerHTML="CHF "+amount_ch;
           document.getElementById("cot_amount_2").innerHTML="CHF "+amount_ch;
           document.getElementById("cot_amount_3").innerHTML=amount_ch;
           document.getElementById("cot_amount_4").innerHTML="CHF "+amount_ch;
           if (currency=="EUR") {
                document.getElementById("cot_amount_5").innerHTML=amount_fr_changed;
           } 
           
       } else if (country=="France") {
           document.getElementById("cot_amount_2").innerHTML="EUR "+amount_fr;
           document.getElementById("cot_amount_4").innerHTML="EUR "+amount_fr;
           document.getElementById("cot_amount_5").innerHTML=amount_fr;
           if (currency!="EUR") {
                document.getElementById("cot_amount_3").innerHTML=amount_ch_changed;
           } 
       } else {
          if (currency=="EUR") {
            document.getElementById("cot_amount_2").innerHTML="EUR "+amount_fr;
            document.getElementById("cot_amount_4").innerHTML="EUR "+amount_fr;
            document.getElementById("cot_amount_5").innerHTML=amount_fr;
          } else {
            document.getElementById("cot_amount").innerHTML="CHF "+amount_ch;
            document.getElementById("cot_amount_2").innerHTML="CHF "+amount_ch;
            document.getElementById("cot_amount_3").innerHTML=amount_ch;
            document.getElementById("cot_amount_4").innerHTML="CHF "+amount_ch;
          }
       } 
       
       // Specific to simple adhesion (no account)
       if (type_form==0) {
          if (country== "France") {
             document.getElementById("ad_ass").value="Actif";
             document.getElementById("ad_fr_2").style.display="None";
             document.getElementById("ad_fr_4").style.display="none";

             document.getElementById("ad_fr_p").style.display="inline-block";
               
           } else {
             document.getElementById("ad_ass").value="Oui";
             document.getElementById("ad_ch_p").style.display="inline-block";
           }
        }
        
        // section COnformite
       if (currency == "CHF") {
          document.getElementById("curr_ret").innerHTML="LEM-CHF pourront être remboursées en francs suisses";
       } else  if (currency == "EUR") {
          document.getElementById("curr_ret").innerHTML="LEM-EUR pourront être remboursées en euros";
       } else  {
          document.getElementById("curr_ret").innerHTML="LEM-CHF pourront être remboursées en francs suisses et les LEM-EUR en euros";
       }
       
       let need_finma = country=="Suisse" || currency == "CHF" || currency == "BOTH";
       
        document.getElementById("tt_finma").style.display = need_finma ? "inline" : "none";
        document.getElementById("conf_finma").style.display = need_finma ? "inline" : "none";
        
        // CGU
        document.getElementById("cgu_ch").style.display = (currency == "CHF" || currency == "BOTH") ? "inline" : "none";
        document.getElementById("cgu_fr").style.display = (currency == "EUR" || currency == "BOTH") ? "inline" : "none";
        document.getElementById("cgu_both").style.display = (currency == "BOTH") ? "inline" : "none";
 
    }
    
    
    function changeCoti() {
       var country = document.forms["form"]["country"].value;
       var currency = document.forms["form"]["chx_curr"].value;
       
       document.getElementById("ad_fr_p").style.display="None";
       document.getElementById("ad_ch_p").style.display="None";
       document.getElementById("ad_fr_ep").style.display="None";
       document.getElementById("ad_ch_ep").style.display="None";
  
            
       if (document.getElementById("opt_adh_oui").style.display=="none") {
            if (document.getElementById("ad_ass").value=="Actif") {
                if (currency=="BOTH" && country != "France") {
                    document.getElementById("ad_ch_p").style.display="inline-block";   
                    document.getElementById("ad_ch_ep").style.display="inline-block"; 
                } else {
                    document.getElementById("ad_fr_p").style.display="inline-block";   
                    if (currency=="EUR") {
                        document.getElementById("ad_fr_ep").style.display="inline-block"; 
                    } else {
                        document.getElementById("ad_ch_ep").style.display="inline-block"; 
                    }
                }
                
            }
        } else {
            if (document.getElementById("ad_ass").value=="Oui"  || document.getElementById("ad_ass").value=="Déjà membre") {
                document.getElementById("ad_ch_p").style.display="inline-block";  
                document.getElementById("ad_ch_ep").style.display="inline-block"; 
            } 
        }
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
    
    function validateSectionInfo(){
       var valid = true;
       var fields = ["name", "surname", "gender", "street", "zip", "city", "country", "cit", "born", "mail"];
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
       
       if (document.forms["form"]["mail"].value != document.forms["form"]["mailconf"].value){
           document.getElementById("lb_mailconf").classList.add("missing");
           valid=false;
       } else {
            document.getElementById("lb_mailconf").classList.remove("missing");
       }
       
       
       if (type_form==1) {
           if (document.forms["form"]["chx_curr"].value != ""){
               document.getElementById("lb_chx_curr").classList.remove("missing");
           } else {
              document.getElementById("lb_chx_curr").classList.add("missing");
              valid=false;
           }
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
    
    function togleAed(){
        var x = document.forms["form"]["aed_dec"].value;
        document.getElementById("aed_other").style.display=x=="Autre"?"block":"none";
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
               fields = ["aed_"+aed_id+"_surname","aed_"+aed_id+"_add","aed_"+aed_id+"_zip", "aed_"+aed_id+"_city", "aed_"+aed_id+"_country","aed_"+aed_id+"_born","aed_"+aed_id+"_cit"];  
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
       
       if (document.forms["form"]["img"].value==""){
           document.getElementById("lb_img").classList.add("missing");
           valid=false;
       } else {
            document.getElementById("lb_img").classList.remove("missing");
       }
       
       return valid;
    }
  </script>
  </head>
<body>';

echo '
  <span class="fond"></span>
  <span class="cont">
  
 <a class="logo" href="http://monnaie-leman.org/"><img src="css/image/logo.png" width="160px"/></a> 
 
	<h2> <span id="title">Léman électronique: VOS DONNÉES</span> - Particulier (<span id="step">1</span>/<span id="tot_step">5</span>) </h2>';

echo '
    <span class="cont_d" >
    <form id="form"  enctype="multipart/form-data" action="submitIndividual.php" method="post">
    <div id="sect_ip">
    <h3> Informations personnelles  </h3>
     <span class="fitem">
	   <span class="label" id="lb_gender">Civilité*</span>
	   <select  class="inputText" name="gender" id ="gender" >
	    <option value =""></option>
	    <option value ="Feminin">Mme</option>
	    <option value ="Masculin">M.</option>
	    <option value ="Autre">Autre</option>
	   </select><br/>
	 </span>
	 <span class="fitem">
	   <span class="label" id="lb_name">Nom*</span>
	   <input class="inputText"  type="text" id ="name" name="name" value="" placeholder="Nom*" /><br/>
	 </span>
	 <span class="fitem">
	   <span class="label" id="lb_surname" >Prénom*</span>
	   <input class="inputText"  type="text" id ="surname" name="surname" value="" placeholder="Prénom*" /><br/>
	 </span>
	
	 <span class="fitem">
	   <span class="label" id="lb_mail">Email*</span>
	   <input class="inputText"  type="email" id="mail" name="mail" value="" placeholder="Email*" /><br/>
	 </span>
	 <span class="fitem">
	   <span class="label" id="lb_mailconf">Email (confirmation)*</span>
	   <input class="inputText"  type="email" id="mailconf" name="mailconf" value="" placeholder="Email (confirmation)*" /><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" id="lb_phone">Téléphone</span>
	   <input class="inputText"  type="tel"  id="phone" name="phone" value="" placeholder="+41 22 123 45 67 / +33 6 77 77 88 99" /><br/>
	 </span>
	 
	  <span class="fitem">
	   <span class="label" id="lb_street">Rue et numéro*</span>
	   <input class="inputText"  type="text" id="street" name="street" value="" placeholder="Rue et numéro*" /><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" >Complément d\'adresse</span>
	   <input class="inputText"  type="text" id="compl" name="compl" value="" placeholder="Complément d\'adresse" /><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" id="lb_zip">Code postal*</span>
	   <input class="inputText"  type="text" id="zip" name="zip" value="" placeholder="Code postal*" /><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" id="lb_city">Ville*</span>
	   <input class="inputText"  type="text" id="city" name="city" value="" placeholder="Ville*" /><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" id="lb_country">Pays*</span>
	   <select  class="inputText" name="country" id ="country" onchange="adjustCurrency(); computeCotisation();" >
	   '.$country.'
	   </select><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" id="lb_cit">Nationalité*</span>
	   <select  class="inputText" name="cit" id ="cit" >
	   '.$country.'
	   </select><br/>
	 </span>
	 
	 <span class="fitem">
	   <span class="label" id="lb_born">Date de naissance*</span>
	   <input class="datechk inputText"  type="date" id="born" name="born" value=""/><br/>
	 </span>
	 
<span id="curr_sel">
    <h3> J\'ouvre </h3>
      <span class="label" id="lb_chx_curr">un compte*</span>
	  <span class="rb3">
        <input type="radio" id="chx_curr_chf" name="chx_curr" value="CHF"  onchange="computeCotisation();"> LEM-CHF 
	  </span>
	  <span class="rb3">
        <input type="radio" id="chx_curr_eur" name="chx_curr" value="EUR"  onchange="computeCotisation();"> LEM-EUR
	  </span><br/>
	  <span class="label"> deux comptes</span>
	  <span class="rb3">
        <input type="radio" id="chx_curr_both" name="chx_curr" value="BOTH"  onchange="computeCotisation();"> LEM-CHF et LEM-EUR
	  </span>
</span> <br/>
	 
	 <a class="button" onclick="if (validateSectionInfo()){showSection(\'sect_add\');}">Suivant</a>
</div>
<div id="sect_add" style="display:none" >
<h3> Adhésion à l\'association Monnaie Léman </h3>
<span id="ad_ch_1" class="labelWide" >
  L\'association Monnaie Léman gère et promeut l\'utilisation de la monnaie complémentaire le Léman. <br/><br/> 
 Vous pouvez devenir membre et participer ainsi au développement de votre monnaie. La cotisation annuelle se monte à <span class="strong" id="cot_amount">CHF 50</span>.<br/><br/> 
</span>

<span id="ad_fr_1" class="labelWide" >
  L\'association Monnaie Léman gère et promeut l\'utilisation de la monnaie complémentaire le Léman.<br/><br/>
</span>
<span id="ad_fr_2" class="labelWide" >
    Pour des exigences légales*, toute personne qui utilise le Léman doit adhérer à l\'association. En remplissant ce formulaire, vous devenez, de fait, Membre sympathisant·e (sans cotisation).
    <br/>
</span>

<span id="ad_fr_3" class="labelWide" >
    Vous pouvez <span id="ad_fr_4">également </span>devenir Membre actif pour <span class="strong" id="cot_amount_2">CHF 50</span> par an, avec droit de vote à l\'Assemblée générale et participation au développement de votre monnaie.<br/><span style="font-size:10px;"> *LOI n° 2014-856 du 31 juillet 2014 relative à l\'économie sociale et solidaire </span><br/>
</span>';

if ($type_form==0) {
echo '
    <span id="lb_ad_ass" style="display:none;"></span>
	<input  type="hidden"  id="ad_ass" name="ad_ass" value="Oui" />   ';
}
else {
echo'
<span class="labelWide" id="lb_ad_ass">Voulez vous adhérer à l\'association Monnaie-Léman?*</span>
<span class="labelWide" >
<select  class="inputText" name="ad_ass" id ="ad_ass"  onchange="changeCoti();" >
	    <option value ="" id="opt_adh_blk"></option>
	    <option value ="Déjà membre"  id="opt_adh_deja">Je suis déjà membre</option>
	    <option value ="Oui"  id="opt_adh_oui">Oui</option>
	    <option value ="Non"  id="opt_adh_non">Non</option>
	    <option value ="Utilisateur"  id="opt_adh_ut">Utilisatrice.eur - Membre sympathisant.e (sans cotisation annuelle)</option>
	    <option value ="Actif"  id="opt_adh_sym">Membre actif (avec cotisation annuelle)</option>
</select></span><br/><br/>';
}
echo'

<span id="ad_ch_p" class="labelWide" >	   
 Nous vous remercions d’effectuer votre versement sur le compte de Monnaie Léman: <br/> 
	    <span class="full" >
            Monnaie Léman - Ch. du 23-Août 1 - 1205 Genève<br/>
            Banque Alternative Suisse - IBAN: CH22 0839 0034 3841 1010 0 - BIC: ABSOCH22 <br/>
	    </span>	<br/> 
</span>
<span id="ad_fr_p" class="labelWide" >	  

Nous vous remercions d’effectuer un versement de <span class="strong" id="cot_amount_4">CHF 50</span> sur le compte de Monnaie Léman: <br/> 	 
<span class="full">
Monnaie Léman France - 11A avenue Napoléon III - 74160 Saint-Julien-en-Genevois<br/>
CREDIT COOPERATIF - IBAN: FR76 4255 9100 0008 0258 5486 909 - BIC: CCOPFRPPXXX<br/>
	  </span>

</span>
<span id="ad_fr_ep" class="labelWide" >		  
Vous pouvez régler votre cotisation en lémans électroniques (eLEM-EUR) sur le compte de l’association (clé publique 0x278b77b93134d1e6c5f3d41ca5e04b19ee7d57e8): <span class="strong">eLEM-EUR <span id="cot_amount_5" >50</span></span>.
<br/><br/>

Vous recevrez une facture dans les prochains jours.

<br/>
<br/>
</span>	 

<span id="ad_ch_ep" class="labelWide" >	
Vous pouvez régler votre cotisation en lémans électroniques sur le compte de l’association (clé publique 0x15a18329381cdf1919d51d05834920585066646f): <span class="strong">eLEM-CHF <span id="cot_amount_3" >50</span></span>.
<br/><br/>

Vous recevrez une facture dans les prochains jours.
<br/>
<br/>
</span> 
	   

';

if ($type_form==0) {
echo '
	 <span class="fitem">
	   <input class="inputCb" style="margin-left: 20px !important;" type="checkbox"  id="data" name="data" value="1" />
	   <span class="labelCb" style="width: calc(100% - 80px);" id="lb_data">En remplissant ce formulaire, vous acceptez que l\'on utilise vos données pour vous contacter, ou pour toutes autres utilisations permettant de développer le Léman de façon anonyme sans les communiquer à des tiers.*</span><br/>
	 </span>
	 
	 <span class="fitem">
	   <input class="inputCb" style="margin-left: 20px !important;" type="checkbox" id="news" name="news" value="1" />
	   <span  class="labelCb" style="width: calc(100% - 80px);">En cochant cette case, je consens à recevoir la newsletter de l’association. </span><br/>
	 </span>
	 
	 <span class="fitem" id="fld_ce" style="display:None;">
	     <input class="inputCb" style="margin-left: 20px !important;" type="checkbox" name="ce_0"  value="1" />
	     <span  class="labelCb" style="width: calc(100% - 80px);" id="lb_ce_0">J\'adhère à la "<a target="_blank" href="'.$url_charte.'" class="it ait">Charte éthique du Léman</a>.* </span><br/>
     </span>
	 
	<span class="fitem" id="fld_att" style="display:None;">
	 <input class="inputCb" style="margin-left: 20px !important;" type="checkbox" name="att_0"  value="1" />
	 <span  class="labelCb" style="width: calc(100% - 80px);" id="lb_att_0">
    J’atteste que toutes les informations fournies ci-dessus sont, à ma connaissance, authentiques et exactes, et je m’engage à vous informer sans délai de tout changement.* </span><br/>
    </span> 
	 
	 <span class="fitem" id="fld_cr_acc" style="display:None;">
	 <!--  <span class="labelWide" id="lb_cr_acc">Voulez vous aussi ouvrir un compte en Léman électronique?*</span>
	   <select  class="inputText" name="cr_acc" id ="cr_acc" onchange="changeType();" >
	    <option value =""></option>
	    <option value ="1">Oui</option>
	    <option value ="0">Non</option>
	   </select>
-->	 
<input type="hidden" name="cr_acc" id ="cr_acc" value="0"/>

  <br/>
	 </span>';
} else {
echo '
	 
	 <span class="fitem">
	   <input class="inputCb" style="margin-left: 20px !important;" type="checkbox"  id="data" name="data" value="1" />
	   <span class="labelCb" style="width: calc(100% - 80px);"id="lb_data">En remplissant ce formulaire, vous acceptez que l\'on utilise vos données pour vous contacter, ou pour toutes autres utilisations permettant de développer le Léman de façon anonyme sans les communiquer à des tiers.*</span><br/>
	 </span>
	 
	 <span class="fitem">
	   <input class="inputCb" style="margin-left: 20px !important;" type="checkbox" id="news" name="news" value="1" />
	   <span  class="labelCb" style="width: calc(100% - 80px);"> En cochant cette case, je consens à recevoir la newsletter de l’association. </span><br/>
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


	 
echo'
	 
     <a  class="button" onclick="showSection(\'sect_ip\'); document.getElementById(\'ad_ass\').value=\'\';">Précédent</a>
	 <a class="button" id="adh_next" onclick="if (validateSectionAdd()){showSection(\'sect_fin\');}">Suivant</a>
	 <a class="button" id="adh_sub" onclick="if (validateSectionAdd()){document.forms[\'form\'].submit();return false;}">Valider ma demande</a>
</div>
<div id="sect_fin" style="display:none">
 <h3> Conformité / compliance <span id="tt_finma">FINMA</span>  </h3>


	   <span class="fitem">
	   
	   <span class="labelWide" >Je prends connaissance et je souscris aux conditions suivantes:<br/> <br/> 
Votre argent est placé dans une banque éthique et ciblé sur des produits "durables".
En cas d\'arrêt des activités de Monnaie Léman, les personnes détentrices de lémans  <span id="curr_ret">LEM-CHF pourront être remboursées en francs suisses</span>.<br/><br/>
<span id="conf_finma">Conformité FINMA (applicable pour l’ouverture de comptes électroniques en Suisse):<ul>
<li>Monnaie Léman n\'est pas surveillée par la FINMA;</li>
<li>Les dépôts ne sont pas couverts par la garantie des dépôts.</li></ul></span>
</span><br/>
	 </span>
	 <span class="fitem">
	 <input class="inputCb"  type="checkbox" name="cond" name="cond" value="1" />
	 <span  class="labelCb" id="lb_cond">Lu et approuvé* </span><br/>
	 </span>
	  </span>
	  
	  
 <h3>Déclaration de la / des personne/s bénéficiaire/s et ADE</h3>

<span class="fitem">
	   <span class="labelWide" id="lb_pep">La/les personne/s ayant droit économique (ADE) est-elle / sont-elles une/des personne/s politiquement exposée/s (<a class="tooltip ait" >PEP<span class="tooltiptext">Les personnes politiquement exposées (PEP) sont des personnes physiques qui exercent une haute fonction publique ou politique ou des personnes connues pour leur être étroitement associées.</span></a>)?* </span>
	   <select  class="inputText" id="pep" name="pep">
	    <option value =""></option>
	    <option value ="1">Oui</option>
	    <option value ="0">Non</option>
	   </select><br/>
	 </span>

<span class="fitem">
	   <span class="labelWide"  id="lb_peprel">La/les personne/s ADE est-elle / sont-elles liée/s à une/des <a class="tooltip ait" >PEP<span class="tooltiptext">Les personnes politiquement exposées (PEP) sont des personnes physiques qui exercent une haute fonction publique ou politique ou des personnes connues pour leur être étroitement associées.</span></a> (famille, ami-e-s proches, etc.)?*</span>
	   <select  class="inputText" id="peprel" name="peprel">
	    <option value =""></option>
	    <option value ="1">Oui</option>
	    <option value ="0">Non</option>
	   </select><br/>
	 </span>
	  
	  
	<br/>  
<span class="fitem">	  
	 <span class="label"  id="lb_aed_dec">Je déclare:*</span>	 </span><br/>
	 <input class="inputCb"  type="radio" name="aed_dec" value="AED" onClick="togleAed()"/>
	 <span  class="labelCb">être la seule personne ayant droit économique (ADE) des valeurs patrimoniales  impliquées dans sa relation avec le Léman électronique.</span><br/>
	 
	  <input class="inputCb"  type="radio" name="aed_dec" value="Autre" onClick="togleAed()"/>
	 <span  class="labelCb">que la/les personne/s suivante/s est/sont la/les personne/s ayant droit économique (ADE) des valeurs patrimoniales impliquées dans la relation avec le Léman électronique.</span><br/>
	 
	   
	 </span>
	 
	 <span id="aed_other"  style="display:none" >
	    Personnes ADE: 
	       <a onClick="showAed(1)" id="btn_aed1" class="selected ait">(1)</a> 
	       <a onClick="showAed(2)" id="btn_aed2"  class="ait" style="display:none">(2)</a>  
	       <a onClick="showAed(3)" id="btn_aed3"  class="ait" style="display:none">(3)</a>  
	       <a onClick="showAed(4)" id="btn_aed4"  class="ait" style="display:none">(4)</a>  
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
	        <input class="datechk inputText"  type="date" name="aed_1_born" value="" >
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
	    <input class="datechk inputText"  type="date" name="aed_2_born" value=""  >
	  
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
	    <input class="datechk inputText"  type="date" name="aed_3_born" value=""  >
	  
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
	    <input class="datechk inputText"  type="date" name="aed_4_born" value=""  >
	  
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
	 <input class="inputCb"  type="checkbox" name="cgu" id="cgu" value="1" />
	 <span  class="labelCb" id="lb_cgu">J’atteste avoir pris connaissance et accepté les ';
	 
	 
echo	 '<span id="cgu_ch"><a class="it ait" target="_blank" href="'.$url_cgu_ch.'">Conditions générales d’utilisation du Léman en Suisse</a></span>';
echo     '<span id="cgu_both"> et les </span>';
echo	 '<span id="cgu_fr"><a class="it ait" target="_blank" href="'.$url_cgu_fr.'">Conditions générales d’utilisation du Léman en France</a></span>';
echo	 '.* </span><br/>
  </span>
  <span class="fitem">
	 <input class="inputCb" type="checkbox" name="ce" id="ce" value="1" />
	 <span  class="labelCb" id="lb_ce">J\'adhère à la <a target="_blank" href="'.$url_charte.'" class="it ait">Charte éthique du Léman</a>.* </span><br/>
  </span>
  
  <span class="fitem">
   <span class="label" id="lb_img">Copie d’une pièce d’identité valide (Recto/verso)*</span>
  <input class="inputText" type="file" id="img" name="img" accept="application/pdf,image/*" >
  <input class="inputText" type="file" id="img2" name="img2" accept="application/pdf,image/*" >
    </span>
    
    
  <span class="fitem">
	 <input class="inputCb" type="checkbox" name="eng" id="eng" value="1" />
	 <span  class="labelCb" id="lb_eng">J\'ai pris note que remplir intentionnellement ce formulaire de manière erronée est constitutif du délit de faux dans les titres au sens de l’<span class="it">Art. 251 du Code pénal suisse</span>.* </span><br/>
  </span>  
  
  <span class="fitem">
	 <input class="inputCb" type="checkbox" name="att" id="att" value="1" />
	 <span  class="labelCb" id="lb_att">
    J’atteste que toutes les informations fournies ci-dessus sont, à ma connaissance, authentiques et exactes, et je m’engage à vous informer sans délai de tout changement.* </span><br/>
  </span>
  
  <h3>EN VALIDANT CETTE DEMANDE, VOUS PASSEZ À LA PHASE 2: L\'OUVERTURE DE VOTRE COMPTE </h3>
   
   <a  class="button" onclick="showSection(\'sect_fin\');">Précédent</a>
   <a class="button" onclick="if (validateSectionDoc()){document.forms[\'form\'].submit();return false;}">Valider ma demande</a>
  
  
</div>
    </form>
   
     
   
  </span>
   </span>
</body>
<script>
    function handleFileDialog(changed) {
       
        if (changed){
            var file = document.getElementById("img").files[0];

            if(file && file.size < 1048576*'.$uploal_limit_MB.') { // 1 MB (this size is in bytes)
                 // ok
            } else {
                alert("Ce fichier est trop volumineux! il fait "+Math.round(file.size/10485.76)/100+"MB, la limite est de '.$uploal_limit_MB.'MB.");
                document.getElementById("img").value="";
            }
        
        }
    }
    
    function handleFileDialog2(changed) {
       
        if (changed){
            var file = document.getElementById("img2").files[0];

            if(file && file.size < 1048576*'.$uploal_limit_MB.') { // 1 MB (this size is in bytes)
                 // ok
            } else {
                alert("Ce fichier est trop volumineux! il fait "+Math.round(file.size/10485.76)/100+"MB, la limite est de '.$uploal_limit_MB.'MB.");
                document.getElementById("img2").value="";
            }
        
        }
    }

    var fileSelected = null;
    document.getElementById("img").onchange = function(e) { // will trigger each time
        handleFileDialog(document.getElementById("img").value !== fileSelected);
    };
    document.getElementById("img2").onchange = function(e) { // will trigger each time
        handleFileDialog2(document.getElementById("img2").value !== fileSelected);
    };
    
    setTypeForm('.$type_form.');';
    if ($type_form==1){
      echo'
    document.getElementById("cr_acc").value=1;';
    }
    echo"
    
    var dateClass='.datechk';
$(document).ready(function ()
{
  if (document.querySelector(dateClass).type !== 'date')
  {
    var oCSS = document.createElement('link');
    oCSS.type='text/css'; oCSS.rel='stylesheet';
    oCSS.href='resources/jquery/jquery-ui.css';
    oCSS.onload=function()
    {
      var oJS = document.createElement('script');
      oJS.type='text/javascript';
      oJS.src='resources/jquery/jquery-ui.min.js';
      oJS.onload=function()
      {
        $(dateClass).datepicker({dateFormat: 'yy-mm-dd'});
      }
      document.body.appendChild(oJS);
    }
    document.body.appendChild(oCSS);
  }
});

</script>
</html>";
?>
