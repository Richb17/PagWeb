<?php
include("funciones.php");
session_start();
session_destroy();
header($ruta."Portada.php");
?>