<?php
echo'
<!DOCTYPE html>
<html>
  <head>';
include 'p_head.php';
makeHead(100);
echo' <title>QR génération | Monnaie Léman</title>';

$add='';
$amount='';
$ref='';
if (isset($_GET['address'])){
    $add=$_GET['address'];
}
if (isset($_GET['amount'])){
    $amount=$_GET['amount'];
}
if (isset($_GET['ref'])){
    $ref=$_GET['ref'];
}
echo'  

    <script type="text/javascript" src="qrcodejs/jquery.min.js"></script>
    <script type="text/javascript" src="qrcodejs/qrcode.js"></script>
    <script type="text/javascript">
    
    
    
    
    
       function t(t) {
        for (var e = 0; e < a.length; e++)
            a[e] = 0;
        for (var e = 0; e < t.length; e++)
            a[e % 4] = (a[e % 4] << 5) - a[e % 4] + t.charCodeAt(e)
        }
        function e() {
            var t = a[0] ^ a[0] << 11;
            return a[0] = a[1],
            a[1] = a[2],
            a[2] = a[3],
            a[3] = a[3] ^ a[3] >> 19 ^ t ^ t >> 8,
            (a[3] >>> 0) / (1 << 31 >>> 0)
        }
        function o() {
            var t = Math.floor(360 * e())
              , o = 60 * e() + 40 + "%"
              , r = 25 * (e() + e() + e() + e()) + "%"
              , i = "hsl(" + t + "," + o + "," + r + ")";
            return i
        }
        function r(t) {
            for (var o = t, r = t, i = Math.ceil(o / 2), n = o - i, a = [], s = 0; s < r; s++) {
                for (var l = [], h = 0; h < i; h++)
                    l[h] = Math.floor(2.3 * e());
                var u = l.slice(0, n);
                u.reverse(),
                l = l.concat(u);
                for (var d = 0; d < l.length; d++)
                    a.push(l[d])
            }
            return a
        }
        function i(t, e, o, r, i) {
            var n = document.createElement("canvas")
              , a = Math.sqrt(t.length);
            n.width = n.height = a * o;
            var s = n.getContext("2d");
            s.fillStyle = r,
            s.fillRect(0, 0, n.width, n.height),
            s.fillStyle = e;
            for (var l = 0; l < t.length; l++) {
                var h = Math.floor(l / a)
                  , u = l % a;
                s.fillStyle = 1 == t[l] ? e : i,
                t[l] && s.fillRect(u * o, h * o, o, o)
            }
            return n
        }
        function n(e) {
            e = e || {};
            var n = e.size || 8
              , a = e.scale || 4
              , s = e.seed || Math.floor(Math.random() * Math.pow(10, 16)).toString(16);
            t(s);
            var l = e.color || o()
              , h = e.bgcolor || o()
              , u = e.spotcolor || o()
              , d = r(n)
              , c = i(d, l, a, h, u);
            return c
        }
   
        var a = new Array(4);
        window.blockies = {create: n};
    
    
    
    function getBlockie(address) {
	    return blockies.create({
		    seed: address.toLowerCase(),
		    size: 8,
		    scale: 16
	    }).toDataURL();
    }
    
    
    function addressBlur(){
        var address = document.getElementById("add");
	    var re = /^0x[0-9abcdefABCDEF]{40}$/;
	    if (!address.value || !re.test(address.value.trim())) {
		        document.getElementById("addressIdenticon").style.backgroundImage=\'unset\';
		        return;
	     } else {
	                  document.getElementById("addressIdenticon").style.backgroundImage= \'url(\' + getBlockie(address.value.trim()) + \')\';
	       
	     }
    }
    
       

        function makeCode () {	
            document.getElementById("qrcode").innerHTML="";
            var qrcode = new QRCode(document.getElementById("qrcode"), {
	            width : 350,
	            height : 350
            });
        
        	
	        var address = document.getElementById("add");
	        var amount = document.getElementById("amount");
	        var ref = document.getElementById("ref");
	        
	        var re = /^0x[0-9abcdefABCDEF]{40}$/;
	        
	        if (!address.value || !re.test(address.value.trim())) {
		        document.getElementById("lbl_add").classList.add("missing");
		        document.getElementById("addressIdenticon").style.backgroundImage=\'unset\';
		        return;
	        } else {
	            document.getElementById("lbl_add").classList.remove("missing");
	            document.getElementById("addressIdenticon").style.backgroundImage= \'url(\' + getBlockie(address.value.trim()) + \')\';
	        
	        }
	        
	        var text = \' {"address":"\'+address.value.trim()+\'", "serverName":"Monnaie-Leman"\';
	        
	        if (amount.value){
	           text = text + \', "amount":"\'+amount.value+\'"\';
	        }
	        
	        if (ref.value){
	           text = text + \', "ref":"\'+ref.value+\'"\';
	        }
	        
	        text = text+\'}\'
	        document.getElementById("content").innerHTML=text;
	        qrcode.makeCode(text);
        }
</script>
  </head>
<body>';

echo '
  <span class="fond"></span>
  <span class="cont">
  
 <a class="logo" href="http://monnaie-leman.org/"><img src="css/image/logo.png" width="160px"/></a> <br/>
 <a href="http://monnaie-leman.org/" class="ariane">< Retour</a> 
  
	<h2> Génération de QR Monnaie Léman </h2>';

echo '
    
     <h3> Informations à encoder  </h3>
     <span style="display: inline-block;
    margin-right: 10px;
    
    max-width: calc(100% - 95px);
}">
         <span class="fitem">
	       <span class="label" id="lbl_add">Adresse du destinataire*</span>
	        <input class="inputText"  type="text" id ="add" name="add" value="'.$add.'" placeholder="0xABCD12345..." onBlur="addressBlur()"/><br/>
	     </span>
	     <span class="fitem">
	       <span class="label" >Montant du payement</span>
	        <input class="inputText" min="0" step="0.01" type="number" id ="amount" name="amount" value="'.$amount.'" placeholder="0.00" /><br/>
	     </span>
	     <span class="fitem">
	       <span class="label" >Référence du payement</span>
	        <input class="inputText"  type="text" id ="ref" name="ref" value="'.$ref.'" placeholder="Référence du payement" /><br/>
	     </span>
	 </span>
	 <span style="display: inline-block; vertical-align:top;">
	 <div id="addressIdenticon" style="height:80px;width:80px;background-size: cover;
    background-repeat: no-repeat;
    border-radius: 20%;
    box-shadow: inset 0 2px 2px hsla(0,0%,100%,.5), inset 0 -1px 8px rgba(0,0,0,.6);"></div>
	 </span>
	 
	 <a class="big_button" onClick="makeCode();">Générer</a><br/>
    
    <div id="qrcode" style="width:350px; height:350px; margin:15px auto;"></div>
    <span class="label" style="width:100%;text-align: center;" id="content" ></span>
  </span>  
</body>';
if ($add!=''){
echo'
 <script type="text/javascript">
    makeCode();
 </script>
 ';
}

echo'
</html>';
?>
