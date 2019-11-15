<?php
include_once '../model/ciclosModel.php';

$codFam=filter_input(INPUT_GET, 'codFam');

$ciclo=new ciclosModel();

$ciclo->setCod_familia($codFam);

$ciclo->setList();

$listaCicloJson=$ciclo->getListCicloJson();

echo $listaCicloJson;

unset ($ciclo);