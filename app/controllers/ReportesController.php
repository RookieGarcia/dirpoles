<?php
require_once 'app/models/reportemodel.php';

function general()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Secretaria') {

        require_once 'app/views/reportes_general.php';
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function generateReportGeneral()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Secretaria') {

        $modelo = new ReporteModel();
        $strDate = $_POST['fecha_inicio'];
        $endDate = $_POST['fecha_fin'];

        $data = $modelo->getReportDataGeneral($strDate, $endDate);

        echo json_encode($data);
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function vistaPsicologia()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Secretaria'  || $_SESSION['tipo_empleado'] === 'Psicologo') {

        $tipo_reporte = isset($_GET['tipo_reporte']) ? $_GET['tipo_reporte'] : null;

        $modelo = new ReporteModel();

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

            if (!$tipo_reporte) {
                require_once 'app/views/reportes_psicologia.php';
            } else {
                if ($tipo_reporte === 'citas') {
                    $beneficiarios = $modelo->listarBeneficiariosPsicologiaCitas();
                } elseif ($tipo_reporte === 'morbilidad') {
                    $beneficiarios = $modelo->listarBeneficiariosPsicologiaMorb();
                } else {
                    $beneficiarios = [];
                }

                echo json_encode($beneficiarios);
            }
        }
    } else {
        header('location:index.php?action=login');
        exit();
    }
}


function generateReportPs()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Secretaria'  || $_SESSION['tipo_empleado'] === 'Psicologo') {

        $modelo = new ReporteModel();

        $startDate = $_POST['fecha_inicio'];
        $endDate = $_POST['fecha_fin'];
        $tipoReporte = $_POST['tipo_reporte'] ?? '';

        if ($tipoReporte === 'morbilidad') {
            $data = $modelo->getReportDataPs($startDate, $endDate);
        } else if ($tipoReporte === 'citas') {
            $data = $modelo->getReportDataPsCit($startDate, $endDate);
        }

        echo json_encode($data);
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function medicina()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Secretaria'  || $_SESSION['tipo_empleado'] === 'Medico') {

        $modelo = new ReporteModel();

        $beneficiarios = $modelo->listarBeneficiariosMed();
        require_once 'app/views/reportes_medicina.php';
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function generateReportMed()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Secretaria'  || $_SESSION['tipo_empleado'] === 'Medico') {

        $modelo = new ReporteModel();

        $startDate = $_POST['fecha_inicio'];
        $endDate = $_POST['fecha_fin'];

        $data = $modelo->getReportDataMed($startDate, $endDate);

        echo json_encode($data);
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function orientacion()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Secretaria'  || $_SESSION['tipo_empleado'] === 'Orientador') {

        $modelo = new ReporteModel();

        $beneficiarios = $modelo->listarBeneficiariosOr();
        require_once 'app/views/reportes_orientacion.php';
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function generateReportOr()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Secretaria'  || $_SESSION['tipo_empleado'] === 'Orientador') {

        $modelo = new ReporteModel();

        $startDate = $_POST['fecha_inicio'];
        $endDate = $_POST['fecha_fin'];

        $data = $modelo->getReportDataOr($startDate, $endDate);

        echo json_encode($data);
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function trabajo_social()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Secretaria'  || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $servicio = isset($_GET['servicio']) ? $_GET['servicio'] : null;
        $tipo_reporte = isset($_GET['tipo_reporte']) ? $_GET['tipo_reporte'] : null;

        $modelo = new ReporteModel();

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

            if (!$servicio && !$tipo_reporte) {
                require_once 'app/views/reportes_trabajo_social.php';
            } else {
                if ($servicio === 'becas') {
                    $beneficiarios = $modelo->listarBeneficiariosBecas();
                } elseif ($servicio === 'exoneracion') {
                    $beneficiarios = $modelo->listarBeneficiariosEx();
                } elseif ($servicio === 'fames') {
                    $beneficiarios = $modelo->listarBeneficiariosFames();
                } else {
                    $beneficiarios = [];
                }

                echo json_encode($beneficiarios);
            }
        }
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function generateReportTs()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Secretaria'  || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $modelo = new ReporteModel();

        $startDate = $_POST['fecha_inicio'];
        $endDate = $_POST['fecha_fin'];
        $servicio = $_POST['servicio'];

        if ($servicio === 'becas') {
            $data = $modelo->getReportDataBecas($startDate, $endDate);
        } elseif ($servicio === 'exoneracion') {
            $data = $modelo->getReportDataEx($startDate, $endDate);
        } elseif ($servicio === 'fames') {
            $data = $modelo->getReportDataFames($startDate, $endDate);
        }

        echo json_encode($data);
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function discapacidad()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Secretaria'  || $_SESSION['tipo_empleado'] === 'Discapacidad') {

        $modelo = new ReporteModel();

        $beneficiarios = $modelo->listarBeneficiariosDisc();
        require_once 'app/views/reportes_discapacidad.php';
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function generateReportD()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Secretaria'  || $_SESSION['tipo_empleado'] === 'Discapacidad') {

        $modelo = new ReporteModel();

        $startDate = $_POST['fecha_inicio'];
        $endDate = $_POST['fecha_fin'];

        $data = $modelo->getReportDataD($startDate, $endDate);

        echo json_encode($data);
    } else {
        header('location:index.php?action=login');
        exit();
    }
}
