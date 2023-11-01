<?php
//------------------------------------------------------------------------------------------------
// Autor: Arnau Soler Tomás
// Fichero: CifrarDescifrarAES.php
// Descripción: Clase en formato PHP que nos sirve para encriptar o desencriptar una cadena de texto
// mediante el cifrado AES-256-CBC
//------------------------------------------------------------------------------------------------
class CifrarDescifrarAES
{
    //Propiedades
    private $cipher = "AES-256-CBC", // Método de cifrado
    $options = 0, // Opciones
    $text, // texto a cifrar/cifrado
    $key = "CleanBajoquetaClientChiperAESKey", // clave secreta de 32 caracteres
    $iv; // vector de inicialización
    //------------------------------------------------------------------------------------------------
    // Constructor
    // text:Txt --> __construct() --> obj:CifrarDescifrarAES
    //------------------------------------------------------------------------------------------------
    public function __construct($text)
    {
        $this->text = $text;
        $this->iv = str_repeat("\0", openssl_cipher_iv_length($this->cipher));
    }
    //---------------------------------------------------------------------------------------------------
    // obj:CifrarDescifrarAES --> desencriptar() --> res:Txt
    // Descripción: Método que sirve para desencriptar una cadena de texto que previamente fue encriptada
    //----------------------------------------------------------------------------------------------------
    public function desencriptar()
    {
        $decryptedResult = openssl_decrypt($this->text, $this->cipher, $this->key, $this->options, $this->iv);
        return $decryptedResult;
    }
    //---------------------------------------------------------------------------------------------------
    // obj:CifrarDescifrarAES --> encriptar() --> res:Txt
    // Descripción: Método que sirve para encriptar una cadena de texto
    //----------------------------------------------------------------------------------------------------
    public function encriptar()
    {
        $encryptedResult = openssl_encrypt($this->text, $this->cipher, $this->key, $this->options, $this->iv);
        return $encryptedResult;
    }
} //Fin Clase CifrarDescifrarAES

?>