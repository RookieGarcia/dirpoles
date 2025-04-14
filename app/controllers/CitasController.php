<?php
require_once "app/models/CitaModel.php";

function citas_crear() {
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Psicologo') {
        $modelo = new Cita();

        // Obtener la información de beneficiarios, psicólogos y horarios
        $beneficiarios = $modelo->listarBeneficiarios(); // Los beneficiarios son visibles para ambos roles
        $psicologos = $modelo->listar_Psicologos(); // Listar psicólogos es independiente del tipo de empleado
        
        // Filtrar horarios según el tipo de empleado
        if ($_SESSION['tipo_empleado'] === 'Administrador') {
            $horarios = $modelo->obtenerHorarios(); // Administrador ve todos los horarios
        } elseif ($_SESSION['tipo_empleado'] === 'Psicologo') {
            $id_empleado = $_SESSION['id_empleado']; // ID del psicólogo desde la sesión
            $horarios = $modelo->obtenerHorarios($id_empleado); // Psicólogo ve solo sus horarios
        }

        // Incluir la vista para la creación de citas
        include 'app/views/citas_crear.php';

    } else {
        // Mensaje de error si el usuario no tiene los permisos adecuados
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción.";
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

// Validar fecha pasada
function validar_fecha_cita() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fecha = $_POST['fecha'];
        $response = ['valido' => ($fecha >= date('Y-m-d'))];
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
}

// Validar disponibilidad del empleado
function validar_disponibilidad_empleado() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $modelo = new Cita();
        $id_empleado = $_POST['id_empleado'];
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];
        
        // Llama a citaExistente() UNA VEZ y obtén ambos valores
        $citaExistenteResult = $modelo->citaExistente($id_empleado, $fecha, $hora);
        
        $response = [
            'horario_valido' => $modelo->validarHorario($id_empleado, $fecha, $hora),
            'existe_misma_hora' => $citaExistenteResult['existe_misma_hora'],
            'existe_intervalo' => $citaExistenteResult['existe_intervalo']
        ];
        
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
}


function citas_registrar()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Psicologo') {
        $modelo = new Cita();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];
            $id_beneficiario = $_POST['id_beneficiario'];
            $id_empleado = $_POST['id_empleado'];
            $estatus = $_POST['estatus'];

            $resultado = $modelo->cita_crear($fecha, $hora, $id_beneficiario, $id_empleado, $estatus);

            if ($resultado) {
                $_SESSION['mensaje'] = "Cita creada exitosamente.";
                $_SESSION['tipo_mensaje'] = 'exito';
                echo "<script>toastr.success('Cita creada exitosamente.');</script>";
            } else {
                $_SESSION['mensaje'] = "Error al crear cita.";
                $_SESSION['tipo_mensaje'] = 'error';
                echo "<script>toastr.error('Error al crear cita.');</script>";
            }

            header('Location: index.php?action=citas_crear');
            exit();
        }
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function cargar_citas() {
    $modelo = new Cita();
    $citas = $modelo->citas_para_calendario();

    $eventos = [];
    foreach ($citas as $row) {
        $eventos[] = [
            'id' => $row['id_cita'],
            'title' => 'Cita: ' . $row['nombre_beneficiario'] . ' ' . $row['apellido_beneficiario'] .
                       ' con ' . $row['nombre_empleado'] . ' ' . $row['apellido_empleado'],
            'start' => $row['fecha'] . 'T' . $row['hora'],
            'color' => '#007bff',
            'textColor' => '#ffffff',
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($eventos);
    exit;
}




function citas_listar()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Psicologo') {

        $modelo = new Cita();
        $citas = $modelo->citas_listar($_SESSION['id_empleado'], $_SESSION['tipo_empleado']);
        include 'app/views/citas_listar.php';

    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function citas_editar()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Psicologo') {

        $modelo = new Cita();

        $id_cita = isset($_GET['id_cita']) ? $_GET['id_cita'] : null;
        if (!$id_cita) {
            $_SESSION['mensaje'] = "No se encontró la cita a editar";
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?action=citas_listar');
            exit();
        }

        $cita_id = $modelo->citasID($id_cita);
        $beneficiarios = $modelo->listarBeneficiarios();
        require 'app/views/citas_editar.php';
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function citas_actualizar()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Psicologo') {

        $modelo = new Cita();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_cita = $_POST['id_cita'];
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];
            $estatus = $_POST['estatus'];

            $resultado = $modelo->citas_actualizar($id_cita, $fecha, $hora, $estatus);

            if ($resultado) {
                $_SESSION['mensaje'] = "Cita actualizada exitosamente";
                $_SESSION['tipo_mensaje'] = 'exito';
            } else {
                $_SESSION['mensaje'] = "Error al actualizar cita";
                $_SESSION['tipo_mensaje'] = 'error';
            }
        }
        header('Location: index.php?action=citas_listar');
        exit();
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function citas_eliminar()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Psicologo') {

        $modelo = new Cita();

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $id_cita = $_GET['id_cita'];
            $resultado = $modelo->citas_eliminar($id_cita);
            if ($resultado) {
                $_SESSION['mensaje'] = "Cita eliminada exitosamente";
                $_SESSION['tipo_mensaje'] = 'exito';
            } else {
                $_SESSION['mensaje'] = "Error al eliminar cita";
                $_SESSION['tipo_mensaje'] = 'error';
            }
        }
        header('Location: index.php?action=citas_listar');
        exit();
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}
