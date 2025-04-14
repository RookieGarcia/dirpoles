<?php
require_once "app/models/conexion.php";

class ReporteModel extends Database
{

    public function __construct()
    {
        parent::__construct();
    }

    public function listarBeneficiariosBecas()
    {
        $query = "SELECT DISTINCT beneficiario.id_beneficiario,
        beneficiario.nombres,
        beneficiario.apellidos,
        beneficiario.tipo_cedula,
        beneficiario.cedula,
        beneficiario.fecha_nac,
        beneficiario.telefono,
        beneficiario.correo,
        beneficiario.genero,
        beneficiario.direccion,
        beneficiario.estatus,
        pnf.nombre_pnf AS nombre_pnf
        FROM beneficiario
        JOIN pnf ON beneficiario.id_pnf = pnf.id_pnf
        JOIN solicitud_de_servicio ss ON beneficiario.id_beneficiario = ss.id_beneficiario
        JOIN becas b ON ss.id_solicitud_serv = b.id_solicitud_serv
        WHERE 
            beneficiario.estatus = 1
        ORDER BY beneficiario.id_beneficiario ASC";

        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarBeneficiariosEx()
    {
        $query = "SELECT DISTINCT beneficiario.id_beneficiario,
        beneficiario.nombres,
        beneficiario.apellidos,
        beneficiario.tipo_cedula,
        beneficiario.cedula,
        beneficiario.fecha_nac,
        beneficiario.telefono,
        beneficiario.correo,
        beneficiario.genero,
        beneficiario.direccion,
        beneficiario.estatus,
        pnf.nombre_pnf AS nombre_pnf
        FROM beneficiario
        JOIN pnf ON beneficiario.id_pnf = pnf.id_pnf
        JOIN solicitud_de_servicio ss ON beneficiario.id_beneficiario = ss.id_beneficiario
        JOIN exoneracion ex ON ss.id_solicitud_serv = ex.id_solicitud_serv
        WHERE 
            beneficiario.estatus = 1
        ORDER BY beneficiario.id_beneficiario ASC";

        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarBeneficiariosFames()
    {
        $query = "SELECT DISTINCT beneficiario.id_beneficiario,
        beneficiario.nombres,
        beneficiario.apellidos,
        beneficiario.tipo_cedula,
        beneficiario.cedula,
        beneficiario.fecha_nac,
        beneficiario.telefono,
        beneficiario.correo,
        beneficiario.genero,
        beneficiario.direccion,
        beneficiario.estatus,
        pnf.nombre_pnf AS nombre_pnf
        FROM beneficiario
        JOIN pnf ON beneficiario.id_pnf = pnf.id_pnf
        JOIN solicitud_de_servicio ss ON beneficiario.id_beneficiario = ss.id_beneficiario
        JOIN fames f ON ss.id_solicitud_serv = f.id_solicitud_serv
        WHERE 
            beneficiario.estatus = 1
        ORDER BY beneficiario.id_beneficiario ASC";

        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarBeneficiariosPsicologiaCitas()
    {
        $query = "SELECT DISTINCT beneficiario.id_beneficiario,
        beneficiario.nombres,
        beneficiario.apellidos,
        beneficiario.tipo_cedula,
        beneficiario.cedula,
        beneficiario.fecha_nac,
        beneficiario.telefono,
        beneficiario.correo,
        beneficiario.genero,
        beneficiario.direccion,
        beneficiario.estatus,
        pnf.nombre_pnf AS nombre_pnf
        FROM beneficiario
        JOIN pnf ON beneficiario.id_pnf = pnf.id_pnf
        JOIN cita c ON beneficiario.id_beneficiario = c.id_beneficiario
        WHERE 
            beneficiario.estatus = 1
        ORDER BY beneficiario.id_beneficiario ASC";

        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarBeneficiariosPsicologiaMorb()
    {
        $query = "SELECT DISTINCT beneficiario.id_beneficiario,
        beneficiario.nombres,
        beneficiario.apellidos,
        beneficiario.tipo_cedula,
        beneficiario.cedula,
        beneficiario.fecha_nac,
        beneficiario.telefono,
        beneficiario.correo,
        beneficiario.genero,
        beneficiario.direccion,
        beneficiario.estatus,
        pnf.nombre_pnf AS nombre_pnf
        FROM beneficiario
        JOIN pnf ON beneficiario.id_pnf = pnf.id_pnf
        JOIN solicitud_de_servicio ss ON beneficiario.id_beneficiario = ss.id_beneficiario
        JOIN consulta_psicologica cp ON ss.id_solicitud_serv = cp.id_solicitud_serv
        WHERE 
            beneficiario.estatus = 1
        ORDER BY beneficiario.id_beneficiario ASC";

        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReportDataGeneral($startDate, $endDate)
    {
        try {
            $query = "SELECT 
                    b.nombres, 
                    b.apellidos, 
                    b.cedula, 
                    pnf.nombre_pnf, 
                    'Becas' AS nombre_serv,
                    bp.fecha_creacion
                FROM 
                    beneficiario b
                LEFT JOIN pnf ON b.id_pnf = pnf.id_pnf
                LEFT JOIN solicitud_de_servicio ss ON ss.id_beneficiario = b.id_beneficiario
                LEFT JOIN becas bp ON ss.id_solicitud_serv = bp.id_solicitud_serv
                WHERE bp.fecha_creacion IS NOT NULL";

            if ($startDate && $endDate) {
                $query .= " AND bp.fecha_creacion BETWEEN :startDate AND :endDate";
            }

            $query .= " UNION ALL 

            SELECT 
                b.nombres, 
                b.apellidos, 
                b.cedula, 
                pnf.nombre_pnf, 
                'Exoneración' AS nombre_serv,
                ep.fecha_creacion
            FROM 
                beneficiario b
            LEFT JOIN pnf ON b.id_pnf = pnf.id_pnf
            LEFT JOIN solicitud_de_servicio ss ON ss.id_beneficiario = b.id_beneficiario
            LEFT JOIN exoneracion ep ON ss.id_solicitud_serv = ep.id_solicitud_serv
            WHERE ep.fecha_creacion IS NOT NULL";

            if ($startDate && $endDate) {
                $query .= " AND ep.fecha_creacion BETWEEN :startDate AND :endDate";
            }

            $query .= " UNION ALL

            SELECT 
                b.nombres, 
                b.apellidos, 
                b.cedula, 
                pnf.nombre_pnf, 
                'FAMES' AS nombre_serv,
                fp.fecha_creacion
            FROM 
                beneficiario b
            LEFT JOIN pnf ON b.id_pnf = pnf.id_pnf
            LEFT JOIN solicitud_de_servicio ss ON ss.id_beneficiario = b.id_beneficiario
            LEFT JOIN fames fp ON ss.id_solicitud_serv = fp.id_solicitud_serv
            WHERE fp.fecha_creacion IS NOT NULL";

            if ($startDate && $endDate) {
                $query .= " AND fp.fecha_creacion BETWEEN :startDate AND :endDate";
            }

            $query .= " UNION ALL

            SELECT 
                b.nombres, 
                b.apellidos, 
                b.cedula, 
                pnf.nombre_pnf, 
                s.nombre_serv,
                mp.fecha_creacion
            FROM 
                beneficiario b
            LEFT JOIN pnf ON b.id_pnf = pnf.id_pnf
            LEFT JOIN solicitud_de_servicio ss ON ss.id_beneficiario = b.id_beneficiario
            LEFT JOIN servicio s ON ss.id_servicios = s.id_servicios
            LEFT JOIN consulta_medica mp ON ss.id_solicitud_serv = mp.id_solicitud_serv
            WHERE mp.fecha_creacion IS NOT NULL";

            if ($startDate && $endDate) {
                $query .= " AND mp.fecha_creacion BETWEEN :startDate AND :endDate";
            }

            $query .= " UNION ALL

            SELECT 
                b.nombres, 
                b.apellidos, 
                b.cedula, 
                pnf.nombre_pnf, 
                s.nombre_serv,
                op.fecha_creacion
            FROM 
                beneficiario b
            LEFT JOIN pnf ON b.id_pnf = pnf.id_pnf
            LEFT JOIN solicitud_de_servicio ss ON ss.id_beneficiario = b.id_beneficiario
            LEFT JOIN servicio s ON ss.id_servicios = s.id_servicios
            LEFT JOIN orientacion op ON ss.id_solicitud_serv = op.id_solicitud_serv
            WHERE op.fecha_creacion IS NOT NULL";

            if ($startDate && $endDate) {
                $query .= " AND op.fecha_creacion BETWEEN :startDate AND :endDate";
            }

            $query .= " UNION ALL

            SELECT 
                b.nombres, 
                b.apellidos, 
                b.cedula, 
                pnf.nombre_pnf, 
                s.nombre_serv,
                dp.fecha_creacion
            FROM 
                beneficiario b
            LEFT JOIN pnf ON b.id_pnf = pnf.id_pnf
            LEFT JOIN solicitud_de_servicio ss ON ss.id_beneficiario = b.id_beneficiario
            LEFT JOIN servicio s ON ss.id_servicios = s.id_servicios
            LEFT JOIN discapacidad dp ON ss.id_solicitud_serv = dp.id_solicitud_serv
            WHERE dp.fecha_creacion IS NOT NULL";

            if ($startDate && $endDate) {
                $query .= " AND dp.fecha_creacion BETWEEN :startDate AND :endDate";
            }

            $query .= " UNION ALL

            SELECT 
                b.nombres, 
                b.apellidos, 
                b.cedula, 
                pnf.nombre_pnf, 
                s.nombre_serv,
                cp.fecha_creacion
            FROM 
                beneficiario b
            LEFT JOIN pnf ON b.id_pnf = pnf.id_pnf
            LEFT JOIN solicitud_de_servicio ss ON ss.id_beneficiario = b.id_beneficiario
            LEFT JOIN servicio s ON ss.id_servicios = s.id_servicios
            LEFT JOIN consulta_psicologica cp ON ss.id_solicitud_serv = cp.id_solicitud_serv
            WHERE cp.fecha_creacion IS NOT NULL";

            if ($startDate && $endDate) {
                $query .= " AND cp.fecha_creacion BETWEEN :startDate AND :endDate";
            }



            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":startDate", $startDate);
            $stmt->bindParam(":endDate", $endDate);


            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
            return false;
        }
    }

    public function getReportDataPs($startDate, $endDate)
    {
        $query = "SELECT p.*, b.id_beneficiario, b.nombres, b.apellidos, b.cedula, pnf.nombre_pnf
         FROM consulta_psicologica p
         LEFT JOIN solicitud_de_servicio ss ON p.id_solicitud_serv = ss.id_solicitud_serv
         LEFT JOIN beneficiario b ON ss.id_beneficiario = b.id_beneficiario
         LEFT JOIN pnf ON b.id_pnf = pnf.id_pnf";

        if ($startDate && $endDate) {
            $query .= " WHERE p.fecha_creacion 
         BETWEEN :startDate AND :endDate";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":startDate", $startDate);
        $stmt->bindParam(":endDate", $endDate);


        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReportDataPsCit($startDate, $endDate)
    {
        $query = "SELECT ct.*, b.id_beneficiario, b.nombres, b.apellidos, b.cedula, pnf.nombre_pnf
         FROM cita ct
         LEFT JOIN empleado e ON ct.id_empleado = e.id_empleado
         LEFT JOIN beneficiario b ON ct.id_beneficiario = b.id_beneficiario
         LEFT JOIN pnf ON b.id_pnf = pnf.id_pnf";

        if ($startDate && $endDate) {
            $query .= " WHERE ct.fecha_creacion 
         BETWEEN :startDate AND :endDate";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":startDate", $startDate);
        $stmt->bindParam(":endDate", $endDate);


        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarBeneficiariosMed()
    {
        $query = "SELECT DISTINCT beneficiario.id_beneficiario,
        beneficiario.nombres,
        beneficiario.apellidos,
        beneficiario.tipo_cedula,
        beneficiario.cedula,
        beneficiario.fecha_nac,
        beneficiario.telefono,
        beneficiario.correo,
        beneficiario.genero,
        beneficiario.direccion,
        beneficiario.estatus,
        pnf.nombre_pnf AS nombre_pnf
        FROM beneficiario
        JOIN pnf ON beneficiario.id_pnf = pnf.id_pnf
        JOIN solicitud_de_servicio ss ON beneficiario.id_beneficiario = ss.id_beneficiario
        JOIN consulta_medica cm ON ss.id_solicitud_serv = cm.id_solicitud_serv
        WHERE 
            beneficiario.estatus = 1
        ORDER BY beneficiario.id_beneficiario ASC";

        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReportDataMed($startDate, $endDate)
    {
        $query = "SELECT cm.*, b.id_beneficiario, b.nombres, b.apellidos, b.cedula, pnf.nombre_pnf
         FROM consulta_medica cm
         LEFT JOIN solicitud_de_servicio ss ON cm.id_solicitud_serv = ss.id_solicitud_serv
         LEFT JOIN beneficiario b ON ss.id_beneficiario = b.id_beneficiario
         LEFT JOIN pnf ON b.id_pnf = pnf.id_pnf";

        if ($startDate && $endDate) {
            $query .= " WHERE cm.fecha_creacion 
         BETWEEN :startDate AND :endDate";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":startDate", $startDate);
        $stmt->bindParam(":endDate", $endDate);


        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarBeneficiariosOr()
    {
        $query = "SELECT DISTINCT beneficiario.id_beneficiario,
        beneficiario.nombres,
        beneficiario.apellidos,
        beneficiario.tipo_cedula,
        beneficiario.cedula,
        beneficiario.fecha_nac,
        beneficiario.telefono,
        beneficiario.correo,
        beneficiario.genero,
        beneficiario.direccion,
        beneficiario.estatus,
        pnf.nombre_pnf AS nombre_pnf
        FROM beneficiario
        JOIN pnf ON beneficiario.id_pnf = pnf.id_pnf
        JOIN solicitud_de_servicio ss ON beneficiario.id_beneficiario = ss.id_beneficiario
        JOIN orientacion o ON ss.id_solicitud_serv = o.id_solicitud_serv
        WHERE 
            beneficiario.estatus = 1
        ORDER BY beneficiario.id_beneficiario ASC";

        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReportDataOr($startDate, $endDate)
    {
        $query = "SELECT o.*, b.id_beneficiario, b.nombres, b.apellidos, b.cedula, pnf.nombre_pnf
         FROM orientacion o
         LEFT JOIN solicitud_de_servicio ss ON o.id_solicitud_serv = ss.id_solicitud_serv
         LEFT JOIN beneficiario b ON ss.id_beneficiario = b.id_beneficiario
         LEFT JOIN pnf ON b.id_pnf = pnf.id_pnf";

        if ($startDate && $endDate) {
            $query .= " WHERE o.fecha_creacion 
         BETWEEN :startDate AND :endDate";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":startDate", $startDate);
        $stmt->bindParam(":endDate", $endDate);


        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReportDataBecas($startDate, $endDate)
    {
        $query = "SELECT bc.*, b.id_beneficiario, b.nombres, b.apellidos, b.cedula, pnf.nombre_pnf
         FROM becas bc
         LEFT JOIN solicitud_de_servicio ss ON bc.id_solicitud_serv = ss.id_solicitud_serv
         LEFT JOIN beneficiario b ON ss.id_beneficiario = b.id_beneficiario
         LEFT JOIN pnf ON b.id_pnf = pnf.id_pnf";

        if ($startDate && $endDate) {
            $query .= " WHERE bc.fecha_creacion 
         BETWEEN :startDate AND :endDate";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":startDate", $startDate);
        $stmt->bindParam(":endDate", $endDate);


        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReportDataEx($startDate, $endDate)
    {
        $query = "SELECT ex.*, b.id_beneficiario, b.nombres, b.apellidos, b.cedula, pnf.nombre_pnf
         FROM exoneracion ex
         LEFT JOIN solicitud_de_servicio ss ON ex.id_solicitud_serv = ss.id_solicitud_serv
         LEFT JOIN beneficiario b ON ss.id_beneficiario = b.id_beneficiario
         LEFT JOIN pnf ON b.id_pnf = pnf.id_pnf";

        if ($startDate && $endDate) {
            $query .= " WHERE ex.fecha_creacion 
         BETWEEN :startDate AND :endDate";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":startDate", $startDate);
        $stmt->bindParam(":endDate", $endDate);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReportDataFames($startDate, $endDate)
    {
        $query = "SELECT fm.*, b.id_beneficiario, b.nombres, b.apellidos, b.cedula, pnf.nombre_pnf, p.nombre_patologia
         FROM fames fm
         LEFT JOIN detalle_patologia pt ON fm.id_detalle_patologia = pt.id_detalle_patologia
         LEFT JOIN patologia p ON pt.id_patologia = p.id_patologia
         LEFT JOIN solicitud_de_servicio ss ON fm.id_solicitud_serv = ss.id_solicitud_serv
         LEFT JOIN beneficiario b ON ss.id_beneficiario = b.id_beneficiario
         LEFT JOIN pnf ON b.id_pnf = pnf.id_pnf";

        if ($startDate && $endDate) {
            $query .= " WHERE fm.fecha_creacion 
         BETWEEN :startDate AND :endDate";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":startDate", $startDate);
        $stmt->bindParam(":endDate", $endDate);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarBeneficiariosDisc()
    {
        $query = "SELECT DISTINCT beneficiario.id_beneficiario,
        beneficiario.nombres,
        beneficiario.apellidos,
        beneficiario.tipo_cedula,
        beneficiario.cedula,
        beneficiario.fecha_nac,
        beneficiario.telefono,
        beneficiario.correo,
        beneficiario.genero,
        beneficiario.direccion,
        beneficiario.estatus,
        pnf.nombre_pnf AS nombre_pnf
        FROM beneficiario
        JOIN pnf ON beneficiario.id_pnf = pnf.id_pnf
        JOIN solicitud_de_servicio ss ON beneficiario.id_beneficiario = ss.id_beneficiario
        JOIN discapacidad d ON ss.id_solicitud_serv = d.id_solicitud_serv
        WHERE 
            beneficiario.estatus = 1
        ORDER BY beneficiario.id_beneficiario ASC";

        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReportDataD($startDate, $endDate)
    {
        $query = "SELECT d.*, b.id_beneficiario, b.nombres, b.apellidos, b.cedula, pnf.nombre_pnf
         FROM discapacidad d
         LEFT JOIN solicitud_de_servicio ss ON d.id_solicitud_serv = ss.id_solicitud_serv
         LEFT JOIN beneficiario b ON ss.id_beneficiario = b.id_beneficiario
         LEFT JOIN pnf ON b.id_pnf = pnf.id_pnf";

        if ($startDate && $endDate) {
            $query .= " WHERE d.fecha_creacion 
         BETWEEN :startDate AND :endDate";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":startDate", $startDate);
        $stmt->bindParam(":endDate", $endDate);


        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}