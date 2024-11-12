<?php
require 'conexion.php';
header('Content-Type: application/json');

// Obtener los datos enviados en el cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);

// Preparar la consulta para obtener los datos, excepto LON y LAT
$sql = "SELECT ID, RAZON_SOCIAL, SUJETO, LAT, LON
        FROM censo
        WHERE LAT != '' AND LON != ''";

$stmt = $conexion->prepare($sql);
$info = [];
if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($info, $row);
        }
        echo json_encode(['data' => $info]);
    } else {
        echo json_encode(["message" => "No se encontró un registro con el RIF proporcionado"]);
    }

    $stmt->close();
} else {
    echo json_encode(["message" => "Error en la preparación de la consulta"]);
}

$conexion->close();
