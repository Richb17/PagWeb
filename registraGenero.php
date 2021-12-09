<?php
    include("include/funciones.php");
    //Se verifica que los datos enviados sean correctos
    if( !isset($_GET['genero']) ){
            header($ruta."agregarGenero.php?err=1");
    }
    else if( $_GET['genero'] == "" ){
        header($ruta."agregarGenero.php?err=2");
    }
    else{
        extract($_GET);
        echo "$genero<br>";
        $conexion = conectarBD();
        $consulta = "";
        $trozos=explode(" ",$genero);
        $numero=count($trozos);
        if ($numero==1) {
            //SI SOLO HAY UNA PALABRA DE BUSQUEDA SE ESTABLECE UNA INSTRUCION CON LIKE
            $consulta="SELECT * FROM `generoscat` WHERE `name` LIKE '$genero'";
        } 
        elseif ($numero>1) {
            //SI HAY UNA FRASE SE UTILIZA EL ALGORTIMO DE BUSQUEDA AVANZADO DE MATCH AGAINST
            //busqueda de frases con mas de una palabra y un algoritmo especializado
            $consulta="SELECT * , MATCH (`name`) AGAINST ( '$genero' ) AS `Score` FROM `generoscat` WHERE MATCH ( `name` ) AGAINST ( '$genero' ) ORDER BY `Score` DESC";
        }
        //ejecución de la consulta en la BD
        echo $consulta."<br>";
        $res = $conexion->query($consulta);
        if(mysqli_num_rows($res) > 0){
            header($ruta."agregarGenero.php?err=3");
        }
        else{
            echo "INSERT INTO `generoscat`(`name`, `created_at`) VALUES ('$genero',now())";
            $conexion ->query("INSERT INTO `generoscat`(`name`, `created_at`) VALUES ('$genero',now())");
            header($ruta."agregarGenero.php?err=0");
        }
        
        /* $consulta = "INSERT INTO `usuario`(`idusuario`, `username`, `password`, `email`, `first_name`, `last_name`, `role`) VALUES 
                    ('NULL','$txtUsuario','$txtPwd','$txtEmail','$txtNombre','$txtApellido', '1');";
        $rs = mysqli_query($conexion, $consulta); */
        mysqli_close($conexion);
        
        //header($ruta."registro.php?err=0");
    }
?>