var wrapper = document.getElementById("signature-pad"),
    clearButton = wrapper.querySelector("[data-action=clear]"),
    savePNGButton = wrapper.querySelector("[data-action=save-png]"),
    saveSVGButton = wrapper.querySelector("[data-action=save-svg]"),
    canvas = wrapper.querySelector("canvas"),
    signaturePad;

// Adjust canvas coordinate space taking into account pixel ratio,
// to make it look crisp on mobile devices.
// This also causes canvas to be cleared.
function resizeCanvas() {
    // When zoomed out to less than 100%, for some very strange reason,
    // some browsers report devicePixelRatio as less than 1
    // and only part of the canvas is cleared then.
    var ratio =  Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
}

window.onresize = resizeCanvas;
resizeCanvas();

signaturePad = new SignaturePad(canvas);

clearButton.addEventListener("click", function (event) {
    signaturePad.clear();
});

/*Funcion de Capturar, Almacenar datos y Limpiar campos*/
$(document).ready(function(){
	$('#btn-sv-firm-CLI').click(function(){      
		//Consigue firma del cliente
		var firm_cli = signaturePad.toDataURL();
		
		//Guarda la firma del cliente
		sessionStorage.setItem("Firma_Cliente", firm_cli);
		
		//Recupera de localstorage la firma del cliente
		var firma_cliente = sessionStorage.getItem("Firma_Cliente");
		
		//Introduce en el input la firma del cliente
		document.getElementById("firma_cliente").value = firma_cliente;
		
		//Limpia la pantalla de firma
		signaturePad.clear();
	});  
});

/*Funcion Cargar y Mostrar datos*/
$(document).ready(function(){
	$('#btn-sv-firm-COM').click(function(){                 
		//Consigue firma del cliente
		var firm_com = signaturePad.toDataURL();
		
		//Guarda la firma del cliente
		sessionStorage.setItem("Firma_Comercial", firm_com);
		
		//Recupera de localstorage la firma del cliente
		var firma_comercial = sessionStorage.getItem("Firma_Comercial");
		
		//Introduce en el input la firma del cliente
		document.getElementById("firma_comercial").value = firma_comercial;
		
		//Limpia la pantalla de firma
		signaturePad.clear();
	});  
});