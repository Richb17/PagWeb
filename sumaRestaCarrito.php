<?php
    include("funciones.php");
    autenticado();

    if(!isset($_GET['id']) || !isset($_GET['band'])){
        header($ruta."Portada.php");
    }
    extract($_GET);
    
?>