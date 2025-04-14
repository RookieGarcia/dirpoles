<?php
require_once "app/models/OrientacionModel.php";

function orientacion_crear()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Orientador') {

        $modelo = new Orientacion();

        if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Orientador') {
            $servicios = $modelo->Servicios();
            $beneficiarios = $modelo->listarBeneficiarios();
            require_once "app/views/diagnostico_orientacion.php";
        } else {
            $_SESSION['mensaje'] = "No tienes permisos de Administrador para realizar esta acción.";
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?action=inicio');
            exit();
        }
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function orientacion_constancia()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Orientador') {

        $modelo = new Orientacion();

        if (isset($_GET['id_orientacion'])) {
            $id_orientacion = $_GET['id_orientacion'];

            $datos = $modelo->obtenerDatosConsultaOrientacion($id_orientacion);

           require_once "pdf/constancia/procesar.php";
        }
    }
}

function orientacion_editar()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Orientador') {

        $modelo = new Orientacion();

        if (isset($_GET['id_orientacion'])) {
            $id_orientacion = $_GET['id_orientacion'];

            $datos = $modelo->obtenerDatosConsultaOrientacion($id_orientacion);
            $beneficiarios = $modelo->listarBeneficiarios();

            if ($datos) {
                include 'app/views/diagnostico_orientacion_editar.php';
            } else {
                $_SESSION['mensaje'] = "Error al obtener los detalles de la consulta orientacion.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: index.php?action=orientacion_consulta');
                exit();
            }
        } else {
            $_SESSION['mensaje'] = "ID de consulta orientacion no proporcionado.";
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?action=orientacion_consulta');
            exit();
        }
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function orientacion_visualizar()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Orientador') {

        $modelo = new Orientacion();

        if (isset($_GET['id_orientacion'])) {
            $id_orientacion = $_GET['id_orientacion'];

            $datos = $modelo->obtenerDatosConsultaOrientacion($id_orientacion);
            $beneficiarios = $modelo->listarBeneficiarios();

            if ($datos) {
                include 'app/views/diagnostico_orientacion_ver.php';
            } else {
                $_SESSION['mensaje'] = "Error al obtener los detalles de la consulta orientacion.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: index.php?action=orientacion_consulta');
                exit();
            }
        } else {
            $_SESSION['mensaje'] = "ID de consulta orientacion no proporcionado.";
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?action=orientacion_consulta');
            exit();
        }
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function consulta_consulta()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Orientador') {

        $modelo = new Orientacion();

        $orientacion = $modelo->consulta_orientacion();

        require_once "app/views/diagnostico_orientacion_consulta.php";
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function consulta_registrar()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Orientador') {

        $modelo = new Orientacion();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_beneficiario = $_POST['id_beneficiario'];
            $id_servicios = $_POST['id_servicios'];
            $motivo_orientacion = $_POST['motivo_orientacion'];
            $descripcion_orientacion = $_POST['descripcion_orientacion'];
            $indicaciones_orientacion = $_POST['indicaciones_orientacion'];
            $obs_adic_orientacion = $_POST['obs_adic_orientacion'];

            $resultado = $modelo->orientacion_crear(
                $id_beneficiario,
                $id_servicios,
                $motivo_orientacion,
                $descripcion_orientacion,
                $indicaciones_orientacion,
                $obs_adic_orientacion
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Consulta orientacion registrada con éxito";
                $_SESSION['tipo_mensaje'] = 'exito';
            } else {
                $_SESSION['mensaje'] = "Error al registrar la consulta orientacion";
                $_SESSION['tipo_mensaje'] = 'error';
            }
        }
        header('Location: index.php?action=diagnostico_orientacion');
        exit();
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function orientacion_actualizar()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Orientador') {

        $modelo = new Orientacion();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_orientacion = $_POST['id_orientacion'];
            $id_solicitud_serv = $_POST['id_solicitud_serv'];
            $id_beneficiario = $_POST['id_beneficiario'];
            $motivo_orientacion = $_POST['motivo_orientacion'];
            $descripcion_orientacion = $_POST['descripcion_orientacion'];
            $indicaciones_orientacion = $_POST['indicaciones_orientacion'];
            $obs_adic_orientacion = $_POST['obs_adic_orientacion'];

            $datos = $modelo->orientacion_actualizar($id_orientacion, $id_solicitud_serv, $id_beneficiario, $motivo_orientacion, $indicaciones_orientacion, $descripcion_orientacion, $obs_adic_orientacion);

            if ($datos) {
                $_SESSION['mensaje'] = "Consulta orientacion actualizada con éxito";
                $_SESSION['tipo_mensaje'] = 'exito';
            } else {
                $_SESSION['mensaje'] = "Error al actualizar la consulta orientacion";
                $_SESSION['tipo_mensaje'] = 'error';
            }
        }
        header('Location: index.php?action=orientacion_consulta');
        exit();
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function orientacion_eliminar()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Orientador') {

        $modelo = new Orientacion();

        if (isset($_GET['id_orientacion']) && isset($_GET['id_solicitud_serv'])) {
            $id_orientacion = $_GET['id_orientacion'];
            $id_solicitud_serv = $_GET['id_solicitud_serv'];
            $resultado = $modelo->orientacion_eliminar($id_orientacion, $id_solicitud_serv);

            if ($resultado) {
                $_SESSION['mensaje'] = "Consulta orientacion eliminada con éxito.";
                $_SESSION['tipo_mensaje'] = 'exito';
            } else {
                $_SESSION['mensaje'] = "Error al eliminar la consulta orientacion.";
                $_SESSION['tipo_mensaje'] = 'error';
            }
        } else {
            $_SESSION['mensaje'] = "Parámetros inválidos para la eliminación de la consulta.";
            $_SESSION['tipo_mensaje'] = 'error';
        }
        header('Location: index.php?action=orientacion_consulta');
        exit();
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function orientacion_referencia(){
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Orientador') {
        $modelo = new Orientacion();
        $id_orientacion = $_GET['id_orientacion'];
        $orientacion = $modelo->obtenerDatosConsultaOrientacion($id_orientacion);
        require_once 'PDF/referencia/procesar.php';
    }
}
