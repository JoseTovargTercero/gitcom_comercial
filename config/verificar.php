<?php

include('conexion.php');


$doc = $_POST['user'];
$doc = addslashes($doc);
$doc = strip_tags($doc);

$contrasena = $_POST['pass'];
$contrasena = addslashes($contrasena);
$contrasena = strip_tags($contrasena);

try {
	$sql = "SELECT * FROM usuarios WHERE user = ?";
	$stmt = $conexion->prepare($sql);  // preparar la consulta
	$stmt = $conexion->stmt_init();

	if (!$stmt->prepare($sql)) {
		throw new Exception("Falló la preparación: (" . $conexion->errno . ") " . $conexion->error);
	}

	// Vincular el parámetro y ejecutar
	$stmt->bind_param("s", $doc);
	$stmt->execute();
	$resultado = $stmt->get_result();

	// Verificar si hay resultados
	if ($registro = $resultado->fetch_assoc()) {
		$passAlmacenada = $registro['password'];

		// Verificar contraseña
		if (password_verify($contrasena, $passAlmacenada)) {
			session_start();
			$_SESSION['nombre'] = $registro['nombre'];
			$_SESSION['user'] = $registro['user'];
			$_SESSION['id'] = $registro['id'];

			// Redirigir
			header('Location: ../mapas/index.php');
			exit();
		} else {
			header('Location: ../');
			exit();
		}
	} else {
		header('Location: ../');
		exit();
	}

	// Cerrar la consulta
	$stmt->close();
} catch (Exception $e) {
	echo 'Error: ' . $e->getMessage();
}
