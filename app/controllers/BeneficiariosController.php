<?php
require_once "app/models/BeneficiarioModel.php";



function crear_beneficiario(){

    if ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Psicologo' || $_SESSION['tipo_empleado'] == 'Medico' || $_SESSION['tipo_empleado'] == 'Trabajador Social' || $_SESSION['tipo_empleado'] == 'Orientador' || $_SESSION['tipo_empleado'] == 'Discapacidad') {

        $modelo = new BeneficiarioModel();

        $pnfs = $modelo->obtenerPNF();
        $data['pnfs'] = $pnfs;
        include 'app/views/beneficiarios_crear.php';
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: index.php?action=login');
        exit();
    }
}

function validarCedula() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tipo_cedula = $_POST['tipo_cedula'];
        $cedula = $_POST['cedula'];
        $id_empleado = $_POST['id_empleado'] ?? null; // Solo aplica para empleados
        $id_beneficiario = $_POST['id_beneficiario'] ?? null; // Solo aplica para beneficiarios

        $modelo = new BeneficiarioModel();
        $existe = $modelo->beneficiarioCedula(
            $tipo_cedula, 
            $cedula,
            $id_empleado,
            $id_beneficiario
        );
        
        echo json_encode(['existe' => $existe]);
        exit();
    }
}

function validar_telefono() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $prefijo = $_POST['prefijo'];
        $numero = $_POST['numero'];
        $telefono_completo = $prefijo . $numero;

        $modelo = new BeneficiarioModel();
        $existe = $modelo->validarTelefonoUnico($telefono_completo);
        
        echo json_encode(['existe' => $existe]);
        exit();
    }
}

function beneficiario_registrar(){

    if ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Psicologo' || $_SESSION['tipo_empleado'] == 'Medico' || $_SESSION['tipo_empleado'] == 'Trabajador Social' || $_SESSION['tipo_empleado'] == 'Orientador' || $_SESSION['tipo_empleado'] == 'Discapacidad') {

        $modelo = new BeneficiarioModel();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_pnf = $_POST['id_pnf'];
            $nombres = $_POST['nombres'];
            $apellidos = $_POST['apellidos'];
            $tipo_cedula = $_POST['tipo_cedula'];
            $cedula = $_POST['cedula'];
            $fecha_nac = $_POST['fecha_nac'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $genero = $_POST['genero'];
            $direccion = $_POST['direccion'];
            $estatus = $_POST['estatus'];

            $existeCedula = $modelo->existeCedula($cedula);

            if ($existeCedula) {
                $_SESSION['mensaje'] = "La cédula ya existe en el sistema.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: index.php?action=beneficiarios_crear');
                exit();
            }

            $registroExitoso = $modelo->beneficiario_registrar($id_pnf, $nombres, $apellidos, $tipo_cedula, $cedula, $fecha_nac, $telefono, $correo, $genero, $direccion, $estatus);

            if ($registroExitoso) {

                $_SESSION['mensaje'] = "Beneficiario registrado con éxito";
                $_SESSION['tipo_mensaje'] = 'exito';
            } else {

                $_SESSION['mensaje'] = "Error al registrar beneficiario";
                $_SESSION['tipo_mensaje'] = 'error';
            }


            header('Location: index.php?action=beneficiarios_crear');
            exit();
        }
    }else{
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: index.php?action=login');
        exit();
    }
}


function consulta_beneficiario()
{

    if ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Psicologo' || $_SESSION['tipo_empleado'] == 'Medico' || $_SESSION['tipo_empleado'] == 'Trabajador Social' || $_SESSION['tipo_empleado'] == 'Orientador' || $_SESSION['tipo_empleado'] == 'Discapacidad') {

        $modelo = new BeneficiarioModel();
            $beneficiarios = $modelo->listarBeneficiarios();
            include 'app/views/beneficiarios_consulta.php';
        } else {
            $_SESSION['mensaje'] = "No tienes permisos de Administrador para realizar esta acción.";
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?action=inicio');
            exit();
        }
}

function editar_beneficiario()
{

    if ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Psicologo' || $_SESSION['tipo_empleado'] == 'Medico' || $_SESSION['tipo_empleado'] == 'Trabajador Social' || $_SESSION['tipo_empleado'] == 'Orientador' || $_SESSION['tipo_empleado'] == 'Discapacidad') {

        $modelo = new BeneficiarioModel();

        $id_beneficiario = isset($_GET['id_beneficiario']) ? $_GET['id_beneficiario'] : null;
        if (!$id_beneficiario) {
            $_SESSION['mensaje'] = "No se encontró el ID del beneficiario a editar";
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?action=beneficiarios_consulta');
            exit();
        }

        $beneficiarios = $modelo->beneficiario_ID($id_beneficiario);
        $pnfs = $modelo->obtenerPNF();

        $telefono_prefijo = substr($beneficiarios['telefono'], 0, 4); // Primeros 4 dígitos
        $telefono_numero = substr($beneficiarios['telefono'], 4); // Resto de dígitos

        if (!$beneficiarios) {
            $_SESSION['mensaje'] = "No se encontró el beneficiario a editar";
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?action=beneficiarios_consulta');
            exit();
        }

        require 'app/views/beneficiarios_editar.php';
    }else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: index.php?action=login');
        exit();
    }
}

function beneficiario_actualizar()
{

    if ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Psicologo' || $_SESSION['tipo_empleado'] == 'Medico' || $_SESSION['tipo_empleado'] == 'Trabajador Social' || $_SESSION['tipo_empleado'] == 'Orientador' || $_SESSION['tipo_empleado'] == 'Discapacidad') {

        $modelo = new BeneficiarioModel();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_beneficiario = $_POST['id_beneficiario'];
            $id_pnf = $_POST['id_pnf'];
            $nombres = $_POST['nombres'];
            $apellidos = $_POST['apellidos'];
            $tipo_cedula = $_POST['tipo_cedula'];
            $cedula = $_POST['cedula'];
            $fecha_nac = $_POST['fecha_nac'];
            $telefono_prefijo = $_POST['telefono_prefijo']; // Nuevo campo
            $telefono_numero = $_POST['telefono_numero']; // Nuevo campo
            $telefono = $telefono_prefijo . $telefono_numero; // Combinar ambos
            $correo = $_POST['correo'];
            $genero = $_POST['genero'];
            $direccion = $_POST['direccion'];
            
            $beneficiarioActual = $modelo->beneficiario_ID($id_beneficiario);
            $estatus_actual = $beneficiarioActual['estatus'];
            if ($_SESSION['tipo_empleado'] == 'Administrador') {
                $estatus = $_POST['estatus'];
            } else {
                $estatus = $estatus_actual;
            }

            $datos = $modelo->beneficiario_actualizar($id_beneficiario, $id_pnf, $nombres, $apellidos, $tipo_cedula, $cedula, $fecha_nac, $telefono, $correo, $genero, $direccion, $estatus);

            if ($datos) {
                $_SESSION['mensaje'] = "Beneficiario actualizado con éxito";
                $_SESSION['tipo_mensaje'] = 'exito';
            } else {
                $_SESSION['mensaje'] = "Hubo un error al actualizar el Beneficiario";
                $_SESSION['tipo_mensaje'] = 'error';
            }
        }
        header('Location: index.php?action=beneficiarios_consulta');
        exit();
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: index.php?action=login');
        exit();
    }
}

function beneficiario_eliminar($id_beneficiario)
{

    if ($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Psicologo' || $_SESSION['tipo_empleado'] == 'Medico' || $_SESSION['tipo_empleado'] == 'Trabajador Social' || $_SESSION['tipo_empleado'] == 'Orientador' || $_SESSION['tipo_empleado'] == 'Discapacidad') {

        $modelo = new BeneficiarioModel();

        $tieneCitas = $modelo->validar_beneficiario_cita($id_beneficiario);
        $tieneSolicitudes = $modelo->validar_beneficiario_solicitud($id_beneficiario);

        if($tieneCitas){
            $_SESSION['mensaje'] = "El beneficiario tiene alguna cita asociada. No se puede eliminar.";
            $_SESSION['tipo_mensaje'] = 'error';
        }elseif($tieneSolicitudes){
            $_SESSION['mensaje'] = "El beneficiario tiene alguna solicitud de servicio asociada. No se puede eliminar.";
            $_SESSION['tipo_mensaje'] = 'error';
        }else{
            $resultado = $modelo->beneficiario_eliminar($id_beneficiario);
            if ($resultado) {
                $_SESSION['mensaje'] = "Beneficiario eliminado exitosamente";
                $_SESSION['tipo_mensaje'] = 'exito';
            } else {
                $_SESSION['mensaje'] = "Hubo un error al eliminar el beneficiario";
                $_SESSION['tipo_mensaje'] = 'error';
            }
        }
        header('Location: index.php?action=beneficiarios_consulta');
        exit();
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: index.php?action=login');
        exit();
    }
}
