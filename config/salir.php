<?php
 session_start();

unset($_SESSION);

session_destroy();

define('PAGINA_INICIO','../index.php');
header('Location: '.PAGINA_INICIO);
    
?>