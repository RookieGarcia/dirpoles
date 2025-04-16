<?php
// Configurar cabeceras para PDF
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="ficha_tecnica_'.$ficha['ficha']['id_ficha'].'.pdf"');

require_once 'libs/tcpdf/tcpdf.php';

// Crear nuevo documento PDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Configurar documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sistema DIRPOLES');
$pdf->SetTitle('Ficha Técnica '.$ficha['ficha']['id_ficha']);
$pdf->SetSubject('Ficha Técnica de Inventario');
$pdf->SetKeywords('inventario, ficha técnica, mobiliario, equipos');

// Eliminar márgenes
$pdf->SetMargins(15, 15, 15);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

// Añadir página
$pdf->AddPage();

// Logo
$logo = 'assets/img/logo_unerg.png';
$pdf->Image($logo, 15, 15, 25, 0, 'PNG');

// Título
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'FICHA TÉCNICA DE INVENTARIO', 0, 1, 'C');
$pdf->Ln(5);

// Información de la ficha
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 6, 'Número: FT-'.$ficha['ficha']['id_ficha'], 0, 1);
$pdf->Cell(0, 6, 'Fecha: '.date('d/m/Y', strtotime($ficha['ficha']['fecha_creacion'])), 0, 1);
$pdf->Cell(0, 6, 'Nombre: '.$ficha['ficha']['nombre_ficha'], 0, 1);
$pdf->Cell(0, 6, 'Servicio/Área: '.$ficha['ficha']['servicio'], 0, 1);
$pdf->Cell(0, 6, 'Responsable: '.$ficha['ficha']['responsable'], 0, 1);
$pdf->Cell(0, 6, 'Descripción: '.$ficha['ficha']['descripcion'], 0, 1);
$pdf->Ln(10);

// Mobiliario
if (!empty($ficha['mobiliario'])) {
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 6, 'MOBILIARIO ASIGNADO', 0, 1);
    $pdf->Ln(2);
    
    $pdf->SetFont('helvetica', '', 10);
    $header = array('Tipo', 'Descripción', 'Cantidad', 'Observaciones');
    $data = array();
    
    foreach ($ficha['mobiliario'] as $item) {
        $data[] = array(
            $item['tipo_mobiliario'],
            $item['marca'].' '.$item['modelo'].' ('.$item['color'].')',
            $item['cantidad'],
            $item['observaciones']
        );
    }
    
    $pdf->BasicTable($header, $data);
    $pdf->Ln(10);
}

// Equipos
if (!empty($ficha['equipos'])) {
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 6, 'EQUIPOS ASIGNADOS', 0, 1);
    $pdf->Ln(2);
    
    $pdf->SetFont('helvetica', '', 10);
    $header = array('Tipo', 'Descripción', 'Serial', 'Observaciones');
    $data = array();
    
    foreach ($ficha['equipos'] as $item) {
        $data[] = array(
            $item['tipo_equipo'],
            $item['nombre'].' - '.$item['marca'].' '.$item['modelo'],
            $item['serial'],
            $item['observaciones']
        );
    }
    
    $pdf->BasicTable($header, $data);
}

// Pie de página
$pdf->SetY(-30);
$pdf->SetFont('helvetica', 'I', 8);
$pdf->Cell(0, 6, 'Generado el: '.date('d/m/Y H:i:s'), 0, 1, 'C');
$pdf->Cell(0, 6, 'Sistema de Gestión DIRPOLES - UNERG', 0, 1, 'C');

// Salida del PDF
$pdf->Output('ficha_tecnica_'.$ficha['ficha']['id_ficha'].'.pdf', 'I');