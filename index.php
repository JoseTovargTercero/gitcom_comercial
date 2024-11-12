<?php
require_once("head/head.php");
?>

<div class="container d-flex">



    <div class="fondo-login m-auto" style="min-width: 90%;">

        <div class="icon text-center mt-3">
            <img src="img/logo.png" alt="logo" width="10%" style="width: 90px;">
        </div>

        <div class="text-center mt-2">Ingresa tus credenciales para iniciar sesión</div>
        <form action="config/verificar.php" method="POST" autocomplete="off" class="mb-3 mt-3">
            <div class="mb-3">
                <label for="user" class="form-label">Usuario</label>
                <input type="text" name="user" class="form-control" id="user" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">Clave</label>

                <div class="d-flex">
                    <input type="password" name="pass" class="form-control pass_form-control" id="pass">
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-danger">Ingresar</button>
            </div>
        </form>



        <?php if (!empty($_GET['error'])): ?>
            <div id="alertError" style="margin: auto;" class="alert alert-danger mb-2" role="alert">
                <?= !empty($_GET['error']) ? $_GET['error'] : "" ?>
            </div>
        <?php endif; ?>


    </div>



</div>


<?php
require_once("head/footer.php");
?>