<?php
//------------------------------------------------------------------------------------------------
// Autor: Arnau Soler Tomás
// Fichero: TempData.php
// Descripción: Clase en formato PHP que nos sirve para guardar y recuperar datos que estarán de forma temporal
//------------------------------------------------------------------------------------------------
class TempData
{
    //Propiedades
    private $fileName;
    private $data;
    //------------------------------------------------------------------------------------------------
    // Constructor
    // fileName:Txt, data:Txt --> __construct() --> obj:TempData
    //------------------------------------------------------------------------------------------------
    public function __construct($fileName, $data){
        $this->fileName = $fileName;
        $this->data = $data;
    }
    //---------------------------------------------------------------------------------------------------
    // obj:TempData --> putTempData() --> filename.txt
    // Descripción: Guarda nueva información del objeto en un archivo de texto
    //----------------------------------------------------------------------------------------------------
    public function putTempData(){
        if(file_exists($this->fileName)){
            $this->eraseTempData();
        }
        file_put_contents($this->fileName, $this->data);
    }
    //---------------------------------------------------------------------------------------------------
    // obj:TempData --> getTempData() --> res:Txt
    // Descripción: Recupera la información de un archivo de texto
    //----------------------------------------------------------------------------------------------------
    public function getTempData(){
        if(file_exists($this->fileName)){
            $text = file_get_contents($this->fileName);
            return $text;
        }
    }
    //---------------------------------------------------------------------------------------------------
    // obj:TempData --> eraseTempData()
    // Descripción: Borra el archivo temporal si existe
    //----------------------------------------------------------------------------------------------------
    public function eraseTempData(){
        if(file_exists($this->fileName)){
            unlink($this->fileName);
        }
    }

} //Fin Clase TempData
?>