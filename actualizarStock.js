//Funciones que se ejecutan al cargar la página
window.onload = (function(){
    cargaCREFS();
    let btnPrecios = document.getElementById("id_btnActualizarPrecio");
    btnPrecios.addEventListener("click", ()=>{
        updatePrecio();
    });
});

let solicitud_cargaCREFS;

//Esta función se copia y pega, solo se cambia el nombre de las funciones y  del archivo php
function cargaCREFS(){
    solicitud_cargaCREFS=new XMLHttpRequest();
    solicitud_cargaCREFS.onreadystatechange = procesarCREFS; //Función que se encarga de la respuesta que devuelve php
    solicitud_cargaCREFS.open('POST','php_peticiones/cargaCREFS.php', true); //Archivo php que se va a encargar de la petición
    solicitud_cargaCREFS.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); //Esto va siempre xd
    solicitud_cargaCREFS.send(); //Función que se encarga de mandar la información al php
}

//las funciones procesar sirven para procesar las vueltas de las peticiones a la base de datos
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
    solicitud_cargaPrecios.open('POST','php_peticiones/cargaPrecios.php', true);
    solicitud_cargaPrecios.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    solicitud_cargaPrecios.send(enviarCREF());
}

//las funciones enviar sirven para enviar los datos de javascript a archivos php donde se hacen peticiones a la base de datos
function enviarCREF(){
    let value = document.getElementById('inp_CREFS').value;
    let textobusquedaenviado = 'inp_CREFS='+encodeURIComponent(value);
    return textobusquedaenviado;
}

function procesarPrecios(){
    limpiarPrecios();
    let divImagen = document.getElementById("id_col-img");


    if(solicitud_cargaPrecios.readyState == 4 && solicitud_cargaPrecios.status==200){
        var data = JSON.parse(solicitud_cargaPrecios.responseText);
        let imagen = document.createElement("img");
        imagen.setAttribute("id", "id_img_producto");
        imagen.setAttribute("src", "");
        document.getElementById("id_precioMayorista").value = data[0].NPREMAYOR;
        document.getElementById("id_precioPVP").value = data[0].NPCONIVA;
        imagen.setAttribute("src", "imgs/producto/"+data[0].CIMAGEN+".jpg");
        imagen.setAttribute("widht", 300);
        imagen.setAttribute("height", 400);
        divImagen.appendChild(imagen);
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
            divColor.setAttribute("class", "col-divColor")
            let img = document.createElement("img");
            let nombreColor = document.createElement("h3");
            nombreColor.innerText = data[i].DESCRIPCION;
            divColor.appendChild(nombreColor);
            img.setAttribute("src", "imgs/muestras/"+data[i].CIMAGEN+".jpg");
            img.setAttribute("class", "imgColores");
            divColor.appendChild(img);
            div.appendChild(divColor);
        }
    }
}

//limpia los precios cada vez que se quita el CREF del input
function limpiarPrecios(){
    var selectPrecioMayorista = document.getElementById("id_precioMayorista");
    selectPrecioMayorista.value="";

    var selectPVP = document.getElementById("id_precioPVP");
    selectPVP.value="";

    if (document.getElementById("id_img_producto")){
        let imagen = document.getElementById("id_img_producto");
        imagen.remove();
    }
}

//limpia el select de colores  cada vez que se cambie el CREF
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

let solicitud_updatePrecio;

function updatePrecio(){
    solicitud_updatePrecio=new XMLHttpRequest();
    solicitud_updatePrecio.onreadystatechange = procesarPrecio;
    solicitud_updatePrecio.open('POST','php_peticiones/actualizarPrecio.php', true);
    solicitud_updatePrecio.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    solicitud_updatePrecio.send(enviarPrecio()); //Uso la misma función ya que solo quiero mandar el CREF como antes
}

function enviarPrecio(){
    let value = document.getElementById("inp_CREFS").value;
    let textobusquedaenviado = "inp_CREFS=" + encodeURIComponent(value)
    value = document.getElementById('id_precioMayorista').value;
    textobusquedaenviado += '&mayorista='+encodeURIComponent(value);
    value = document.getElementById("id_precioPVP").value;
    textobusquedaenviado += "&pvp=" + encodeURIComponent(value);
    console.log(textobusquedaenviado);
    return textobusquedaenviado;
    
}


function procesarPrecio(){
    if(solicitud_updatePrecio.readyState == 4 && solicitud_updatePrecio.status==200) {
       alert("Precios actualizados correctamente");
    }
}