<?php
require_once 'app/models/EmpleadoModel.php';

    function crear_empleado() {
        if($_SESSION['tipo_empleado'] === 'Administrador'){
            $modelo = new EmpleadoModel();
            $tipos = $modelo->tipos_empleados();
            include 'app/views/empleados_crear.php'; 
        }else{
            $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
            $_SESSION['tipo_mensaje'] = 'error';
            header ('Location: index.php?action=inicio');
            exit();
        }
    }

    function validarCedulaEmp(){
        $modelo = new EmpleadoModel();
        
        if (isset($_POST['cedula']) && isset($_POST['tipo_cedula'])) {
            $cedula = $_POST['cedula'];
            $tipo_cedula = $_POST['tipo_cedula'];
            $respuesta = $modelo->validarCedula($tipo_cedula, $cedula);
    
            echo json_encode(['existe' => $respuesta]);
        }
    }

    function validar_telefono_emp() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $prefijo = $_POST['prefijo'];
            $numero = $_POST['numero'];
            $telefono_completo = $prefijo . $numero;
    
            $modelo = new EmpleadoModel();
            $existe = $modelo->validarTelefonoUnico($telefono_completo);
            
            echo json_encode(['existe' => $existe]);
            exit();
        }
    }

    function consulta_empleado() {
        if($_SESSION['tipo_empleado'] === 'Administrador'){
            $modelo = new EmpleadoModel();
            $tipos = $modelo->tipos_empleados();
            $empleados = $modelo->empleados_listar();
            include 'app/views/empleados_consulta.php'; 
        }else{
            $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
            $_SESSION['tipo_mensaje'] = 'error';
            header ('Location: index.php?action=inicio');
            exit();
        }
    }

    function editar_empleado(){
        $modelo = new EmpleadoModel();
        $id_empleado = isset($_GET['id_empleado']) ? $_GET['id_empleado'] : null;
        
        if(!$id_empleado){
            $_SESSION['mensaje'] = "No se encontró el empleado a editar.";
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?action=empleados_consulta');
            exit();
        }
    
        $empleado = $modelo->empleados_ID($id_empleado);
    
        // Dividir el teléfono en prefijo y número
        $telefono_prefijo = substr($empleado['telefono'], 0, 4); // Primeros 4 dígitos
        $telefono_numero = substr($empleado['telefono'], 4); // Resto de dígitos
    
        // Pasar estos valores a la vista
        $horarios = $modelo->obtenerHorariosPorEmpleado($id_empleado);
        $tipos = $modelo->tipos_empleados();
        
        require 'app/views/empleados_editar.php';
    }

    function editar_horario(){
        $modelo = new EmpleadoModel();
        // Obtener el id del horario desde la URL
        $id_horario = isset($_GET['id_horario']) ? $_GET['id_horario'] : null;
    
        // Verificar si el id es válido
        if (!$id_horario) {
            $_SESSION['mensaje'] = "No se encontró el horario a editar.";
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?action=empleados_consulta');
            exit();
        }
        $horario = $modelo->HorarioID($id_horario);
        $empleado = $modelo->empleados_ID($_GET['id_empleado']);
    
        if (!$horario) {
            $_SESSION['mensaje'] = "El horario no existe.";
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?action=empleados_consulta');
            exit();
        }
    
        require_once 'app/views/empleados_editar_horario.php';
    }

    function horario_actualizar(){
        $modelo = new EmpleadoModel();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_horario = $_POST['id_horario'];
            $dia_semana = $_POST['dia_semana'];
            $hora_inicio = $_POST['hora_inicio'];
            $hora_fin = $_POST['hora_fin'];
            $id_empleado = $_POST['id_empleado'];

            if (strtotime($hora_inicio) < strtotime('07:00') || strtotime($hora_fin) > strtotime('16:00')) {
                $_SESSION['mensaje'] = "El horario debe estar entre las 7:00 AM y las 4:00 PM.";
                $_SESSION['tipo_mensaje'] = 'error';
                header("Location: index.php?action=empleados_editar&id_empleado=" . $id_empleado);
                exit();
            }

            $dia_existente = $modelo->DiaExistente($id_empleado, $dia_semana, $id_horario); // Nota: Agregar excepción para el horario actual en el modelo
            if ($dia_existente) {
                $_SESSION['mensaje'] = "Ya existe un horario registrado para el día $dia_semana.";
                $_SESSION['tipo_mensaje'] = 'error';
                header("Location: index.php?action=empleados_editar&id_empleado=" . $id_empleado);
                exit();
            }

            $datos = $modelo->horario_editar($id_horario, $dia_semana, $hora_inicio, $hora_fin);

            if ($datos) {
                $_SESSION['mensaje'] = "Horario editado con éxito.";
                $_SESSION['tipo_mensaje'] = 'exito';
            } else {
                $_SESSION['mensaje'] = "Error al editar el horario.";
                $_SESSION['tipo_mensaje'] = 'error';
            }
        }

        header("Location: index.php?action=empleados_editar&id_empleado=" . $id_empleado);
        exit();
    }


    function horario_eliminar($id_horario){
        $modelo = new EmpleadoModel();
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $id_horario = $_GET['id_horario'];
            $id_empleado = $_GET['id_empleado'];

            $datos = $modelo->horario_eliminar($id_horario);

            if($datos){
                $_SESSION['mensaje'] = "Horario eliminado con éxito.";
                $_SESSION['tipo_mensaje'] = 'exito';
            }else{
                $_SESSION['mensaje'] = "Error al eliminar el horario.";
                $_SESSION['tipo_mensaje'] = 'error';
            }
        }
        header("Location: index.php?action=empleados_editar&id_empleado=".$id_empleado);
        exit();
    }
    

    function empleados_registrar() {
        $modelo = new EmpleadoModel();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $tipo_cedula = $_POST['tipo_cedula'];
            $cedula = $_POST['cedula'];
            $correo = $_POST['correo'];
            $telefono = $_POST['telefono'];
            $id_tipo_empleado = $_POST['id_tipo_empleado'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $direccion = $_POST['direccion'];
            $clave = $_POST['clave'];
            $estatus = $_POST['estatus'];
    
            $existeCedula = $modelo->existeCedula($cedula);
            $existeCorreo = $modelo->existeCorreo($correo);
    
            if ($existeCedula) {
                $_SESSION['mensaje'] = "La cédula ya existe en el sistema.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: index.php?action=empleados_crear');
                exit();
            } elseif ($existeCorreo) {
                $_SESSION['mensaje'] = "El correo ya existe en el sistema.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: index.php?action=empleados_crear');
                exit();
            }
    
            if ($id_tipo_empleado == 1 && !empty($_POST['dia_semana']) && is_array($_POST['dia_semana'])) {
                $dias = $_POST['dia_semana'];
                $horariosRepetidos = false;
    
                $diasUnicos = array_unique($dias);
                if (count($dias) !== count($diasUnicos)) {
                    $horariosRepetidos = true;
                }
    
                if ($horariosRepetidos) {
                    $_SESSION['mensaje'] = "Existen días duplicados en los horarios.";
                    $_SESSION['tipo_mensaje'] = 'error';
                    header('Location: index.php?action=empleados_crear');
                    exit();
                }
            }
    
            $id_empleado = $modelo->empleados_registrar(
                $nombre,
                $apellido,
                $tipo_cedula,
                $cedula,
                $correo,
                $telefono,
                $id_tipo_empleado,
                $fecha_nacimiento,
                $direccion,
                $clave,
                $estatus
            );
    
            if ($id_empleado && $id_tipo_empleado == 1) {
                if (!empty($_POST['dia_semana']) && is_array($_POST['dia_semana'])) {
                    $dias = $_POST['dia_semana'];
                    $horasInicio = $_POST['hora_inicio'];
                    $horasFin = $_POST['hora_fin'];
    
                    foreach ($dias as $index => $dia) {
                        $hora_inicio = $horasInicio[$index];
                        $hora_fin = $horasFin[$index];
    
                        if (strtotime($hora_inicio) < strtotime('07:00') || strtotime($hora_fin) > strtotime('16:00')) {
                            $_SESSION['mensaje'] = "El horario debe estar entre las 7:00 AM y las 4:00 PM.";
                            $_SESSION['tipo_mensaje'] = 'error';
                            header('Location: index.php?action=empleados_crear');
                            exit();
                        }
    
                        $modelo->HorarioPsicologo($id_empleado, $dia, $hora_inicio, $hora_fin);
                    }
                }
            }
    
    
            if ($id_empleado) {
                $_SESSION['mensaje'] = "Empleado registrado con éxito.";
                $_SESSION['tipo_mensaje'] = 'exito';
            } else {
                $_SESSION['mensaje'] = "Error al registrar el empleado.";
                $_SESSION['tipo_mensaje'] = 'error';
            }
    
            header('Location: index.php?action=empleados_crear');
            exit();
        }
    }
    

    function agregar_horario() {
        $modelo = new EmpleadoModel();
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_empleado = $_POST['id_empleado'];
            $dia_semana = $_POST['dia_semana'];
            $hora_inicio = $_POST['hora_inicio'];
            $hora_fin = $_POST['hora_fin'];
    
            $dia_existente = $modelo->verificarDiaExistente($id_empleado, $dia_semana);
    
            if ($dia_existente) {
                $_SESSION['mensaje'] = "Ya existe un horario registrado para el día $dia_semana.";
                $_SESSION['tipo_mensaje'] = 'error';
            } else {
                $datos = $modelo->HorarioPsicologo($id_empleado, $dia_semana, $hora_inicio, $hora_fin);
    
                if ($datos) {
                    $_SESSION['mensaje'] = "Horario agregado con éxito.";
                    $_SESSION['tipo_mensaje'] = 'exito';
                } else {
                    $_SESSION['mensaje'] = "Error al agregar horario.";
                    $_SESSION['tipo_mensaje'] = 'error';
                }
            }
        }
    
        header("Location: index.php?action=empleados_editar&id_empleado=" . $id_empleado);
        exit();
    }
    
    

    function empleados_actualizar(){
        $modelo = new EmpleadoModel();
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id_empleado = $_POST['id_empleado'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $tipo_cedula = $_POST['tipo_cedula'];
            $cedula = $_POST['cedula'];
            $correo = $_POST['correo'];
            $telefono_prefijo = $_POST['telefono_prefijo']; // Nuevo campo
            $telefono_numero = $_POST['telefono_numero']; // Nuevo campo
            $telefono = $telefono_prefijo . $telefono_numero; // Combinar ambos
            $id_tipo_empleado = $_POST['id_tipo_empleado'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $direccion = $_POST['direccion'];
            $clave = $_POST['clave'];
            $estatus = $_POST['estatus'];

            $datos = $modelo->empleados_editar($id_empleado, $nombre, $apellido, $tipo_cedula, $cedula, $correo, $telefono, $id_tipo_empleado, $fecha_nacimiento, $direccion, $clave, $estatus);

            if($datos){
                $_SESSION['mensaje'] = "Empleado actualizado con éxito.";
                $_SESSION['tipo_mensaje'] = 'exito';
            }else{
                $_SESSION['mensaje'] = "Error al actualizar el empleado.";
                $_SESSION['tipo_mensaje'] = 'error';
            }
        }
        header('Location: index.php?action=empleados_consulta');
        exit();
    }

    function empleados_eliminar() {
        $modelo = new EmpleadoModel();
        
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id_empleado'])) {
            $id_empleado = $_GET['id_empleado'];
    
            // Validar primero
            $usuarioActual = $_SESSION['id_empleado'];
            if($usuarioActual == $id_empleado){
                $_SESSION['mensaje'] = "No puedes eliminar tu propio usuario.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: index.php?action=empleados_consulta');
                exit();
            }
            $tieneCitas = $modelo->validar_empleado_cita($id_empleado);
            $tieneSolicitudes = $modelo->validar_empleado_solicitud($id_empleado);
            if ($tieneCitas) {
                $_SESSION['mensaje'] = "El empleado tiene citas asociadas. No se puede eliminar.";
                $_SESSION['tipo_mensaje'] = 'error';
            } elseif ($tieneSolicitudes) {
                $_SESSION['mensaje'] = "El empleado tiene solicitudes de servicio. No se puede eliminar.";
                $_SESSION['tipo_mensaje'] = 'error';
            } else {
                // Intentar eliminación solo si pasa las validaciones
                $resultado = $modelo->empleados_eliminar($id_empleado);
                
                if ($resultado) {
                    $_SESSION['mensaje'] = "Empleado eliminado con éxito.";
                    $_SESSION['tipo_mensaje'] = 'exito';
                } else {
                    $_SESSION['mensaje'] = "Error al eliminar el empleado.";
                    $_SESSION['tipo_mensaje'] = 'error';
                }
            }
        }
        
        header('Location: index.php?action=empleados_consulta');
        exit();
    }
?>