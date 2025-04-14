<?php

    function index() {
        $modelo = new UserModel();
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit();
        }
        $empleados = $modelo->obtenerConteoEmpleados();
        $beneficiarios = $modelo->obtenerConteoBeneficiarios();
        $citas = $modelo->obtenerConteoCitas();
        $diagnosticos = $modelo->obtenerConteoDiagnosticos();
        $citasPorDia = $modelo->obtenerCitasPorDia();
        require_once 'app/views/inicio.php';
    }

?>