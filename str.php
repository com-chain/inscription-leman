<?php
function getServerName(){
    return "Monnaie-Leman";
}



function base64url_encode($data) {
  return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data) {
  return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

function getStr($val){

$pkeyid = openssl_pkey_get_private("myPathToPrivateKeyPemFile"); # Must be accessible from the php server.

# you can convert rsa key generated from keygen using 
# openssl rsa -in ~/.ssh/id_rsa -outform pem > id_rsa.pem


if(!$pkeyid){
    throw new Exception('Private key not found.');
}


openssl_sign($val, $sign, $pkeyid, "sha1WithRSAEncryption");
$sign = base64url_encode($sign);
$data = array('id' => $val, 'servername'=>getServerName(), 'signature' => $sign);
$data = json_encode($data);

// free the key from memory
openssl_free_key($pkeyid);


return $data;
}
?>
