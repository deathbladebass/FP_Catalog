<?php
include_once 'connect_data.php';
include_once 'centrosClass.php';

class centrosModel extends centrosClass{
    private $link;
    private $list=array();
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
    public function findCentroByCode()
    {
        $this->OpenConnect();  // konexio zabaldu  - abrir conexión
        
        $codCentro=$this->getCod_centro();
        
        $sql = "CALL spFindCentro('$codCentro')"; // SQL sententzia - sentencia SQL
        
        $result = $this->link->query($sql); // result-en ddbb-ari eskatutako informazio dena gordetzen da
        // se guarda en result toda la información solicitada a la bbdd
        
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $this->setTerritorio($row['territorio']);
            $this->setDependencia($row['dependencia']);
            $this->setCod_centro($row['cod_centro']);
            $this->setNom_centro($row['nom_centro']);
            $this->setDireccion($row['direccion']);
            $this->setMunicipio($row['municipio']);
            $this->setCp($row['cp']);
            $this->setTelefono($row['telefono']);
            $this->setFax($row['fax']);
            $this->setEmail($row['email']);
            $this->setWeb($row['web']);
            $this->setCoord_x($row['coord_x']);
            $this->setCoord_y($row['coord_y']);
            
        }
        mysqli_free_result($result);
        $this->CloseConnect();
        return $this;
    }
}