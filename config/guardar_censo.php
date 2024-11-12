<?php
require 'conexion.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(["message" => "Datos no válidos"]);
    exit;
}











// Verificar si el RIF ya existe
$rif = $data["RIF"];
$sql_check = "SELECT COUNT(*) FROM censo WHERE RIF = ?";
$stmt_check = $conexion->prepare($sql_check);

if ($stmt_check) {
    $stmt_check->bind_param("s", $rif);
    $stmt_check->execute();
    $stmt_check->bind_result($count);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($count > 0) {
        // Si el RIF existe, hacer un UPDATE
        $sql_update = "UPDATE censo SET PARROQUIA = ?, COMUNA = ?, COMUNIDAD = ?, DIRECCION_COMPLETA = ?, RAZON_SOCIAL = ?, SUJETO = ?, PROPETARIO = ?, CI = ?, TELEFONO = ?, CORREO = ?, SECTOR_COMERCIAL = ?, ACTIVIDAD_COMERCIAL = ?, REFERENCIA = ?, REFERENCIA_1 = ?, M2 = ?, CAPACIDAD_OPERATIVA = ?, ESTATUS = ?, gas_p = ?, BASURA = ?, AGUA = ?, AGUAS_SERVIDAS = ?, LAT = ?, LON = ?, gas_m = ?, gas_g = ?, FRECUENCIA_RECOLECCION = ?, USO_AGUA = ?, ALMACENAMIENTO_AGUA = ? WHERE RIF = ?";

        $stmt_update = $conexion->prepare($sql_update);
        if ($stmt_update) {
            $stmt_update->bind_param(
                "sssssssssssssssisisssssssssss",
                $data["PARROQUIA"],
                $data["COMUNA"],
                $data["COMUNIDAD"],
                $data["DIRECCION_COMPLETA"],
                $data["RAZON_SOCIAL"],
                $data["SUJETO"],
                $data["PROPETARIO"],
                $data["CI"],
                $data["TELEFONO"],
                $data["CORREO"],
                $data["SECTOR_COMERCIAL"],
                $data["ACTIVIDAD_COMERCIAL"],
                $data["REFERENCIA"],
                $data["REFERENCIA_1"],
                $data["M2"],
                $data["CAPACIDAD_OPERATIVA"],
                $data["ESTATUS"],
                $data["gas_p"],
                $data["BASURA"],
                $data["AGUA"],
                $data["AGUAS_SERVIDAS"],
                $data["LAT"],
                $data["LON"],
                $data["gas_m"],
                $data["gas_g"],
                $data["FRECUENCIA_RECOLECCION"],
                $data["USO_AGUA"],
                $data["ALMACENAMIENTO_AGUA"],
                $rif
            );

            if ($stmt_update->execute()) {
                echo json_encode(["success" => "Datos actualizados con éxito"]);
            } else {
                echo json_encode(["error" => "Error al actualizar los datos"]);
            }
            $stmt_update->close();
        } else {
            echo json_encode(["error" => "Error en la preparación de la consulta de actualización"]);
        }
    } else {
        // Si el RIF no existe, hacer un INSERT
        $sql_insert = "INSERT INTO censo (PARROQUIA, COMUNA, COMUNIDAD, DIRECCION_COMPLETA, RAZON_SOCIAL, SUJETO, RIF, PROPETARIO, CI, TELEFONO, CORREO, SECTOR_COMERCIAL, ACTIVIDAD_COMERCIAL, REFERENCIA, REFERENCIA_1, M2, CAPACIDAD_OPERATIVA, ESTATUS, gas_p, BASURA, AGUA, AGUAS_SERVIDAS, LAT, LON, gas_m, gas_g, FRECUENCIA_RECOLECCION, USO_AGUA, ALMACENAMIENTO_AGUA)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt_insert = $conexion->prepare($sql_insert);
        if ($stmt_insert) {
            $stmt_insert->bind_param(
                "sssssssssssssssisisssssssssss",
                $data["PARROQUIA"],
                $data["COMUNA"],
                $data["COMUNIDAD"],
                $data["DIRECCION_COMPLETA"],
                $data["RAZON_SOCIAL"],
                $data["SUJETO"],
                $data["RIF"],
                $data["PROPETARIO"],
                $data["CI"],
                $data["TELEFONO"],
                $data["CORREO"],
                $data["SECTOR_COMERCIAL"],
                $data["ACTIVIDAD_COMERCIAL"],
                $data["REFERENCIA"],
                $data["REFERENCIA_1"],
                $data["M2"],
                $data["CAPACIDAD_OPERATIVA"],
                $data["ESTATUS"],
                $data["gas_p"],
                $data["BASURA"],
                $data["AGUA"],
                $data["AGUAS_SERVIDAS"],
                $data["LAT"],
                $data["LON"],
                $data["gas_m"],
                $data["gas_g"],
                $data["FRECUENCIA_RECOLECCION"],
                $data["USO_AGUA"],
                $data["ALMACENAMIENTO_AGUA"]
            );

            if ($stmt_insert->execute()) {
                echo json_encode(["success" => "Datos guardados con éxito"]);
            } else {
                echo json_encode(["error" => "Error al guardar los datos"]);
            }
            $stmt_insert->close();
        } else {
            echo json_encode(["error" => "Error en la preparación de la consulta de inserción"]);
        }
    }
} else {
    echo json_encode(["error" => "Error en la preparación de la consulta de verificación"]);
}

$conexion->close();
