<?php
include_once 'connect_data.php';
include_once 'familiasClass.php';

class familiasModel extends familiasClass{
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
    public function setList()
    {
        $this->OpenConnect();
        
        $sql = "CALL spAllFamilias()";
        
        $result = $this->link->query($sql);
        
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            
            $new=new familiasModel();
            
            $new->setCod_familia($row['cod_familia']);
            $new->setNom_familia_eu($row['nom_familia_eu']);
            $new->setNom_familia_es($row['nom_familia_es']);
            
            array_push($this->list, $new);
        }
        mysqli_free_result($result);
        $this->CloseConnect();
        
    }
    function getListFamiliaJson() {
        
        $arr=array();
        
        foreach ($this->list as $object)
        {
            $vars = get_object_vars($object);
            
            array_push($arr, $vars);
        }
        return json_encode($arr);
    }
}