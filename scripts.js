function validaFRM() {
    if (document.getElementById("album").value == "" ||
        document.getElementById("artista").value == "" ||
        document.getElementById("precio").value == "" ||
        document.getElementById("formato").value == "" ||
        document.getElementById("stock").value == "") {
        document.getElementById("msgAlerta").innerHTML = "Por favor llene todos los campos.";
        return false;
    } else {
        document.getElementById("nombreStock").value = document.getElementById("album").value + "-" + document.getElementById("artista").value + "-" + document.getElementById("formato").value;
        return true;
    }
}