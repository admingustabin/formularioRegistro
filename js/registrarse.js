sessionStorage.removeItem("bandera");

function incluirUsuario() {
    if (sessionStorage.getItem("bandera") === null) {
        sessionStorage.setItem("bandera", "entro");
        $("body").on("submit", "#formDefault", function(event){
            event.preventDefault();
            if($("#formDefault").valid()){
                $("#barra").show();
                $.ajax({
                    type: "POST",
                    url: "backend/registrarseAPI.php?option=incluirUsuario",
                    dataType: "json",
                    data: $(this).serialize(),
                    success: function(respuesta){
                        console.log(respuesta);
                        $("#barra").hide();
                        if (respuesta.error == 1) {
                            swal(
                                "Houston, tenemos un problema",
                                "El email es invalido",
                                "error"
                            );
                        }
                        if (respuesta.error == 2) {
                            swal(
                                "Houston, tenemos un problema",
                                "El password es invalido",
                                "error"
                            );
                        }
                        if (respuesta.error == 3) {
                            swal(
                                "Houston, tenemos un problema",
                                "Ya existe el email",
                                "error"
                            );
                        }
                        if (respuesta.exito == 1) {
                            swal(
                                "Solicitud realizada!",
                                "La cuenta fue creada",
                                "success"
                            );                            
                            //Limpiar el formulario
                            document.querySelector("#email").value="";
                            document.querySelector("#password").value="";
    
                            //Esperar 4 segundos 
                            setTimeout(function() {
                                //Redirigir a gracias.php
                                console.log("ir a pagina de gracias");
                                //window.location.href="gracias.php";
                            }, 4000);
                            //fin de la espera de los 4 segundos  
                            //hacer algo mas....
                        }
                    }
                })
            }
        })
    }
}