<?php

include_once "ModeloBase.php";
include_once "ContactoModel.php";

/**
 * consumir las funciones del modelo base
 */

class EmpleadoModel extends ModeloBase {

    function __construct()
    {
        parent::__construct("empleado");
    }
    //se sobreescribe la funcion eliminar que esta en modelo base
    //para eliminar antes los contactos.
    public function eliminar($valoresEliminar){
        //var_dump("Funcion eliminar empleadoModel");
        $cm = new ContactoModel($valoresEliminar['id']);
        $cm->eliminar(array("empleado_id"=>$valoresEliminar['id']));
        //var_dump($valoresEliminar);exit;
        return $this->eliminarRegistro("empleado",$valoresEliminar);
    }

}