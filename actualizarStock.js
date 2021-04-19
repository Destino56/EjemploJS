//Funciones que se ejecutan al cargar la página
window.onload = function() {
    cargaCREFS();
}

let solicitud_cargaCREFS;

//Esta función se copia y pega, solo se cambia el nombre de las funciones y  del archivo php
function cargaCREFS(){
    solicitud_cargaCREFS=new XMLHttpRequest();
    solicitud_cargaCREFS.onreadystatechange = procesarCREFS; //Función que se encarga de la respuesta que devuelve php
    solicitud_cargaCREFS.open('POST','php_peticiones/cargaCREFS.php', true); //Archivo php que se va a encargar de la petición
    solicitud_cargaCREFS.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); //Esto va siempre xd
    solicitud_cargaCREFS.send(); //Función que se encarga de mandar la información al php
}


function procesarCREFS(){

    if(solicitud_cargaCREFS.readyState == 4 && solicitud_cargaCREFS.status==200){
        data = JSON.parse(solicitud_cargaCREFS.responseText);
        var select = document.getElementById('listaCREF');

        for (var i=0 ; i<data.length ; i++){
            var option = document.createElement('option');
            var value = data[i].CREF;
            option.value = value;
            select.appendChild(option);
        }
    }
}

let solicitud_cargaPrecios;

function cargaPrecios(){

    solicitud_cargaPrecios=new XMLHttpRequest();
    solicitud_cargaPrecios.onreadystatechange = procesarPrecios;
    solicitud_cargaPrecios.open('POST','php_peticiones/updatePrice.php', true);
    solicitud_cargaPrecios.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    solicitud_cargaPrecios.send(enviarCREF());
}

function enviarCREF(){

    let value = document.getElementById('inp_CREFS').value;
    let textobusquedaenviado = 'inp_CREFS='+encodeURIComponent(value);
    return textobusquedaenviado;
}

function procesarPrecios(){
    if(solicitud_cargaPrecios.readyState == 4 && solicitud_cargaPrecios.status==200){
        var data = JSON.parse(solicitud_cargaPrecios.responseText);
        document.getElementById("id_precioMayorista").value = data[0].NPREMAYOR;
        document.getElementById("id_precioPVP").value = data[0].NPCONIVA;
        let imagen = document.getElementById("id_img_producto")
        imagen.setAttribute("src", "imgs/producto/"+data[0].CIMAGEN+".jpg");
        imagen.setAttribute("width", 200);
        imagen.setAttribute("height", 300);
    }
}

let solicitud_cargaColores;

function cargaColores(){

    solicitud_cargaColores=new XMLHttpRequest();
    solicitud_cargaColores.onreadystatechange = procesarColores;
    solicitud_cargaColores.open('POST','php_peticiones/cargaColores.php', true);
    solicitud_cargaColores.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    solicitud_cargaColores.send(enviarCREF()); //Uso la misma función ya que solo quiero mandar el CREF como antes
}

function procesarColores(){
    limpiarSelect();
    if(solicitud_cargaColores.readyState == 4 && solicitud_cargaColores.status==200){
        let data = JSON.parse(solicitud_cargaColores.responseText);
        console.log(data);
        let select = document.getElementById("id_selectColores");
        let div = document.getElementById("id_fotoColores");
        for (let i=0 ; i<data.length ; i++){
            let option = document.createElement('option');
            let value = data[i].CIMAGEN;
            let text = data[i].DESCRIPCION;
            option.value = value;
            option.text = text;
            select.appendChild(option);

            let divColor = document.createElement("div");
            let img = document.createElement("img");
            img.setAttribute("src", "imgs/muestras/"+data[i].CIMAGEN+".jpg");
            img.setAttribute("height", 30);
            divColor.appendChild(img);
            div.appendChild(divColor);
        }
    }
}

function limpiarSelect(){

    var select = document.getElementById('id_selectColores');
    while (select.firstChild) {
        select.removeChild(select.lastChild);
    }

    var div = document.getElementById("id_fotoColores");
    while (div.firstChild) {
        div.removeChild(div.lastChild);
    }

}