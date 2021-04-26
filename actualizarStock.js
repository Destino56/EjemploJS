//Funciones que se ejecutan al cargar la página
window.onload = (function () {
    cargaCREFS();
    let btnPrecios = document.getElementById("id_btnActualizarPrecio");
    btnPrecios.addEventListener("click", () => {
        updatePrecio();
    });

    let btnStock = document.getElementById("btnStock");
    btnStock.addEventListener("click", () => {
        try{
            cargaValoresStock();
        }catch(ex){
            alert("No ha selccionado un articulo");
        }
    });
});

let solicitud_cargaCREFS;

//Esta función se copia y pega, solo se cambia el nombre de las funciones y  del archivo php
function cargaCREFS() {
    solicitud_cargaCREFS = new XMLHttpRequest();
    solicitud_cargaCREFS.onreadystatechange = procesarCREFS; //Función que se encarga de la respuesta que devuelve php
    solicitud_cargaCREFS.open('POST', 'php_peticiones/cargaCREFS.php', true); //Archivo php que se va a encargar de la petición
    solicitud_cargaCREFS.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); //Esto va siempre xd
    solicitud_cargaCREFS.send(); //Función que se encarga de mandar la información al php
}

//las funciones procesar sirven para procesar las vueltas de las peticiones a la base de datos
function procesarCREFS() {
    if (solicitud_cargaCREFS.readyState == 4 && solicitud_cargaCREFS.status == 200) {
        data = JSON.parse(solicitud_cargaCREFS.responseText);
        var select = document.getElementById('listaCREF');

        for (var i = 0; i < data.length; i++) {
            var option = document.createElement('option');
            var value = data[i].CREF;
            option.value = value;
            select.appendChild(option);
        }
    }
}

let solicitud_cargaPrecios;


function cargaPrecios() {
    solicitud_cargaPrecios = new XMLHttpRequest();
    solicitud_cargaPrecios.onreadystatechange = procesarPrecios;
    solicitud_cargaPrecios.open('POST', 'php_peticiones/cargaPrecios.php', true);
    solicitud_cargaPrecios.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    solicitud_cargaPrecios.send(enviarCREF());
}

//las funciones enviar sirven para enviar los datos de javascript a archivos php donde se hacen peticiones a la base de datos
function enviarCREF() {

    let value = document.getElementById('inp_CREFS').value;
    let textobusquedaenviado = 'inp_CREFS=' + encodeURIComponent(value);

    console.log(textobusquedaenviado)
    return textobusquedaenviado;
}

function procesarPrecios() {
    limpiarPrecios();
    


    if (solicitud_cargaPrecios.readyState == 4 && solicitud_cargaPrecios.status == 200) {
        var data = JSON.parse(solicitud_cargaPrecios.responseText);
        document.getElementById("id_precioMayorista").value = data[0].NPREMAYOR;
        document.getElementById("id_precioPVP").value = data[0].NPCONIVA;        
    }
}

let solicitud_cargaColores;

function cargaColores() {
    solicitud_cargaColores = new XMLHttpRequest();
    solicitud_cargaColores.onreadystatechange = procesarColores;
    solicitud_cargaColores.open('POST', 'php_peticiones/cargaColores.php', true);
    solicitud_cargaColores.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    solicitud_cargaColores.send(enviarCREF()); //Uso la misma función ya que solo quiero mandar el CREF como antes
}

let jsonColores;
let cref;
let rutaImagen;
function procesarColores() {
    let tabla = document.getElementById("tabla");
    while (tabla.firstChild) {
        tabla.removeChild(tabla.lastChild);
    }
    limpiarSelect();
    cref = document.getElementById("inp_CREFS").value;

    if (fileExists("imgs/producto/" + cref + ".jpg")) {
        rutaImagen = "imgs/producto/" + cref + ".jpg";
    } else {
        let lower = cref.toLowerCase();
        rutaImagen = "imgs/producto/" + lower + ".jpg";
    }
    console.log(rutaImagen);
    if (solicitud_cargaColores.readyState == 4 && solicitud_cargaColores.status == 200) {
        jsonColores = JSON.parse(solicitud_cargaColores.responseText);
        ///////////////////////////////

        let tabla = document.getElementById("tabla");
        let tr = document.createElement("tr");
        tr.setAttribute("class", "filaStock");
        tabla.appendChild(tr);

        let tdImg = document.createElement("td");
        tr.appendChild(tdImg);
        tdImg.setAttribute("rowspan", jsonColores.length);
        tdImg.setAttribute("class", "imgStock");
        let imagenArticulo = document.createElement("img");
        imagenArticulo.src = rutaImagen;
        tdImg.appendChild(imagenArticulo);

        for (let n = 30; n <= 46; n += 2) {
            let tdBucle = document.createElement("td");
            tr.appendChild(tdBucle);
            tdBucle.setAttribute("class", "cabStock");
           

            switch (n) {
                case 30:
                    tdBucle.innerHTML = "REFERENCIA";
                    break;

                case 32:
                   
                    tdBucle.setAttribute("colspan", 2);
                    tdBucle.innerHTML = "COLOR";
                    break;

                case 34:
                    tdBucle.innerHTML = "34<br><hr>XS";
                    break;
                case 36:
                    tdBucle.innerHTML = "36<br><hr>S";
                    break;

                case 38:
                    tdBucle.innerHTML = "38<br><hr>M";
                    break;

                case 40:
                    tdBucle.innerHTML = "40<br><hr>L";
                    break;

                case 42:
                    tdBucle.innerHTML = "42<br><hr>XL";
                    break;

                case 44:
                    tdBucle.innerHTML = "44<br><hr>2XL";
                    break;

                case 46:
                    tdBucle.innerHTML = "46<br><hr>3XL";
                    break;

                /*case 48:
                    tdBucle.innerHTML = "48<br><hr>8";
                    break;
                case 50:
                    tdBucle.innerHTML = "50<br><hr>10";
                    break;
                case 52:
                    tdBucle.innerHTML = "52<br><hr>12";
                    break;

                case 54:
                    tdBucle.innerHTML = "54<br><hr>14";
                    break;

                case 56:
                    tdBucle.innerHTML = "56<br><hr>16";
                    break;

                case 58:
                    tdBucle.innerHTML = "&nbsp;";
                    */
            }


        }
        /////////////////////////////
        let select = document.getElementById("id_selectColores");
        
        for (let i=0 ; i<jsonColores.length ; i+=6){
            let option = document.createElement('option');
            let value = jsonColores[i].CIMAGEN;
            let text = jsonColores[i].DESCRIPCION;
            option.value = value;
            option.text = text;
            select.appendChild(option);
            }


        for (let i = 0; i < jsonColores.length; i++) {
            if (jsonColores[i] == jsonColores[jsonColores.length - 1]) {
                llenarTabla(i)

            } else if (jsonColores[i].DESCRIPCION != jsonColores[i + 1].DESCRIPCION) {
                llenarTabla(i)
            }

        }

        let inputTalla;
        for (let p = 0; p < jsonColores.length; p++) {
        
            switch (jsonColores[p].TALLA) {
                case 'S':
                    inputTalla = document.getElementById(jsonColores[p].DESCRIPCION + "S");
                    inputTalla.setAttribute("value", jsonColores[p].NSTOCK);
                    break;
                case 'M':
                    inputTalla = document.getElementById(jsonColores[p].DESCRIPCION + "M");
                    inputTalla.setAttribute("value", jsonColores[p].NSTOCK);
                    break;
                case 'L':
                    inputTalla = document.getElementById(jsonColores[p].DESCRIPCION + "L");
                    inputTalla.setAttribute("value", jsonColores[p].NSTOCK);
                    break;
                case 'XL':
                    inputTalla = document.getElementById(jsonColores[p].DESCRIPCION + "XL");
                    inputTalla.setAttribute("value", jsonColores[p].NSTOCK);
                    break;
                case '2XL':
                    inputTalla = document.getElementById(jsonColores[p].DESCRIPCION + "2XL");
                    inputTalla.setAttribute("value", jsonColores[p].NSTOCK);
                    break;
                case '3XL':
                    inputTalla = document.getElementById(jsonColores[p].DESCRIPCION + "3XL");
                    inputTalla.setAttribute("value", jsonColores[p].NSTOCK);
                    break;
                

            }
        }

    }
}

//limpia los precios cada vez que se quita el CREF del input
function limpiarPrecios() {
    var selectPrecioMayorista = document.getElementById("id_precioMayorista");
    selectPrecioMayorista.value = "";

    var selectPVP = document.getElementById("id_precioPVP");
    selectPVP.value = "";

    if (document.getElementById("id_img_producto")) {
        let imagen = document.getElementById("id_img_producto");
        imagen.remove();
    }
}

//limpia el select de colores  cada vez que se cambie el CREF
function limpiarSelect() {

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

function updatePrecio() {
    solicitud_updatePrecio = new XMLHttpRequest();
    solicitud_updatePrecio.onreadystatechange = procesarPrecio;
    solicitud_updatePrecio.open('POST', 'php_peticiones/actualizarPrecio.php', true);
    solicitud_updatePrecio.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    solicitud_updatePrecio.send(enviarPrecio()); //Uso la misma función ya que solo quiero mandar el CREF como antes
}

function enviarPrecio() {
    let value = document.getElementById("inp_CREFS").value;
    let textobusquedaenviado = "inp_CREFS=" + encodeURIComponent(value)
    value = document.getElementById('id_precioMayorista').value;
    textobusquedaenviado += '&mayorista=' + encodeURIComponent(value);
    value = document.getElementById("id_precioPVP").value;
    textobusquedaenviado += "&pvp=" + encodeURIComponent(value);
    console.log(textobusquedaenviado);
    return textobusquedaenviado;

}


function procesarPrecio() {
    if (solicitud_updatePrecio.readyState == 4 && solicitud_updatePrecio.status == 200) {
        alert("Precios actualizados correctamente");
    }
}


function fileExists(url) {
    $.get(url)
        .done(function () {
            return true;
        }).fail(function () {
            return false;
        })
}



function llenarTabla(i) {
    let tr = document.createElement("tr");
    tabla.appendChild(tr);

    let tdCref = document.createElement("td");
    tdCref.innerHTML = cref;
    tr.appendChild(tdCref);

    
    let tdColor = document.createElement("td");
    tdColor.innerHTML = jsonColores[i].DESCRIPCION;
    tdColor.setAttribute("width", "15%")
    tr.appendChild(tdColor); 

    let tdRuta = document.createElement("td");
    tdRuta.setAttribute("class", "colorStock");
    

    let imagen = document.createElement("img"); 
    tdRuta.appendChild(imagen);

    
    if (fileExists("imgs/muestras/" + jsonColores[i].CIMAGEN + ".jpg")) {
        imagen.src = "imgs/muestras/" + jsonColores[i].CIMAGEN.toLowerCase() + ".jpg";
    } else {
        imagen.src = "imgs/muestras/" + jsonColores[i].CIMAGEN.toUpperCase() + ".jpg";
    }
    tr.appendChild(tdRuta);


    
   
    let tdrelleno2 = document.createElement("td");
    tdrelleno2.innerHTML = 0;
   
    tr.appendChild(tdrelleno2);

    let tdTalla = document.createElement("td");
    tr.appendChild(tdTalla);
    let input = document.createElement("input");
    input.setAttribute("type", "number");
    input.setAttribute("class", "inpStock");
    input.setAttribute("width", "100%");
    input.setAttribute("id", jsonColores[i].DESCRIPCION + "S");
    tdTalla.appendChild(input);

    tdTalla = document.createElement("td");
    tr.appendChild(tdTalla);
    input = document.createElement("input");
    input.setAttribute("type", "number");
    input.setAttribute("class", "inpStock");
    input.setAttribute("width", "100%");
    input.setAttribute("id", jsonColores[i].DESCRIPCION + "M");
    tdTalla.appendChild(input);

    tdTalla = document.createElement("td");
    tr.appendChild(tdTalla);
    input = document.createElement("input");
    input.setAttribute("type", "number");
    input.setAttribute("class", "inpStock");
    input.setAttribute("width", "100%");
    input.setAttribute("id", jsonColores[i].DESCRIPCION + "L");
    tdTalla.appendChild(input);


    tdTalla = document.createElement("td");
    tr.appendChild(tdTalla);
    input = document.createElement("input");
    input.setAttribute("type", "number");
    input.setAttribute("class", "inpStock");
    input.setAttribute("width", "100%");
    input.setAttribute("id", jsonColores[i].DESCRIPCION + "XL");
    tdTalla.appendChild(input);

    tdTalla = document.createElement("td");
    tr.appendChild(tdTalla);
    input = document.createElement("input");
    input.setAttribute("type", "number");
    input.setAttribute("class", "inpStock");
    input.setAttribute("width", "100%");
    input.setAttribute("id", jsonColores[i].DESCRIPCION + "2XL");
    tdTalla.appendChild(input);

    tdTalla = document.createElement("td");
    tr.appendChild(tdTalla);
    input = document.createElement("input");
    input.setAttribute("type", "number");
    input.setAttribute("class", "inpStock");
    input.setAttribute("width", "100%");
    input.setAttribute("id", jsonColores[i].DESCRIPCION + "3XL");
    tdTalla.appendChild(input);
}





function recogerValores(){
    console.log(jsonColores)
    let txtSend="";
    let idCREF;
    for(let i = 0; i<jsonColores.length; i++){
        if (i==0){
        idCREF = "idCREF"+i+"=";
        }else{
        idCREF = "&idCREF"+i+"=";
        }
        let inpCREF = document.getElementById("inp_CREFS");
        let cref = inpCREF.value;
        txtSend+=idCREF+encodeURIComponent(cref);

        let idColor = "&idColor"+i+"=";
        let valorColor = jsonColores[i].COLOR;
        txtSend+=idColor+encodeURIComponent(valorColor);

        let idTalla = "&idTalla"+i+"=";
        let valorTalla = jsonColores[i].TALLA;
        txtSend+=idTalla+encodeURIComponent(valorTalla);

        let idStock = "&idStock"+i+"=";
        let input = document.getElementById(jsonColores[i].DESCRIPCION+jsonColores[i].TALLA);
        let valorStock = input.value;
        txtSend+=idStock+encodeURIComponent(valorStock);
    }
    console.log(txtSend);
    return txtSend;
}

let solicitud_stock;
function cargaValoresStock() {
    solicitud_stock = new XMLHttpRequest();
    solicitud_stock.onreadystatechange = respuestaStock; //Función que se encarga de la respuesta que devuelve php
    solicitud_stock.open('POST', 'php_peticiones/updateStock.php', true); //Archivo php que se va a encargar de la petición
    solicitud_stock.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); //Esto va siempre xd
    solicitud_stock.send(recogerValores()); //Función que se encarga de mandar la información al php
}


function respuestaStock(){
    if (solicitud_stock.readyState == 4 && solicitud_stock.status == 200) {
        alert("Stock actualizado");
        cargaColores();   
    }
}