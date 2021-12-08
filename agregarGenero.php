<?php
    $msg = "";
    if(isset($_GET['err']) && $_GET['err'] != ""){
        if($_GET['err'] == "0") $msg = "Se registro correctamente";
        if($_GET['err'] == "1") $msg = "Se debe utilizar el formulario de registro";
        if($_GET['err'] == "2") $msg = "Se deben llenar todos los campos";
        if($_GET['err'] == "3") $msg = "Ya existia el género que introdujo";
    }
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Género</title>

    <script type="text/javascript">
        function validaFRM(){
            if(document.getElementById("genero").value==""){
                    document.getElementById("msgAlerta").innerHTML = "Por favor llene los campos.";
                    return false;
                }
            else{
                return true;
            }
        }
    </script>
</head>
<body>
    <form method="get" action="registraGenero.php" onsubmit="return validaFRM()">
        <h3>Formulario de registro de géneros</h3>

        <?php 
            if($msg != "" ){
                echo "<div id=\"msgAlerta\"> $msg </div>";
            }
            else{
                echo "<div id=\"msgAlerta\"></div>";
            }
        ?>
        
        Ingresa el nombre del género, (Si existen espacios separar con '-'): <input type="text" id="genero" name = "genero"><br>
        <input type="submit" value="Registrar">
        <input type="reset" value="Cancelar"> <br>
        Regresar a inicio <a href="portada.php">Portada</a>
    </form>
</body>
</html>