
<?php
    include("include/funciones.php");
    autenticado();
    //Se verifica que los datos enviados sean correctos
    if( !isset($_GET['code']) || !isset($_GET['descripcion'])|| 
        !isset($_GET['descuento'])){
            header($ruta."seleccionarDescuento.php?err=1");
    }
    else if( $_GET['code'] == "" || $_GET['descuento'] == ""){
        header($ruta."seleccionarDescuento.php?err=2");
    }
    else{
        extract($_GET);
        $discount = $descuento/100;
        $conexion = conectarBD();
        //ejecución de la consulta en la BD
        $consulta = "INSERT INTO `descuentos`(`id`, `code`, `description`, `discount`) VALUES 
                    ('NULL','$code','$descripcion','$discount');";
        $rs = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        if(isset($_GET['idprod']) && $_GET['idprod'] != ""){
            header($ruta."seleccionarDescuento.php?id=$idprod&ubi=$ubi");
        }else{
            header($ruta."seleccionarDescuento.php");
        }
         
    }
?>