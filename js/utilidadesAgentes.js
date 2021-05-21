let idAgente;
$(document).ready(function () {

    
    cargarAgentes();

    //detecta el id del agente que se hace click
    $('#list-group').on('mouseup', 'a', function () {
        idAgente = $(this).attr('id');
        datosAgentes(idAgente);

    })

    //actualiza
    $('#btnActualizarAgente').click(function () {
        updateAgente();
    });

    //borra
    $('#btnBorrarAgente').click(function () {
        let respuesta = confirm("¿Desea borrar el agente?");
        if (respuesta) {
            deleteAgente(idAgente);
        } else {

        }
    });

    //boton de buscar
    $('#btnBuscarAgente').click(function () {
        buscarAgente();
    });

});




function cargarAgentes() {
    $.ajax({
        method: "POST",
        url: "php_peticiones/cargarAgentes.php"
    }).done(function (response) {
        let data = JSON.parse(response);
        for (var i = 0; i < data.length; i++) {
            $('#list-group').append($("<a>", {
                id: data[i].CCODAGE,
                class: "filasList",
                text: data[i].CNBRAGE + " " + data[i].CAPEAGE
            }));
        }
    });
}

//carga lso datos del agente seleccionado
function datosAgentes(idAgente) {
    console.log(idAgente)
    $.ajax({
        method: "POST",
        url: "php_peticiones/getAgente.php",
        data: 'CCODAGE=' + idAgente
    }).done(function (response) {
        let data = JSON.parse(response);
        $('#aNombre').val(data[0].CNBRAGE);
        $('#aApellido').val(data[0].CAPEAGE);
        $('#aEmail').val(data[0].EMAIL);
        $('#aPassword').val(data[0].CCLVAGE);
        $('#aRPassword').val(data[0].CCLVAGE);
    });
}

function updateAgente() {
    let nombre = $('#aNombre').val();
    let apellidos = $('#aApellido').val();
    let email = $('#aEmail').val();
    let clave = $('#aPassword').val();
    let claveR = $('#aRPassword').val();

    if (clave === claveR) {
        $.ajax({
            method: "POST",
            url: "php_peticiones/updateAgente.php",
            data: 'idAgente=' + idAgente + '&nombre=' + nombre + '&apellidos=' + apellidos + '&clave=' + clave + '&email=' + email
        }).done(function () {
            location.reload();

            datosAgentes(idAgente);
            alert("Actualizado correctamente");
        });
    } else {
        alert("Las contraseñas no coinciden");
    }


}


function deleteAgente(idAgente) {
    $.ajax({
        method: "POST",
        url: "php_peticiones/deleteAgente.php",
        data: 'idAgente=' + idAgente
    }).done(function (response) {
        location.reload();

        alert("Borrado correctamente");
    });
}


function buscarAgente() {
    let texto = $('#txtAgente').val();
    let tokens = texto.split(" ");
    let nombre = tokens[0];
    let apellidos;
    if (tokens.length > 1) {
        apellidos = tokens[1];
    } else {
        apellidos = "%";
    }


    $.ajax({
        method: "POST",
        url: "php_peticiones/buscarAgente.php",
        data: 'nombre=' + nombre + '&apellidos=' + apellidos
    }).done(function (response) {
        let lista = document.getElementById("list-group");
        cleanList(lista);

        let data = JSON.parse(response);
        for(let i =0; i<data.length; i++){
            $('#list-group').append($("<a>", {
                id: data[i].CCODAGE,
                class: "filasList",
                text: data[i].CNBRAGE + " " + data[i].CAPEAGE
            }));
        }
        
    });
}




//metodos para insertar un nuevo agente
let solicitud_insertarAgente;
function insertaAgente() {
    solicitud_insertarAgente = new XMLHttpRequest();
    solicitud_insertarAgente.onreadystatechange = procesaRespuestaInsertar; //Función que se encarga de la respuesta que devuelve php
    solicitud_insertarAgente.open('POST', 'php_peticiones/insertarAgente.php', true); //Archivo php que se va a encargar de la petición
    solicitud_insertarAgente.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); //Esto va siempre xd
    solicitud_insertarAgente.send(recogeDatosInsertar()); //Función que se encarga de mandar la información al php

}

function recogeDatosInsertar(){
//recoge todos los campos del form en un array
    var longitud = document.forms["formInsertar"].getElementsByClassName('inputsInsertar').length;
    var matrizvalores=[];
    var matrizid=[];
    var textobusquedaenviado = '';
    for (var a=0;a<longitud;a++){ //recorre los input del formulario
        matrizvalores[a]=document.forms["formInsertar"].getElementsByClassName('inputsInsertar')[a].value;
        matrizid[a]=document.forms["formInsertar"].getElementsByClassName('inputsInsertar')[a].id+"=";
        if(a>0){
            matrizid[a]="&"+matrizid[a];
        }
        textobusquedaenviado=textobusquedaenviado+matrizid[a]+encodeURIComponent(matrizvalores[a]);
    }
    console.log(textobusquedaenviado);
    return textobusquedaenviado;
}

function procesaRespuestaInsertar(){
    location.reload();
    alert("Agente introducido correctamente");
}


function cleanList(list) {
    while (list.firstChild) {
        list.removeChild(list.lastChild);
    }
}