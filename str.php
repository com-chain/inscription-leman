<?php

class CurrencySignatureHandler {
    private string $server_name;
    private string $key_path;
    private string $logo_path;
    
    public function __construct(string $server_name, string  $key_path, string $logo_path) {
        $this->server_name = $server_name;
        $this->key_path = $key_path;
        $this->logo_path = $logo_path;
    }
    
    protected function base64url_encode($data) {
      return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    
    protected function base64url_decode($data) {
      return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
    
    public function getServerName(){
        return $this->server_name;
    }
    
    public function getLogoPath(){
        return $this->logo_path;
    }
    
    function getStr($val){
        $pkeyid = openssl_pkey_get_private($this->key_path); # Must be accessible from the php server.

        # you can convert rsa key generated from keygen using 
        # openssl rsa -in ~/.ssh/id_rsa -outform pem > id_rsa.pem

        if(!$pkeyid){
            throw new Exception('Private key not found.');
        }


        openssl_sign($val, $sign, $pkeyid, "sha1WithRSAEncryption");
        $sign = $this->base64url_encode($sign);
        $data = array('id' => $val, 'servername'=>$this->server_name, 'signature' => $sign);
        $data = json_encode($data);

        // free the key from memory
        openssl_free_key($pkeyid);
        
        return $data;
    }
}

$signature_handler_chf = new CurrencySignatureHandler("Monnaie-Leman", "myPathToPrivateKeyPemFile", "resources/wide-logo_CHF.png");
$signature_handler_eur = new CurrencySignatureHandler("Leman-EU", "file://../id_rsa_eu.pem", "resources/wide-logo_EUR.png");

?>
