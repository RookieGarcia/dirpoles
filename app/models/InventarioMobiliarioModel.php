<?php
require_once "app/models/conexion.php";

class InventarioMobiliarioModel extends Database {
    public function __construct() {
        parent::__construct();
    }

    // Obtener tipos de mobiliario
    public function obtenerTiposMobiliario() {
        $query = "SELECT * FROM tipo_mobiliario WHERE estatus = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener tipos de equipo
    public function obtenerTiposEquipo() {
        $query = "SELECT * FROM tipo_equipo WHERE estatus = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Registrar nuevo mobiliario
    public function registrarMobiliario($data) {
        try {
            $this->conn->beginTransaction();
            $id_empleado = $_SESSION['id_empleado'];

            $query = "INSERT INTO mobiliario (
                id_tipo_mobiliario, id_servicios, marca, modelo, 
                color, estado, cantidad, fecha_adquisicion, 
                descripcion_adicional, observaciones
            ) VALUES (
                :id_tipo, :id_servicio, :marca, :modelo, 
                :color, :estado, :cantidad, :fecha_adquisicion, 
                :descripcion, :observaciones
            )";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_tipo', $data['id_tipo_mobiliario']);
            $stmt->bindParam(':id_servicio', $data['id_servicios']);
            $stmt->bindParam(':marca', $data['marca']);
            $stmt->bindParam(':modelo', $data['modelo']);
            $stmt->bindParam(':color', $data['color']);
            $stmt->bindParam(':estado', $data['estado']);
            $stmt->bindParam(':cantidad', $data['cantidad']);
            $stmt->bindParam(':fecha_adquisicion', $data['fecha_adquisicion']);
            $stmt->bindParam(':descripcion', $data['descripcion_adicional']);
            $stmt->bindParam(':observaciones', $data['observaciones']);
            $stmt->execute();
            
            $id_mobiliario = $this->conn->lastInsertId();

            // Registrar en historial
            $this->registrarHistorial(
                $id_empleado,
                'mobiliario',
                $id_mobiliario,
                'registro',
                null,
                $data['id_servicios'],
                'Registro inicial de mobiliario'
            );

            // Bitácora
            $this->registrarBitacora($id_empleado, 'Inventario Mobiliario', 'Registro', 'Mobiliario registrado');

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Error al registrar mobiliario: " . $e->getMessage());
            return false;
        }
    }

    // Registrar nuevo equipo
    public function registrarEquipo($data) {
        try {
            $this->conn->beginTransaction();
            $id_empleado = $_SESSION['id_empleado'];

            $query = "INSERT INTO equipos (
                id_tipo_equipo, id_servicios, nombre, marca, modelo, 
                serial, color, estado, fecha_adquisicion, 
                descripcion, observaciones
            ) VALUES (
                :id_tipo, :id_servicio, :nombre, :marca, :modelo, 
                :serial, :color, :estado, :fecha_adquisicion, 
                :descripcion, :observaciones
            )";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_tipo', $data['id_tipo_equipo']);
            $stmt->bindParam(':id_servicio', $data['id_servicios']);
            $stmt->bindParam(':nombre', $data['nombre']);
            $stmt->bindParam(':marca', $data['marca']);
            $stmt->bindParam(':modelo', $data['modelo']);
            $stmt->bindParam(':serial', $data['serial']);
            $stmt->bindParam(':color', $data['color']);
            $stmt->bindParam(':estado', $data['estado']);
            $stmt->bindParam(':fecha_adquisicion', $data['fecha_adquisicion']);
            $stmt->bindParam(':descripcion', $data['descripcion_adicional']);
            $stmt->bindParam(':observaciones', $data['observaciones']);
            $stmt->execute();
            
            $id_equipo = $this->conn->lastInsertId();

            // Registrar en historial
            $this->registrarHistorial(
                $id_empleado,
                'equipo',
                $id_equipo,
                'registro',
                null,
                $data['id_servicios'],
                'Registro inicial de equipo'
            );

            // Bitácora
            $this->registrarBitacora($id_empleado, 'Inventario Equipos', 'Registro', 'Equipo registrado');

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Error al registrar equipo: " . $e->getMessage());
            return false;
        }
    }

    // Crear ficha técnica
    public function crearFichaTecnica($data) {
        try {
            $this->conn->beginTransaction();
            $id_empleado = $_SESSION['id_empleado'];

            // Verificar disponibilidad de items antes de asignar
            if (!$this->verificarDisponibilidadItems($data)) {
                throw new Exception("Uno o más items no están disponibles para asignación");
            }

            // Crear ficha técnica
            $query = "INSERT INTO fichas_tecnicas (
                nombre_ficha, id_servicio, id_empleado_responsable, 
                descripcion, fecha_creacion
            ) VALUES (
                :nombre, :id_servicio, :id_responsable, 
                :descripcion, CURDATE()
            )";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nombre', $data['nombre_ficha']);
            $stmt->bindParam(':id_servicio', $data['id_servicio']);
            $stmt->bindParam(':id_responsable', $data['id_responsable']);
            $stmt->bindParam(':descripcion', $data['descripcion']);
            $stmt->execute();
            
            $id_ficha = $this->conn->lastInsertId();

            // Registrar mobiliario en la ficha
            if (!empty($data['mobiliario'])) {
                foreach ($data['mobiliario'] as $item) {
                    $query = "INSERT INTO detalle_ficha_mobiliario (
                        id_ficha, id_mobiliario, cantidad, observaciones
                    ) VALUES (
                        :id_ficha, :id_mobiliario, :cantidad, :observaciones
                    )";
                    
                    $stmt = $this->conn->prepare($query);
                    $stmt->bindParam(':id_ficha', $id_ficha);
                    $stmt->bindParam(':id_mobiliario', $item['id']);
                    $stmt->bindParam(':cantidad', $item['cantidad']);
                    $stmt->bindParam(':observaciones', $item['observaciones']);
                    $stmt->execute();

                    // Registrar en historial
                    $this->registrarHistorial(
                        $id_empleado,
                        'mobiliario',
                        $item['id'],
                        'asignacion',
                        $id_ficha,
                        $data['id_servicio'],
                        'Asignado a ficha técnica'
                    );
                }
            }

            // Registrar equipos en la ficha
            if (!empty($data['equipos'])) {
                foreach ($data['equipos'] as $item) {
                    $query = "INSERT INTO detalle_ficha_equipo (
                        id_ficha, id_equipo, observaciones
                    ) VALUES (
                        :id_ficha, :id_equipo, :observaciones
                    )";
                    
                    $stmt = $this->conn->prepare($query);
                    $stmt->bindParam(':id_ficha', $id_ficha);
                    $stmt->bindParam(':id_equipo', $item['id']);
                    $stmt->bindParam(':observaciones', $item['observaciones']);
                    $stmt->execute();

                    // Registrar en historial
                    $this->registrarHistorial(
                        $id_empleado,
                        'equipo',
                        $item['id'],
                        'asignacion',
                        $id_ficha,
                        $data['id_servicio'],
                        'Asignado a ficha técnica'
                    );
                }
            }

            // Bitácora
            $this->registrarBitacora($id_empleado, 'Fichas Técnicas', 'Registro', 'Ficha técnica creada');

            $this->conn->commit();
            return $id_ficha;
        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Error al crear ficha técnica: " . $e->getMessage());
            return false;
        }
    }

    // Verificar disponibilidad de items para ficha técnica
    private function verificarDisponibilidadItems($data) {
        // Verificar mobiliario
        if (!empty($data['mobiliario'])) {
            foreach ($data['mobiliario'] as $item) {
                $query = "SELECT 
                    m.cantidad - IFNULL(SUM(dfm.cantidad), 0) as disponible
                    FROM mobiliario m
                    LEFT JOIN detalle_ficha_mobiliario dfm ON m.id_mobiliario = dfm.id_mobiliario
                    WHERE m.id_mobiliario = :id
                    GROUP BY m.id_mobiliario";
                
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':id', $item['id']);
                $stmt->execute();
                $disponible = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$disponible || $disponible['disponible'] < $item['cantidad']) {
                    return false;
                }
            }
        }

        // Verificar equipos
        if (!empty($data['equipos'])) {
            foreach ($data['equipos'] as $item) {
                $query = "SELECT 
                    e.id_equipo, 
                    CASE WHEN df.id_ficha IS NULL THEN 1 ELSE 0 END as disponible
                    FROM equipos e
                    LEFT JOIN detalle_ficha_equipo df ON e.id_equipo = df.id_equipo
                    WHERE e.id_equipo = :id";
                
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':id', $item['id']);
                $stmt->execute();
                $disponible = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$disponible || !$disponible['disponible']) {
                    return false;
                }
            }
        }

        return true;
    }

    // Obtener mobiliario por servicio
    public function obtenerMobiliarioPorServicio($id_servicio = null) {
        $query = "SELECT 
                    m.*, tm.nombre as tipo_mobiliario, s.nombre_serv as servicio,
                    m.cantidad - IFNULL(SUM(dfm.cantidad), 0) as disponible
                  FROM mobiliario m
                  JOIN tipo_mobiliario tm ON m.id_tipo_mobiliario = tm.id_tipo_mobiliario
                  JOIN servicio s ON m.id_servicios = s.id_servicios
                  LEFT JOIN detalle_ficha_mobiliario dfm ON m.id_mobiliario = dfm.id_mobiliario";
        
        if ($id_servicio) {
            $query .= " WHERE m.id_servicios = :id_servicio";
        }
        
        $query .= " GROUP BY m.id_mobiliario ORDER BY m.id_mobiliario DESC";
        
        $stmt = $this->conn->prepare($query);
        
        if ($id_servicio) {
            $stmt->bindParam(':id_servicio', $id_servicio);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener equipos por servicio
    public function obtenerEquiposPorServicio($id_servicio = null) {
        $query = "SELECT 
                    e.*, te.nombre as tipo_equipo, s.nombre_serv as servicio,
                    CASE WHEN df.id_ficha IS NULL THEN 1 ELSE 0 END as disponible
                  FROM equipos e
                  JOIN tipo_equipo te ON e.id_tipo_equipo = te.id_tipo_equipo
                  JOIN servicio s ON e.id_servicios = s.id_servicios
                  LEFT JOIN detalle_ficha_equipo df ON e.id_equipo = df.id_equipo";
        
        if ($id_servicio) {
            $query .= " WHERE e.id_servicios = :id_servicio";
        }
        
        $query .= " GROUP BY e.id_equipo ORDER BY e.id_equipo DESC";
        
        $stmt = $this->conn->prepare($query);
        
        if ($id_servicio) {
            $stmt->bindParam(':id_servicio', $id_servicio);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener fichas técnicas
    public function obtenerFichasTecnicas() {
        $query = "SELECT 
                    ft.*, s.nombre_serv as servicio,
                    CONCAT(e.nombre, ' ', e.apellido) as responsable
                  FROM fichas_tecnicas ft
                  JOIN servicio s ON ft.id_servicio = s.id_servicios
                  LEFT JOIN empleado e ON ft.id_empleado_responsable = e.id_empleado
                  ORDER BY ft.fecha_creacion DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener detalles de ficha técnica
    public function obtenerDetalleFicha($id_ficha) {
        $data = [];
        
        // Información básica de la ficha
        $query = "SELECT 
                    ft.*, s.nombre_serv as servicio,
                    CONCAT(e.nombre, ' ', e.apellido) as responsable
                  FROM fichas_tecnicas ft
                  JOIN servicio s ON ft.id_servicio = s.id_servicios
                  LEFT JOIN empleado e ON ft.id_empleado_responsable = e.id_empleado
                  WHERE ft.id_ficha = :id_ficha";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_ficha', $id_ficha);
        $stmt->execute();
        $data['ficha'] = $stmt->fetch(PDO::FETCH_ASSOC);

        // Mobiliario asociado
        $query = "SELECT 
                    dfm.*, m.*, tm.nombre as tipo_mobiliario
                  FROM detalle_ficha_mobiliario dfm
                  JOIN mobiliario m ON dfm.id_mobiliario = m.id_mobiliario
                  JOIN tipo_mobiliario tm ON m.id_tipo_mobiliario = tm.id_tipo_mobiliario
                  WHERE dfm.id_ficha = :id_ficha";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_ficha', $id_ficha);
        $stmt->execute();
        $data['mobiliario'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Equipos asociados
        $query = "SELECT 
                    dfe.*, e.*, te.nombre as tipo_equipo
                  FROM detalle_ficha_equipo dfe
                  JOIN equipos e ON dfe.id_equipo = e.id_equipo
                  JOIN tipo_equipo te ON e.id_tipo_equipo = te.id_tipo_equipo
                  WHERE dfe.id_ficha = :id_ficha";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_ficha', $id_ficha);
        $stmt->execute();
        $data['equipos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    // Registrar en historial
    private function registrarHistorial($id_empleado, $tipo_item, $id_item, $tipo_movimiento, $id_ficha, $id_servicio, $descripcion) {
        $query = "INSERT INTO historial_inventario (
            id_empleado, tipo_item, id_item, tipo_movimiento, 
            id_ficha, id_servicio_nuevo, descripcion
        ) VALUES (
            :id_empleado, :tipo_item, :id_item, :tipo_movimiento, 
            :id_ficha, :id_servicio, :descripcion
        )";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_empleado', $id_empleado);
        $stmt->bindParam(':tipo_item', $tipo_item);
        $stmt->bindParam(':id_item', $id_item);
        $stmt->bindParam(':tipo_movimiento', $tipo_movimiento);
        $stmt->bindParam(':id_ficha', $id_ficha);
        $stmt->bindParam(':id_servicio', $id_servicio);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->execute();
    }

    // Registrar en bitácora
    private function registrarBitacora($id_empleado, $modulo, $accion, $descripcion) {
        $query = "INSERT INTO bitacora (
            id_empleado, modulo, accion, descripcion, fecha
        ) VALUES (
            :id_empleado, :modulo, :accion, :descripcion, NOW()
        )";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_empleado', $id_empleado);
        $stmt->bindParam(':modulo', $modulo);
        $stmt->bindParam(':accion', $accion);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->execute();
    }

    // Obtener historial de inventario
    public function obtenerHistorial($tipo_item = null, $id_item = null) {
        $query = "SELECT 
                    hi.*, 
                    DATE_FORMAT(hi.fecha_movimiento, '%d/%m/%Y %H:%i') as fecha_formato,
                    CONCAT(e.nombre, ' ', e.apellido) as empleado,
                    s.nombre_serv as servicio,
                    ft.nombre_ficha as ficha
                  FROM historial_inventario hi
                  JOIN empleado e ON hi.id_empleado = e.id_empleado
                  LEFT JOIN servicio s ON hi.id_servicio_nuevo = s.id_servicios
                  LEFT JOIN fichas_tecnicas ft ON hi.id_ficha = ft.id_ficha";
        
        if ($tipo_item && $id_item) {
            $query .= " WHERE hi.tipo_item = :tipo_item AND hi.id_item = :id_item";
        }
        
        $query .= " ORDER BY hi.fecha_movimiento DESC";
        
        $stmt = $this->conn->prepare($query);
        
        if ($tipo_item && $id_item) {
            $stmt->bindParam(':tipo_item', $tipo_item);
            $stmt->bindParam(':id_item', $id_item);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>