<?php
include("include/funciones.php");
include("include/partesPag.php");
$msg = "";
if (isset($_GET['err']) && $_GET['err'] != "") {
    if ($_GET['err'] == "0") $msg = "Se registro correctamente el usuario";
    if ($_GET['err'] == "1") $msg = "Se debe utilizar el formulario de registro";
    if ($_GET['err'] == "2") $msg = "Se deben llenar todos los campos";
    if ($_GET['err'] == "3") $msg = "Las contraseñas no coinciden";
}
?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de administradores</title>

    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
    <link href="styles/main.css" rel="stylesheet">

</head>

<body>
    <?php
    navbar();
    //Autenticación
    ?>
    <div class="container-fluid" style="padding:200px 0px; max-width: 1468px;">
        <div class="row justify-content-center">
            <div class="col-5 align-self-center">
                <div class="card text-center">
                    <div class="card-header">
                        <h3>Registrar un usuario</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        if ($msg != "" && isset($_GET['reg'])) {
                            if ($_GET['reg'] != "0") {
                                echo "
                            <div class=\"alert alert-dismissible alert-danger\" id=\"alertaPwd\">
                                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                                <strong>Oh no!</strong> $msg
                            </div>
                            ";
                            } else {
                                echo "
                            <div class=\"alert alert-dismissible alert-success\" id=\"alertaPwd\">
                                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                                <strong>Muy bien!</strong> $msg
                            </div>
                            ";
                            }
                        }
                        ?>
                        <form method="get" action="agregarAdmin.php" class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" placeholder="usuario"><br>
                                    <label for="txtUsuario">Nombre de usuario</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" type="email" id="txtEmail" name="txtEmail" placeholder="email"><br>
                                    <label for="txtEmail">E-Mail</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="input-group">
                                    <span class="input-group-text">Nombre y apellidos</span>
                                    <input type="text" type="text" id="txtNombre" name="txtNombre" aria-label="First name" class="form-control">
                                    <input type="text" type="text" id="txtApellido" name="txtApellido" aria-label="Last name" class="form-control">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <select class="form-select" name="txtRol" id="txtRol" aria-label="Floating label select example">
                                        <option value="1">General</option>
                                        <option value="2">Administrador</option>
                                        <option value="3">Capturista</option>
                                    </select>
                                    <label for="txtRol">Rol</label>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" type="password" id="txtPwd" name="txtPwd" placeholder="Contraseña"><br>
                                    <label for="txtPwd">Contraseña</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" type="password" id="txtConfirm" name="txtConfirm" placeholder="Confirmar Contraseña"><br>
                                    <label for="txtConfirm">Confirmar contraseña</label>
                                </div>
                            </div>

                            <input type="submit" class="btn btn-primary" value="Registrar">
                            <input type="reset" class="btn btn-secondary" value="Cancelar">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>