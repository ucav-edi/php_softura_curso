<?php

include_once "../controlador/CatalogosController.php";
include_once "../controlador/EmpleadosController.php";

$peticion = $_GET['peticion'];
$funcion = $_GET['funcion'];
$data = $_POST;

$catalogoController = new CatalogosController();
$empleadoController = new EmpleadosController();
//var_dump($peticion,$funcion);exit;

if(isset($_GET['peticion']) && $_GET['peticion'] != '' && isset($_GET['funcion']) && $_GET['funcion'] != ''){
    switch ($peticion){
        //peticion para obtener los catalogos
        case 'catalogos':
            switch ($funcion){
                //rutas de contacto
                case 'contacto':
                    $resultado = $catalogoController->catalogoContacto();
                    echo json_encode($resultado);
                    break;
                case 'guardar_contacto':
                    $resultado = $catalogoController->actualizarCatalogoContacto($data);
                    echo json_encode($resultado);
                    break;
                case 'estado':
                    $resultado = $catalogoController->catalogoEstado();
                    echo json_encode($resultado);
                    break;
                default:
                    echo json_encode(array(
                        'success' => false,
                        'msg' => array(
                            'Error, no encontre la peticion solicitada'
                        )
                    ));
                    break;
            }
            break;
        //peticion para obtener y realizar las funciones correspondientes a los empleados
        case 'empleados':
            switch ($funcion){
                case 'listado':
                    $resultado = $empleadoController->obtenerEmpleados();
                    //var_dump($resultado);exit;
                    echo json_encode($resultado);
                    break;
                case 'guardar':
                    //realizar las funciones correspondientes de guardar un empleados
                    //considerar validaciones de campos
                    $resultado = $empleadoController->insertarNuevoEmpleado($data);
                    //var_dump($data);exit;
                    echo json_encode($resultado);
                    break;
                case 'actualizar':
                    //realizar las funcioens para actualizar un empleados
                    //tomar en cuenta sus validaciones
                    $resultado = $empleadoController->actualizarEmpleado($data);
                    echo json_encode($resultado);
                    break;
                 case 'eliminar':
                    //realizar las funciones para eliminar un empleado
                    $resultado = $empleadoController->eliminarEmpleado($data);
                    //var_dump($resultado);exit;
                    echo json_encode($resultado);
                    break;

                default:
                    echo json_encode(array(
                        'success' => false,
                        'msg' => array(
                            'Error, no encontre la peticion solicitada'
                        )
                    ));
                    break;
            }
            break;

        default:
            echo json_encode(array(
                'success' => false,
                'msg' => array(
                    'Error, no encontre la peticion solicitada'
                )
            ));
            break;
    }
}else{
    echo json_encode(array(
        'success' => false,
        'msg' => array(
            'Error, no encontre la peticion solicitada'
        )
    ));
}


