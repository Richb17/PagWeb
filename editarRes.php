<?php
include("include/funciones.php");
autenticado();

$conexion = conectarBD();
$res = $conexion->query("SELECT `username` FROM `reseña` WHERE `idreview`=".$_POST['idReview']);
$rs = $res->fetch_array(MYSQLI_ASSOC);
echo "aqui";
if($rs['username']==$_SESSION['username'] || $_SESSION['role']>1){
    if($_POST['radioRec']==1){
        $conexion->query("UPDATE `reseña` SET `reviewtext`='".$_POST['txtReview']."',`modified_at`=now(),`vote`=".$_POST['radioRec']." WHERE `idreview`=".$_POST['idReview']);
    }else{
        $conexion->query("UPDATE `reseña` SET `reviewtext`='".$_POST['txtReview']."',`modified_at`=now(),`vote`=0 WHERE `idreview`=".$_POST['idReview']);
    }
    
    regresarUltimaUbi($_POST['ubi']);
}
else{
    echo "sali";
    regresarUltimaUbi($_POST['ubi']);
}
