<?php
require 'conexion.php';
header('Content-Type: application/json');

// Obtener los datos enviados en el cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['rif'])) {
    echo json_encode(["message" => "RIF no proporcionado"]);
    exit;
}

$rif = $data['rif'];

// Preparar la consulta para obtener los datos, excepto LON y LAT
$sql = "SELECT PARROQUIA, DIRECCION_COMPLETA, RAZON_SOCIAL, SUJETO, RIF, PROPETARIO, CI, TELEFONO, CORREO, SECTOR_COMERCIAL, ACTIVIDAD_COMERCIAL, REFERENCIA, REFERENCIA_1, M2, CAPACIDAD_OPERATIVA, ESTATUS, BASURA, AGUA, AGUAS_SERVIDAS, gas_m, gas_g, FRECUENCIA_RECOLECCION, USO_AGUA, ALMACENAMIENTO_AGUA
        FROM censo
        WHERE RIF = ?";

$stmt = $conexion->prepare($sql);

if ($stmt) {
    $stmt->bind_param("s", $rif);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró un registro
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row); // Enviar los datos en formato JSON
    } else {
        echo json_encode(["message" => "No se encontró un registro con el RIF proporcionado"]);
    }

    $stmt->close();
} else {
    echo json_encode(["message" => "Error en la preparación de la consulta"]);
}

$conexion->close();
