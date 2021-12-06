<?php
    $msg = "";
    if(isset($_GET['err']) && $_GET['err'] != ""){
        if($_GET['err'] == "0") $msg = "Se registro correctamente el descuento";
        if($_GET['err'] == "1") $msg = "Se debe utilizar el formulario de registro";
        if($_GET['err'] == "2") $msg = "Se deben llenar todos los campos";
    }
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de administradores</title>

    <script type="text/javascript">
        function validaFRM(){
            if(document.getElementById("code").value=="" || 
                document.getElementById("descuento").value==""){
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
    <form method="get" action="agregarDescuento.php" onsubmit="return validaFRM()">
        <h3>Formulario de registro de descuentos</h3>

        <?php 
            if($msg != "" ){
                echo "<div id=\"msgAlerta\"> $msg </div>";
            }
            else{
                echo "<div id=\"msgAlerta\"></div>";
            }
        ?>
        
        Ingresa código para el descuento: <input type="text" id="code" name = "code"><br>
        Escriba una descripción del descuento: <input type="text" id="descripcion" name = "descripcion"><br>
        Ingrese valor del descuento: <input type="number" id="descuento" required name="descuento" min="0" max="100" placeholder="50%"><br>
        <input type="submit" value="Registrar">
        <input type="reset" value="Cancelar"> <br>
        <a href="portada.php">Regresar a inicio</a>
    </form>
</body>
</html>