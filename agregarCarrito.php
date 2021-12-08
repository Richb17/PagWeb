<?php
    include("funciones.php");
    autenticado();
    if(!isset($_GET['id']) || !isset($_GET['ubi'])){
        header($ruta."Portada.php");
    }
    else if($_GET['id']=="" && $_GET['ubi']!=""){
        regresarUltimaUbi($_GET['ubi']);
    }
    else if($_GET['id']!="" && $_GET['ubi']!=""){
        if(conseguirStock($_GET['id'])>0){
            agregarAlCarrito($_GET['id'],1);
        }
        regresarUltimaUbi($_GET['ubi']);
    }
    echo "<a href=\"portada.php\">Regresar a inicio</a><br><br>";
?>