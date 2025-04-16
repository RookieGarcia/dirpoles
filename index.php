<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// CONTROLLERS
require_once 'app/controllers/AuthController.php';
require_once 'app/controllers/InicioController.php';
require_once 'app/controllers/EmpleadosController.php';
require_once 'app/controllers/BeneficiariosController.php';
require_once 'app/controllers/CitasController.php';
require_once 'app/controllers/ConfigController.php';
require_once 'app/controllers/InventarioController.php';
require_once 'app/controllers/MedicinaController.php';
require_once 'app/controllers/PsicologiaController.php';
require_once 'app/controllers/tsController.php';
require_once 'app/controllers/OrientacionController.php';
require_once 'app/controllers/DiscapacidadController.php';
require_once 'app/controllers/ReportesController.php';
require_once 'app/controllers/BitacoraController.php';
require_once 'app/controllers/ReferenciasController.php';
require_once 'app/controllers/InventarioMobiliarioController.php';


$action = $_GET['action'] ?? 'login';

try {
    switch ($action) {
        case 'login':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                login($_POST['username'], $_POST['password']);
            } else {
                showLogin();
            }
            break;

        case 'verificar_username':
            verificar_username();
            break;

        case 'inicio':
            index();
            break;

        case 'empleados_crear':
            crear_empleado();
            break;

        case 'validar_cedula_emp':
            validarCedulaEmp();
            break;

        case 'validar_telefono_emp':
            validar_telefono_emp();
            break;

        case 'empleados_registrar':
            empleados_registrar();
            break;

        case 'empleados_consulta':
            consulta_empleado();
            break;

        case 'empleados_editar':
            editar_empleado();
            break;

        case 'horario_agregar':
            agregar_horario();
            break;

        case 'editar_horario':
            editar_horario();
            break;

        case 'eliminar_horario':
            horario_eliminar($_GET['id_horario']);
            break;

        case 'horario_actualizar':
            horario_actualizar();
            break;

        case 'empleados_actualizar':

            empleados_actualizar();
            break;

        case 'empleado_eliminar':

            empleados_eliminar();
            break;



            //BENEFICIARIOS

        case 'beneficiarios_crear':

            crear_beneficiario();
            break;

        case 'validar_cedula':
            validarCedula();
            break;

        case 'beneficiarios_registrar':
            beneficiario_registrar();
            break;

        case 'beneficiarios_consulta':

            consulta_beneficiario();
            break;

        case 'beneficiarios_editar':

            editar_beneficiario();
            break;

        case 'beneficiario_actualizar':

            beneficiario_actualizar();
            break;

        case 'beneficiarios_eliminar':

            beneficiario_eliminar($_GET['id_beneficiario']);
            break;

        case 'validar_telefono':
            validar_telefono();
            break;

            //CITAS

        case 'citas_crear':

            citas_crear();
            break;

        case 'citas_listar':

            citas_listar();
            break;

        case 'citas_registrar':

            citas_registrar();
            break;

        case 'citas_editar':

            citas_editar();
            break;

        case 'citas_actualizar':

            citas_actualizar();
            break;

        case 'citas_eliminar':

            citas_eliminar();
            break;

        case 'cargar_citas':
            cargar_citas();
            break;

        case 'validar_fecha_cita':
            validar_fecha_cita();
            break;

        case 'validar_disponibilidad_empleado':
            validar_disponibilidad_empleado();
            break;

            //CONFIGURACIÓN

        case 'config_crear':
            config_crear();
            break;

        case 'config_listar':
            config_listar();
            break;

        case 'config_registrar':
            config_registrar();
            break;

        case 'editar_config':
            config_editar();
            break;

        case 'config_actualizar':
            config_actualizar();
            break;

            // case 'config_eliminar':
            //     if (isset($_GET['id']) && isset($_GET['tabla'])) {
            //         $id = $_GET['id'];
            //         $tabla = $_GET['tabla'];
            //         config_eliminar();
            //     }
            //     break;

            //INVENTARIO - INSUMOS

        case 'inventario_crear':
            inventario_crear();
            break;

        case 'inventario_consulta':
            inventario_consulta();
            break;

        case 'inventario_registrar':
            registrar_inventario();
            break;

        case 'inventario_entrada':
            inventario_entrada();
            break;

        case 'inventario_movimientos':
            inventario_movimientos();
            break;

        case 'inventario_editar':
            inventario_editar();
            break;

        case 'inventario_actualizar':
            actualizar_inventario();
            break;

        case 'inventario_eliminar':
            inventario_eliminar();
            break;

        case 'registrar_entrada':
            registrar_entrada();
            break;
            
            
            //DIAGNOSTICOS MEDICINA

        case 'diagnostico_medicina':
            medicina_crear();
            break;

        case 'medicina_crear':
            consulta_registrar_medicina();
            break;

        case 'medicina_consulta':
            medicina_consulta();
            break;

        case 'medicina_visualizar':
            medicina_visualizar();
            break;

        case 'medicina_constancia':
            medicina_constancia();
            break;

        case 'medicina_editar':
            medicina_editar();
            break;

        case 'medicina_actualizar':
            medicina_actualizar();
            break;

        case 'medicina_eliminar':
            medicina_eliminar();
            break;

        case 'medicina_recipe':
            medicina_recipe();
            break;

        case 'medicina_referencia':
            medicina_referencia();
            break;

            //DIAGNOSTICO PSICOLOGIA

            //DIAGNOSTICO PSICOLOGIA

        case 'diagnostico_psicologia':
            diagnostico_psicologia();
            break;

        case 'psicologia_registrar':
            psicologia_crear();
            break;

        case 'psicologia_registrar_2':
            psicologia_2();
            break;

        case 'psicologia_listar':
            psicologia_listar();
            break;

        case 'psicologia_constancia':
            psicologia_constancia();
            break;

        case 'psicologia_editar':
            psicologia_editar();
            break;

        case 'psicologia_actualizar':
            psicologia_actualizar();
            break;

        case 'psicologia_actualizar_2':
            psicologia_actualizar_2();
            break;

        case 'psicologia_eliminar':
            psicologia_eliminar();
            break;

        case 'psicologia_visualizar':
            psicologia_visualizar();
            break;

        case 'psicologia_referencia':
            psicologia_referencia();
            break;

            //DIAGNOSTICO DE DISCAPACIDAD

        case 'diagnostico_discapacidad':
            diagnostico_discapacidad();
            break;

        case 'discapacidad_registrar':
            discapacidad_crear();
            break;

        case 'discapacidad_listar':
            listar_discapacidad();
            break;

        case 'discapacidad_editar':
            discapacidad_editar();
            break;

        case 'discapacidad_constancia':
            discapacidad_constancia();
            break;

        case 'discapacidad_referencia':
            discapacidad_referencia();
            break;

        case 'discapacidad_actualizar':
            discapacidad_actualizar();
            break;

        case 'discapacidad_eliminar':
            discapacidad_eliminar();
            break;


            // DIAGNOSTICOS ORIENTACION
        case 'diagnostico_orientacion':
            orientacion_crear();
            break;

        case 'orientacion_crear':
            consulta_registrar();
            break;

        case 'orientacion_consulta':
            consulta_consulta();
            break;

        case 'orientacion_visualizar':
            orientacion_visualizar();
            break;

        case 'orientacion_constancia':
            orientacion_constancia();
            break;

        case 'orientacion_editar':
            orientacion_editar();
            break;

        case 'orientacion_actualizar':
            orientacion_actualizar();
            break;

        case 'orientacion_eliminar':
            orientacion_eliminar();
            break;

        case 'orientacion_referencia':
            orientacion_referencia();
            break;


            //------------------------------------------ DIAGNOSTICOS

            // TRABAJO SOCIAL
            // GENERAL
        case 'vista_trabajo_social':
            mostrarVistaTs();

            break;

        case 'consulta_trabajo_social':
            mostrarConsultaTs();
            break;

            //----------------------------------------------------- BECAS
        case 'crear_beca':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                crearB();
            } else {
                require_once('app/views/diagnostico_trabajo_social.php');
            }
            break;

        case 'consultar_beca':
            consultarBeca();
            break;

        case 'mostrar_imagen_beca':
            mostrarImagenBeca();
            break;

        case 'beca_constancia':
            beca_constancia();
            break;

        case 'beca_referencia':
            beca_referencia();
            break;

        case 'editar_beca':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                editarBeca();
            } else {
                mostrarFormularioEditar();
            }
            break;

        case 'eliminar_beca':
            eliminarBeca();
            break;

            //-------------------------------------------------------- EXONERACION

        case 'crear_exoneracion':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                crearEx();
            } else {
                include_once('app/views/diagnostico_trabajo_social.php');
            }
            break;

        case 'consultar_exoneracion':

            consultarEx();
            break;

        case 'ex_constancia':
            ex_constancia();
            break;

        case 'ex_referencia':
            ex_referencia();
            break;

        case 'editar_ex':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                editarEx();
            } else {
                mostrarFormularioEditarEx();
            }
            break;

        case 'eliminar_ex':
            eliminarEx();
            break;

            //------------------------------------------------------ FAMES

        case 'crear_fames':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                crearFames();
            } else {
                obtenerPatologiasFames();
            }
            break;

        case 'consultar_fames':
            consultarFames();
            break;

        case 'fames_constancia':
            fames_constancia();
            break;

        case 'fames_referencia':
            fames_referencia();
            break;

        case 'editar_fames':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                editarFames();
            } else {
                mostrarFormularioEditarFames();
            }
            break;

        case 'eliminar_fames':
            eliminarFames();
            break;

 //--------------------------------------- mobiliario
 // INVENTARIO MOBILIARIO Y EQUIPOS
case 'inventario_mobiliario_index':
    inventario_mobiliario_index();
    break;

case 'inventario_mobiliario_registrar':
    inventario_mobiliario_registrar();
    break;

case 'inventario_mobiliario_guardar':
    inventario_mobiliario_guardar();
    break;

case 'inventario_mobiliario_ficha':
    inventario_mobiliario_ficha();
    break;

case 'inventario_mobiliario_guardar_ficha':
    inventario_mobiliario_guardar_ficha();
    break;

case 'inventario_mobiliario_ver_ficha':
    inventario_mobiliario_ver_ficha();
    break;

case 'inventario_mobiliario_historial':
    inventario_mobiliario_historial();
    break;

case 'inventario_mobiliario_imprimir_ficha':
    inventario_mobiliario_imprimir_ficha();
    break;
    

            //--------------------------------------- REPORTES

        case 'reportes_general':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                generateReportGeneral();
            } else {
                general();
            }
            break;

        case 'reportes_trabajo_social':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                generateReportTs();
            } else {
                trabajo_social();
            }
            break;

        case 'reportes_psicologia':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                generateReportPs();
            } else {
                vistaPsicologia();
            }
            break;

        case 'reportes_medicina':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                generateReportMed();
            } else {
                medicina();
            }
            break;

        case 'reportes_orientacion':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                generateReportOr();
            } else {
                orientacion();
            }
            break;

        case 'reportes_discapacidad':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                generateReportD();
            } else {
                discapacidad();
            }
            break;

        //BITACORA

        case 'bitacora_listar':
            bitacora_listar();
            break;

        //REFERENCIAS

        case 'referencias_crear':
            referencias_crear();
            break;

        case 'logout':
            logout();
            break;

        default:
            header('Location: index.php?action=login');
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
