<?php
    include("include/funciones.php");
    autenticado();
    //Se verifica que los datos enviados sean correctos
    if( !isset($_POST['tipoP']) || !isset($_POST['prov'])|| 
        !isset($_POST['cuenta']) || !isset($_POST['vencimiento'])){
            //regresarUltimaUbi($_GET['ubi']);
    }
    else if( $_POST['tipoP'] == "" || $_POST['prov'] == "" || 
        $_POST['cuenta'] == "" || $_POST['vencimiento'] == "" ){
        //regresarUltimaUbi($_GET['ubi']);
    }
    else{
        extract($_POST);
        $fecha = $vencimiento."-01";
        $conexion = conectarBD();
        //ejecución de la consulta en la BD
        $consulta = "INSERT INTO `pago_usuario`(`id`, `iduser`, `pay_type`, `provider`, `account_no`, `expire`) VALUES 
                    ('NULL','".$_SESSION['idusuario']."','$tipoP','$prov','$cuenta','$fecha');";
        $rs = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        regresarUltimaUbi($_GET['ubi']);
    }
?>