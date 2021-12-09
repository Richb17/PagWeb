<?php
include("include/funciones.php");
include("include/partesPag.php");
autenticado();
$msg="";
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil | SoundStream</title>

    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
    <link href="styles/main.css" rel="stylesheet">

    <script type="text/javascript">
        function validaFRM_P() {
            if (document.getElementById("txtPwdActual").value == "" ||
                document.getElementById("txtPwdNueva").value == "" ||
                document.getElementById("txtConfirma").value == "") {
                document.getElementById("alertaPwd").innerHTML = "Por favor llene todos los campos.";
                return false;
            } else if (document.getElementById("txtPwdNueva").value != document.getElementById("txtConfirma").value) {
                document.getElementById("alertaPwd").innerHTML = "Las contraseñas no coinciden, debe introducir la misma contraseña en ambos campos";
                document.getElementById("txtPwdNueva").value = "";
                document.getElementById("txtPwdActual").value = "";
                document.getElementById("txtConfirma").value = "";
                return false;
            } else if (document.getElementById("txtPwdNueva").value == document.getElementById("txtPwdActual").value) {
                document.getElementById("alertaPwd").innerHTML = "Su nueva contraseña no puede ser la misma que la anterior";
                document.getElementById("txtPwdNueva").value = "";
                document.getElementById("txtPwdActual").value = "";
                document.getElementById("txtConfirma").value = "";
                return false;
            } else {
                return true;
            }
        }

        function validaFRM_Name() {
            if (document.getElementById("newname").value == "") {
                document.getElementById("alertaName").innerHTML = "Por favor llene todos los campos.";
                return false;
            } else {
                return true;
            }
        }
    </script>
</head>
<body>

<?php
navbar();
//Autenticación
?>
<div class="container-fluid" style="padding:100px 0px; max-width: 1468px;">
    <?php echo "<h2 style=\"padding-top:100px;\">".$_SESSION['username']."</h2>"?>
    <div class="row">
            <div class="col-6" style="border:1px solid White;">
                <p>
                    <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthPWD" aria-expanded="false" aria-controls="collapseWidthPWD">
                      Cambiar contraseña.
                    </button>
                </p>
                <div style="min-height: 120px;">
                    <div class="collapse collapse-horizontal" id="collapseWidthPWD">

                        <div class="card card-body" style="width: 500px;">
                        <?php
                        if($msg != ""){
                            echo "<div class=\"alertaPwd\">$msg</div>";
                        }
                        else{
                            echo "<div class=\"alertaPwd\"></div>";
                        }
                        ?>
                            <form method="post" action="cambiarPwd.php" onsubmit="return validaFRM_P()"></form>
                            Ingresa la contraseña actual: <input type="password" id="txtPwdActual" name="txtPwdActual"><br> Ingresa tu nueva contraseña: <input type="password" id="txtPwdNueva" name="txtPwdNueva"><br> Confirma tu contraseña: <input type="password"
                                id="txtConfirma" name="txtConfirma"><br>
                            <input type="submit" class="btn btn-primary" value="Actualizar contraseña">
                            <input type="reset" class="btn btn-danger" value="Cancelar"> <br>
                            </form>
                        </div>
                    </div>
                </div>
                <p>
                    <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthName" aria-expanded="false" aria-controls="collapseWidthName">
                      Cambiar nombre de usuario.
                    </button>
                </p>
                <div style="min-height: 120px;">
                    <div class="collapse collapse-horizontal" id="collapseWidthName">
                        <div class="card card-body" style="width: 500px;">
                        <?php
                        if($msg != ""){
                            echo "<div class=\"alertaName\">$msg</div>";
                        }
                        else{
                            echo "<div class=\"alertaName\"></div>";
                        }
                        ?>
                            
                            <form method="post" action="cambiarUserN.php" onsubmit="return validaFRM_Name()"></form>
                            Ingresa tu nuevo nombre de usuario: <input type="text" id="newname" name="newname"><br>
                            <input type="button" class="btn btn-primary" value="Actualizar nombre de usuario" data-bs-toggle="modal" data-bs-target="#staticBackdropName">
                            <input type="reset" class="btn btn-danger" value="Cancelar"> <br>

                            <div class="modal fade" id="staticBackdropName" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropNameLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropNameLabel">Cambio de nombre de usuario</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Está seguro de querer cambiar su nombre de usuario?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <input type="submit" class="btn btn-primary"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6" style="border:1px solid White;">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdropEliminar">
                    Eliminar cuenta
                </button>

                <!-- Modal -->
                <div class="modal fade" id="staticBackdropEliminar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropEliminarLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropEliminarLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                ¿Está seguro de querer eliminar su cuenta?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-danger" href="eliminarCuenta.php">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>


<?php
footer();
?>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>