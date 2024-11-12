<?php
    require_once("view/head/head.php");
    
?>

<div class="fondo_menu">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Inicio</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <?php if(empty($_SESSION['usuario'])): ?>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Reporte Operativo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Partes Especiales</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contactanos</a>
                        </li>
                    </ul>
                    <a href="/sarounidades/view/home/login.php" class="boton">Inicia Sesión</a>
                    <a href="/sarounidades/view/home/signup.php" class="boton">Registrate</a>
                </div>
                <?php else: ?>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Actualizar Parte Especial</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Estadísticas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Agregar Unidades Operativas</a>
                        </li>
                    </ul>
                    <a href="/login/view/home/logout.php" class="boton">Cerrar Sesión</a>
                </div>
                <?php endif ?>

            </div>
        </nav>
    </div>
</div>
<div class="fondo">

