<?php
include_once '../model/familiasModel.php';

$familia=new familiasModel();
$familia->setList();

$listaFamiliaJson=$familia->getListFamiliaJson();

echo $listaFamiliaJson;

unset ($familia);