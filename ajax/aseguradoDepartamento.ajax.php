<?php
require_once "../controladores/provincia.controlador.php";
require_once "../controladores/municipio.controlador.php";

require_once "../modelos/provincia.modelo.php";
require_once "../modelos/municipio.modelo.php";

class AjaxDepartamentos{
    public $idDepartamento;    
    public function buscarProvinciaPertenescanDepartamento(){
        $valor=$this->idDepartamento;
        $respuesta = ControladorProvincia::ctrMostrarProvinciaPertenescanDepartamento($valor);
        echo json_encode($respuesta);
    }    
}

class AjaxMunicipio{
    public $idMunicipio;
    public function buscarMunicipioPerteneceProvincia(){
        $valor=$this->idMunicipio;
        $respuesta = ControladorMunicipio::ctrMostrarMunicipioPerteneceProvincia($valor);
        echo json_encode($respuesta);
    }
}

if (isset($_POST["idDepartamento"])) {
	$departamentos = new AjaxDepartamentos();
	$departamentos -> idDepartamento=$_POST["idDepartamento"];
	$departamentos -> buscarProvinciaPertenescanDepartamento();
}

if (isset($_POST["idProvincia"])) {
	$municipio = new AjaxMunicipio();
	$municipio -> idMunicipio=$_POST["idProvincia"];
	$municipio -> buscarMunicipioPerteneceProvincia();

}

?>