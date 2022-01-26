<?php

include_once "BaseDeDatos.php";

/**
 * realizar las operaciones basicas
 * select, insert, update, delete
 */

class ModeloBase extends BaseDeDatos{

    private $tabla;

    function __construct($tabla)
    {
        parent::__construct();
        $this->tabla = $tabla;
    }

    public function obtenerRegistros($condicionales = array()){
        //$consulta = "select * from ".$this->tabla;
        $registros = $this->consultaRegistros($this->tabla,$condicionales);
        return $registros;
    }

    public function actualizar($valoresUpdate,$condicionales){
        return $this->actualizarRegistro($this->tabla,$valoresUpdate,$condicionales);
    }

    public function insertar($valoresInsert){
        return $this->insertarRegistro($this->tabla,$valoresInsert);
    }

    public function eliminar($valoresEliminar){
        //var_dump("este eliminar es del modelo base".$this->tabla);
        return $this->eliminarRegistro($this->tabla,$valoresEliminar);

    }
    /*public function obtenerUltimoRegistro(){
        return $this->ultimoIdInsertado();
    }*/
}