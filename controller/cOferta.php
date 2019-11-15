<?php
include_once '../model/ofertaModel.php';

$codCiclo=filter_input(INPUT_GET, 'codCiclo');

$oferta=new ofertaModel();

$oferta->setCod_ciclo($codCiclo);

$oferta->setList();

$objCentroJSON=$oferta->getObjCentroJson();

echo $objCentroJSON;

unset ($oferta);