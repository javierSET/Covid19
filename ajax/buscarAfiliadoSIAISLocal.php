/*
    @Author: Daniel Villegas Veliz
    @descripcion: clase para realizar la busqueda depacientes
    este modulo esta en desarrollo no se esta usando todavia
 */
<?php

require_once "../controladores/afiliadosSIAIS.controlador.php";
require_once "../modelos/afiliadosSIAIS.modelo.php";

require_once "../controladores/fichas.controlador.php";
require_once "../modelos/fichas.modelo.php";

class BusquedaPacienteSIAISLocal{
    public $id_ficha;
    public $id_afiliado;
    
    /*=================================================
        Search afiliado
      =================================================*/
    public function ajaxBuscadorAfiliadoSiaisLocal(){
        $respuesta = "";
        return $respuesta;
    }
}
