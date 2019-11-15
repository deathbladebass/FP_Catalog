<?php
include_once 'connect_data.php';
include_once 'centrosModel.php';
include_once 'ofertaClass.php';

class ofertaModel extends ofertaClass{
    
    private $link;
    private $list=array();
    private $objCentro;
    
    public function getObjCentro()
    {
        return $this->objCentro;
    }

    public function getLink()
    {
        return $this->link;
    }
    
    public function getList()
    {
        return $this->list;
    }
    
    public function OpenConnect()
    {
        $konDat=new connect_data();
        try
        {
            $this->link=new mysqli($konDat->host,$konDat->userbbdd,$konDat->passbbdd,$konDat->ddbbname);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        $this->link->set_charset("utf8"); // honek behartu egiten du aplikazio eta
        //                  //databasearen artean UTF -8 erabiltzera datuak trukatzeko
    }
    public function CloseConnect()
    {
        try
        {
            $this->link->close();
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }
    public function setList() {
        $this->OpenConnect();  // konexio zabaldu  - abrir conexión
        
        $codCentro=$this->getCod_centro();
        
        $sql = "CALL spAllOferta('$codCentro')"; // SQL sententzia - sentencia SQL
        
        $result = $this->link->query($sql); // result-en ddbb-ari eskatutako informazio dena gordetzen da
        // se guarda en result toda la información solicitada a la bbdd
        
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            
            $new=new ofertaModel();
            
            $this->setCodigo($row['codigo']);
            $this->setCod_ciclo($row['cod_ciclo']);
            $this->setCod_centro($row['cod_centro']);
            $this->setModelo($row['modelo']);
            $this->setTurno($row['turno']);
            
            $centro=new centrosModel();
            $centro->setCod_centro($row['cod_centro']);
            $new->objCentro=$centro->findCentroByCode();
            
            array_push($this->list, $new);
        }
        mysqli_free_result($result);

        $this->CloseConnect();
    }
    function getObjCentroJson() {
        
        $arr=array();
        
        foreach ($this->list as $object) {
            $vars = $object->getObjectVars();
            
            $objCentro=$object->getObjCentro()->getObjectVars();
            $vars['objCentro']=$objCentro;
                      
            array_push($arr, $vars);
        }
        return json_encode($arr);
    }
}