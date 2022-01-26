<?php

//1.- consumir el modelo
include_once "../modelo/EmpleadoModel.php";
include_once "../modelo/ContactoModel.php";
include_once "../helper/ValidacionFormulario.php";

class EmpleadosController {

    /**
     * operaciones necesarias para poder manipular el sistema
     * obtener registros
     * insertar registrsos
     * actualizar
     * eliminar
     */
    public function obtenerEmpleados(){
        try{
            $empleadoModel = new EmpleadoModel();
            $registrosEmpleado = $empleadoModel->obtenerRegistros();
            //funcionalidad para obtener los datos de contacto por empleado
            $empleadoCompleto = array();
            foreach ($registrosEmpleado as $index => $empleado){
                $contactoModel = new ContactoModel($empleado['id']);
                $registroContactoEmpleado = $contactoModel->obtenerRegistros();
                $empleado['datos_contacto'] = $registroContactoEmpleado;
                $empleadoCompleto[$index] = $empleado;
            }
            $respuesta = array(
                'success' => true,
                'data' => array(
                    'empleados' => $empleadoCompleto
                )
            );
            return $respuesta;
        }catch (Exception $ex){
            $respuesta = array(
                'success' => false,
                'msg' => array(
                    utf8_encode('Ocurrio un error en el servidor, intentar más tarde'),
                    $ex->getMessage()
                )
            );
            return $respuesta;
        }
    }

    public function insertarNuevoEmpleado($datosFormulario){
        try{
            //validar datos del formulario
            $validacion = ValidacionFormulario::validarFormEmpleado($datosFormulario);
            if($validacion['status']){
                $empleadoModel = new EmpleadoModel();
                unset($datosFormulario['id']);
                //actualizar empleado
                //$empleadoModel = new EmpleadoModel();
                $insertar = $empleadoModel->insertar($datosFormulario);
                if($insertar){
                    $respuesta = array(
                        'success' => true,
                        'msg' => array(
                            'Se creo el empleado correctamente'
                        )
                    );
                }else {
                    $respuesta = array(
                        'success' => false,
                        'msg' => array(
                            'No fue posible crear el empleado'
                        )
                    );
                }
            }else{
                $respuesta['success'] = false;
                $respuesta['msg'] = $validacion['msg'];
            }
        }catch (Exception $ex){
            $respuesta = array(
                'success' => false,
                'msg' => array(
                    utf8_encode('Ocurrio un error en el servidor, intentar más tarde'),
                    $ex->getMessage()
                )
            );
        }
        return $respuesta;
    }

    public function actualizarEmpleado($datosFormulario){
        try{
            //validar datos del formulario
            $validacion = ValidacionFormulario::validarFormEmpleado($datosFormulario);
            if($validacion['status']){
                $empleadoModel = new EmpleadoModel();
                //actualizar empleado
                $guardar = $empleadoModel->actualizar($datosFormulario,array('id' => $datosFormulario['id']));
                if($guardar){
                    $respuesta = array(
                        'success' => true,
                        'msg' => array(
                            'Se actualizo el empleado correctamente'
                        )
                    );
                }else{
                    $respuesta = array(
                        'success' => false,
                        'msg' => array(
                            'No fue posible actualizar el empleado correctamente'
                        )
                    );
                }
            }else{
                $respuesta['success'] = false;
                $respuesta['msg'] = $validacion['msg'];
            }
        }catch (Exception $ex){
            $respuesta = array(
                'success' => false,
                'msg' => array(
                    utf8_encode('Ocurrio un error en el servidor, intentar más tarde'),
                    $ex->getMessage()
                )
            );
        }
        return $respuesta;
    }

    public function eliminarEmpleado($datosFormulario){
        try{
            $empleadoModel = new EmpleadoModel();
            $eliminar = $empleadoModel->eliminar($datosFormulario,array('id' => $datosFormulario['id']));
            //var_dump($eliminar);exit;
            if($eliminar){
                $respuesta = array(
                    'success' => true,
                    'msg' => array(
                        'Se elimino el empleado correctamente'
                    )
                );
            }else{
                $respuesta = array(
                    'success' => false,
                    'msg' => array(
                        'No fue posible eliminar el empleado correctamente'
                    )
                );
            }
            return $respuesta;
        }catch (Exception $ex){
            $respuesta = array(
                'success' => false,
                'msg' => array(
                    utf8_encode('Ocurrio un error en el servidor, intentar más tarde'),
                    $ex->getMessage()
                )
            );
            return $respuesta;
        }

    }

}