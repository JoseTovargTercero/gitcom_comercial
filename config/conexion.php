<?php
date_default_timezone_set('America/Manaus');

$conexion = new mysqli("localhost", "user_comercial", "0mR]{jx3n3-G", "gitcom_comercial");
mysqli_set_charset($conexion, 'utf8');
if ($conexion->connect_error) {
    die('Problemas con la conexion a la base de datos');
}
