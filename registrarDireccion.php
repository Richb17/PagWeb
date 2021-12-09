<?php
    include("include/funciones.php");
    autenticado();
    //Se verifica que los datos enviados sean correctos
    if( !isset($_POST['dir']) || !isset($_POST['ciudad'])|| 
        !isset($_POST['pais']) || !isset($_POST['codP'])){
            regresarUltimaUbi($_GET['ubi']);
    }
    else if( $_POST['dir'] == "" || $_POST['ciudad'] == "" || 
        $_POST['pais'] == "" || $_POST['codP'] == "" ){
        regresarUltimaUbi($_GET['ubi']);
    }
    else{
        extract($_POST);
        $conexion = conectarBD();
        //ejecución de la consulta en la BD
        $consulta = "INSERT INTO `direccion_usuario`(`id`, `iduser`, `address_line1`, `city`, `postal_code`, `country`) VALUES 
                    ('NULL','".$_SESSION['idusuario']."','$dir','$ciudad','$codP','$pais');";
        $rs = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        echo $_GET['ubi'];
        regresarUltimaUbi($_GET['ubi']);
    }
?>