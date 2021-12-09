<?php
function conectar(){
    $conexion = mysqli_connect("localhost", "root", "", "tiendadesweb");
        if (!$conexion) {
            die("Connection failed: " . mysqli_connect_error());
        }
    
    return $conexion;
}

function navbar(){
    echo "<header>";
    echo "<nav class=\"navbar navbar-expand-lg navbar-dark fixed-top bg-dark\">
    <div class=\"container-fluid\">
        <a class=\"navbar-brand\" href=\"Portada.php\">SoundStream</a>
        <button class=\"navbar-toggler\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#navbarColor02\" aria-controls=\"navbarColor02\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
      <span class=\"navbar-toggler-icon\"></span>
    </button>

        <div class=\"collapse navbar-collapse\" id=\"navbarColor02\">
            <ul class=\"navbar-nav me-auto\">
                <li class=\"nav-item\">
                    <a class=\"nav-link active\" href=\"Portada.php\">Inicio
            <span class=\"visually-hidden\">(current)</span>
          </a></li>";
    echo   "<li class=\"nav-item\">
                <a class=\"nav-link\" href=\"allProductos.php\">Productos</a>
            </li>";
    echo "<li class=\"nav-item dropdown\">
            <a class=\"nav-link dropdown-toggle\" data-bs-toggle=\"dropdown\" href=\"#\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">Generos</a>
                <div class=\"dropdown-menu\">";
    $conexion = conectar();
    $rs = $conexion->query("SELECT `name` FROM `generoscat`");
    while($res = $rs->fetch_array(MYSQLI_ASSOC)){
        echo "<a class=\"dropdown-item\" href=\"explorarGenero.php?name=".$res['name']."\">".$res['name']."</a>";
    }
    if(isset($_SESSION['role']) && $_SESSION['role']>1){
        echo "<div class=\"dropdown-divider\"></div>";
        echo "<a class=\"dropdown-item\" href=\"agregarGenero.php\">Agregar Genero</a>";
    }
    echo "  </div>
    </li>
    <li class=\"nav-item dropdown\">
        <a class=\"nav-link dropdown-toggle\" data-bs-toggle=\"dropdown\" href=\"#\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">Formatos</a>
        <div class=\"dropdown-menu\">
            <a class=\"dropdown-item\" href=\"explorarFormato.php?f=Vinilo\">Vinilo</a>
            <a class=\"dropdown-item\" href=\"explorarFormato.php?f=CD\">CD</a>
            <a class=\"dropdown-item\" href=\"explorarFormato.php?f=Cassete\">Cassete</a>
        </div>
    </li>";
    if(!isset($_SESSION['role'])){
        echo "  <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"#\">Iniciar Sesión o Registrarse</a>
                </li>";
    }
    else{
        echo "  <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"perfil.php\">Perfil</a>
                </li>";
        if($_SESSION['role']>1){
            echo "  <li class=\"nav-item dropdown\">
                        <a class=\"nav-link dropdown-toggle\" data-bs-toggle=\"dropdown\" href=\"#\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">Agregar</a>
                        <div class=\"dropdown-menu\">
                            <a class=\"dropdown-item\" href=\"agregarProducto.php\">Nuevo Producto</a>
                            <a class=\"dropdown-item\" href=\"subirImagen.php\">Nueva Imagen</a>";
            if($_SESSION['role']==2){ 
                echo "<a class=\"dropdown-item\" href=\"registroAdmin.php\">Nuevo usuario</a>";
            }
            echo "          <a class=\"dropdown-item\" href=\"registroDescuento.php\">Nuevo descuento</a>
                        </div>
                    </li>";
        }
        else{
            echo "  <li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"verCarrito.php\">Carrito</a>
                    </li>";
        }
        echo "  <li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"mostrarPedidos.php\">Pedidos</a>
                    </li>";
        echo "  <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"logout.php\">Cerrar Sesión</a>
                </li>";
    }
    echo "</ul>
                <form method='post' action=\"buscar.php\" class=\"d-flex\">
                    <input id='busqueda' name='busqueda' class=\"form-control me-sm-2\" type=\"text\" placeholder=\"Buscar\">
                    <button class=\"btn btn-secondary my-2 my-sm-0\" type=\"submit\">Buscar</button>
                </form>
            </div>
            </div>
            </nav>
            </header>";
}

function precioDescuento($idprod){
    $conexion = conectar();
    $resProd = $conexion->query("SELECT `prices`, `iddiscount` FROM `productos` WHERE `idprod`=$idprod");
    $valuesProd = $resProd->fetch_array(MYSQLI_ASSOC);
    $precio = $valuesProd['prices'];
    if($valuesProd['iddiscount'] != NULL){ 
        $iddiscount = $valuesProd['iddiscount'];
        $resDisc = $conexion->query("SELECT `discount` FROM `descuentos` WHERE `id`=$iddiscount");
        $resD = $resDisc->fetch_array(MYSQLI_ASSOC);
        $desc = $resD['discount'];
        $precio *= (1-$desc);
    }
    mysqli_close($conexion);
    return $precio;
}

function prodCard($idprod, $ubi){
    $conexion = conectar();
    $res = $conexion->query("SELECT * FROM `productos` WHERE `idprod`='$idprod'");
    $rs = $res->fetch_array(MYSQLI_ASSOC);
    extract($rs);
    $precio = precioDescuento($idprod);
    $imageQRY = $conexion->query("SELECT * FROM `imagenes` WHERE `idprod` = $idprod");
    if($imageQRY){
        $img = $imageQRY->fetch_array(MYSQLI_ASSOC);
        //echo "<img src='mostrarImagen.php?id=".$img["id"]."' class='rounded mx-auto d-block img_prod_min'><br>";
    }
    echo "
    <div class=\"card text-center col-auto\">
        <a href=\"verProducto.php?id=$idprod&ubi=$ubi\"> <img src='mostrarImagen.php?id=".$img["id"]."' class=\"card-img-top rounded mx-auto d-block img_prod_min\"></a>
        <div class=\"card-body\">
            <a href=\"verProducto.php?id=$idprod&ubi=$ubi\"> <h4 class=\"card-title\">$albumname</h4></a>
            <h5 class=\"card-subtitle\">$artistname - $format</h5>
            <h6 class=\"card-text\">\$$precio</h6>
            <div class=\"container\">";
    if(isset($_SESSION['role'])){
        if($_SESSION['role']>1){
            echo 
            "<div class=\"row\">
                <div class=\"col\"><a href=\"editarArticulo.php?id=$idprod&ubi=$ubi\" class=\"btn btn-primary\">Editar producto</a></div>
                <div class=\"col\"><a href=\"eliminarArticulo.php?id=$idprod&ubi=$ubi\" class=\"btn btn-danger\">Eliminar producto</a></div>";
        }
        else{
            echo 
            "<div class=\"row\">
                <div class=\"col\"><a href=\"agregarCarrito.php?id=$idprod&ubi=$ubi\" class=\"btn btn-primary\">Añadir al carrito</a></div>
                <div class=\"col\"><a href=\"comprarAhora.php?id=$idprod&ubi=$ubi\" class=\"btn btn-secondary\">Comprar ahora</a></div>";
        }
        echo "</div>";
    }
                
    echo "
            </div>
        </div>
    </div>";
}

function itemCarrusel($ids, $conexion, $n ){
    $imageQRY = $conexion->query("SELECT * FROM `imagenes` WHERE `idprod` =". $ids['idprod']);
    if($imageQRY){
        $img = $imageQRY->fetch_array(MYSQLI_ASSOC);
    }
    if($n == 0){
        echo"
        <div class=\"carousel-item active\">
            <img src=\"mostrarImagen.php?id=".$img["id"]."\" class=\"d-block w-100 \">
            <div class=\"carousel-caption d-none d-md-block\" >
                <a href=\"verProducto.php?id=".$ids['idprod']."&ubi=portada\"> <h5>".$ids['albumname']."</h5></a>
                <h6>".$ids['artistname']."</h6>
                <p>Recien añadido</p>
            </div>
        </div>";
    }else{
        echo"
        <div class=\"carousel-item\">
            <img src=\"mostrarImagen.php?id=".$img["id"]."\" class=\"d-block w-100 \">
            <div class=\"carousel-caption d-none d-md-block\" >
                <a href=\"verProducto.php?id=".$ids['idprod']."&ubi=portada\"> <h5>".$ids['albumname']."</h5></a>
                <h6>".$ids['artistname']."</h6>
                <p>Recien añadido</p>
            </div>
        </div>";
    }
}

function footer(){
    echo "
    <footer class=\"container-fluid text-center text-lg-start\" style=\"background-color: #375a7f;\">
        <div class=\"container d-flex justify-content-center py-5\" style=\"height=100px;\">
            <button type=\"button\" class=\"btn btn-primary btn-lg btn-floating mx-2\" style=\"background-color: #444444; border-radius: 20%;\">
            <a href=\"https://www.facebook.com/Rickb.hdz\"><i class=\"fab fa-facebook-f\"></i></a>
            </button>
            <button type=\"button\" class=\"btn btn-primary btn-lg btn-floating mx-2\" style=\"background-color: #444444; border-radius: 20%;\">
                <a href=\"https://www.linkedin.com/in/ricardo-barba-hern%C3%A1ndez-b313b6191/\"><i class=\"fab fa-linkedin\"></i></a>
            </button>
            <button type=\"button\" class=\"btn btn-primary btn-lg btn-floating mx-2\" style=\"background-color: #444444; border-radius: 20%;\">
                <a href=\"https://github.com/Richb17\"><i class=\"fab fa-github\"></i></a>
            </button>
        </div>

        <div class=\"text-center text-white p-3\" style=\"background-color: rgba(0, 0, 0, 0.2);\">
            © 2021 Copyright:
            <p>SoundStream Records</p>
        </div>
    </footer>";
}
?>  