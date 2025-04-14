<?php

require_once "app/models/UserModel.php";

    function showLogin() {
        include 'app/views/login.php';
    }

    function login($username, $password) {
        $userModel = new UserModel();
        $response = ['success' => false, 'message' => ''];
    
        try {
            $user = $userModel->authenticate($username, $password);
            
            if ($user) {
                if ($user['estatus'] == 0) {
                    $response['message'] = "Tu cuenta está deshabilitada";
                } else {
                    $_SESSION['user'] = $user['correo'];
                    $_SESSION['id_empleado'] = $user['id_empleado'];
                    $_SESSION['nombre'] = $user['nombre'];
                    $_SESSION['apellido'] = $user['apellido'];
                    $_SESSION['tipo_empleado'] = $user['nombre_tipo'];
                    
                    $response['success'] = true;
                    $response['message'] = "Inicio de sesión exitoso";
                }
            } else {
                $_SESSION['failed_attempts'] = ($_SESSION['failed_attempts'] ?? 0) + 1;
                
                if ($_SESSION['failed_attempts'] >= 3) {
                    $userModel->disableUser($username);
                    $response['message'] = "Cuenta deshabilitada por múltiples intentos";
                } else {
                    $response['message'] = "Usuario o contraseña incorrectos";
                }
            }
        } catch (Exception $e) {
            $response['message'] = "Error en el servidor: " . $e->getMessage();
        }
    
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    function verificar_username() {
        $modelo = new UserModel();
        // Usar el parámetro correcto, en este caso 'username'
        $username = $_POST['username'];
        $usuario = $modelo->existe_usuario($username);
        echo json_encode(['exists' => $usuario ? true : false]);
        exit();
    }
    
    function logout() {
        session_start();
        session_unset(); 
        session_destroy();
        header('Location: index.php?action=login');
    }
?>