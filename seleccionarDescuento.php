<?php
    include("include/funciones.php");
    $msg = "";
    autenticado();
    
    if($_SESSION['role']==1) header($ruta."Portada.php");

    if(isset($_GET['err']) && $_GET['err'] != ""){
        if($_GET['err'] == "0") $msg = "Se selecciono el descuento correctamente";
        if($_GET['err'] == "1") $msg = "Se debe utilizar el formulario de registro";
    }
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgregarProducto</title>

    <script type="text/javascript">
        function validaFRM(){
            if( document.getElementById("titulo").value==""){
                    document.getElementById("msgAlerta").innerHTML = "Por favor llene todos los campos.";
                    return false;
                }
            else{
                return true;
            }
        }
    </script>
</head>
<body>
    <h1>Sistema de control de archivos</h1>
    <a href="portada.php">Regresar a inicio</a>
        <?php
            echo "<h3>Seleccion de descuentos</h3>";
            if($msg != "" ){
                echo "<div id=\"msgAlerta\"> $msg </div>";
            }
            else{
                echo "<div id=\"msgAlerta\"></div>";
            }

            $conexion = conectarBD();
            $res = $conexion->query("SELECT * FROM `descuentos`");
            if($res){
                echo "<table>";
                echo "<tr>";
                echo "<td>Codigo descuento</td>";
                echo "<td>Descripción</td>";
                echo "<td>% Descuento</td>";
                echo "<td>Selección</td>";
                echo "</tr>";
                while($val = $res->fetch_array(MYSQLI_ASSOC)){
                    echo "<td>".$val['id']."</td>";
                    echo "<td>".$val['code']."</td>";
                    echo "<td>".$val['description']."</td>";
                    $descuento = $val['discount']*100;
                    echo "<td>$descuento%</td>";
                   
                    echo "<td><a href=\"aplicarDescuento.php?idprod=".$_GET['id']."&iddesc=".$val['id']."\">Seleccionar</a></td>";
                    
                    echo "</tr>";
                }
            }
            mysqli_close($conexion);
        ?>
    <a href="portada.php">Regresar a inicio</a>
</body>
</html>
