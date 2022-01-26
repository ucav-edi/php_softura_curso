<?php

include_once 'ConfigBD.php';

/*
 * consultas
 * nuevos registros
 * modificar registros
 * eliminar registros
 * CRUD
 */

class BaseDeDatos{

    private $dbConfig;
    private $mysqli;

    function __construct()
    {
        //manejo de errores
        try{
            //$this->mysqli_set_charset($connect,"utf8");

            $this->dbConfig = ConfigBD::getConfig();
            $this->mysqli = new mysqli(
                $this->dbConfig['host'],
                $this->dbConfig['user'],
                $this->dbConfig['password'],
                $this->dbConfig['database'],
                $this->dbConfig['port']
            );
            if($this->mysqli->connect_errno){
                echo "Error en la conexion de BD ".$this->mysqli->connect_error;
            }
            //$this->mysqli_set_charset($,"utf8");
        }catch (Exception $ex){
            //mostrar mensaje de error de constructor de BaseDeDatos
            echo 'Error en el constructor de BaseDeDatos';die;
        }
    }

    /*public function consultaRegistros($tabla,$condicionales = array())
    { //consuta_registros
        $consulta = $this->mysqli->query($querySQL);
        $indexRegistro = 0;
        $array_registros = array();
        while ($registro = $consulta->fetch_assoc()){
            foreach ($registro as $columna => $valor){
                $array_registros[$indexRegistro][$columna] = utf8_encode($valor);
            }
            $indexRegistro++;
        }
        return $array_registros;
    }*/
    ///se modifico la funcion para usar la funcion de condiciones puesta mas abajo
    public function consultaRegistros($tabla,$condicionales = array()){
        //aca se obtienen las condicionales a evaluar de la consulta SQL
        $consultaWhere = $this->obtenerCondicionalesAnd($condicionales);
        //se concatena la consulta sql con las sentencias where
        $consultaSelect = "SELECT * FROM ".$tabla." ".$consultaWhere;
        //se ejecuta la consulta
        $consultaSQL = $this->mysqli->query($consultaSelect);
        //se crea un variables para llevar control del indice y capturar los datos
        $indexRegistro = 0;
        $array_registro = array();
        //se crea un while que funcionara mientras se obtenga una fila de la consulta
        //var_dump($consultaWhere);exit;
        while($registro = $consultaSQL->fetch_assoc()){
            foreach($registro as $columna => $valor){
                $array_registro[$indexRegistro][$columna]= utf8_encode($valor);
            }
            $indexRegistro++;

        }
        //var_dump($array_registro);exit;
        return $array_registro;
    }
    public function obtenerRegistrosArray($querySQL){
        $consultaSql = $this->mysqli->query($querySQL);
        $indexRegistro = 0;
        $array_registros = array();
        while ($registro = $consultaSql->fetch_assoc()){
            foreach ($registro as $columna => $valor){
                $array_registros[$indexRegistro][$columna] = utf8_encode($valor);
            }
            $indexRegistro++;
        }
        return $array_registros;
    }




    /**
     * @param $tabla string nombre de la tabla a actualizar
     * @param $valoresUpdate recibir un arreglo de datos que contenga el nombre de la columna y su valor
     * @param $condicionales recibir un arreglo de datos que contenga el nombre de la columna y su valor
     * update $tabla set $valores where $condicionales
     */
    public function actualizarRegistro($tabla,$valoresUpdate,$condicionales){ //funcion1,
        $sqlSets = $this->obtenerValoresUpdate($valoresUpdate);
        $sqlWhere = $this->obtenerCondicionalesAnd($condicionales);
        $consultaUpdate = "UPDATE $tabla $sqlSets $sqlWhere";
        //var_dump($consultaUpdate);exit;
        return $this->queryNativa($consultaUpdate);
    }

    /**
     * @param $tabla
     * @param $valoresInsert
     * INSERT INTO tabla(columna1, columna2, ... ,columnaN) VALUES (valor1,valor2,...,valorN)
     */
    public function insertarRegistro($tabla,$valoresInsert){ //funcion2
        //parte usada para setear los valores a insertar
        //siguiendo la estructura -> nombre_columnas = nombre
        //valor_columna = valor
        $nombres_columnas = "";
        $valores_columna = "";
        //index va a ser el contador de iteracion de campos que llegan del los valores
        $index = 1;
        //se obtiene la longitud de los campos a agregar
        $max_long_datos = sizeof($valoresInsert);
        //se crea un foreach para obtener y concatenar los nombres de los campos de columna y
        // los valores a insertar
        foreach ($valoresInsert as $columna => $valor){
            $nombres_columnas .= $columna;
            $valores_columna .= "'".utf8_decode($valor). "'";
            //se crea un if para ir agregando las comas que separan los campos y los valores en
            //la estructura del insert
            if($index < $max_long_datos){
                $nombres_columnas .= ",";
                $valores_columna .= ",";
            }
            $index++;

        }
        //se estructura los paramtros de la consulta con los datos
        //de la columna y sus valores a insertar
        $sql_insertar = "INSERT INTO ".$tabla." (".$nombres_columnas.") VALUES (".$valores_columna.");";
        //var_dump($sql_insertar);exit;
        //se retorna el valor a la funcion queryNativa para ejecutar la insercion
        //var_dump($sql_insertar);exit;
        return $this->queryNativa($sql_insertar);
    }

    /**
     * @param $tabla
     * @param $condionales
     * DELETE FROM $tabla WHERE condicionales
     */
    public function eliminarRegistro($tabla,$condicionales){
        //var_dump($condicionales);exit;
        $condicionalesdelete = $this->obtenerCondicionalesAnd($condicionales);
        //var_dump($condicionalesdelete);exit;
        $sql_eliminar = "DELETE FROM ".$tabla." ".$condicionalesdelete;
        return $this->queryNativa($sql_eliminar);
    }

 //   public function ultimoIdInsertado($tabla)
 //   {
 //       $sql_consulta = "SELECT MAX (id) AS id FROM " .$tabla;
 //       //var_dump($sql_consulta);exit;
 //       return $this->queryNativa($sql_consulta);
 //   }



    public function queryNativa($querySQL){
        try{
            $queryExecutada = $this->mysqli->query($querySQL);
            //var_dump($querySQL);
            return $queryExecutada;
        }catch (Exception $ex){
            return false;
        }
    }

    //funcion privada para formatear los datos que se van actualizar en una tabla "SET"
    // array ('clave' => 'ecorona','nombres' => 'Luis Enrique') ----->
    // array(
    //    nombre_columna => valor,
    //    nombre_columna2 => valor,
    //    nombre_columna3 => valor,
    //    nombre_columna4 => valor,
    //    nombre_columna5 => valor
    //)
    // return "clave = 'ecorona', nombres = 'Luis Enrique'"
    private function obtenerValoresUpdate($valoresUpdate){
        $sets = " SET";
        $index = 1; $max = sizeof($valoresUpdate);
        foreach ($valoresUpdate as $columna => $valor){
            $valor = utf8_decode($valor);
            if($index < $max){
                $sets .= " $columna = '$valor',";
            }else{
                $sets .= " $columna = '$valor'";
            }
            $index++;
        }
        return $sets;
    }


    private function obtenerCondicionalesAnd($condicionales){
        $condiciones = ' where 1=1';
        $index = 1; $max = sizeof($condicionales);
        foreach ($condicionales as $columna => $valor){
            if($index <= $max){
                if(strpos($valor,'%') !== false){
                    $condiciones .= " AND $columna LIKE '$valor'";
                }else{
                    $condiciones .= " AND $columna = '$valor'";
                }
            }
            $index++;
        }
        return $condiciones;
    }
    public function getMsgErrors(){
        $msgErrors = array();
        foreach ($this->errors as $e){
            $msgErrors[] = "Code error: ".$e['errno']." Explicacion: ".$e['error'];
        }
        return $msgErrors;
    }


}

/*$configDB = ConfigBD::getConfig();
$conexion = new mysqli(
    $configDB['host'],$configDB['user'],$configDB['password'],$configDB['database'],$configDB['port']
);

//$update = $conexion->query("UPDATE catalogo_contacto SET tipo = 'Redes sociales' WHERE id=3");
//$delete = $conexion->query("DELETE FROM catalogo_contacto WHERE id=4");
$insert = $conexion->query("INSERT INTO catalogo_contacto(tipo) values ('Nuevo cat')");
$consulta = $conexion->query("select * from catalogo_contacto");

$indexRegistro = 0;
$array_registros = array();
while ($registro = $consulta->fetch_assoc()){
    foreach ($registro as $columna => $valor){
        $array_registros[$indexRegistro][$columna] = $valor;
    }
    $indexRegistro++;
}

var_dump($array_registros);
*/
