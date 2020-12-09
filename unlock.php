<?php

include 'checkUser.php';
?>

<html>
   <head>
     <script type="text/javascript" src="./test-master.js"></script>
   </head>
   <body>
   
    
    <div style="width:calc(48% - 20px); display:inline-block;vertical-align: top; padding: 10px;" >
       <div>
<?php       

echo'
           <span style="font-weight:600;">Compte &agrave; d&eacute;bloquer:</span><br/>
           <input id="id" type="hidden" value="'.$_GET['id'].'"/>
           Adresse: <input id="add" type="text" readonly="readonly" value="'.$_GET['add'].'"/> <br/>';
           
    
$typeName= 'PROFESSIONEL';
$type=1;

if ($_GET['type']==2) {
    $typeName= 'INDIVIDUEL';
    $type=0;
}

$lm=0;
$lp=3000;
$cat = (int)$_GET['cat'];

if ($cat==1) {
    $lm=-1000;
    $lp=3000;
} else if ($cat==2) {
    $lm=-5000;
    $lp=15000;
} else if ($cat==3) {
    $lm=-10000;
    $lp=30000;
} else if ($cat==4) {
    $lm=-20000;
    $lp=60000;
} 
           
echo'
           Type:   <input  type="text" readonly="readonly" value="'.$typeName.'"/> <input id="tp" type="hidden" value="'.$type.'"/> <br/>
           Limites L&eacute;manex: [<input id="lm" type="text" readonly="readonly" value="'.$lm.'"/>, <input id="lp" type="text" readonly="readonly" value="'.$lp.'"/>]<br/><br/><br/>
           
';
?>
       </div>
      
       <div id="selector" style="display:none;"> 
            <span style="font-weight:600;">Compte Admin manquant:</span><br/>
            Cliquer ci-dessous pour selectionner le fichier .dat du compte admin<br/>
            <input id="file-input" type="file" name="name" accept=".dat"/>
       </div>
       <div id="passwrd" style="display:none;"> 
         <span style="font-weight:600;">Compte Admin pour le d&eacutebloquage:</span> <br/>
         <div id="blockie" style="width: 60px; 
                                  height: 60px; 
                                  border: solid 1px black; 
                                  margin: 3px;  
                                  background-size: cover;
                                  background-repeat: no-repeat;
                                  border-radius: 20%;"></div>
         <input type="text" id="address" name="address" readonly="readonly" style="vertical-align: bottom;margin: 0px 0px 25px 10px;"/><br/>
         <label for="password">Mot de passe:</label>
         <input type="password" id="psw" name="psw"><br>
         <input type="submit" value="Débloquer" onClick="unlock();">
       </div>
       
       
       
    </div>   
    <div style="width:48%; display:inline-block;vertical-align: top; padding:20px;color:white; background-color:black;">
    
        <div id="Message" >
        </div>
    </div>
       
   </body>

 <script type="text/javascript">
     
var sendData = function() {  
    var xobj = new XMLHttpRequest();
    xobj.open('GET', 'unlockWallet.php?id='+document.getElementById("id").value+'&add='+document.getElementById("add").value, true); 
    xobj.onreadystatechange = function () {
          if (xobj.readyState == 4 && xobj.status == "200") {
            alert('Compte débloqué');
          }
    };
    xobj.send(null);  
 
}




var openWallet= function(){
 // Cas 1 wallet stoqué
 var json_wallet = localStorage.getItem('AdminWallet');
 if (json_wallet==undefined || json_wallet=='') {
    document.getElementById('selector').style.display="inline-block";
    
 } else {
    loadWallet(json_wallet);
 }
}

var loadWallet = function(json_wallet) {
    var address = '0x'+JSON.parse(json_wallet).address;  
    
    document.getElementById("address").value = address;
    document.getElementById("blockie").style.backgroundImage = 'url(' + Wallet.blockies(address) +')';
    jsc3l_bcRead.getAccountType(address, function(value){
        if (value==2) {
            localStorage.setItem('AdminWallet',json_wallet);
            document.getElementById("passwrd").style.display="inline-block";
            document.getElementById("Message").innerHTML+= "<br/>Attente du mot de passe du compte admin...";
            document.getElementById('selector').style.display="None";
        } else {
            document.getElementById("Message").innerHTML= "Le compte n'est pas un compte admin !";
            localStorage.setItem('AdminWallet',"");
        }
    });  
}


document.getElementById('file-input').onchange = e => { 
        var file = e.target.files[0]; 

       // setting up the reader
       var reader = new FileReader();
       reader.readAsText(file,'UTF-8');

       // here we tell the reader what to do when it's done reading...
       reader.onload = readerEvent => {
          var content = readerEvent.target.result; 
          loadWallet( content );
       }
    }






// Check if a node is selected and up
document.getElementById("Message").innerHTML= "Choix du Noeud ComChain";
var current_end_point = jsc3l_customization.getEndpointAddress();
jsc3l_connection.testNode(current_end_point, function(valid_end_point){
    if (valid_end_point) {
        var name_currency = "Monnaie-Leman";
        //Configure la monnaie
        document.getElementById("Message").innerHTML+= "<br/>Configuration de la monnaie...";
        jsc3l_customization.getConfJSON(name_currency,function(success_config){
            if (!success_config) {
                 document.getElementById("Message").innerHTML= "Erreur dans la configuration de la monnaie!";
            } else {
                openWallet();
            }
        });
    } else {
       document.getElementById("Message").innerHTML= "R&eacute;cup&eacute;ration d'un r&eacute;po...";
        jsc3l_connection.ensureComChainRepo(function(success_repo) {
            if (!success_repo) {
                 document.getElementById("Message").innerHTML= "Pas de r&eacute;po disponible!";
            } else {
                 // Obtention du back-end ComChain
                document.getElementById("Message").innerHTML+= "<br/>Obtention du back-end ComChain...";
                jsc3l_connection.acquireEndPoint(function(success_end_point){
                    if (!success_end_point) {
                         document.getElementById("Message").innerHTML= "Pas de back-end disponible!";
                    } else {
                        var name_currency = "Monnaie-Leman";
                        //Configure la monnaie
                        document.getElementById("Message").innerHTML+= "<br/>Configuration de la monnaie...";
                        jsc3l_customization.getConfJSON(name_currency,function(success_config){
                            if (!success_config) {
                                 document.getElementById("Message").innerHTML= "Erreur dans la configuration de la monnaie!";
                            } else {
                                openWallet();
                            }
                        });
                    }
                });
            }
         }); 
    }
});


var unlock = function() {
    var password = document.getElementById("psw").value;
    // Décryptage du wallet
    try {
   
        var local_wallet = Wallet.getWalletFromPrivKeyFile(localStorage.getItem('AdminWallet'), password);
        document.getElementById("Message").innerHTML+= "<br/>D&eacute;verrouillage du compte Admin...";
        document.getElementById("passwrd").style.display="none";   
    } catch (error) {
      document.getElementById("Message").innerHTML=error;
       throw error;
    } 
   
   document.getElementById("Message").innerHTML+= "<br/>Envois de l'ordre de transaction de débloquage...";
   
   var address = document.getElementById("add").value;
   var tp = document.getElementById("tp").value;
   var lm = document.getElementById("lm").value;
   var lp = document.getElementById("lp").value;
   
   jsc3l_bcTransaction.SetAccountParam(local_wallet, address, 1, tp, lm, lp, function(res){
     if (res.isError){
		document.getElementById("Message").innerHTML+= "<br/>"+res.error;
     } else {
        document.getElementById("Message").innerHTML+= "<br/>Ordre transmis...";
        sendData();
     }
   });
}

                       
    
 

</script>
</html>
