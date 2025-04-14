<?php
require_once "app/models/conexion.php";

class Configuracion extends Database{
    public function __construct(){
        parent::__construct();
    }

    public function config_crear($tabla, $datos) {
        $camposValidacion = [
            'servicio' => 'nombre_serv',
            'pnf' => 'nombre_pnf',
            'patologia' => 'nombre_patologia',
            'tipo_empleado' => 'tipo',
            'presentacion_insumo' => 'nombre_presentacion'
        ];
    
        if (isset($camposValidacion[$tabla]) && isset($datos[$camposValidacion[$tabla]])) {
            $campoValidar = $camposValidacion[$tabla];
            $valorValidar = $datos[$campoValidar];
            
            $sql = "SELECT COUNT(*) FROM $tabla WHERE $campoValidar = :valorValidar";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':valorValidar', $valorValidar, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();
    
            if ($count > 0) {
                return false;
            }
        }
    
        if (!isset($datos['fecha_creacion'])) {
            $datos['fecha_creacion'] = 'CURDATE()';
        }
    
        $columnas = implode(", ", array_keys($datos));
        $valores = implode(", ", array_map(function($key) {
            return $key === 'fecha_creacion' ? 'CURDATE()' : ":$key";
        }, array_keys($datos)));
    
        $sql = "INSERT INTO $tabla ($columnas) VALUES ($valores)";
        $stmt = $this->conn->prepare($sql);
    
        foreach ($datos as $key => &$val) {
            if ($key !== 'fecha_creacion') {
                $stmt->bindParam(":$key", $val);
            }
        }
    
        return $stmt->execute();
    }
    
    
    
    
    

    public function config_listar($tabla) {
        $sql = "SELECT * FROM $tabla";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($tabla, $id) {
        // Definir el mapeo de las columnas de ID
        $idColumnMap = [
            'presentacion_insumo' => 'id_presentacion',
            'patologia' => 'id_patologia',
            'pnf' => 'id_pnf',
            'servicio' => 'id_servicios',
            'tipo_empleado' => 'id_tipo_emp'
        ];
    
        // Obtener el nombre de la columna de ID para la tabla solicitada
        $idColumn = $idColumnMap[$tabla] ?? 'id';
    
        // Ejecutar la consulta usando el nombre de columna de ID adecuado
        $sql = "SELECT * FROM $tabla WHERE $idColumn = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public function config_actualizar($tabla, $id, $datos) {
        // Definir el mapeo de columnas de ID por tabla
        $idColumnMap = [
            'presentacion_insumo' => 'id_presentacion',
            'patologia' => 'id_patologia',
            'pnf' => 'id_pnf',
            'servicio' => 'id_servicios',
            'tipo_empleado' => 'id_tipo_emp'
        ];
    
        // Obtener el nombre de la columna de ID
        $idColumn = $idColumnMap[$tabla] ?? 'id';
    
        // Campos que requieren validación de duplicados
        $camposValidacion = [
            'servicio' => 'nombre_serv',
            'pnf' => 'nombre_pnf',
            'patologia' => 'nombre_patologia',
            'tipo_empleado' => 'tipo',
            'presentacion_insumo' => 'nombre_presentacion'
        ];
    
        // Verificar si hay un campo de validación para esta tabla
        if (isset($camposValidacion[$tabla])) {
            $campoValidar = $camposValidacion[$tabla];
            
            // Verificar si el campo de validación está en los datos
            if (isset($datos[$campoValidar])) {
                $valorValidar = $datos[$campoValidar];
    
                // Consulta para verificar duplicados, excluyendo el registro actual
                $sql = "SELECT COUNT(*) FROM $tabla WHERE $campoValidar = :valorValidar AND $idColumn != :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':valorValidar', $valorValidar, PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $count = $stmt->fetchColumn();
    
                // Si ya existe un registro con ese valor, devolver false
                if ($count > 0) {
                    return false; // Valor duplicado
                }
            }
        }
    
        // Construir el conjunto de datos para la consulta
        $set = "";
        foreach ($datos as $key => $val) {
            $set .= "$key = :$key, ";
        }
        $set = rtrim($set, ", ");
    
        // Ejecutar la consulta con el nombre de columna de ID adecuado
        $sql = "UPDATE $tabla SET $set WHERE $idColumn = :id";
        $stmt = $this->conn->prepare($sql);
    
        foreach ($datos as $key => &$val) {
            $stmt->bindParam(":$key", $val);
        }
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
        return $stmt->execute();
    }
    

    public function config_eliminar($tabla, $id) {
        // Mapeo de columnas de ID por tabla
        $idColumnMap = [
            'presentacion_insumo' => 'id_presentacion',
            'patologia' => 'id_patologia',
            'pnf' => 'id_pnf',
            'servicio' => 'id_servicios',
            'tipo_empleado' => 'id_tipo_emp'
        ];
    
        // Obtener el nombre de la columna de ID según la tabla
        $idColumn = $idColumnMap[$tabla] ?? 'id';  // Default a 'id' si no está mapeada
    
        // Consulta DELETE usando la columna de ID correcta
        $sql = "DELETE FROM $tabla WHERE $idColumn = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
        return $stmt->execute();
    }
    
}